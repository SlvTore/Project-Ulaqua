@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div class="form-head d-flex mb-3 mb-md-4 align-items-start">
        <div class="me-auto d-none d-lg-block">
            <h2 class="text-primary font-weight-bold">Laporan Kas Masuk (Penjualan)</h2>
            <p>Riwayat transaksi penjualan barang jadi dan nilai pendapatan Kas Perusahaan.</p>
        </div>
        <a href="{{ route('sales.create') }}" class="btn btn-primary btn-rounded">+ Catat Penjualan Baru</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success solid alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
            <strong>Berhasil!</strong> {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="example3">
                    <thead class="bg-light">
                        <tr>
                            <th>Tanggal Jual</th>
                            <th>No. Invoice</th>
                            <th>Klien / Produk</th>
                            <th class="text-center">Qty (Jumlah)</th>
                            <th class="text-end">Total Tagihan</th>
                            <th class="text-center">Status Kas & Kirim</th>
                            <th>Catatan</th>
                            <th class="text-center">Aksi / Batal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $sale)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('d M Y') }}</td>
                            <td><strong><span class="badge badge-success light">{{ $sale->reference_number }}</span></strong></td>
                            <td>
                                @if($sale->client)
                                    <a class="text-primary font-weight-bold" href="{{ route('clients.show', $sale->client->id) }}">{{ $sale->client->name }}</a>
                                @else
                                    Customer Tunai
                                @endif
                                <br><small>{{ $sale->item->name }}</small>
                            </td>
                            <td class="text-center font-weight-bold fs-16">{{ $sale->quantity }} {{ $sale->item->unit->name ?? '' }}</td>
                            <td class="text-end text-success font-weight-bold">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                            <td class="text-center">
                                @if($sale->payment_status == 'Lunas')
                                    <span class="badge light badge-success"><i class="fa fa-check-circle me-1"></i> {{ $sale->payment_status }}</span>
                                @elseif($sale->payment_status == 'Jatuh Tempo')
                                    <span class="badge light badge-danger"><i class="fa fa-exclamation-triangle me-1"></i> {{ $sale->payment_status }}</span>
                                @else
                                    <span class="badge light badge-warning"><i class="fa fa-clock me-1"></i> {{ $sale->payment_status }}</span>
                                @endif

                                <br>

                                @if($sale->delivery_status == 'Selesai')
                                    <span class="badge light badge-primary mt-1"><i class="fa fa-box me-1"></i> {{ $sale->delivery_status }}</span>
                                @else
                                    <span class="badge light badge-secondary mt-1"><i class="fa fa-truck me-1"></i> {{ $sale->delivery_status }}</span>
                                @endif
                            </td>
                            <td class="text-muted text-truncate" style="max-width: 150px;" title="{{ $sale->notes }}">
                                {{ $sale->notes ?: '-' }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-warning btn-xs sharp shadow text-white me-1"><i class="fa fa-pencil-alt"></i></a>
                                <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="d-inline delete-form" data-confirm-message="ATENSI: Membatalkan transaksi penjualan ini akan mengembalikan stok produk ke Gudang. Lanjutkan?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs sharp shadow"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
