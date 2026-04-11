@extends('layouts.default')

@section('content')
<div class="container-fluid">
    @if(session('success_item'))
        <div class="alert alert-success solid alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
            <strong>Pemberitahuan!</strong> {!! session('success_item') !!}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success solid alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
            <strong>Sukses!</strong> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger solid alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
            <strong>Perhatian!</strong> {{ session('error') }}
        </div>
    @endif

    <div class="form-head d-flex mb-3 mb-md-4 align-items-start">
        <div class="me-auto d-none d-lg-block">
            <a href="javascript:void(0);" class="btn btn-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#addItemModal" >+ Tambah Barang</a>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-4 fs-14">
                            <thead>
                                <tr>
                                    <th>SKU / Kode</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Satuan</th>
                                    <th>HPP / Harga</th>
                                    <th>Limit Stok</th>
                                    <th>Stok Terkini</th>
                                    <th class="text-end" width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <!-- Baris dibuat agak pudar/transparan jika barang nonaktif -->
                                <tr style="{{ !$item->is_active ? 'opacity: 0.5;' : '' }}">
                                    <td class="font-w600 text-primary">
                                        {{ $item->sku ?? '-' }}
                                        @if(!$item->is_active)
                                            <br><span class="badge badge-danger badge-xs my-1">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="font-w500">{{ $item->name }}</td>
                                    <td><span class="badge badge-info light">{{ $item->category->name }}</span></td>
                                    <td>{{ $item->unit->name }}</td>
                                    <td>Rp. {{ number_format($item->default_price, 0, ',', '.') }}</td>
                                    <td>{{ $item->min_alert }}</td>
                                    <td>
                                        @php
                                            if ($item->expected_stock > $item->min_alert) {
                                                $badgeClass = 'badge-success';
                                            } elseif ($item->expected_stock == $item->min_alert) {
                                                $badgeClass = 'badge-warning';
                                            } else {
                                                $badgeClass = 'badge-danger';
                                            }
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">
                                            {{ $item->expected_stock }} {{ $item->unit->short_name }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <!-- Tombol Edit (Akan Terkunci Jika Nonaktif) -->
                                        @if($item->is_active)
                                            <a href="javascript:void(0);" class="btn btn-primary shadow btn-xs sharp me-2 align-middle"
                                               data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}" title="Edit Info">
                                               <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        @else
                                            <button type="button" class="btn btn-secondary shadow btn-xs sharp me-2 align-middle"
                                                    style="cursor: not-allowed; opacity: 0.6;" disabled title="Barang Dinonaktifkan">
                                               <i class="fas fa-pencil-alt"></i>
                                            </button>
                                        @endif

                                        <!-- Toggle Status (Tetap Ada) -->
                                        <form action="{{ route('items.toggle_status', $item->id) }}" method="POST" class="d-inline align-middle">
                                            @csrf
                                            @method('PATCH')
                                            <div class="form-check form-switch d-inline-block m-0" style="font-size: 1.2rem;">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                       title="Geser untuk ON / OFF"
                                                       onchange="this.form.submit()"
                                                       style="cursor: pointer;"
                                                       {{ $item->is_active ? 'checked' : '' }}>
                                            </div>
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
    </div>
</div>

