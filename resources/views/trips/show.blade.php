@extends('layouts.app')
@section('title',$trip->trip_name)
@section('page-title',$trip->trip_name)

@push('styles')
<style>
  .trip-hero{background:linear-gradient(135deg,var(--forest),var(--sage));border-radius:24px;padding:28px 32px;margin-bottom:24px;color:#fff;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px}
  .trip-hero h2{font-family:var(--ff-display);font-size:24px;font-weight:600;margin-bottom:8px}
  .th-meta{display:flex;flex-wrap:wrap;gap:14px;font-size:13px;color:rgba(255,255,255,.75)}
  .th-meta span{display:flex;align-items:center;gap:5px}
  .tabs{display:flex;gap:4px;background:var(--sand);padding:4px;border-radius:10px;margin-bottom:22px}
  .tab-btn{padding:9px 20px;border-radius:8px;border:none;background:none;font-size:13px;color:var(--text-muted);cursor:pointer;font-family:var(--ff-body);transition:all .18s;display:flex;align-items:center;gap:6px}
  .tab-btn:hover{background:#fff}
  .tab-btn.active{background:#fff;color:var(--forest);font-weight:500;box-shadow:0 1px 4px rgba(0,0,0,.08)}
  .tab-content{display:none}.tab-content.active{display:block}
  .day-block{background:#fff;border-radius:16px;border:1px solid var(--gray2);overflow:hidden;margin-bottom:16px;box-shadow:0 1px 3px rgba(0,0,0,.06)}
  .day-header{background:var(--forest);padding:12px 20px;display:flex;align-items:center;justify-content:space-between}
  .day-title{color:#fff;font-size:15px;font-weight:500;font-family:var(--ff-display)}
  .act-list{padding:6px 20px 12px}
  .act-item{display:flex;align-items:flex-start;gap:12px;padding:10px 0;border-bottom:1px solid var(--gray2)}
  .act-item:last-child{border-bottom:none}
  .act-time{font-size:12px;color:var(--text-muted);width:44px;flex-shrink:0;padding-top:3px}
  .act-dot{width:10px;height:10px;border-radius:50%;flex-shrink:0;margin-top:5px}
  .act-info{flex:1}
  .act-name{font-size:14px;font-weight:500}
  .act-loc{font-size:12px;color:var(--text-muted);display:flex;align-items:center;gap:3px;margin-top:2px}
  .act-note{font-size:12px;color:var(--text-muted);margin-top:4px}
  .act-tag{font-size:11px;padding:2px 9px;border-radius:8px;font-weight:500;white-space:nowrap}
  .tag-pantai{background:#E6F1FB;color:#185FA5}
  .tag-budaya{background:#EEEDFE;color:#534AB7}
  .tag-alam{background:#EAF3DE;color:#3B6D11}
  .tag-wisata{background:#EEF5F2;color:var(--sage)}
  .tag-kuliner{background:#FAEEDA;color:#854F0B}
  .tag-belanja{background:#FEF8EC;color:var(--gold)}
  .tag-transport{background:var(--gray1);color:var(--gray4);border:1px solid var(--gray2)}
  .add-form{background:var(--gray1);border:1px dashed var(--gray3);border-radius:12px;padding:16px;margin:0 20px 14px;display:none}
  .add-form.open{display:block}
  .add-form-grid{display:grid;grid-template-columns:2fr 1fr 1fr;gap:10px;margin-bottom:10px}
  .add-form-grid2{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px}
  .bt-box{background:var(--forest);border-radius:16px;padding:22px 26px;color:#fff;margin-bottom:20px}
  .bt-lbl{font-size:13px;color:rgba(255,255,255,.65);margin-bottom:4px}
  .bt-val{font-family:var(--ff-display);font-size:30px;font-weight:600}
  .budget-table-wrap{background:#fff;border-radius:16px;border:1px solid var(--gray2);overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.06);margin-bottom:20px}
  .budget-table{width:100%;border-collapse:collapse}
  .budget-table th{background:var(--sand);padding:11px 16px;font-size:12px;font-weight:500;color:var(--text-muted);text-align:left;text-transform:uppercase;letter-spacing:.5px;border-bottom:1px solid var(--gray2)}
  .budget-table td{padding:13px 16px;font-size:14px;border-bottom:1px solid var(--gray2)}
  .budget-table tbody tr:last-child td{border-bottom:none}
  .budget-table tbody tr:hover{background:var(--gray1)}
  .budget-table tfoot td{background:var(--sand);font-weight:600}
  .cl-progress{background:#fff;border-radius:12px;border:1px solid var(--gray2);padding:14px 18px;margin-bottom:16px;display:flex;align-items:center;gap:14px;box-shadow:0 1px 3px rgba(0,0,0,.06)}
  .cl-track{flex:1;height:8px;background:var(--gray2);border-radius:4px}
  .cl-fill{height:100%;border-radius:4px;background:var(--forest)}
  .cl-box{background:#fff;border-radius:16px;border:1px solid var(--gray2);overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.06);margin-bottom:16px}
  .cl-item{display:flex;align-items:center;gap:12px;padding:13px 18px;border-bottom:1px solid var(--gray2);transition:background .15s}
  .cl-item:last-child{border-bottom:none}
  .cl-item:hover{background:var(--gray1)}
  .cl-name{flex:1;font-size:14px}
  .cl-name.done{text-decoration:line-through;color:var(--gray3)}
  .photo-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px}
  .photo-card{background:#fff;border-radius:12px;border:1px solid var(--gray2);overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.06)}
  .photo-card img{width:100%;height:160px;object-fit:cover}
  .photo-info{padding:12px}
</style>
@endpush

@section('content')
@php $days=\Carbon\Carbon::parse($trip->start_date)->diffInDays($trip->end_date)+1; @endphp

<a href="{{ route('trips.index') }}" class="btn-outline sm" style="margin-bottom:16px;display:inline-flex"><i class="ti ti-arrow-left"></i> Semua Trip</a>

<div class="trip-hero">
  <div>
    <h2>{{ $trip->trip_name }} 🌴</h2>
    <div class="th-meta">
      <span><i class="ti ti-map-pin"></i> {{ $trip->destination }}</span>
      <span><i class="ti ti-calendar"></i> {{ \Carbon\Carbon::parse($trip->start_date)->format('d M Y') }} – {{ \Carbon\Carbon::parse($trip->end_date)->format('d M Y') }}</span>
      <span><i class="ti ti-clock"></i> {{ $days }} Hari</span>
      <span><i class="ti ti-users"></i> {{ $trip->people }} Orang</span>
      <span><i class="ti ti-wallet"></i> Rp {{ number_format($trip->budget) }}</span>
    </div>
  </div>
  <a href="{{ route('trips.edit',$trip) }}" class="btn-outline sm" style="color:#fff;border-color:rgba(255,255,255,.4)"><i class="ti ti-edit"></i> Edit</a>
</div>

<div class="tabs">
  <button class="tab-btn active" onclick="switchTab('itinerary')"><i class="ti ti-calendar-event"></i> Itinerary</button>
  <button class="tab-btn" onclick="switchTab('budget')"><i class="ti ti-wallet"></i> Budget</button>
  <button class="tab-btn" onclick="switchTab('checklist')"><i class="ti ti-checklist"></i> Checklist</button>
  <button class="tab-btn" onclick="switchTab('gallery')"><i class="ti ti-photo"></i> Galeri</button>
</div>

{{-- ITINERARY --}}
<div class="tab-content active" id="tab-itinerary">
  @for($d=1;$d<=$days;$d++)
  @php $dayActs=$itineraries->get($d,collect()); @endphp
  <div class="day-block">
    <div class="day-header">
      <div class="day-title">Hari {{ $d }} — {{ \Carbon\Carbon::parse($trip->start_date)->addDays($d-1)->isoFormat('dddd, D MMMM Y') }}</div>
      <button class="btn-outline sm" style="color:#fff;border-color:rgba(255,255,255,.4);background:transparent" onclick="toggleForm({{ $d }})">
        <i class="ti ti-plus"></i> Tambah
      </button>
    </div>
    <div class="act-list">
      @forelse($dayActs as $act)
      <div class="act-item">
        <div class="act-time">{{ $act->time ? substr($act->time,0,5) : '—' }}</div>
        <div class="act-dot" style="background:{{ ['pantai'=>'#185FA5','budaya'=>'#534AB7','alam'=>'#3B6D11','wisata'=>'#52796F','kuliner'=>'#854F0B','belanja'=>'#E09F3E','transport'=>'#9A9890'][$act->category] ?? '#ccc' }}"></div>
        <div class="act-info">
          <div class="act-name">{{ $act->activity }}</div>
          @if($act->location)<div class="act-loc"><i class="ti ti-map-pin"></i> {{ $act->location }}</div>@endif
          @if($act->notes)<div class="act-note">{{ $act->notes }}</div>@endif
        </div>
        <span class="act-tag tag-{{ $act->category }}">{{ ucfirst($act->category) }}</span>
        <form action="{{ route('itineraries.destroy',$act) }}" method="POST" style="margin-left:8px">
          @csrf @method('DELETE')
          <button type="submit" class="btn-danger" style="padding:5px 8px"><i class="ti ti-trash"></i></button>
        </form>
      </div>
      @empty
      <div style="padding:16px 0;text-align:center;color:var(--text-muted);font-size:13px">Belum ada aktivitas.</div>
      @endforelse
    </div>
    <div class="add-form" id="form-{{ $d }}">
      <form action="{{ route('itineraries.store',$trip) }}" method="POST">
        @csrf
        <input type="hidden" name="day" value="{{ $d }}">
        <div class="add-form-grid">
          <div class="form-group" style="margin:0">
            <label>Aktivitas *</label>
            <input type="text" name="activity" class="form-input" placeholder="Nama tempat" required/>
          </div>
          <div class="form-group" style="margin:0">
            <label>Waktu</label>
            <input type="time" name="time" class="form-input" value="09:00"/>
          </div>
          <div class="form-group" style="margin:0">
            <label>Kategori</label>
            <select name="category" class="form-input">
              <option value="wisata">Wisata</option>
              <option value="pantai">Pantai</option>
              <option value="budaya">Budaya</option>
              <option value="alam">Alam</option>
              <option value="kuliner">Kuliner</option>
              <option value="belanja">Belanja</option>
              <option value="transport">Transport</option>
            </select>
          </div>
        </div>
        <div class="add-form-grid2">
          <div class="form-group" style="margin:0">
            <label>Lokasi</label>
            <input type="text" name="location" class="form-input" placeholder="Cth: Kuta, Bali"/>
          </div>
          <div class="form-group" style="margin:0">
            <label>Catatan</label>
            <input type="text" name="notes" class="form-input" placeholder="Tips..."/>
          </div>
        </div>
        <div style="display:flex;gap:8px">
          <button type="submit" class="btn-primary sm"><i class="ti ti-check"></i> Simpan</button>
          <button type="button" class="btn-outline sm" onclick="toggleForm({{ $d }})">Batal</button>
        </div>
      </form>
    </div>
  </div>
  @endfor
</div>

{{-- BUDGET --}}
<div class="tab-content" id="tab-budget">
  @php $totalEst=$budgets->sum('estimated'); @endphp
  <div class="bt-box">
    <div class="bt-lbl">Total Estimasi Budget</div>
    <div class="bt-val">Rp {{ number_format($totalEst) }}</div>
  </div>
  <div class="budget-table-wrap">
    <table class="budget-table">
      <thead><tr><th>Kategori</th><th>Keterangan</th><th>Estimasi</th><th>Aktual</th><th></th></tr></thead>
      <tbody>
        @forelse($budgets as $b)
        <tr>
          <td><strong>{{ ucfirst($b->category) }}</strong></td>
          <td>{{ $b->description ?? '—' }}</td>
          <td>Rp {{ number_format($b->estimated) }}</td>
          <td>{{ $b->actual ? 'Rp '.number_format($b->actual) : '—' }}</td>
          <td>
            <form action="{{ route('budgets.destroy',$b) }}" method="POST">
              @csrf @method('DELETE')
              <button type="submit" class="btn-danger" style="padding:5px 8px"><i class="ti ti-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;color:var(--text-muted);padding:24px">Belum ada budget.</td></tr>
        @endforelse
      </tbody>
      <tfoot><tr><td colspan="2">TOTAL</td><td>Rp {{ number_format($totalEst) }}</td><td>—</td><td></td></tr></tfoot>
    </table>
  </div>
  <div class="card" style="max-width:540px">
    <div style="font-size:15px;font-weight:500;margin-bottom:16px;color:var(--forest)">Tambah Budget</div>
    <form action="{{ route('budgets.store',$trip) }}" method="POST">
      @csrf
      <div class="form-row">
        <div class="form-group">
          <label>Kategori</label>
          <select name="category" class="form-input">
            <option value="transportasi">Transportasi</option>
            <option value="hotel">Hotel</option>
            <option value="makan">Makan</option>
            <option value="tiket">Tiket Wisata</option>
            <option value="belanja">Belanja</option>
            <option value="lainnya">Lainnya</option>
          </select>
        </div>
        <div class="form-group">
          <label>Keterangan</label>
          <input type="text" name="description" class="form-input" placeholder="Cth: Tiket pesawat PP"/>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Estimasi (Rp) *</label>
          <input type="number" name="estimated" class="form-input" placeholder="500000" required/>
        </div>
        <div class="form-group">
          <label>Aktual (Rp)</label>
          <input type="number" name="actual" class="form-input" placeholder="Opsional"/>
        </div>
      </div>
      <button type="submit" class="btn-primary"><i class="ti ti-check"></i> Simpan</button>
    </form>
  </div>
</div>

{{-- CHECKLIST --}}
<div class="tab-content" id="tab-checklist">
  @php $done=$checklists->where('status',true)->count(); $total=$checklists->count(); $pct=$total>0?round($done/$total*100):0; @endphp
  <div class="cl-progress">
    <span style="font-size:13px;color:var(--text-muted);min-width:140px">{{ $done }} dari {{ $total }} selesai</span>
    <div class="cl-track"><div class="cl-fill" style="width:{{ $pct }}%"></div></div>
    <span style="font-size:13px;font-weight:500;color:var(--forest)">{{ $pct }}%</span>
  </div>
  <div class="cl-box">
    @forelse($checklists as $cl)
    <div class="cl-item">
      <form action="{{ route('checklists.toggle',$cl) }}" method="POST">
        @csrf @method('PATCH')
        <button type="submit" style="background:none;border:none;cursor:pointer;display:flex;align-items:center">
          <div style="width:22px;height:22px;border-radius:7px;border:1.5px solid {{ $cl->status?'var(--forest)':'var(--gray3)' }};background:{{ $cl->status?'var(--forest)':'transparent' }};display:flex;align-items:center;justify-content:center">
            @if($cl->status)<i class="ti ti-check" style="color:#fff;font-size:13px"></i>@endif
          </div>
        </button>
      </form>
      <div style="flex:1;margin-left:10px">
        <div class="cl-name {{ $cl->status?'done':'' }}">{{ $cl->item_name }}</div>
        @if($cl->note)<div style="font-size:11px;color:var(--text-muted)">{{ $cl->note }}</div>@endif
      </div>
      <form action="{{ route('checklists.destroy',$cl) }}" method="POST">
        @csrf @method('DELETE')
        <button type="submit" style="background:none;border:none;cursor:pointer;color:var(--gray3);font-size:16px"><i class="ti ti-x"></i></button>
      </form>
    </div>
    @empty
    <div style="padding:24px;text-align:center;color:var(--text-muted);font-size:13px">Belum ada checklist.</div>
    @endforelse
  </div>
  <div class="card" style="max-width:480px">
    <div style="font-size:15px;font-weight:500;margin-bottom:14px;color:var(--forest)">Tambah Item</div>
    <form action="{{ route('checklists.store',$trip) }}" method="POST">
      @csrf
      <div class="form-group">
        <label>Nama Item *</label>
        <input type="text" name="item_name" class="form-input" placeholder="Cth: Bawa sunscreen" required/>
      </div>
      <div class="form-group">
        <label>Keterangan</label>
        <input type="text" name="note" class="form-input" placeholder="Opsional"/>
      </div>
      <button type="submit" class="btn-primary"><i class="ti ti-check"></i> Tambah</button>
    </form>
  </div>
</div>

{{-- GALLERY --}}
<div class="tab-content" id="tab-gallery">
  <div class="photo-grid">
    @forelse($photos as $photo)
    <div class="photo-card">
      <img src="{{ asset('storage/'.$photo->image_path) }}" alt="{{ $photo->caption }}"/>
      <div class="photo-info">
        <div style="font-size:13px;font-weight:500">{{ $photo->caption ?? 'Foto perjalanan' }}</div>
        <div style="display:flex;justify-content:space-between;align-items:center;margin-top:8px">
          <div style="font-size:11px;color:var(--text-muted)">{{ $photo->created_at->format('d M Y') }}</div>
          <form action="{{ route('photos.destroy',$photo) }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit" class="btn-danger" style="padding:4px 8px"><i class="ti ti-trash"></i></button>
          </form>
        </div>
      </div>
    </div>
    @empty
    <div style="grid-column:1/-1;text-align:center;padding:40px;color:var(--text-muted)">Belum ada foto.</div>
    @endforelse
  </div>
  <div class="card" style="margin-top:20px;max-width:480px">
    <div style="font-size:15px;font-weight:500;margin-bottom:14px;color:var(--forest)">Upload Foto</div>
    <form action="{{ route('photos.store',$trip) }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label>Pilih Foto *</label>
        <input type="file" name="image" class="form-input" accept="image/*" required/>
      </div>
      <div class="form-group">
        <label>Caption</label>
        <input type="text" name="caption" class="form-input" placeholder="Cth: Sunset di Kuta"/>
      </div>
      <button type="submit" class="btn-primary"><i class="ti ti-upload"></i> Upload</button>
    </form>
  </div>
</div>

@endsection

@push('scripts')
<script>
function switchTab(name){
  document.querySelectorAll('.tab-btn').forEach((b,i)=>{
    b.classList.toggle('active',['itinerary','budget','checklist','gallery'][i]===name);
  });
  document.querySelectorAll('.tab-content').forEach(c=>c.classList.remove('active'));
  document.getElementById('tab-'+name).classList.add('active');
}
function toggleForm(day){
  const f=document.getElementById('form-'+day);
  f.classList.toggle('open');
}
</script>
@endpush