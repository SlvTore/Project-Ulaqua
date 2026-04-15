@extends('layouts.default')
@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
    /* Wajib untuk Leaflet: berikan tinggi absolut & z-index agar tidak tertutup elemen template lain */
    #clientMap {
        height: 250px !important; /* Perbesar sedikit menjadi 250px agar peta jelas */
        width: 100%;
        border-radius: 10px;
        z-index: 1; /* Mencegah map meluap di atas header/navbar dropdown */
    }

    /* CSS efek hover unggah foto */
    .photo-wrapper {
        position: relative;
        cursor: pointer;
        width: 130px;
        height: 130px;
        overflow: hidden;
    }
    .photo-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.6);
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: 0.3s ease;
    }
    .photo-wrapper:hover .photo-overlay {
        opacity: 1;
    }
</style>

<script>
    // Memastikan Plugin Peity berjalan untuk Chart Donut
    if(jQuery().peity) {
        $("span.donut").peity("donut", {
            width: "150",
            height: "150"
        });
    }

    // Eksekusi Peta Leaflet
    document.addEventListener("DOMContentLoaded", function() {
        // Koordinat Default (Anda bisa sesuaikan koordinat pusatnya misal Bandung/Jakarta)
        var lat = {{ $client->latitude ?? '-6.914744' }};  // Latitude Bandung
        var lng = {{ $client->longitude ?? '107.609810' }}; // Longitude Bandung

        var map = L.map('clientMap').setView([lat, lng], 14); // Set zoom ke 14 atau 15 agar lebih dekat/fokus

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Marker Titik Klien
        L.marker([lat, lng]).addTo(map)
            .bindPopup('<b>{{ $client->name }}</b><br>Kira-kira di Area ini.')
            .openPopup();

        // Fix untuk kendala Map rendering parsial dalam Bootstrap Tabs/Cards
        setTimeout(function(){
            map.invalidateSize();
        }, 500);
    });
</script>
@endpush

