@extends('layouts.default')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success solid alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
            <strong>Sukses!</strong> {{ session('success') }}
        </div>
    @endif

    <div class="d-flex mb-3 align-items-center justify-content-between">
        <h4 class="mb-0">Daftar Bill of Materials (Resep Produksi)</h4>
        <a href="{{ route('boms.create') }}" class="btn btn-primary btn-rounded">+ Buat Formula Baru</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID.</th>
                            <th>Nama Formula / Resep</th>
                            <th>Produk Jadi Target</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($boms as $bom)
                        <tr>
                            <td><strong>{{ $loop->iteration }}</strong></td>
                            <td class="font-w600 text-primary">{{ $bom->name }}</td>
                            <td><span class="badge badge-success light">{{ $bom->product->name }}</span></td>
                            <td>
                                <a href="{{ route('boms.edit', $bom->id) }}" class="btn btn-primary btn-xs sharp shadow me-1"><i class="fa fa-pencil-alt"></i></a>

                                <form action="{{ route('boms.destroy', $bom->id) }}" method="POST" class="d-inline delete-form" data-confirm-message="Anda yakin ingin menghapus resep Bom ini? Tindakan ini akan mengarsipkannya secara aman.">
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
        $('#dataTable').DataTable({
            language: {
                paginate: {
                  next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                  previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                },
                lengthMenu: "Tampilkan _MENU_ resep BOM",
                search: "Cari Resep BOM:",
                info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data resep",
                emptyTable: "Belum ada resep BOM."
            }
        });
    })(jQuery);
</script>
<link href="{{ asset('vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.5rem 0.5rem;
    }
    .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter {
        margin-bottom: 20px;
    }
</style>
@endpush

