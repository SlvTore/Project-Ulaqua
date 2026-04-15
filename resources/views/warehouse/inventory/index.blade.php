@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Notifikasi Sukses / Error -->
    @if(session('success'))
        <div class="alert alert-success solid alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
            <strong>Berhasil!</strong> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger solid alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
            <strong>Gagal!</strong> {{ session('error') }}
        </div>
    @endif

    <div class="form-head d-flex mb-3 mb-md-4 align-items-start">
        <div class="me-auto d-none d-lg-block">
            <a href="javascript:void(0);" class="btn btn-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#addTransactionModal" >
                + Transaksi Barang (In/Out)
            </a>
        </div>
        <div class="input-group search-area ms-auto d-inline-flex me-3">
            <input type="text" class="form-control" placeholder="Cari Riwayat...">
            <div class="input-group-append">
                <button type="button" class="input-group-text"><i class="flaticon-381-search-2"></i></button>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- TABEL DATA RIWAYAT TRANSAKSI -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h4 class="card-title">Riwayat Arus Barang Terakhir</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-striped patient-list mb-4 fs-14 pb-0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Tipe</th>
                                    <th>Nama Barang</th>
                                    <th>Kuantitas</th>
                                    <th>Staff Penginput</th>
                                    <th>No. Referensi (PB/DO)</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $log)
                                <tr>
                                    <td class="font-w500">{{ \Carbon\Carbon::parse($log->transaction_date)->format('d M Y') }}</td>
                                    <td>
                                        @if($log->type == 'IN')
                                            <span class="badge badge-success light"><i class="fa fa-arrow-down text-success me-1"></i> MASUK</span>
                                        @else
                                            <span class="badge badge-warning light"><i class="fa fa-arrow-up text-warning me-1"></i> KELUAR</span>
                                        @endif
                                    </td>
                                    <td class="text-primary font-w600">{{ $log->item->name ?? 'Barang Dihapus' }}</td>
                                    <td>
                                        <b class="text-dark">{{ $log->qty }}</b> {{ $log->item->unit->short_name ?? '-' }}
                                    </td>
                                    <td>{{ $log->user->name ?? 'Sistem' }}</td>
                                    <td>{{ $log->reference_number ?? '-' }}</td>
                                    <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $log->notes }}">
                                        {{ $log->notes ?? '-' }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada riwayat transaksi barang di gudang.</td>
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

@push('modals')
<!-- Modal Input Barang Masuk/Keluar -->
<div class="modal fade" id="addTransactionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title text-white">Form Input Transaksi Gudang</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('inventory.store') }}">
            @csrf
            <div class="row">
              <div class="col-xl-6">
                  <div class="form-group">
                      <label>Jenis Transaksi Gudang:</label>
                      <select name="type" class="form-control default-select form-control-lg" required>
                          <option value="IN">BARANG MASUK (Menambah Stok)</option>
                          <option value="OUT">BARANG KELUAR (Mengurangi Stok)</option>
                      </select>
                  </div>
              </div>
              <div class="col-xl-6">
                  <div class="form-group">
                      <label>Tanggal Dokumen/Fisik:</label>
                      <input type="date" name="transaction_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                  </div>
              </div>
              <div class="col-xl-12 mt-3">
                  <div class="form-group">
                      <label>Pilih Barang (Katalog):</label>
                      <!-- Idealnya menggunakan plugin Select2 agar bisa mengetik pencarian -->
                      <select name="item_id" class="form-control default-select form-control-lg" required>
                          <option value="">-- Pilih Barang --</option>
                          @foreach($items as $item)
                              <option value="{{ $item->id }}">
                                  {{ $item->name }} (Sisa Stok: {{ $item->expected_stock }} {{ $item->unit->short_name }})
                              </option>
                          @endforeach
                      </select>
                  </div>
              </div>
              <div class="col-xl-6 mt-3">
                  <div class="form-group">
                      <label>Jumlah (Qty):</label>
                      <input type="number" name="qty" class="form-control form-control-lg" min="1" required placeholder="Contoh: 100">
                  </div>
              </div>
              <div class="col-xl-6 mt-3">
                  <div class="form-group">
                      <label>No. Dokumen (PO/Surat Jalan) <small>Opsional</small>:</label>
                      <input type="text" name="reference_number" class="form-control form-control-lg" placeholder="Contoh: SJ-AMDK-001">
                  </div>
              </div>
              <div class="col-xl-12 mt-3">
                  <div class="form-group">
                      <label>Catatan/Keterangan <small>Opsional</small>:</label>
                      <textarea name="notes" class="form-control" rows="2" placeholder="Ketikan detail keperluan atau alasan..."></textarea>
                  </div>
              </div>
            </div>
            <div class="modal-footer mt-4">
              <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-save me-2"></i>Simpan Transaksi</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>

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
                lengthMenu: "Tampilkan _MENU_ riwayat",
                search: "Cari Riwayat:",
                info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data riwayat stok",
                emptyTable: "Belum ada riwayat transaksi gudang."
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

