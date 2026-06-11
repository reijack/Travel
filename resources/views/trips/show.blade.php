@extends('layouts.app')
@section('title',$trip->trip_name)
@section('page-title',$trip->trip_name)

@push('styles')
<style>
  .trip-hero{background:linear-gradient(135deg,var(--forest),var(--sage));border-radius:24px;padding:28px 32px;margin-bottom:24px;color:#fff;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px}
  .trip-hero h2{font-family:var(--ff-display);font-size:24px;font-weight:600;margin-bottom:8px}
  .th-meta{display:flex;flex-wrap:wrap;gap:14px;font-size:13px;color:rgba(255,255,255,.75)}
  .th-meta span{display:flex;align-items:center;gap:5px}
  .tabs{display:flex;gap:4px;background:var(--sand);padding:4px;border-radius:10px;margin-bottom:22px;width:100%}
  .tab-btn{flex:1;padding:10px 16px;border-radius:8px;border:none;background:none;font-size:13px;color:var(--text-muted);cursor:pointer;font-family:var(--ff-body);transition:all .18s;display:flex;align-items:center;justify-content:center;gap:6px}
  .tab-btn:hover{background:#fff}
  .tab-btn.active{background:#fff;color:var(--forest);font-weight:500;box-shadow:0 1px 4px rgba(0,0,0,.08)}
  .tab-content{display:none;width:100%}
  .tab-content.active{display:block}
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
  .budget-stats{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px}
  .bs-card{border-radius:16px;padding:22px 26px;color:#fff}
  .bs-card.total{background:var(--forest)}
  .bs-card.perorang{background:var(--terra)}
  .bs-lbl{font-size:13px;color:rgba(255,255,255,.7);margin-bottom:6px}
  .bs-val{font-family:var(--ff-display);font-size:28px;font-weight:600}
  .bs-sub{font-size:12px;color:rgba(255,255,255,.6);margin-top:4px}
  .budget-table-wrap{background:#fff;border-radius:16px;border:1px solid var(--gray2);overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.06);margin-bottom:24px}
  .budget-table{width:100%;border-collapse:collapse}
  .budget-table th{background:var(--sand);padding:11px 16px;font-size:12px;font-weight:500;color:var(--text-muted);text-align:left;text-transform:uppercase;letter-spacing:.5px;border-bottom:1px solid var(--gray2)}
  .budget-table td{padding:13px 16px;font-size:14px;border-bottom:1px solid var(--gray2)}
  .budget-table tbody tr:last-child td{border-bottom:none}
  .budget-table tbody tr:hover{background:var(--gray1)}
  .budget-table tfoot td{background:var(--sand);font-weight:600}
  .cl-progress{background:#fff;border-radius:12px;border:1px solid var(--gray2);padding:14px 18px;margin-bottom:16px;display:flex;align-items:center;gap:14px;box-shadow:0 1px 3px rgba(0,0,0,.06)}
  .cl-track{flex:1;height:8px;background:var(--gray2);border-radius:4px}
  .cl-fill{height:100%;border-radius:4px;background:var(--forest);transition:width .3s}
  .cl-box{background:#fff;border-radius:16px;border:1px solid var(--gray2);overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.06);margin-bottom:24px}
  .cl-item{display:flex;align-items:center;gap:12px;padding:13px 18px;border-bottom:1px solid var(--gray2);transition:background .15s}
  .cl-item:last-child{border-bottom:none}
  .cl-item:hover{background:var(--gray1)}
  .cl-name{flex:1;font-size:14px}0
  .cl-name.done{text-decoration:line-through;color:var(--gray3)}
  .photo-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px}
  .photo-card{background:#fff;border-radius:12px;border:1px solid var(--gray2);overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.06);transition:all .18s}
  .photo-card:hover{transform:translateY(-2px);box-shadow:0 4px 12px rgba(0,0,0,.08)}
  .photo-card img{width:100%;height:180px;object-fit:cover}
  .photo-info{padding:12px}
  .photo-caption{font-size:13px;font-weight:500;color:var(--text)}
  .photo-date{font-size:11px;color:var(--text-muted);margin-top:4px;display:flex;align-items:center;gap:4px}
  .empty-state{text-align:center;padding:48px 20px;color:var(--text-muted)}
  .empty-state i{font-size:40px;color:var(--gray3);margin-bottom:12px;display:block}
  .form-section{background:#fff;border-radius:16px;border:1px solid var(--gray2);padding:24px;box-shadow:0 1px 3px rgba(0,0,0,.06)}
  .form-section-title{font-size:15px;font-weight:500;color:var(--forest);margin-bottom:18px;display:flex;align-items:center;gap:8px}
  .modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:999;align-items:center;justify-content:center;padding:20px}
  .modal-overlay.open{display:flex}
  .modal{background:#fff;border-radius:20px;width:100%;max-width:500px;box-shadow:0 20px 60px rgba(0,0,0,.15)}
  .modal-header{display:flex;align-items:center;justify-content:space-between;padding:20px 24px 16px;border-bottom:1px solid var(--gray2)}
  .modal-title{font-family:var(--ff-display);font-size:18px;font-weight:600;color:var(--forest)}
  .modal-close{background:none;border:none;cursor:pointer;color:var(--gray4);font-size:20px;width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center}
  .modal-body{padding:20px 24px}
  .modal-footer{display:flex;justify-content:flex-end;gap:10px;padding:16px 24px 20px;border-top:1px solid var(--gray2)}
  .btn-ghost{background:transparent;color:var(--text-muted);border:none;border-radius:8px;padding:10px 18px;font-size:14px;font-family:var(--ff-body);cursor:pointer}
  .btn-ghost:hover{background:var(--gray1)}
</style>
@endpush

@section('content')
@php $days=\Carbon\Carbon::parse($trip->start_date)->diffInDays($trip->end_date)+1; @endphp

<div style="margin-bottom:16px">
  <a href="{{ route('trips.index') }}" class="btn-outline sm"><i class="ti ti-arrow-left"></i> Semua Trip</a>
</div>

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
  <a href="{{ route('trips.edit',$trip) }}" class="btn-outline sm" style="color:#fff;border-color:rgba(255,255,255,.4)">
    <i class="ti ti-edit"></i> Edit
  </a>
</div>

<div class="tabs">
  <button class="tab-btn active" onclick="switchTab('itinerary',this)"><i class="ti ti-calendar-event"></i> Itinerary</button>
  <button class="tab-btn" onclick="switchTab('budget',this)"><i class="ti ti-wallet"></i> Budget</button>
  <button class="tab-btn" onclick="switchTab('checklist',this)"><i class="ti ti-checklist"></i> Checklist</button>
  <button class="tab-btn" onclick="switchTab('gallery',this)"><i class="ti ti-photo"></i> Galeri</button>
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
        <div style="display:flex;gap:4px;margin-left:8px">
          <button type="button" class="btn-outline sm" style="padding:5px 8px"
            onclick="openEditAct({{ $act->id }},'{{ addslashes($act->activity) }}','{{ $act->time ? substr($act->time,0,5) : '' }}','{{ addslashes($act->location ?? '') }}','{{ $act->category }}','{{ addslashes($act->notes ?? '') }}')">
            <i class="ti ti-edit"></i>
          </button>
          <form action="{{ route('itineraries.destroy',$act) }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit" class="btn-danger" style="padding:5px 8px" onclick="return confirm('Hapus?')">
              <i class="ti ti-trash"></i>
            </button>
          </form>
        </div>
      </div>
      @empty
      <div class="empty-state">
        <i class="ti ti-calendar-off"></i>
        Belum ada aktivitas. Klik <strong>Tambah</strong>.
      </div>
      @endforelse
    </div>
    <div class="add-form" id="form-{{ $d }}">
      <form action="{{ route('itineraries.store',$trip) }}" method="POST">
        @csrf
        <input type="hidden" name="day" value="{{ $d }}">
        <div class="add-form-grid">
          <div class="form-group" style="margin:0">
            <label>Aktivitas *</label>
            <input type="text" name="activity" class="form-input" placeholder="Cth: Pantai Kuta" 
            maxlength="60"
            oninput="this.value=this.value.replace(/[^A-Za-z\s]/g,'')"
            required/>
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
            <input type="text" name="location" class="form-input" placeholder="Cth: Kuta, Bali"
             maxlength="60"
            />
            
          </div>
          <div class="form-group" style="margin:0">
            <label>Catatan</label>
            <input type="text" name="notes" class="form-input" placeholder="Tips..."
            maxlength="60"
            oninput="this.value=this.value.replace(/[^A-Za-z\s]/g,'')"
            />
          </div>
        </div>
        <div style="display:flex;gap:8px;margin-top:4px">
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
  @php
    $totalEst = $budgets->sum('estimated');
    $totalAct = $budgets->sum('actual');
    $perOrang = $trip->people > 0 ? $totalEst / $trip->people : 0;
  @endphp
  <div class="budget-stats">
    <div class="bs-card total">
      <div class="bs-lbl">Total Estimasi Budget</div>
      <div class="bs-val">Rp {{ number_format($totalEst) }}</div>
      @if($totalAct > 0)<div class="bs-sub">Aktual: Rp {{ number_format($totalAct) }}</div>@endif
    </div>
    <div class="bs-card perorang">
      <div class="bs-lbl">Per Orang ({{ $trip->people }} orang)</div>
      <div class="bs-val">Rp {{ number_format($perOrang) }}</div>
    </div>
  </div>
  <div class="budget-table-wrap">
    <table class="budget-table">
      <thead>
        <tr><th>Kategori</th><th>Keterangan</th><th>Estimasi</th><th>Per Orang</th><th>Aktual</th><th></th></tr>
      </thead>
      <tbody>
        @forelse($budgets as $b)
        <tr>
          <td><strong>{{ ucfirst($b->category) }}</strong></td>
          <td>{{ $b->description ?? '—' }}</td>
          <td>Rp {{ number_format($b->estimated) }}</td>
          <td>Rp {{ number_format($trip->people > 0 ? $b->estimated / $trip->people : 0) }}</td>
          <td>{{ $b->actual ? 'Rp '.number_format($b->actual) : '—' }}</td>
          <td>
            <div style="display:flex;gap:4px">
              <button type="button" class="btn-outline sm" style="padding:5px 8px"
                onclick="openEditBudget({{ $b->id }},'{{ $b->category }}','{{ addslashes($b->description ?? '') }}',{{ $b->estimated }},{{ $b->actual ?? 0 }})">
                <i class="ti ti-edit"></i>
              </button>
              <form action="{{ route('budgets.destroy',$b) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger" style="padding:5px 8px" onclick="return confirm('Hapus?')">
                  <i class="ti ti-trash"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;color:var(--text-muted);padding:28px">Belum ada budget.</td></tr>
        @endforelse
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2"><strong>TOTAL</strong></td>
          <td><strong>Rp {{ number_format($totalEst) }}</strong></td>
          <td><strong>Rp {{ number_format($perOrang) }}</strong></td>
          <td><strong>{{ $totalAct > 0 ? 'Rp '.number_format($totalAct) : '—' }}</strong></td>
          <td></td>
        </tr>
      </tfoot>
    </table>
  </div>
  <div class="form-section">
    <div class="form-section-title"><i class="ti ti-plus"></i> Tambah Budget</div>
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
          <input type="text" name="description" class="form-input" placeholder="Cth: Tiket pesawat PP" maxlength="60" oninput="this.value=this.value.replace(/[^A-Za-z\s]/g,'')"/>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Estimasi (Rp) *"</label>
          <input type="number" name="estimated" class="form-input" placeholder="500000" required/>
        </div>
        <div class="form-group">
          <label>Aktual (Rp)</label>
          <input type="number" name="actual" class="form-input" placeholder="Opsional"/>
        </div>
      </div>
      <button type="submit" class="btn-primary"><i class="ti ti-check"></i> Simpan Budget</button>
    </form>
  </div>
</div>

{{-- CHECKLIST --}}
<div class="tab-content" id="tab-checklist">
  @php
    $done  = $checklists->where('status',true)->count();
    $total = $checklists->count();
    $pct   = $total > 0 ? round($done / $total * 100) : 0;
  @endphp
  <div class="cl-progress">
    <span style="font-size:13px;color:var(--text-muted);min-width:150px">{{ $done }} dari {{ $total }} selesai</span>
    <div class="cl-track"><div class="cl-fill" style="width:{{ $pct }}%"></div></div>
    <span style="font-size:14px;font-weight:500;color:var(--forest)">{{ $pct }}%</span>
  </div>
  <div class="cl-box">
    @forelse($checklists as $cl)
    <div class="cl-item">
      <form action="{{ route('checklists.toggle',$cl) }}" method="POST">
        @csrf @method('PATCH')
        <button type="submit" style="background:none;border:none;cursor:pointer;padding:0;display:flex">
          <div style="width:22px;height:22px;border-radius:7px;border:1.5px solid {{ $cl->status ? 'var(--forest)' : 'var(--gray3)' }};background:{{ $cl->status ? 'var(--forest)' : 'transparent' }};display:flex;align-items:center;justify-content:center">
            @if($cl->status)<i class="ti ti-check" style="color:#fff;font-size:13px"></i>@endif
          </div>
        </button>
      </form>
      <div style="flex:1;margin-left:12px">
        <div class="cl-name {{ $cl->status ? 'done' : '' }}">{{ $cl->item_name }}</div>
        @if($cl->note)<div style="font-size:11px;color:var(--text-muted)">{{ $cl->note }}</div>@endif
      </div>
      <div style="display:flex;gap:4px">
        <button type="button" style="background:none;border:none;cursor:pointer;color:var(--gray4);font-size:16px;padding:4px"
          onclick="openEditCheck({{ $cl->id }},'{{ addslashes($cl->item_name) }}','{{ addslashes($cl->note ?? '') }}')">
          <i class="ti ti-edit"></i>
        </button>
        <form action="{{ route('checklists.destroy',$cl) }}" method="POST">
          @csrf @method('DELETE')
          <button type="submit" style="background:none;border:none;cursor:pointer;color:var(--gray3);font-size:16px;padding:4px" onclick="return confirm('Hapus?')">
            <i class="ti ti-x"></i>
          </button>
        </form>
      </div>
    </div>
    @empty
    <div class="empty-state">
      <i class="ti ti-checklist"></i>
      Belum ada item checklist.
    </div>
    @endforelse
  </div>
  <div class="form-section" style="max-width:500px">
    <div class="form-section-title"><i class="ti ti-plus"></i> Tambah Item</div>
    <form action="{{ route('checklists.store',$trip) }}" method="POST">
      @csrf
      <div class="form-group">
        <label>Nama Item *</label>
        <input type="text" name="item_name" class="form-input" placeholder="Cth: Bawa sunscreen" required
          maxlength="60"
          oninput="this.value=this.value.replace(/[^A-Za-z\s]/g,'')"
        />
      </div>
      <div class="form-group">
        <label>Keterangan</label>
        <input type="text" name="note" class="form-input" placeholder="Opsional"
          maxlength="60"
          oninput="this.value=this.value.replace(/[^A-Za-z\s]/g,'')"
        />
      </div>
      <button type="submit" class="btn-primary"><i class="ti ti-check"></i> Tambah</button>
    </form>
  </div>
</div>

{{-- GALLERY --}}
<div class="tab-content" id="tab-gallery">
  @if($photos->isEmpty())
  <div class="empty-state" style="background:#fff;border-radius:16px;border:1px solid var(--gray2)">
    <i class="ti ti-photo-off"></i>
    Belum ada foto.
  </div>
  @else
  <div class="photo-grid">
    @foreach($photos as $photo)
    <div class="photo-card">
      <img src="{{ asset('storage/'.$photo->image_path) }}" alt="{{ $photo->caption }}"/>
      <div class="photo-info">
        <div class="photo-caption">{{ $photo->caption ?? 'Foto perjalanan' }}</div>
        <div style="display:flex;justify-content:space-between;align-items:center;margin-top:8px">
          <div class="photo-date"><i class="ti ti-calendar"></i> {{ $photo->created_at->format('d M Y') }}</div>
          <div style="display:flex;gap:4px">
            <button type="button" class="btn-outline sm" style="padding:4px 8px"
              onclick='openEditPhoto({{ $photo->id }}, @json($photo->caption ?? ""))'>
              <i class="ti ti-edit"></i>
            </button>
            <form action="{{ route('photos.destroy',$photo) }}" method="POST" onsubmit="return confirm('Hapus?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn-danger" style="padding:4px 8px"><i class="ti ti-trash"></i></button>
            </form>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  @endif
  <div class="form-section" style="max-width:500px;margin-top:20px">
    <div class="form-section-title"><i class="ti ti-upload"></i> Upload Foto</div>
    <form action="{{ route('photos.store',$trip) }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label>Pilih Foto *</label>
        <input type="file" name="image" class="form-input" accept="image/*" required/>
      </div>
      <div class="form-group">
        <label>Caption</label>
        <input type="text" name="caption" class="form-input" placeholder="Cth: Sunset di Kuta 🌅"/>
      </div>
      <button type="submit" class="btn-primary"><i class="ti ti-upload"></i> Upload</button>
    </form>
  </div>
</div>

{{-- MODAL EDIT AKTIVITAS --}}
<div class="modal-overlay" id="modalAct">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Edit Aktivitas</div>
      <button class="modal-close" onclick="closeModal('modalAct')"><i class="ti ti-x"></i></button>
    </div>
    <form id="formEditAct" method="POST">
      @csrf @method('PUT')
      <div class="modal-body">
        <div class="form-group">
          <label>Nama Aktivitas *</label>
          <input type="text" name="activity" id="editActName" class="form-input"
          maxlength="60"
          oninput="this.value=this.value.replace(/[^A-Za-z\s]/g,'')" 
          required/>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Waktu</label>
            <input type="time" name="time" id="editActTime" class="form-input"/>
          </div>
          <div class="form-group">
            <label>Kategori</label>
            <select name="category" id="editActCat" class="form-input">
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
        <div class="form-group">
          <label>Lokasi</label>
          <input type="text" name="location" id="editActLoc" class="form-input"
          maxlength="60"
          />
          
        </div>
        <div class="form-group" style="margin:0">
          <label>Catatan</label>
          <input type="text" name="notes" id="editActNotes" class="form-input"
          maxlength="60"
          oninput="this.value=this.value.replace(/[^A-Za-z\s]/g,'')" />
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-ghost" onclick="closeModal('modalAct')">Batal</button>
        <button type="submit" class="btn-primary"><i class="ti ti-check"></i> Simpan</button>
      </div>
    </form>
  </div>
</div>

{{-- MODAL EDIT BUDGET --}}
<div class="modal-overlay" id="modalBudget">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Edit Budget</div>
      <button class="modal-close" onclick="closeModal('modalBudget')"><i class="ti ti-x"></i></button>
    </div>
    <form id="formEditBudget" method="POST">
      @csrf @method('PUT')
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group">
            <label>Kategori</label>
            <select name="category" id="editBudgetCat" class="form-input">
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
            <input type="text" name="description" id="editBudgetDesc" class="form-input"
            maxlength="60"
            oninput="this.value=this.value.replace(/[^A-Za-z\s]/g,'')"
            />
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Estimasi (Rp) *</label>
            <input type="number" name="estimated" id="editBudgetEst" class="form-input" required/>
          </div>
          <div class="form-group" style="margin:0">
            <label>Aktual (Rp)</label>
            <input type="number" name="actual" id="editBudgetAct" class="form-input"/>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-ghost" onclick="closeModal('modalBudget')">Batal</button>
        <button type="submit" class="btn-primary"><i class="ti ti-check"></i> Simpan</button>
      </div>
    </form>
  </div>
</div>

{{-- MODAL EDIT CHECKLIST --}}
<div class="modal-overlay" id="modalCheck">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Edit Checklist</div>
      <button class="modal-close" onclick="closeModal('modalCheck')"><i class="ti ti-x"></i></button>
    </div>
    <form id="formEditCheck" method="POST">
      @csrf @method('PUT')
      <div class="modal-body">
        <div class="form-group">
          <label>Nama Item *</label>
          <input type="text" name="item_name" id="editCheckName" class="form-input" required/>
        </div>
        <div class="form-group" style="margin:0">
          <label>Keterangan</label>
          <input type="text" name="note" id="editCheckNote" class="form-input"
          maxlength="60"
          oninput="this.value=this.value.replace(/[^A-Za-z\s]/g,'')"
          />
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-ghost" onclick="closeModal('modalCheck')">Batal</button>
        <button type="submit" class="btn-primary"><i class="ti ti-check"></i> Simpan</button>
      </div>
    </form>
  </div>
</div>

{{-- MODAL EDIT FOTO --}}
<div class="modal-overlay" id="modalPhoto">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Edit Caption Foto</div>
      <button class="modal-close" onclick="closeModal('modalPhoto')"><i class="ti ti-x"></i></button>
    </div>
    <form id="formEditPhoto" method="POST">
      @csrf @method('PUT')
      <div class="modal-body">
        <div class="form-group" style="margin:0">
          <label>Caption</label>
          <input type="text" name="caption" id="editPhotoCaption" class="form-input"/>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-ghost" onclick="closeModal('modalPhoto')">Batal</button>
        <button type="submit" class="btn-primary"><i class="ti ti-check"></i> Simpan</button>
      </div>
    </form>
  </div>
</div>

@endsection

@push('scripts')
<script>
function switchTab(name, btn) {
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
  document.getElementById('tab-' + name).classList.add('active');
}
function toggleForm(day) {
  document.getElementById('form-' + day).classList.toggle('open');
}
function openModal(id) {
  document.getElementById(id).classList.add('open');
}
function closeModal(id) {
  document.getElementById(id).classList.remove('open');
}
document.querySelectorAll('.modal-overlay').forEach(el => {
  el.addEventListener('click', function(e) {
    if (e.target === this) this.classList.remove('open');
  });
});
function openEditAct(id, activity, time, location, category, notes) {
  document.getElementById('formEditAct').action = '/itineraries/' + id;
  document.getElementById('editActName').value  = activity;
  document.getElementById('editActTime').value  = time;
  document.getElementById('editActLoc').value   = location;
  document.getElementById('editActNotes').value = notes;
  document.getElementById('editActCat').value   = category;
  openModal('modalAct');
}
function openEditBudget(id, category, description, estimated, actual) {
  document.getElementById('formEditBudget').action = '/budgets/' + id;
  document.getElementById('editBudgetCat').value   = category;
  document.getElementById('editBudgetDesc').value  = description;
  document.getElementById('editBudgetEst').value   = estimated;
  document.getElementById('editBudgetAct').value   = actual > 0 ? actual : '';
  openModal('modalBudget');
}
function openEditCheck(id, name, note) {
  document.getElementById('formEditCheck').action  = '/checklists/' + id;
  document.getElementById('editCheckName').value   = name;
  document.getElementById('editCheckNote').value   = note;
  openModal('modalCheck');
}
function openEditPhoto(id, caption) {
  document.getElementById('formEditPhoto').action      = '/photos/' + id;
  document.getElementById('editPhotoCaption').value    = caption;
  openModal('modalPhoto');
}
</script>
@endpush