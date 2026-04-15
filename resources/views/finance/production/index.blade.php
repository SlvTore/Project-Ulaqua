@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div class="form-head d-flex mb-3 mb-md-4 align-items-start">
        <div class="me-auto d-none d-lg-block">
            <h2 class="text-primary font-weight-bold">Laporan Biaya Produksi (HPP)</h2>
            <p>Riwayat seluruh proses manufaktur barang jadi dan total modal yang dihabiskan.</p>
        </div>
        <a href="{{ route('productions.create') }}" class="btn btn-primary btn-rounded">+ Catat Produksi Baru</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="example3">
                    <thead class="bg-light">
                        <tr>
                            <th>No. Referensi</th>
                            <th>Tanggal Data</th>
                            <th>Produk Dihasilkan</th>
                            <th class="text-center">Jml Produksi (Qty)</th>
                            <th class="text-end">Total Biaya Pabrik (HPP)</th>
                            <th>Operator</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productions as $prod)
                        <tr>
                            <td><strong>{{ $prod->reference_number }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($prod->production_date)->format('d M Y') }}</td>
                            <td><span class="badge badge-success light">{{ $prod->item->name }}</span></td>
                            <td class="text-center font-weight-bold fs-16">{{ $prod->quantity }}</td>
                            <td class="text-end text-danger font-weight-bold">Rp {{ number_format($prod->total_cost, 0, ',', '.') }}</td>
                            <td>{{ $prod->user->name }}</td>
                            <td class="text-center">
                                <a href="{{ route('productions.edit', $prod->id) }}" class="btn btn-warning btn-xs sharp shadow text-white me-1"><i class="fa fa-pencil-alt"></i></a>
                                <form action="{{ route('productions.destroy', $prod->id) }}" method="POST" class="d-inline delete-form" data-confirm-message="ATENSI: Menghapus rekapan Produksi ini akan mengembalikan komponen bahan baku ke gudang! Lanjut batalkan?">
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
@push('scripts')
<script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script>
    (function($) {
        "use strict"
        $('#example3').DataTable({
            language: {
                paginate: {
                  next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                  previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>' 
                },
                lengthMenu: "Tampilkan _MENU_ produksi",
                search: "Cari Produksi:",
                info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ daftar produksi",
                emptyTable: "Belum ada rekapan produksi."
            }
        });
    })(jQuery);
</script>
<link href="{{ asset('vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button { padding: 0.5rem 0.5rem; }
    .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter { margin-bottom: 20px; }
</style>
@endpush

