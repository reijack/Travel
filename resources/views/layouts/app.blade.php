<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>WanderPlan — @yield('title', 'Perencana Perjalanan')</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css"/>
  <style>
    *{box-sizing:border-box;margin:0;padding:0}
    :root{
      --forest:#1B4332;--forest-lt:#2D6A4F;--sage:#52796F;
      --terra:#C1440E;--gold:#E09F3E;--cream:#FDFAF5;
      --sand:#F5EFE0;--mist:#D8E2DC;--gray1:#F8F8F6;
      --gray2:#EEECE8;--gray3:#D0CEC8;--gray4:#9A9890;
      --text:#2C2A26;--text-muted:#7A7870;
      --ff-display:'Playfair Display',serif;
      --ff-body:'DM Sans',sans-serif;
    }
    body{font-family:var(--ff-body);background:var(--cream);color:var(--text);min-height:100vh;display:flex}
    ::-webkit-scrollbar{width:6px}::-webkit-scrollbar-thumb{background:var(--gray3);border-radius:3px}
    .sidebar{width:260px;min-height:100vh;background:var(--forest);display:flex;flex-direction:column;position:fixed;top:0;left:0;z-index:100;overflow-y:auto}
    .sidebar-brand{display:flex;align-items:center;gap:12px;padding:22px 20px 18px;border-bottom:1px solid rgba(255,255,255,.1)}
    .brand-logo{width:38px;height:38px;background:var(--gold);border-radius:10px;display:flex;align-items:center;justify-content:center}
    .brand-logo i{color:var(--forest);font-size:20px}
    .brand-name{font-family:var(--ff-display);color:#fff;font-size:20px;font-weight:600}
    .sidebar-nav{padding:18px 12px 8px}
    .nav-label{font-size:10px;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,.4);padding:0 10px;margin-bottom:6px}
    .nav-item{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:8px;color:rgba(255,255,255,.65);text-decoration:none;font-size:14px;margin-bottom:2px;transition:all .18s}
    .nav-item i{font-size:18px}
    .nav-item:hover{background:rgba(255,255,255,.1);color:#fff}
    .nav-item.active{background:var(--gold);color:var(--forest);font-weight:500}
    .sidebar-trips{padding:18px 12px 24px;border-top:1px solid rgba(255,255,255,.1)}
    .trip-pill{display:flex;align-items:center;gap:10px;padding:10px;border-radius:8px;margin-bottom:4px;text-decoration:none;transition:background .18s}
    .trip-pill:hover{background:rgba(255,255,255,.08)}
    .trip-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;background:var(--terra)}
    .trip-pill-name{font-size:13px;color:#fff}
    .trip-pill-date{font-size:11px;color:rgba(255,255,255,.45);margin-top:1px}
    .main-wrapper{margin-left:260px;flex:1;display:flex;flex-direction:column}
    .topbar{height:62px;background:#fff;border-bottom:1px solid var(--gray2);display:flex;align-items:center;padding:0 28px;gap:16px;position:sticky;top:0;z-index:50;box-shadow:0 1px 3px rgba(0,0,0,.06)}
    .topbar-title{font-size:17px;font-weight:500;flex:1}
    .topbar-actions{display:flex;align-items:center;gap:8px}
    .avatar{width:36px;height:36px;background:var(--forest);border-radius:50%;color:#fff;font-size:13px;font-weight:500;display:flex;align-items:center;justify-content:center}
    .content{flex:1;padding:28px 32px 48px}
    .alert{padding:12px 18px;border-radius:12px;margin-bottom:20px;font-size:14px;display:flex;align-items:center;gap:10px}
    .alert-success{background:#F0FDF4;color:#15803D;border:1px solid #BBF7D0}
    .alert-error{background:#FEF2F2;color:#B91C1C;border:1px solid #FCA5A5}
    .btn-primary{background:var(--forest);color:#fff;border:none;border-radius:8px;padding:10px 20px;font-size:14px;font-weight:500;font-family:var(--ff-body);cursor:pointer;display:inline-flex;align-items:center;gap:7px;text-decoration:none;transition:all .18s}
    .btn-primary:hover{background:var(--forest-lt);transform:translateY(-1px)}
    .btn-primary.sm{padding:8px 14px;font-size:13px}
    .btn-outline{background:transparent;color:var(--text);border:1px solid var(--gray3);border-radius:8px;padding:10px 18px;font-size:14px;font-family:var(--ff-body);cursor:pointer;display:inline-flex;align-items:center;gap:7px;text-decoration:none;transition:all .18s}
    .btn-outline:hover{background:var(--gray1)}
    .btn-outline.sm{padding:8px 14px;font-size:13px}
    .btn-danger{background:#FEF2F2;color:#B91C1C;border:1px solid #FCA5A5;border-radius:8px;padding:8px 12px;font-size:13px;font-family:var(--ff-body);cursor:pointer;display:inline-flex;align-items:center;gap:6px;transition:all .18s;text-decoration:none}
    .btn-danger:hover{background:#FEE2E2}
    .card{background:#fff;border-radius:16px;border:1px solid var(--gray2);box-shadow:0 1px 3px rgba(0,0,0,.06);padding:24px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px}
    .page-h1{font-family:var(--ff-display);font-size:26px;font-weight:600;color:var(--forest);margin-bottom:4px}
    .page-sub{font-size:14px;color:var(--text-muted)}
    .form-group{margin-bottom:18px}
    .form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
    label{display:block;font-size:13px;font-weight:500;color:#3A3834;margin-bottom:6px}
    .form-input{width:100%;background:var(--gray1);border:1px solid var(--gray2);border-radius:8px;padding:10px 14px;font-size:14px;color:var(--text);font-family:var(--ff-body);transition:all .18s}
    .form-input:focus{outline:none;border-color:var(--sage);background:#fff;box-shadow:0 0 0 3px rgba(82,121,111,.15)}
    textarea.form-input{resize:vertical;line-height:1.5}
    select.form-input{appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24'%3E%3Cpath fill='%23999' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center;padding-right:36px}
    .form-error{color:#B91C1C;font-size:12px;margin-top:4px}
  </style>
  @stack('styles')
</head>
<body>
<aside class="sidebar">
  <div class="sidebar-brand">
    <div class="brand-logo"><i class="ti ti-compass"></i></div>
    <span class="brand-name">WanderPlan</span>
  </div>
  <nav class="sidebar-nav">
    <div class="nav-label">Menu</div>
    <a href="{{ route('trips.index') }}" class="nav-item {{ request()->routeIs('trips.index') ? 'active' : '' }}">
      <i class="ti ti-layout-dashboard"></i> Dashboard
    </a>
    <a href="{{ route('trips.create') }}" class="nav-item {{ request()->routeIs('trips.create') ? 'active' : '' }}">
      <i class="ti ti-plus"></i> Buat Trip Baru
    </a>
  </nav>
  <div class="sidebar-trips">
    <div class="nav-label">Trip Aktif</div>
    @foreach($sidebarTrips ?? [] as $st)
    <a href="{{ route('trips.show', $st) }}" class="trip-pill">
      <div class="trip-dot"></div>
      <div>
        <div class="trip-pill-name">{{ $st->trip_name }}</div>
        <div class="trip-pill-date">{{ \Carbon\Carbon::parse($st->start_date)->format('d M') }} · {{ $st->people }} orang</div>
      </div>
    </a>
    @endforeach
  </div>
</aside>
<div class="main-wrapper">
  <header class="topbar">
    <div class="topbar-title">@yield('page-title', 'WanderPlan')</div>
    <div class="topbar-actions">
      <a href="{{ route('trips.create') }}" class="btn-primary sm"><i class="ti ti-plus"></i> Trip Baru</a>
      <div class="avatar">WP</div>
    </div>
  </header>
  <main class="content">
    @if(session('success'))
      <div class="alert alert-success"><i class="ti ti-circle-check"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-error"><i class="ti ti-alert-circle"></i> {{ session('error') }}</div>
    @endif
    @yield('content')
  </main>
</div>
@stack('scripts')
</body>
</html>