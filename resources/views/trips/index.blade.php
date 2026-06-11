@extends('layouts.app')
@section('title','Dashboard')
@section('page-title','Dashboard')

@push('styles')
<style>
  .hero{background:linear-gradient(135deg,var(--forest),var(--sage));border-radius:24px;padding:36px 40px;margin-bottom:28px;color:#fff}
  .hero-tag{display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,.15);font-size:12px;padding:5px 14px;border-radius:20px;margin-bottom:14px}
  .hero h1{font-family:var(--ff-display);font-size:28px;font-weight:700;margin-bottom:8px}
  .hero p{color:rgba(255,255,255,.75);margin-bottom:22px;font-size:15px}
  .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:28px}
  .stat-card{background:#fff;border-radius:12px;border:1px solid var(--gray2);padding:16px;display:flex;align-items:center;gap:14px;box-shadow:0 1px 3px rgba(0,0,0,.06)}
  .stat-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px}
  .si-g{background:#E8F5EE;color:var(--forest)}
  .si-t{background:#FDF0EB;color:var(--terra)}
  .si-d{background:#FEF8EC;color:var(--gold)}
  .si-s{background:#EEF5F2;color:var(--sage)}
  .stat-val{font-size:20px;font-weight:500}
  .stat-lbl{font-size:12px;color:var(--text-muted);margin-top:2px}
  .sec-title{font-family:var(--ff-display);font-size:20px;font-weight:600;color:var(--forest);margin-bottom:16px}
  .trips-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:16px}
  .trip-card{background:#fff;border-radius:16px;border:1px solid var(--gray2);padding:22px;box-shadow:0 1px 3px rgba(0,0,0,.06);transition:all .18s}
  .trip-card:hover{transform:translateY(-2px);box-shadow:0 4px 12px rgba(0,0,0,.08)}
  .tc-head{display:flex;align-items:flex-start;gap:12px;margin-bottom:16px}
  .tc-emoji{font-size:36px;line-height:1}
  .tc-head h3{font-size:17px;font-weight:500;margin-bottom:6px}
  .tc-meta{display:flex;flex-wrap:wrap;gap:10px;font-size:12px;color:var(--text-muted)}
  .tc-meta span{display:flex;align-items:center;gap:4px}
  .badge{font-size:11px;font-weight:500;padding:3px 10px;border-radius:10px}
  .badge.upcoming{background:#FEF3E2;color:#B45309}
  .badge.planned{background:#EEF2FF;color:#4338CA}
  .badge.done{background:#F0FDF4;color:#15803D}
  .tc-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin:14px 0}
  .tcs{background:var(--gray1);border-radius:8px;padding:10px;text-align:center}
  .tcs-val{font-size:15px;font-weight:500}
  .tcs-lbl{font-size:11px;color:var(--text-muted);margin-top:2px}
  .tc-actions{display:flex;gap:8px;flex-wrap:wrap}
  .empty{text-align:center;padding:60px 20px;color:var(--text-muted)}
  .empty i{font-size:48px;color:var(--gray3);margin-bottom:16px;display:block}
  .empty h3{font-size:18px;margin-bottom:8px;color:var(--text)}
  .empty p{font-size:14px;margin-bottom:24px}
</style>
@endpush

@section('content')
<div class="hero">
  <div class="hero-tag"><i class="ti ti-sun"></i> Selamat datang!</div>
  <h1>Rencanakan Petualanganmu 🌍</h1>
  <p>kelola semua trip, itinerary, dan budget perjalananmu di satu tempat.</p>
  <a href="{{ route('trips.create') }}" class="btn-primary"><i class="ti ti-plus"></i> Buat Trip Baru</a>
</div>

<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon si-g"><i class="ti ti-map-2"></i></div>
    <div><div class="stat-val">{{ $trips->count() }}</div><div class="stat-lbl">Total Trip</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon si-t"><i class="ti ti-calendar-check"></i></div>
    <div><div class="stat-val">{{ $trips->where('status','upcoming')->count() }}</div><div class="stat-lbl">Upcoming</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon si-d"><i class="ti ti-wallet"></i></div>
    <div><div class="stat-val">Rp {{ number_format($trips->sum('budget')/1000000,1) }}jt</div><div class="stat-lbl">Total Budget</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon si-s"><i class="ti ti-trophy"></i></div>
    <div><div class="stat-val">{{ $trips->where('status','done')->count() }}</div><div class="stat-lbl">Selesai</div></div>
  </div>
</div>

<div class="sec-title">Semua Trip</div>

@if($trips->isEmpty())
<div class="empty">
  <i class="ti ti-map-off"></i>
  <h3>Belum ada trip</h3>
  <p>Yuk buat rencana perjalanan pertamamu!</p>
  <a href="{{ route('trips.create') }}" class="btn-primary"><i class="ti ti-plus"></i> Buat Trip Pertama</a>
</div>
@else
<div class="trips-grid">
  @foreach($trips as $trip)
  @php
    $emojis=['🌴','🏝️','🌋','🏔️','🗺️','✈️','🌊','🏖️'];
    $emoji=$emojis[$trip->id % count($emojis)];
    $days=\Carbon\Carbon::parse($trip->start_date)->diffInDays($trip->end_date)+1;
  @endphp
  <div class="trip-card">
    <div class="tc-head">
      <div class="tc-emoji">{{ $emoji }}</div>
      <div style="flex:1">
        <h3>{{ $trip->trip_name }}</h3>
        <div class="tc-meta">
          <span><i class="ti ti-map-pin"></i> {{ $trip->destination }}</span>
          <span><i class="ti ti-calendar"></i> {{ \Carbon\Carbon::parse($trip->start_date)->format('d M Y') }}</span>
        </div>
      </div>
      <span class="badge {{ $trip->status }}">{{ ucfirst($trip->status) }}</span>
    </div>
    <div class="tc-stats">
      <div class="tcs">
        <div class="tcs-val">{{ $days }}</div>
        <div class="tcs-lbl">Hari</div>
      </div>
      <div class="tcs">
        <div class="tcs-val">{{ $trip->itineraries_count ?? $trip->itineraries()->count() }}</div>
        <div class="tcs-lbl">Aktivitas</div>
      </div>
      <div class="tcs">
        <div class="tcs-val">Rp {{ number_format($trip->budget/1000000,1) }}jt</div>
        <div class="tcs-lbl">Budget</div>
      </div>
    </div>
    <div class="tc-actions">
      <a href="{{ route('trips.show', $trip) }}" class="btn-primary" style="flex:1;text-align:center">
        <i class="ti ti-eye"></i> Lihat
      </a>
      <a href="{{ route('trips.edit', $trip) }}" class="btn-outline">
        <i class="ti ti-edit"></i>
      </a>
      <form action="{{ route('trips.destroy', $trip) }}" method="POST" onsubmit="return confirm('Hapus trip ini?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-outline" style="color:#dc2626;border-color:#fca5a5">
          <i class="ti ti-trash"></i>
        </button>
      </form>
    </div>
  </div>
  @endforeach
</div>
@endif

@endsection