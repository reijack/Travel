@extends('layouts.app')
@section('title','Buat Trip Baru')
@section('page-title','Buat Trip Baru')

@section('content')
<div class="page-header">
  <div>
    <h1 class="page-h1">Buat Trip Baru ✈️</h1>
    <p class="page-sub">Isi detail rencana perjalananmu</p>
  </div>
  <a href="{{ route('trips.index') }}" class="btn-outline"><i class="ti ti-arrow-left"></i> Kembali</a>
</div>

<div class="card" style="max-width:640px">
  <form action="{{ route('trips.store') }}" method="POST">
    @csrf
    <div class="form-group">
      <label>Nama Trip *</label>
      <input type="text" name="trip_name" class="form-input" placeholder="Cth: Liburan ke Bali" value="{{ old('trip_name') }}" required/>
      @error('trip_name')<div class="form-error">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
      <label>Destinasi *</label>
      <input type="text" name="destination" class="form-input" placeholder="Cth: Bali, Indonesia" value="{{ old('destination') }}" required/>
      @error('destination')<div class="form-error">{{ $message }}</div>@enderror
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Tanggal Berangkat *</label>
        <input type="date" name="start_date" class="form-input" value="{{ old('start_date') }}" required/>
      </div>
      <div class="form-group">
        <label>Tanggal Pulang *</label>
        <input type="date" name="end_date" class="form-input" value="{{ old('end_date') }}" required/>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Jumlah Orang</label>
        <input type="number" name="people" class="form-input" min="1" max="50" value="{{ old('people',2) }}"/>
      </div>
      <div class="form-group">
        <label>Total Budget (Rp)</label>
        <input type="number" name="budget" class="form-input" placeholder="Cth: 2000000" value="{{ old('budget') }}"/>
      </div>
    </div>
    <div class="form-group">
      <label>Status</label>
      <select name="status" class="form-input">
        <option value="planned">Planned</option>
        <option value="upcoming">Upcoming</option>
        <option value="done">Done</option>
      </select>
    </div>
    <div style="display:flex;gap:10px">
      <button type="submit" class="btn-primary"><i class="ti ti-check"></i> Simpan Trip</button>
      <a href="{{ route('trips.index') }}" class="btn-outline">Batal</a>
    </div>
  </form>
</div>
@endsection