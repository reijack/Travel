@extends('layouts.app')
@section('title', 'Admin Panel')
@section('page-title', 'Admin Panel')

@push('styles')
<style>
  .admin-header{background:linear-gradient(135deg,#1a1a2e,#16213e);border-radius:24px;padding:28px 32px;margin-bottom:24px;color:#fff;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px}
  .admin-header h2{font-family:var(--ff-display);font-size:24px;font-weight:600;margin-bottom:6px}
  .admin-header p{color:rgba(255,255,255,.65);font-size:14px}
  .admin-badge{background:rgba(224,159,62,.2);color:var(--gold);font-size:11px;font-weight:500;padding:4px 12px;border-radius:20px;border:1px solid rgba(224,159,62,.3);display:inline-flex;align-items:center;gap:5px;margin-bottom:10px}

  .stats-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:28px}
  .stat-card{background:#fff;border-radius:16px;border:1px solid var(--gray2);padding:20px 24px;box-shadow:0 1px 3px rgba(0,0,0,.06);display:flex;align-items:center;gap:16px}
  .stat-icon{width:48px;height:48px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0}
  .si-blue{background:#EFF6FF;color:#1D4ED8}
  .si-green{background:#F0FDF4;color:#15803D}
  .si-purple{background:#F5F3FF;color:#6D28D9}
  .stat-val{font-size:28px;font-weight:600;color:var(--text);line-height:1}
  .stat-lbl{font-size:13px;color:var(--text-muted);margin-top:4px}

  .section-title{font-family:var(--ff-display);font-size:20px;font-weight:600;color:var(--forest);margin-bottom:16px;display:flex;align-items:center;gap:10px}

  .user-table-wrap{background:#fff;border-radius:16px;border:1px solid var(--gray2);overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.06)}
  .user-table{width:100%;border-collapse:collapse}
  .user-table th{background:var(--sand);padding:12px 18px;font-size:12px;font-weight:500;color:var(--text-muted);text-align:left;text-transform:uppercase;letter-spacing:.5px;border-bottom:1px solid var(--gray2)}
  .user-table td{padding:14px 18px;font-size:14px;border-bottom:1px solid var(--gray2);vertical-align:middle}
  .user-table tbody tr:last-child td{border-bottom:none}
  .user-table tbody tr:hover{background:var(--gray1)}

  .user-avatar{width:36px;height:36px;border-radius:50%;background:var(--forest);color:#fff;font-size:14px;font-weight:500;display:flex;align-items:center;justify-content:center;flex-shrink:0}
  .user-info{display:flex;align-items:center;gap:12px}
  .user-name{font-size:14px;font-weight:500;color:var(--text)}
  .user-email{font-size:12px;color:var(--text-muted);margin-top:2px}

  .role-badge{font-size:11px;font-weight:500;padding:3px 10px;border-radius:10px;display:inline-flex;align-items:center;gap:4px}
  .role-admin{background:#FEF3C7;color:#92400E}
  .role-user{background:#F0FDF4;color:#15803D}

  .trip-count{display:inline-flex;align-items:center;gap:5px;background:var(--gray1);padding:4px 10px;border-radius:8px;font-size:13px;color:var(--text-muted)}
</style>
@endpush

@section('content')

{{-- ADMIN HEADER --}}
<div class="admin-header">
  <div>
    <div class="admin-badge"><i class="ti ti-shield-check"></i> Admin Panel</div>
    <h2>Manajemen Pengguna 👥</h2>
    <p>Kelola semua akun pengguna WanderPlan</p>
  </div>
  <a href="{{ route('trips.index') }}" class="btn-outline sm" style="color:#fff;border-color:rgba(255,255,255,.3)">
    <i class="ti ti-arrow-left"></i> Kembali ke Dashboard
  </a>
</div>

{{-- STATS --}}
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon si-blue"><i class="ti ti-users"></i></div>
    <div>
      <div class="stat-val">{{ $totalUsers }}</div>
      <div class="stat-lbl">Total Pengguna</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon si-green"><i class="ti ti-map-2"></i></div>
    <div>
      <div class="stat-val">{{ $totalTrips }}</div>
      <div class="stat-lbl">Total Trip Dibuat</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon si-purple"><i class="ti ti-shield"></i></div>
    <div>
      <div class="stat-val">{{ $totalAdmins }}</div>
      <div class="stat-lbl">Total Admin</div>
    </div>
  </div>
</div>

{{-- USER TABLE --}}
<div class="section-title">
  <i class="ti ti-users" style="color:var(--forest)"></i>
  Daftar Pengguna
</div>

<div class="user-table-wrap">
  <table class="user-table">
    <thead>
      <tr>
        <th>Pengguna</th>
        <th>Role</th>
        <th>Trip</th>
        <th>Bergabung</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $user)
      <tr>
        <td>
          <div class="user-info">
            <div class="user-avatar">{{ strtoupper(substr($user->name,0,1)) }}</div>
            <div>
              <div class="user-name">{{ $user->name }}</div>
              <div class="user-email">{{ $user->email }}</div>
            </div>
          </div>
        </td>
        <td>
          @if($user->is_admin)
            <span class="role-badge role-admin"><i class="ti ti-shield-check"></i> Admin</span>
          @else
            <span class="role-badge role-user"><i class="ti ti-user"></i> User</span>
          @endif
        </td>
        <td>
         <div class="trip-count">
    <i class="ti ti-map-pin"></i>
    {{ $user->trips->count() }} trip
</div>
        </td>
        <td style="color:var(--text-muted);font-size:13px">
          {{ $user->created_at->format('d M Y') }}
        </td>
        <td>
          @if(!$user->is_admin)
          <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
            onsubmit="return confirm('Hapus user {{ $user->name }}? Semua tripnya akan ikut terhapus!')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-danger sm">
              <i class="ti ti-trash"></i> Hapus
            </button>
          </form>
          @else
          <span style="font-size:12px;color:var(--text-muted);font-style:italic">Tidak bisa dihapus</span>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@endsection