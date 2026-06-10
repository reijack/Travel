<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Daftar – Travel Planner</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    *{box-sizing:border-box;margin:0;padding:0}
    :root{--forest:#1B4332;--gold:#E09F3E;--sage:#52796F;
          --cream:#FDFAF5;--gray2:#EEECE8;
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
    h1{font-family:var(--ff-display);font-size:22px;color:var(--forest);margin-bottom:6px;font-weight:700}
    .sub{font-size:14px;color:var(--text-muted);margin-bottom:24px}
    label{display:block;font-size:13px;font-weight:500;color:#3A3834;margin-bottom:6px}
    input{width:100%;background:#F8F8F6;border:1px solid var(--gray2);
          border-radius:8px;padding:10px 14px;font-size:14px;
          font-family:var(--ff-body);color:var(--text);transition:all .18s;margin-bottom:16px}
    input:focus{outline:none;border-color:var(--sage);background:#fff;
                box-shadow:0 0 0 3px rgba(82,121,111,.15)}
    .err{color:#B91C1C;font-size:12px;margin-top:-12px;margin-bottom:12px}
    .btn{width:100%;padding:11px;background:var(--forest);color:#fff;
         border:none;border-radius:8px;font-size:15px;font-weight:500;
         font-family:var(--ff-body);cursor:pointer;transition:background .18s}
    .btn:hover{background:var(--sage)}
    .footer{text-align:center;margin-top:18px;font-size:13px;color:var(--text-muted)}
    .footer a{color:var(--forest);text-decoration:none;font-weight:500}
  </style>
</head>
<body>
<div class="wrap">
  <div class="logo">
    <div class="logo-icon">🧭</div>
    <span class="logo-name">Travel Planner</span>
  </div>
  <div class="card">
    <h1>Buat akun baru</h1>
    <p class="sub">Mulai rencanakan perjalananmu 🌍</p>
    <form method="POST" action="{{ route('register') }}">
      @csrf
      <label>Nama</label>
      <input type="text" name="name" value="{{ old('name') }}" required/>
      @error('name') <p class="err">{{ $message }}</p> @enderror

      <label>Email</label>
      <input type="text" name="email" value="{{ old('email') }}" required/>
      @error('email') <p class="err">{{ $message }}</p> @enderror

      <label>Password</label>
      <input type="password" name="password" required/>
      @error('password') <p class="err">{{ $message }}</p> @enderror

      <label>Konfirmasi Password</label>
      <input type="password" name="password_confirmation" required/>

      <button class="btn" type="submit">Daftar</button>
    </form>
    <p class="footer">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
  </div>
</div>
</body>
</html>