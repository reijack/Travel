@extends('layouts.app')
@section('title','Edit Trip')
@section('page-title','Edit Trip')

@section('content')
<form action="{{ route('trips.update', $trip) }}" method="POST">
  @csrf
  @method('PUT')
  <div class="page-header">
    <div>
      <h1 class="page-h1">Edit Trip ✏️</h1>
      <p class="page-sub">Ubah detail rencana perjalanan</p>
    </div>
    <a href="{{ route('trips.show',$trip) }}" class="btn-outline"><i class="ti ti-arrow-left"></i> Kembali</a>
  </div>

  <div class="form-group">
  <label>Nama Trip *</label>
  <input type="text" name="trip_name" class="form-input"
    value="{{ old('trip_name',$trip->trip_name) }}"
    pattern="[A-Za-z\s]+"
    oninput="this.value=this.value.replace(/[^A-Za-z\s]/g,'')"
    maxlength="20"
    required/>
</div>

<div class="form-group">
  <label>Destinasi *</label>
  <input type="text" name="destination" class="form-input"
    value="{{ old('destination',$trip->destination) }}"
    pattern="[A-Za-z\s,]+"
    oninput="this.value=this.value.replace(/[^A-Za-z\s,]/g,'')"
    maxlength="20"
    required/>
</div>
    <div class="form-row">
      <div class="form-group">
        <label>Tanggal Berangkat *</label>
        <input type="date" name="start_date" class="form-input" value="{{ old('start_date',$trip->start_date) }}" required/>
      </div>
      <div class="form-group">
        <label>Tanggal Pulang *</label>
        <input type="date" name="end_date" class="form-input" value="{{ old('end_date',$trip->end_date) }}" required/>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Jumlah Orang</label>
        <input type="number" name="people" class="form-input" min="1" value="{{ old('people',$trip->people) }}"/>
      </div>
      <div class="form-group">
        <label>Total Budget (Rp)</label>
        <input type="number" name="budget" class="form-input" value="{{ old('budget',$trip->budget) }}"/>
      </div>
    </div>
    <div class="form-group">
      <label>Status</label>
      <select name="status" class="form-input">
        <option value="planned"  {{ $trip->status=='planned'  ?'selected':'' }}>Planned</option>
        <option value="upcoming" {{ $trip->status=='upcoming' ?'selected':'' }}>Upcoming</option>
        <option value="done"     {{ $trip->status=='done'     ?'selected':'' }}>Done</option>
      </select>
    </div>
    <div style="display:flex;gap:10px">
      <button type="submit" class="btn-primary"><i class="ti ti-check"></i> Update Trip</button>
      <a href="{{ route('trips.show',$trip) }}" class="btn-outline">Batal</a>
    </div>
</form>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const startDate = document.querySelector('input[name="start_date"]');
    const endDate = document.querySelector('input[name="end_date"]');

    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const todayStr = today.toISOString().split('T')[0];

    if (startDate) {
      startDate.min = todayStr;
      startDate.addEventListener('change', function () {
        if (!this.value) {
          endDate.min = todayStr;
          return;
        }

        endDate.min = this.value;
        if (endDate.value && endDate.value < this.value) {
          endDate.value = this.value;
        }
      });
    }

    if (endDate) {
      endDate.min = todayStr;
    }
  });
</script>

@endsection