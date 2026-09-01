#!/bin/sh
set -e

# Render injects PORT; Apache image defaults to 80. Rewrite the listen
# directive and the vhost so the container binds to whatever Render expects.
PORT="${PORT:-80}"
sed -ri "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -ri "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

cd /var/www/html

# Generate APP_KEY on first boot if one wasn't provided via env vars.
if [ -z "$APP_KEY" ]; then
    echo "WARNING: APP_KEY is not set. Set it in Render's environment variables."
fi

# Cache config/routes/views for production performance.
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run pending migrations against Supabase Postgres on every deploy.
php artisan migrate --force

# Make sure the public storage symlink exists (photos disk).
php artisan storage:link || true

# Force a single MPM (prefork, required by mod_php) right before Apache
# actually starts. Some platforms (Railway included) re-enable a second MPM
# after the image is built, so this must run at the very last moment.
a2dismod mpm_event 2>/dev/null || true
a2dismod mpm_worker 2>/dev/null || true
rm -f /etc/apache2/mods-enabled/mpm_event.load /etc/apache2/mods-enabled/mpm_event.conf \
      /etc/apache2/mods-enabled/mpm_worker.load /etc/apache2/mods-enabled/mpm_worker.conf
a2enmod mpm_prefork 2>/dev/null || true
ln -sf /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load
ln -sf /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf
apache2ctl -t || true

exec "$@"
