@extends('layouts.default')

@section('content')

<div class="container-fluid">
    <div class="form-head d-flex mb-3 mb-md-4 align-items-start">
        <div class="me-auto d-none d-lg-block">
            <h3 class="text-black font-w600">Dashboard Ulaqua</h3>
            <p class="mb-0 fs-18">Ulul Albab Hidro Prima</p>
        </div>

        <!-- Tombol Aksi Cepat / Shortcut -->
    </div>

    <!-- WIDGET WELCOME & NOTIFIKASI -->
    <div class="row mb-4">
        <!-- Welcome Card (Biru) -->
        <div class="col-xl-8 col-lg-8">
            <div class="card bg-primary mb-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <h2 class="text-white font-w600 mb-2">Selamat Datang, {{ Auth::check() ? Auth::user()->name : 'User' }}!</h2>
                        <p class="text-white mb-0 fs-16">Senang melihat Anda kembali!</p>
                    </div>
                    <div class="ms-auto d-none d-sm-block">
                        <i class="flaticon-381-user-9 fa-4x text-white opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Notification / Operasional Card -->
        <div class="col-xl-4 col-lg-4 mt-4 mt-lg-0">
            <div class="card mb-0 h-100">
                <div class="card-header border-0 pb-2">
                    <h4 class="card-title text-black fs-18 mb-0">Info Kinerja</h4>
                </div>
                <div class="card-body pt-2">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-start mb-3">
                            <span class="text-success me-3 mt-1"><i class="fas fa-chart-line fa-lg"></i></span>
                            <span class="fs-14">Omset Penjualan tercatat <strong>Rp {{ number_format($revenue, 0, ',', '.') }}</strong> saat ini.</span>
                        </li>
                        <li class="d-flex align-items-start mb-3">
                            <span class="text-warning me-3 mt-1"><i class="fas fa-boxes fa-lg"></i></span>
                            <span class="fs-14">Terdapat <strong>{{ $totalItems ?? 0 }} macam barang</strong> di data Gudang.</span>
                        </li>
                        <li class="d-flex align-items-start">
                            <span class="text-info me-3 mt-1"><i class="fas fa-shopping-cart fa-lg"></i></span>
                            <span class="fs-14">Jumlah transaksi <strong>{{ $totalSales ?? 0 }} order</strong>.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- BARIS 1: KARTU KPI (4 WIDGETS) -->
    <div class="row">
        <!-- 1. Klien Aktif -->
        <div class="col-xl-3 col-xxl-3 col-sm-6">
            <div class="card gradient-bx text-white bg-danger">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="media-body">
                            <p class="mb-1">Total Klien</p>
                            <div class="d-flex flex-wrap">
                                <h2 class="fs-40 font-w600 text-white mb-0 me-3">{{ number_format($totalClients) }}</h2>
                            </div>
                        </div>
                        <span class="d-flex align-items-center justify-content-center border rounded-circle flex-shrink-0" style="width: 50px; height: 50px; border-width: 1px !important;">
                            <i class="flaticon-381-user-9 fa-lg text-white mt-1"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- 2. Pesanan Aktif -->
        <div class="col-xl-3 col-xxl-3 col-sm-6">
            <div class="card gradient-bx text-white bg-success">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="media-body">
                            <p class="mb-1">Total Transaksi</p>
                            <div class="d-flex flex-wrap">
                                <h2 class="fs-40 font-w600 text-white mb-0 me-3">{{ number_format($totalSales) }}</h2>
                            </div>
                        </div>
                        <span class="d-flex align-items-center justify-content-center border rounded-circle flex-shrink-0" style="width: 50px; height: 50px; border-width: 1px !important;">
                            <i class="las la-shopping-cart fa-lg text-white mt-1"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- 3. Barang Gudang -->
        <div class="col-xl-3 col-xxl-3 col-sm-6">
            <div class="card gradient-bx text-white bg-info">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="media-body">
                            <p class="mb-1">Macam Barang</p>
                            <div class="d-flex flex-wrap">
                                <h2 class="fs-40 font-w600 text-white mb-0 me-3">{{ number_format($totalItems) }}</h2>
                            </div>
                        </div>
                        <span class="d-flex align-items-center justify-content-center border rounded-circle flex-shrink-0" style="width: 50px; height: 50px; border-width: 1px !important;">
                            <i class="flaticon-381-box-2 fa-lg text-white mt-1"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- 4. Pendapatan (Omzet) -->
        <div class="col-xl-3 col-xxl-3 col-sm-6">
            <div class="card gradient-bx text-white bg-secondary">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="media-body">
                            <p class="mb-1">Total Omset</p>
                            <div class="d-flex flex-wrap">
                                <h2 class="fs-40 font-w600 text-white mb-0 me-3">Rp {{ number_format($revenue, 0, ',', '.') }}</h2>
                            </div>
                        </div>
                        <span class="d-flex align-items-center justify-content-center border rounded-circle flex-shrink-0" style="width: 50px; height: 50px; border-width: 1px !important;">
                            <i class="las la-wallet fa-lg text-white mt-1"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BARIS 1.5: REVENUE & GROSS PROFIT MARGIN -->
    <div class="row">
        <!-- WIDGET REVENUE (Kiri, col-6) -->
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h3 class="fs-20 mb-0 text-black">Statistik Revenue</h3>
                    <select class="default-select style-1">
                        <option>Bulan Ini</option>
                        <option>Bulan Lalu</option>
                        <option>Tahun Ini</option>
                    </select>
                </div>
                <div class="card-body">
                    <div>
                        <span class="text-info fs-26 font-w600 me-3">Rp {{ number_format($revenue, 0, ',', '.') }}</span>
                    </div>
                    <!-- Chart Revenue Nyata -->
                    <div id="real-revenue-chart"></div>
                </div>
            </div>
        </div>

        <!-- WIDGET KANAN (Kanan, col-6) -->
        <div class="col-xl-6 col-lg-12">
            <div class="row">
                <!-- 1. Estimasi Gross Profit Margin -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-0 pb-0">
                            <h3 class="fs-20 mb-0 text-black">Gross Profit Margin</h3>

                        </div>
                        <div class="card-body pb-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <p class="mb-1 text-muted">Proyeksi Laba Kotor</p>
                                    <h3 class="fs-24 font-w600 text-black">Rp {{ number_format($grossProfit, 0, ',', '.') }}</h3>
                                </div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="fs-32 font-w600 text-primary mb-0">{{ $profitPercentage }}<span class="fs-16 text-muted">%</span></h2>
                                </div>
                            </div>

                            <!-- Progress Bar Stack -->
                            <div class="progress mb-2" style="height: 10px; border-radius: 10px; cursor: pointer;"
                                 data-bs-container="body" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" data-bs-html="true"
                                 title="Penjelasan Kalkulasi Margins"
                                 data-bs-content="<b>Gross Profit ({{ $profitPercentage }}%)</b> = Laba Kotor dari Total Pendapatan setelah dikurangi HPP.<br/><b>HPP ({{ $hppPercentage }}%)</b> = Total beban biaya barang yang diproduksi.">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $hppPercentage }}%;" title="HPP ({{ $hppPercentage }}%)"></div>
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $profitPercentage }}%;" title="Gross Profit ({{ $profitPercentage }}%)"></div>
                            </div>

                            <div class="d-flex justify-content-center mt-3">
                                <div class="text-center mx-4" style="cursor: help;" data-bs-container="body" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="bottom" data-bs-html="true" data-bs-content="HPP diambil dari <b>Total Biaya Produksi per Barang</b> di database dikalikan dengan kuantitas yang terjual.">
                                    <span class="text-warning d-block mb-1 fs-12"><i class="fas fa-circle me-1"></i>HPP (Rp{{ number_format($totalHpp / 1000000, 1, ',', '.') }}jt) <i class="fas fa-info-circle ms-1"></i></span>
                                    <h5 class="fs-14 font-w600 text-black mb-0">{{ $hppPercentage }}%</h5>
                                </div>
                                <div class="text-center mx-4" style="cursor: help;" data-bs-container="body" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="bottom" data-bs-html="true" data-bs-content="Laba Kotor dihitung murni dari: <b>Total Revenue - Total HPP</b>. Belum termasuk beban non-produksi lainnya.">
                                    <span class="text-primary d-block mb-1 fs-12"><i class="fas fa-circle me-1"></i>Gross Profit <i class="fas fa-info-circle ms-1"></i></span>
                                    <h5 class="fs-14 font-w600 text-black mb-0">{{ $profitPercentage }}%</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Daftar Produk Terlaris -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-0 pb-0">
                            <h3 class="fs-20 mb-0 text-black">Top 3 Produk Terlaris</h3>
                            <a href="{{ route('items.index') }}" class="text-primary fs-14 pb-0">Lihat Semua</a>
                        </div>
                        <div class="card-body pt-3">
                            @php
                                $colors = ['primary', 'info', 'secondary'];
                            @endphp
                            @forelse($topProducts as $index => $prod)
                                @if($prod->item)
                                <div class="d-flex align-items-center {{ !$loop->last ? 'mb-3' : '' }}">
                                    <div class="me-3">
                                        <span class="p-2 bg-{{ $colors[$index % 3] }} text-white rounded"><i class="las la-box fa-lg"></i></span>
                                    </div>
                                    <div class="d-flex justify-content-between w-100 flex-wrap">
                                        <div>
                                            <h5 class="mb-0 font-w600 text-black fs-16">{{ $prod->item->name }}</h5>
                                            <span class="fs-12 text-muted">Kategori: {{ $prod->item->category->name ?? 'Lainnya' }}</span>
                                        </div>
                                        <div class="text-right">
                                            <h5 class="mb-0 font-w600 text-success fs-14">+ {{ number_format($prod->total_sold) }} Terjual</h5>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @empty
                                <p class="text-muted text-center w-100 mb-0">Belum ada data penjualan tercatat.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BARIS 1.75: KARTU PIE CHART (COGS & STOCKOUT) -->
    <div class="row">
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h3 class="fs-20 mb-0 text-black">Analisis Produksi & Stok</h3>
                    <i class="fas fa-info-circle text-primary fs-18" style="cursor:help;" data-bs-container="body" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" data-bs-html="true" data-bs-content="<b>COGS:</b> Persentase Biaya Produksi memproduksi barang.<br/><b>Stockout:</b> Tingkat persentase barang yang habis stok/kosong."></i>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <!-- Pie 1: COGS -->
                        <div class="col-6 border-end text-center">
                            <h4 class="fs-14 text-muted mb-2">Cost of Goods Sold (COGS)</h4>
                            <div id="cogs-pie-chart" class="d-flex justify-content-center"></div>
                        </div>
                        <!-- Pie 2: Stockout -->
                        <div class="col-6 text-center">
                            @php
                                $totalDataBarang = \App\Models\Item::count();
                                // Diperbaiki: tingkat kehabisan stok (dibawah limit)
                                $stokHabis = \App\Models\Item::whereColumn('expected_stock', '<=', 'min_alert')->count();
                                $stokAman = $totalDataBarang - $stokHabis;
                                $stockoutRate = $totalDataBarang > 0 ? round(($stokHabis / $totalDataBarang) * 100) : 0;
                            @endphp
                            <h4 class="fs-14 text-muted mb-2">Tingkat Kehabisan Stok (Stockout)</h4>
                            <div id="stockout-pie-chart" class="d-flex justify-content-center"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- WIDGET KANAN (Kanan, col-6) - TINGKAT RETENSI PELANGGAN -->
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header border-0 p-3">
                    <h3 class="fs-20 mb-0 text-black">Tingkat Retensi Pelanggan</h3>
                    <i class="fas fa-info-circle text-primary fs-18 " style="cursor:help;" data-bs-container="body" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" data-bs-html="true" data-bs-content="<b>Pelanggan Baru:</b> Jumlah pelanggan baru.<br/><b>Pelanggan Loyal:</b> Pelanggan dengan frekuensi pembelian > 3x."></i>
                </div>
                <div class="card-body">
                    @php
                        // Logika Tren 6 Bulan untuk Retensi
                        $monthsRetensi = [];
                        $newCustomersData = [];
                        $loyalCustomersData = [];
                        for($i=5; $i>=0; $i--) {
                            $dt = \Carbon\Carbon::now()->subMonths($i);
                            $monthsRetensi[] = $dt->format('M Y');

                            // Pelanggan Baru (Berdasarkan Sale pertama kali di bulan itu)
                            $newCustomersData[] = \App\Models\Sale::whereYear('sale_date', $dt->year)
                                                                ->whereMonth('sale_date', $dt->month)
                                                                ->distinct('client_id')->count();

                            // Pelanggan Loyal (Membeli > 3 kali total) yang transaksi di bulan itu
                            $purchases = \DB::table('sales')
                                        ->whereYear('sale_date', $dt->year)
                                        ->whereMonth('sale_date', $dt->month)
                                        ->select('client_id')
                                        ->groupBy('client_id')
                                        ->get();

                            $loyalCount = 0;
                            foreach($purchases as $p) {
                                $totalBeli = \App\Models\Sale::where('client_id', $p->client_id)->count();
                                if($totalBeli > 3) {
                                    $loyalCount++;
                                }
                            }
                            $loyalCustomersData[] = $loyalCount;
                        }
                    @endphp
                    <div id="retention-area-chart"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- BARIS 2: WIDGET DINAMIS -->
    <div class="row">
        <!-- WIDGET KIRI: JAJARAN PIMPINAN (Mengubah Top Rated Doctors) -->
        <div class="col-xl-9 col-xxl-8 col-lg-7">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h3 class="fs-20 mb-0 text-black">Jajaran Pimpinan</h3>
                    <a href="{{ route('users.index') }}" class="text-primary font-w500">Lihat Semua Karyawan >></a>
                </div>
                <div class="card-body">
                    <div class="assigned-doctor owl-carousel">

                        @for ($i = 1; $i <= 7; $i++)
                        <div class="items">
                            <div class="text-center">
                                <img src="{{ asset('images/profile/profile.png') }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 18px; margin: 0 auto; display: block;" alt="Leader Dummy">
                                <h5 class="fs-16 mt-3 mb-1 font-w600"><a class="text-black" href="javascript:void(0);">Nama Pimpinan {{ $i }}</a></h5>
                                <span class="text-primary mb-2 d-block">Jabatan Eksekutif</span>
                                <p class="fs-12 text-truncate" style="max-height:40px; overflow:hidden;">Deskripsi atau biodata singkat tentang pimpinan untuk diisi di masa depan.</p>
                                <div class="social-media">
                                    <a href="javascript:void(0);"><i class="las la-envelope"></i></a>
                                    <a href="javascript:void(0);"><i class="las la-phone"></i></a>
                                </div>
                            </div>
                        </div>
                        @endfor

                    </div>
                </div>
            </div>
        </div>

        <!-- WIDGET KANAN: PENJUALAN TERBARU (Mengubah Recent Patient) -->
        <div class="col-xl-3 col-xxl-4 col-lg-5">
            <div class="card border-0 pb-0">
                <div class="card-header flex-wrap border-0 pb-0">
                    <h3 class="fs-20 mb-0 text-black">Penjualan Terbaru</h3>
                    <a href="{{ route('sales.index') }}" class="text-primary font-w500">Lihat Semua >></a>
                </div>
                <div class="card-body recent-patient px-0">
                    <div id="DZ_W_Todo2" class="widget-media px-4 dz-scroll height320">
                        <ul class="timeline">
                            @forelse($recentSales as $sale)
                            <li>
                                <div class="timeline-panel d-flex align-items-center">
                                    <div class="media me-3 flex-shrink-0">
                                        <img class="rounded" alt="image" width="50" height="50" style="object-fit:cover; border-radius: 12px !important;" src="{{ $sale->client && $sale->client->photo ? asset('storage/' . $sale->client->photo) : asset('images/profile/profile.png') }}">
                                    </div>
                                    <div class="media-body" style="min-width: 0;">
                                        <h5 class="mb-1 text-truncate" title="{{ $sale->client->name ?? 'Klien Umum' }}">
                                            <a class="text-black" href="{{ route('sales.show', $sale->id) }}">{{ $sale->client->name ?? 'Klien Umum' }}</a>
                                        </h5>
                                        <span class="fs-13 text-muted">#{{ $sale->invoice_number }}</span>
                                    </div>
                                    <div class="text-end d-flex flex-column align-items-end flex-shrink-0 ms-2" style="width: 100px;">
                                        <h5 class="mb-0 text-dark font-w600 text-truncate w-100 text-end" style="font-size: 13px;" title="Rp {{ number_format($sale->total_amount, 0, ',', '.') }}">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</h5>
                                        <span class="badge light badge-{{ strtolower($sale->payment_status) == 'lunas' || strtolower($sale->payment_status) == 'paid' ? 'success' : 'warning' }} mt-1 w-100 text-center" style="font-size: 9px; padding: 4px 0;">
                                            {{ strtoupper($sale->payment_status) }}
                                        </span>
                                    </div>
                                </div>
                            </li>
                            @empty
                            <li>
                                <p class="text-muted w-100 text-center pb-3">Belum ada riwayat transaksi penjualan.</p>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BARIS 3: ANALITIK PENGUNJUNG (PRODUK TERPOPULER DI WEB PUBLIK) -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h3 class="fs-20 mb-0 text-black">Analitik Pengunjung: Produk Terpopuler di Halaman Publik</h3>
                    <span class="text-muted fs-14">Data real-time dari klik produk oleh pelanggan di situs publik</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-md">
                            <thead>
                                <tr>
                                    <th><strong>No.</strong></th>
                                    <th><strong>Nama Produk</strong></th>
                                    <th><strong>SKU</strong></th>
                                    <th><strong>Kategori</strong></th>
                                    <th><strong>Harga Master</strong></th>
                                    <th><strong>Stok Gudang</strong></th>
                                    <th><strong>Status Stok</strong></th>
                                    <th><strong>Total Kunjungan (Klik)</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($productViews as $index => $view)
                                <tr>
                                    <td><strong>{{ $index + 1 }}</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="w-space-no">{{ $view->item->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $view->item->sku ?? '-' }}</td>
                                    <td>{{ $view->item->category->name ?? 'Produk Jadi' }}</td>
                                    <td>Rp {{ number_format($view->item->default_price, 0, ',', '.') }}</td>
                                    <td>{{ $view->item->expected_stock }} {{ $view->item->unit->short_name ?? 'Pcs' }}</td>
                                    <td>
                                        @if($view->item->expected_stock <= 0)
                                            <span class="badge light badge-danger">Stok Habis (Kosong di Web)</span>
                                        @elseif($view->item->expected_stock < $view->item->min_alert)
                                            <span class="badge light badge-warning">Stok Menipis</span>
                                        @else
                                            <span class="badge light badge-success">Stok Aman</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-info pr-3 pl-3 font-w600" style="padding: 6px 12px;"><i class="fa fa-eye me-2"></i>{{ number_format($view->views) }} kali</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">Belum ada data kunjungan produk dari halaman publik.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    // Inisialisasi popover bootstrap untuk deskripsi dinamis
    jQuery(document).ready(function() {
        if(typeof bootstrap !== 'undefined' && bootstrap.Popover) {
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
            var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl)
            });
        } else if (jQuery.fn.popover) {
            jQuery('[data-bs-toggle="popover"]').popover();
        }
    });

    function assignedDoctor() {
        /*  testimonial carousel function by owl.carousel.js */
        jQuery('.assigned-doctor').owlCarousel({
            loop: false,
            margin: 30,
            nav: true,
            autoplaySpeed: 3000,
            navSpeed: 3000,
            paginationSpeed: 3000,
            slideSpeed: 3000,
            smartSpeed: 3000,
            autoplay: false,
            dots: false,
            navText: ['<i class="fa fa-caret-left"></i>', '<i class="fa fa-caret-right"></i>'],
            responsive: {
                0: { items: 1 },
                576: { items: 2 },
                767: { items: 3 },
                991: { items: 2 },
                1200: { items: 3 },
                1600: { items: 4 },
                1920: { items: 5 }
            }
        })
    }

    jQuery(window).on('load', function() {
        setTimeout(function() {
            assignedDoctor();
        }, 1000);
    });

    if (jQuery('#real-revenue-chart').length > 0) {
        var options = {
            series: [{
                name: "Revenue (Rp)",
                data: {!! json_encode($revenueValues) !!}
            }],
            chart: {
                height: 300,
                type: 'area',
                toolbar: { show: false },
                zoom: { enabled: false }
            },
            colors: ['#2f4cdd'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            xaxis: {
                categories: {!! json_encode($revenueLabels) !!},
                tooltip: { enabled: false }
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return "Rp " + value.toLocaleString('id-ID');
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.5,
                    opacityTo: 0.1,
                    stops: [0, 90, 100]
                }
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "Rp " + val.toLocaleString('id-ID');
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#real-revenue-chart"), options);
        chart.render();
    }

    if (jQuery('#cogs-pie-chart').length > 0) {
        var cogsOptions = {
            series: [{{ $hppPercentage }}, {{ 100 - $hppPercentage }}],
            labels: ['COGS (Biaya Produksi)', 'Marginal Profit'],
            chart: { type: 'pie', height: 200, toolbar: { show: false } },
            colors: ['#f94687', '#2bc155'],
            dataLabels: { enabled: true, formatter: function (val) { return Math.round(val) + "%" } },
            legend: { show: false },
            tooltip: { y: { formatter: function (val) { return val + "%" } } }
        };
        var cogsChart = new ApexCharts(document.querySelector("#cogs-pie-chart"), cogsOptions);
        cogsChart.render();
    }

    if (jQuery('#stockout-pie-chart').length > 0) {
        var stockoutOptions = {
            series: [{{ $stokHabis }}, {{ $stokAman }}],
            labels: ['Krisis Stok (Bawah Limit)', 'Stok Aman'],
            chart: { type: 'pie', height: 200, toolbar: { show: false } },
            colors: ['#ff9f00', '#2bc155'],
            dataLabels: { enabled: true, formatter: function (val) { return Math.round(val) + "%" } },
            legend: { show: false },
            tooltip: { y: { formatter: function (val) { return val + " Item" } } }
        };
        var stockChart = new ApexCharts(document.querySelector("#stockout-pie-chart"), stockoutOptions);
        stockChart.render();
    }

    if (jQuery('#retention-area-chart').length > 0) {
        var retentionOptions = {
            series: [
                { name: 'Pelanggan Baru', data: {!! json_encode($newCustomersData) !!} },
                { name: 'Pelanggan Loyal (>3x)', data: {!! json_encode($loyalCustomersData) !!} }
            ],
            chart: {
                height: 250,
                type: 'area',
                toolbar: { show: false },
                zoom: { enabled: false }
            },
            colors: ['#2f4cdd', '#f94687'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            xaxis: {
                categories: {!! json_encode($monthsRetensi) !!},
                tooltip: { enabled: false }
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return Math.round(value);
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.5,
                    opacityTo: 0.1,
                    stops: [0, 90, 100]
                }
            },
            legend: { position: 'top', horizontalAlign: 'right' }
        };

        var retentionChart = new ApexCharts(document.querySelector("#retention-area-chart"), retentionOptions);
        retentionChart.render();
    }
</script>
@endpush

