@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
@push('styles')
<style>
  .hero{background:linear-gradient(135deg,var(--forest),var(--sage));border-radius:var(--radius-xl);padding:36px 40px;margin-bottom:28px;color:#fff}
  .hero h1{font-family:var(--ff-display);font-size:28px;font-weight:700;margin-bottom:8px}
  .hero p{color:rgba(255,255,255,.75);margin-bottom:22px;font-size:15px}
  .hero-tag{display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,.15);font-size:12px;padding:5px 14px;border-radius:20px;margin-bottom:14px}
  .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:28px}
  .stat-card{background:#fff;border-radius:var(--radius);border:1px solid var(--gray2);padding:16px;display:flex;align-items:center;gap:14px;box-shadow:var(--shadow-sm)}
  .stat-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px}
  .stat-icon.g{background:#E8F5EE;color:var(--forest)}
  .stat-icon.t{background:#FDF0EB;color:var(--terra)}
  .stat-icon.d{background:#FEF8EC;color:var(--gold)}
  .stat-icon.s{background:#EEF5F2;color:var(--sage)}
  .stat-val{font-size:20px;font-weight:500}.stat-lbl{font-size:12px;color:var(--text-muted);margin-top:2px}
  .section-title{font-family:var(--ff-display);font-size:20px;font-weight:600;color:var(--forest);margin-bottom:16px}
  .trips-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:16px}
  .trip-card{background:#fff;border-radius:var(--radius-lg);border:1px solid var(--gray2);padding:22px;box-shadow:var(--shadow-sm);transition:all .18s}
  .trip-card:hover{transform:translateY(-2px);box-shadow:var(--shadow)}
  .trip-card-head{display:flex;align-items:flex-start;gap:12px;margin-bottom:16px}
  .trip-emoji{font-size:36px;line-height:1}
  .trip-card h3{font-size:17px;font-weight:500;margin-bottom:6px}
  .trip-meta{display:flex;flex-wrap:wrap;gap:10px;font-size:12px;color:var(--text-muted)}
  .trip-meta span{display:flex;align-items:center;gap:4px}
  .badge{font-size:11px;font-weight:500;padding:3px 10px;border-radius:10px}
  .badge.upcoming{background:#FEF3E2;color:#B45309}
  .badge.planned{background:#EEF2FF;color:#4338CA}
  .badge.done{background:#F0FDF4;color:#15803D}
  .trip-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin:14px 0}
  .ts{background:var(--gray1);border-radius:8px;padding:10px;text-align:center}
  .ts-val{font-size:15px;font-weight:500}.ts-lbl{font-size:11px;color:var(--text-muted);margin-top:2px}
  .trip-actions{display:flex;gap:8px;flex-wrap:wrap}
  .empty-state{text-align:center;padding:60px 20px;color:var(--text-muted)}
  .empty-state i{font-size:48px;color:var(--gray3);margin-bottom:16px;display:block}
  .empty-state h3{font-size:18px;margin-bottom:8px;color:var(--text)}
  .empty-state p{font-size:14px;margin-bottom:24px}
</style>
@endpush

<div class="hero">
  <div class="hero-tag"><i class="ti ti-sun"></i> Selamat datang!</div>
  <h1>Rencanakan Petualanganmu 🌍</h1>
  <p>Kelola semua trip, itinerary, dan budget perjalananmu di satu tempat.</p>
  <a href="{{ route('trips.create') }}" class="btn-primary"><i class="ti ti-plus"></i> Buat Trip Baru</a>
</div>

<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon g"><i class="ti ti-map-2"></i></div>
    <div><div class="stat-val">{{ $trips->count() }}</div><div class="stat-lbl">Total Trip</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon t"><i class="ti ti-calendar-check"></i></div>
    <div><div class="stat-val">{{ $trips->where('status','upcoming')->count() }}</div><div class="stat-lbl">Upcoming</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon d"><i class="ti ti-wallet"></i></div>
    <div><div class="stat-val">Rp {{ number_format($trips->sum('budget')/1000000,1) }}jt</div><div class="stat-lbl">Total Budget</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon s"><i class="ti ti-map-pin"></i></div>
    <div><div class="stat-val">{{ $trips->where('status','done')->count() }}</div><div class="stat-lbl">Selesai</div></div>
  </div>
</div>

<div class="section-title">Semua Trip</div>

@if($trips->isEmpty())
  <div class="empty-state">
    <i class="ti ti-map-off"></i>
    <h3>Belum ada trip</h3>
    <p>Yuk buat rencana perjalanan pertamamu!</p>
    <a href="{{ route('trips.create') }}" class="btn-primary"><i class="ti ti-plus"></i> Buat Trip Pertama</a>
  </div>
@else
  <div class="trips-grid">
    @foreach($trips as $trip)
    @php
      $emojis = ['🌴','🏝️','🌋','🏔️','🗺️','✈️','🌊','🏖️'];
      $emoji  = $emojis[$trip->id % count($emojis)];
      $days   = \Carbon\Carbon::parse($trip->start_date)->diffInDays($trip->end_date) + 1;
    @endphp
    <div class="trip-card">
      <div class="trip-card-head">
        <div class="trip-emoji">{{ $emoji }}</div>
        <div style="flex:1">
          <h3>{{ $trip->trip_name }}</h3>
          <div class="trip-meta">
            <span><i class="ti ti-map-pin"></i> {{ $trip->destination }}</span>
            <span><i class="ti ti-calendar"></i> {{ \Carbon\Carbon::parse($trip->start_date)->format('d M Y') }}</span>
          </div>
        </div>
        <span class="badge {{ $trip->status }}">{{ ucfirst($trip->status) }}</span>
      </div>
      <div class="trip-stats">
        <div class="ts"><div class="ts-val">{{ $days }}</div><div class="ts-lbl">Hari</div></div>
        <div class="ts"><div class="ts-val">{{ $trip->itineraries->count() }}</div><div class="ts-lbl">Aktivitas</div></div>
        <div class="ts"><div class="ts-val">Rp {{ number_format($trip->budget/1000000,1) }}jt</div><div class="ts-lbl">Budget</div></div>
      </div>
      <div class="trip-actions">
        <a href="{{ route('trips.show', $trip) }}" class="btn-primary sm"><i class="ti ti-eye"></i> Lihat Detail</a>
        <a href="{{ route('trips.edit', $trip) }}" class="btn-outline sm"><i class="ti ti-edit"></i> Edit</a>
        <form action="{{ route('trips.destroy', $trip) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus trip ini?')">
          @csrf @method('DELETE')
          <button type="submit" class="btn-danger"><i class="ti ti-trash"></i></button>
        </form>
      </div>
    </div>
    @endforeach
  </div>
@endif
@endsection