@section('content')
<div class="container-fluid">
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">Klien</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Detail Klien</a></li>
        </ol>

    </div>
    <div class="d-flex justify-content-end gap-2 mb-3">
  <!-- Tombol Aksi Dipindah ke Sini -->
        <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-primary btn-rounded wspace-no"><i class="las scale5 la-pencil-alt me-2"></i> Edit Data</a>
        <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="delete-form d-inline" data-confirm-message="Klien ini akan dihapus dari sistem?">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-rounded wspace-no"><i class="las scale5 la-trash me-2"></i> Hapus</button>
        </form>
    </div>

    <div class="row">
        <!-- Kotak Informasi Utama -->
        <div class="col-xl-6 col-xxl-8">
            <div class="card">
                <div class="card-body">
                    <div class="media d-sm-flex d-block text-center text-sm-start pb-4 mb-4 border-bottom">

                        <!-- Form Tersembunyi untuk Unggah Foto -->
                        <form id="photoForm" action="{{ route('clients.update_photo', $client->id) }}" method="POST" enctype="multipart/form-data" class="d-none">
                            @csrf
                            @method('PATCH')
                            <input type="file" name="photo" id="photoInput" accept="image/*" onchange="document.getElementById('photoForm').submit();">
                        </form>

                        <!-- Box Foto Interaktif -->
                        <div class="photo-wrapper rounded me-sm-4 me-0 mb-3 mb-sm-0" onclick="document.getElementById('photoInput').click()">
                            @if($client->photo)
                                <img src="{{ asset('storage/' . $client->photo) }}" width="130" height="130" style="object-fit: cover;">
                            @else
                                <div class="bg-primary d-flex align-items-center justify-content-center text-white" style="width: 100%; height: 100%;">
                                    <i class="flaticon-381-user-9 fa-4x"></i>
                                </div>
                            @endif
                            <!-- Overlay Kamera saat di-hover -->
                            <div class="photo-overlay">
                                <i class="las la-camera fa-3x text-white"></i>
                            </div>
                        </div>

                        <div class="media-body align-items-center">
                            <div class="d-sm-flex d-block justify-content-between my-3 my-sm-0">
                                <div>
                                    <h3 class="fs-22 text-black font-w600 mb-0">{{ $client->name }}</h3>
                                    <p class="mb-2 mb-sm-2">Bergabung: {{ $client->created_at->format('d M Y') }}</p>
                                </div>
                                <span class="text-dark">#{{ $client->kode_client }}</span>
                            </div>

                            <!-- Tag Dinamis Status 6 Bulan (Danger/Success) -->
                            <a href="javascript:void(0);" class="btn {{ $client->status == 'active' ? 'btn-success' : 'btn-danger' }} light btn-rounded mb-2 me-2 d-inline-flex align-items-center">
                                <i class="fa fa-circle text-{{ $client->status == 'active' ? 'success' : 'danger' }} me-2"></i>
                                {{ $client->status == 'active' ? 'Pelanggan Aktif' : 'Pelanggan Non-Aktif' }}
                            </a>

                            <!-- Form Inline Dropdown Tag -->
                            <form action="{{ route('clients.update_tag', $client->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('PATCH')
                                <select name="tag" class="form-control default-select btn-rounded d-inline-block"  onchange="this.form.submit()">
                                    <option value="Klien Baru" {{ $client->tag == 'Klien Baru' ? 'selected' : '' }}>Klien Baru</option>
                                    <option value="Klien Reguler" {{ $client->tag == 'Klien Reguler' ? 'selected' : '' }}>Klien Reguler</option>
                                    <option value="Klien VIP" {{ $client->tag == 'Klien VIP' ? 'selected' : '' }}>Klien VIP</option>
                                    <option value="Bermasalah" {{ $client->tag == 'Bermasalah' ? 'selected' : '' }}>Bermasalah</option>
                                </select>
                            </form>

                            <!-- Tombol Shortcut Tambah Order Baru (akan lempar ke halaman Penjualan) -->
                            <a href="{{ route('sales.create', ['client_id' => $client->id]) }}" class="btn btn-outline-primary btn-sm btn-rounded d-inline-block ms-2"><i class="las la-plus me-1"></i> Buat Order Baru</a>
                        </div>
                    </div>

                    <!-- Detail Kontak & Alamat -->
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <div class="media align-items-start">
                                <span class="p-3 border border-primary-light rounded-circle me-3">
                                    <i class="las la-map-marker fa-2x text-primary"></i>
                                </span>
                                <div class="media-body">
                                    <span class="d-block text-black font-w600 mb-1">Alamat Penagihan</span>
                                    <p>{{ $client->address ?? 'Belum ada alamat tersimpan.' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <span class="d-block text-black font-w600 mb-1">Zona Pengiriman</span>
                            <div id="clientMap" class="mb-3 text-center rounded bg-light" style="height: 150px; z-index:1;"></div>
                        </div>
                        <div class="col-lg-6 mb-md-0 mb-3">
                            <div class="media">
                                <span class="p-3 border border-primary-light rounded-circle me-3">
                                    <i class="las la-phone fa-2x text-primary"></i>
                                </span>
                                <div class="media-body">
                                    <span class="d-block text-dark font-w600 mb-1">Nomor Telepon</span>
                                    <p class="mb-0 font-w600">{{ $client->phone ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="media">
                                <span class="p-3 border border-primary-light rounded-circle me-3">
                                    <i class="las la-envelope fa-2x text-primary"></i>
                                </span>
                                <div class="media-body">
                                    <span class="d-block text-black font-w600 mb-1">Email Klien</span>
                                    <p class="mb-0 font-w600">{{ $client->email ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order History Timeline -->
        <div class="col-xl-3 col-xxl-4 col-md-6">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h4 class="fs-20 font-w600">Riwayat Pembelian</h4>
                </div>
                <div class="card-body">
                    <div class="widget-timeline-icon2">
                        <ul class="timeline">
                            @forelse($client->sales()->latest()->take(5)->get() as $sale)
                            <li>
                                <div class="icon bg-{{ $sale->payment_status == 'Lunas' ? 'success' : 'warning' }}"><i class="las la-shopping-cart"></i></div>
                                <a class="timeline-panel text-muted" href="javascript:void(0);">
                                    <h4 class="mb-2 mt-1">{{ $sale->quantity }} {{ $sale->item->unit->name ?? 'pcs' }} - {{ $sale->item->name }}</h4>
                                    <p class="fs-15 mb-0 text-success font-weight-bold">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</p>
                                    <p class="fs-12 mb-0 mt-1">{{ date('d M Y - H:i', strtotime($sale->sale_date)) }}</p>
                                    <span class="badge badge-sm light mt-2 badge-{{ $sale->payment_status == 'Lunas' ? 'success' : 'danger' }}">{{ $sale->payment_status }}</span>
                                    <span class="badge badge-sm light mt-2 badge-{{ $sale->delivery_status == 'Selesai' ? 'primary' : 'secondary' }}">{{ $sale->delivery_status }}</span>
                                </a>
                            </li>
                            @empty
                            <li class="text-center text-muted mt-3">Belum ada riwayat pembelian.</li>
                            @endforelse

                            <li class="text-center mt-3">
                                <a href="{{ route('sales.index', ['client_id' => $client->id]) }}" class="text-primary font-w600">Lihat Semua Tagihan</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Klien Chart -->
        <div class="col-xl-3 col-xxl-12 col-md-6">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h4 class="fs-20 font-w600">Statistik Klien</h4>
                </div>
                <div class="card-body text-center">
                    <span class="donut" data-peity='{ "fill": ["rgb(209, 209, 209)", "rgba(180, 92, 195, 1)","rgba(255, 214, 0, 1)"]}'>2,5,3</span>
                    <div class="mt-4">
                        <p class="mb-2 d-flex text-dark font-w500 fs-14">Kontribusi Laba (60%)
                            <span class="pull-right ms-auto">Rp 5Jt</span>
                        </p>
                        <div class="progress mb-3" style="height:8px">
                            <div class="progress-bar bg-secondary progress-animated" style="width:60%; height:8px;" role="progressbar"></div>
                        </div>
                        <p class="mb-2 d-flex text-dark font-w500 fs-14">Frekuensi Beli (30%)
                            <span class="pull-right ms-auto">Tinggi</span>
                        </p>
                        <div class="progress mb-3" style="height:8px">
                            <div class="progress-bar bg-warning progress-animated" style="width:80%; height:8px;" role="progressbar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