<!-- Modal Tambah Barang -->
<div class="modal fade" id="addItemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Registrasi Master Barang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('items.store') }}">
            @csrf
            <div class="row">
              <div class="col-xl-6">
                  <div class="form-group">
                      <label>Kode Barang (SKU):</label>
                      <input type="text" name="sku" class="form-control" placeholder="Contoh: BTL-600">
                  </div>
              </div>
              <div class="col-xl-6">
                  <div class="form-group">
                      <label>Nama Barang:</label>
                      <input type="text" name="name" class="form-control" required placeholder="Produk 1...">
                  </div>
              </div>
              <div class="col-xl-6 mt-3">
                  <div class="form-group">
                      <label>Kategori:</label>
                      <select name="category_id" class="form-control" required onchange="togglePriceInput(this)">
                        <option value="">-- Pilih --</option>
                        @foreach($categories as $category)
                            <!-- Sisipkan data atribut untuk mendeteksi tipe kategori -->
                            @php
                                $isMaterial = str_contains(strtolower($category->name), 'bahan') || str_contains(strtolower($category->name), 'kemasan') ? '1' : '0';
                            @endphp
                            <option value="{{ $category->id }}" data-ismaterial="{{ $isMaterial }}">{{ $category->name }}</option>
                        @endforeach
                      </select>
                  </div>
              </div>
              <div class="col-xl-6 mt-3">
                  <div class="form-group">
                      <label>Satuan (Unit):</label>
                      <select name="unit_id" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }} ({{ $unit->short_name }})</option>
                        @endforeach
                      </select>
                  </div>
              </div>
              <div class="col-xl-6 mt-3">
                  <div class="form-group">
                      <label>Peringatan Limit Stok (Min Alert):</label>
                      <input type="number" name="min_alert" class="form-control" required value="0" min="0">
                  </div>
              </div>

              <!-- Kolom Harga (Awalnya Disembunyikan / Display None) -->
              <div class="col-xl-6 mt-3 price-container" style="display: none;">
                  <div class="form-group">
                      <label>Estimasi Harga Rp (Bahan Baku):</label>
                      <input type="number" name="default_price" class="form-control price-input" value="0" min="0">
                  </div>
              </div>

            </div>
            <div class="modal-footer mt-4">
              <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Simpan Barang</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>

<!-- Modal Edit Barang -->
@foreach($items as $item)
<div class="modal fade text-start" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Barang: {{ $item->name }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('items.update', $item->id) }}">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="col-xl-6">
                  <div class="form-group">
                      <label>Kode Barang (SKU):</label>
                      <input type="text" name="sku" class="form-control" value="{{ $item->sku }}">
                  </div>
              </div>
              <div class="col-xl-6">
                  <div class="form-group">
                      <label>Nama Barang:</label>
                      <input type="text" name="name" class="form-control" value="{{ $item->name }}" required>
                  </div>
              </div>
              <div class="col-xl-6 mt-3">
                  <div class="form-group">
                      <label>Kategori:</label>
                      <select name="category_id" class="form-control" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $item->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                      </select>
                  </div>
              </div>
              <div class="col-xl-6 mt-3">
                  <div class="form-group">
                      <label>Satuan (Unit):</label>
                      <select name="unit_id" class="form-control" required>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}" {{ $item->unit_id == $unit->id ? 'selected' : '' }}>
                                {{ $unit->name }}
                            </option>
                        @endforeach
                      </select>
                  </div>
              </div>
              <div class="col-xl-12 mt-3">
                  <div class="form-group">
                      <label>Peringatan Limit Stok:</label>
                      <input type="number" name="min_alert" class="form-control" value="{{ $item->min_alert }}" required min="0">
                  </div>
              </div>
            </div>
            <div class="modal-footer mt-4">
              <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Update Detail Barang</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
@endforeach

<!-- TAMBAHKAN BARIS INI (PENUTUP KONTEN UTAMA) -->
@endsection

@section('scripts')
<script>
    function togglePriceInput(selectElement) {
        // Cari baris form terdekat tempat select ini berada
        const formRow = selectElement.closest('.modal-body');
        const priceContainer = formRow.querySelector('.price-container');
        const priceInput = formRow.querySelector('.price-input');

        // Cek option apa yang dipilih
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const isMaterial = selectedOption.getAttribute('data-ismaterial');

        if (isMaterial == '1') {
            priceContainer.style.display = 'block';
            priceInput.setAttribute('required', 'required');
        } else {
            priceContainer.style.display = 'none';
            priceInput.removeAttribute('required');
            priceInput.value = 0;
        }
    }
</script>
@endsection
