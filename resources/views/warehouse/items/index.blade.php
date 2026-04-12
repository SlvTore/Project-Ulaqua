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

    <!-- TAMBAHKAN BLOK ALERT INI -->
    @if($errors->any())
        <div class="alert alert-danger solid alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
            <strong>Gagal Menyimpan Master Barang!</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
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
                      <input type="text" name="sku" class="form-control @error('sku') is-invalid border-danger @enderror" value="{{ old('sku') }}" placeholder="Contoh: BTL-600">
                      @error('sku')
                          <span class="text-danger mt-1 d-block fs-12"><i class="fa fa-exclamation-triangle"></i> {{ $message }}</span>
                      @enderror
                  </div>
              </div>
              <div class="col-xl-6">
                  <div class="form-group">
                      <label>Nama Barang:</label>
                      <input type="text" name="name" class="form-control @error('name') is-invalid border-danger @enderror" value="{{ old('name') }}" required placeholder="Produk 1...">
                      @error('name')
                          <span class="text-danger mt-1 d-block fs-12"><i class="fa fa-exclamation-triangle"></i> {{ $message }}</span>
                      @enderror
                  </div>
              </div>
              <div class="col-xl-6 mt-3">
                  <div class="form-group">
                      <label>Kategori:</label>
                      <select name="category_id" class="form-control category-select" required onchange="togglePriceInput(this, 'add')">
                        <option value="">-- Pilih --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" data-name="{{ strtolower($category->name) }}">{{ $category->name }}</option>
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

              <!-- Kolom Harga (Awalnya Display None) -->
              <div class="col-xl-6 mt-3 price-container-add" style="display: none;">
                  <div class="form-group">
                      <label>Estimasi Harga Beli (Rp):</label>
                      <input type="number" name="default_price" class="form-control price-input-add" value="0" min="0">
                  </div>
              </div>

              <div class="col-xl-6 mt-3">
                  <div class="form-group">
                      <label>Peringatan Limit Stok (Min Alert):</label>
                      <input type="number" name="min_alert" class="form-control" required value="0" min="0">
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
                      <!-- Trigger saat pertama modal dibuka bisa diatur di JS, tapi di sini cukup dari Onchange -->
                      <select name="category_id" class="form-control" required onchange="togglePriceInput(this, 'edit{{ $item->id }}')">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" data-name="{{ strtolower($category->name) }}" {{ $item->category_id == $category->id ? 'selected' : '' }}>
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

              <!-- Cek Logika saat render PHP apakah muncul atau tidak -->
              @php
                 $isMatEdit = str_contains(strtolower($item->category->name), 'bahan') || str_contains(strtolower($item->category->name), 'kemasan');
              @endphp
              <div class="col-xl-6 mt-3 price-container-edit{{ $item->id }}" style="{{ $isMatEdit ? 'display:block;' : 'display:none;' }}">
                  <div class="form-group">
                      <label>Estimasi Harga Beli (Rp):</label>
                      <input type="number" name="default_price" class="form-control price-input-edit{{ $item->id }}" value="{{ rtrim(rtrim($item->default_price, '0'), '.') }}" min="0">
                  </div>
              </div>

              <div class="col-xl-6 mt-3">
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
    // 1. Ambil data master yang sudah ada dari database langsung ke Javascript
    const existingItems = @json($items->map(function($item){ return ['id' => $item->id, 'sku' => strtolower($item->sku), 'name' => strtolower($item->name)]; })->values());

    document.addEventListener("DOMContentLoaded", function() {

        // Buka modal add otomatis jika error backend masih lolos
        @if($errors->any())
            var myModal = new bootstrap.Modal(document.getElementById('addItemModal'));
            myModal.show();
        @endif

        // 2. Real-time Duplicate Checker untuk Form Add
        const addNameInput = document.querySelector('#addItemModal input[name="name"]');
        const addSkuInput = document.querySelector('#addItemModal input[name="sku"]');
        const addSubmitBtn = document.querySelector('#addItemModal button[type="submit"]');

        function checkDuplicateAdd() {
            let nameVal = addNameInput.value.trim().toLowerCase();
            let skuVal = addSkuInput.value.trim().toLowerCase();

            let isNameDup = existingItems.some(i => i.name === nameVal);
            let isSkuDup = skuVal !== "" && existingItems.some(i => i.sku === skuVal);

            if (isNameDup || isSkuDup) {
                addNameInput.classList.add('border-danger');
                addSubmitBtn.disabled = true; // Matikan tombol simpan
                addSubmitBtn.textContent = 'Data Duplikat!';
            } else {
                addNameInput.classList.remove('border-danger');
                addSubmitBtn.disabled = false;
                addSubmitBtn.textContent = 'Simpan Barang';
            }
        }

        if(addNameInput) addNameInput.addEventListener('input', checkDuplicateAdd);
        if(addSkuInput) addSkuInput.addEventListener('input', checkDuplicateAdd);
    });

    // Fungsi show/hide input harga lama Anda
    function togglePriceInput(selectElement, type) {
        const catName = selectElement.options[selectElement.selectedIndex].getAttribute('data-name') || '';
        const formRow = selectElement.closest('.row');
        const priceContainer = formRow.querySelector('.price-container-' + type);
        const priceInput = formRow.querySelector('.price-input-' + type);

        if (catName.includes('bahan') || catName.includes('kemasan') || catName.includes('mentah')) {
            priceContainer.style.display = 'block';
            priceInput.setAttribute('required', 'required');
        } else {
            priceContainer.style.display = 'none';
            priceInput.removeAttribute('required');
            priceInput.value = 0; // Nol-kan jika bukan bahan
        }
    }
</script>
@endsection
