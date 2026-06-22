<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Reset Password – Travel Planner</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    *{box-sizing:border-box;margin:0;padding:0}
    :root{--forest:#1B4332;--gold:#E09F3E;--sage:#52796F;
          --cream:#FDFAF5;--gray2:#EEECE8;--gray3:#D0CEC8;
          --text:#2C2A26;--text-muted:#7A7870;
          --ff-display:'Playfair Display',serif;
          --ff-body:'DM Sans',sans-serif}
    body{font-family:var(--ff-body);background:var(--cream);
         min-height:100vh;display:flex;align-items:center;justify-content:center}
    .wrap{width:100%;max-width:420px;padding:24px}
    .logo{display:flex;align-items:center;gap:10px;margin-bottom:32px;justify-content:center}
    .logo-icon{width:42px;height:42px;background:var(--gold);border-radius:10px;
               display:flex;align-items:center;justify-content:center;font-size:22px}
    .logo-name{font-family:var(--ff-display);font-size:22px;color:var(--forest);font-weight:700}
    .card{background:#fff;border-radius:16px;border:1px solid var(--gray2);
          padding:2rem 2.25rem;box-shadow:0 2px 16px rgba(0,0,0,.06)}
    h1{font-family:var(--ff-display);font-size:22px;color:var(--forest);
       margin-bottom:6px;font-weight:700}
    .sub{font-size:14px;color:var(--text-muted);margin-bottom:24px}
    label{display:block;font-size:13px;font-weight:500;color:#3A3834;margin-bottom:6px}
    input{width:100%;background:#F8F8F6;border:1px solid var(--gray2);
          border-radius:8px;padding:10px 14px;font-size:14px;
          font-family:var(--ff-body);color:var(--text);transition:all .18s;margin-bottom:16px}
    input:focus{outline:none;border-color:var(--sage);background:#fff;
                box-shadow:0 0 0 3px rgba(82,121,111,.15)}
    input[readonly]{color:var(--text-muted);cursor:not-allowed}
    .err{color:#B91C1C;font-size:12px;margin-top:-12px;margin-bottom:12px;background:#FEF2F2;padding:10px 14px;border-radius:8px}
    .btn{width:100%;padding:11px;background:var(--forest);color:#fff;
         border:none;border-radius:8px;font-size:15px;font-weight:500;
          font-family:var(--ff-body);cursor:pointer;transition:background .18s}
    .btn:hover{background:var(--sage)}
  </style>
</head>
<body>
<div class="wrap">
  <div class="logo">
    <div class="logo-icon">🧭</div>
    <span class="logo-name">Travel Planner</span>
  </div>
  <div class="card">
    <h1>Buat Password Baru</h1>
    <p class="sub">Masukkan password baru untuk akun kamu</p>

    @if($errors->any())
      <p class="err">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">

      <label>Email</label>
      <input type="email" name="email" value="{{ old('email', $email) }}" required readonly/>

      <label>Password Baru</label>
      <input type="password" name="password" placeholder="Minimal 8 karakter" required/>

      <label>Konfirmasi Password Baru</label>
      <input type="password" name="password_confirmation" required/>

      <button class="btn" type="submit">Reset Password</button>
    </form>
  </div>
</div>
</body>
</html>