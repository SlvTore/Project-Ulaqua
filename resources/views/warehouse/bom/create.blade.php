@extends('layouts.default')

@section('content')
<div class="container-fluid">
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Buat Formula Master (BOM) & Kalkulasi Harga</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('boms.store') }}" method="POST" id="bomForm">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="text-primary font-weight-bold">Produk Target Jadi (Output):</label>
                            <select name="item_id" class="form-control form-control-lg" required>
                                <option value="">-- Pilih Barang Jadi --</option>
                                @foreach($finishedGoods as $fg)
                                    <option value="{{ $fg->id }}">{{ $fg->name }} (SKU: {{ $fg->sku }})</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Peringatan: Harga produk yang dipilih di atas akan otomatis terbentuk dari total harga bahan baku di bawah ini.</small>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="text-primary m-0">Daftar Bahan Baku / Material (Input)</h5>
                    <h4>Total HPP: Rp. <span id="grandTotalDisplay" class="text-danger">0</span></h4>
                </div>

                <table class="table table-bordered mb-4" id="materialsTable">
                    <thead class="bg-light">
                        <tr>
                            <th width="45%">Pilih Bahan / Komponen Baku</th>
                            <th width="15%">Harga Per Unit <small>(Bisa Diubah)</small></th>
                            <th width="20%">Jml Keb. (Qty)</th>
                            <th width="15%">Subtotal Harga</th>
                            <th width="5%" class="text-center">#</th>
                        </tr>
                    </thead>
                    <tbody id="materialsBody">
                        <!-- Baris Pertama yang tampil -->
                        <tr>
                            <td>
                                <select name="material_ids[]" class="form-control material-select" required onchange="calculateLivePrice(this)">
                                    <option value="" data-price="0">-- Pilih Komponen Baku --</option>
                                    @foreach($rawMaterials as $rm)
                                        <option value="{{ $rm->id }}" data-price="{{ (int)$rm->default_price }}">
                                            {{ $rm->name }} [Harga Asal: Rp.{{ number_format($rm->default_price,0,'','.') }}]
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <!-- Atribut name="prices[]" dan hapus 'readonly' agar User bisa bebas ganti harga -->
                                <input type="number" name="prices[]" class="form-control item-price border-info" value="0" min="0" required oninput="calculateLivePrice(this)">
                            </td>
                            <td>
                                <input type="number" name="quantities[]" class="form-control item-qty" placeholder="Qty" step="0.01" min="0.01" value="1" required oninput="calculateLivePrice(this)">
                            </td>
                            <td>
                                <input type="number" class="form-control item-subtotal bg-light" readonly value="0">
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm sharp" onclick="removeRow(this)"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <button type="button" class="btn btn-info light mb-4" onclick="addRow()">+ Tambah Baris Bahan</button>

                <div class="mt-3 border-top pt-3 text-end">
                    <a href="{{ route('boms.index') }}" class="btn btn-danger light me-2">Batal</a>
                    <button type="submit" class="btn btn-primary px-5">Simpan BOM & Terapkan Harga</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- TABEL TEMPLATE TERSEMBUNYI UNTUK KLONING AMAN (ANTI ERROR) -->
<table style="display: none;">
    <tbody id="hiddenTemplate">
        <tr>
            <td>
                <select name="material_ids[]" class="form-control material-select" required onchange="calculateLivePrice(this)">
                    <option value="" data-price="0">-- Pilih Komponen Baku --</option>
                    @foreach($rawMaterials as $rm)
                        <option value="{{ $rm->id }}" data-price="{{ (int)$rm->default_price }}">
                            {{ $rm->name }} [Harga Asal: Rp.{{ number_format($rm->default_price,0,'','.') }}]
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" name="prices[]" class="form-control item-price border-info" value="0" min="0" required oninput="calculateLivePrice(this)">
            </td>
            <td>
                <input type="number" name="quantities[]" class="form-control item-qty" placeholder="Qty" step="0.01" min="0.01" value="1" required oninput="calculateLivePrice(this)">
            </td>
            <td>
                <input type="number" class="form-control item-subtotal bg-light" readonly value="0">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm sharp" onclick="removeRow(this)"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
    </tbody>
</table>

@endsection

@section('scripts')
<script>
    // 1. FUNGSI TAMBAH BARIS (Langsung duplikasi baris pertama dan kosongkan)
    function addRow() {
        const tbody = document.getElementById('materialsBody');
        // Ambil elemen <tr> baris pertama yang ada di tabel
        const firstRow = tbody.querySelector('tr');
        // Kloning baris tersebut beserta fungsinya (true)
        const clone = firstRow.cloneNode(true);

        // Kosongkan nilai di baris hasil kloning
        clone.querySelector('.material-select').selectedIndex = 0; // Reset Dropdown
        clone.querySelector('.item-price').value = 0;
        clone.querySelector('.item-qty').value = 1;
        clone.querySelector('.item-subtotal').value = 0;

        // Tambahkan baris baru tersebut ke bagian bawah tabel
        tbody.appendChild(clone);
    }

    // 2. FUNGSI HAPUS BARIS
    function removeRow(btn) {
        const tbody = document.getElementById('materialsBody');
        if(tbody.querySelectorAll('tr').length > 1) {
            btn.closest('tr').remove();
            calculateGrandTotal(); // Hitung ulang total setelah dihapus
        } else {
            alert('Minimal harus ada 1 komponen baku!');
        }
    }

    // 3. FUNGSI KALKULASI HARGA
    function calculateLivePrice(element) {
        const tr = element.closest('tr');
        const selectBox = tr.querySelector('.material-select');
        const priceBox = tr.querySelector('.item-price');
        const qtyBox = tr.querySelector('.item-qty');
        const subtotalBox = tr.querySelector('.item-subtotal');

        if(element.classList.contains('material-select')){
            const selectedOption = selectBox.options[selectBox.selectedIndex];
            // Ambil harga dari atribut, jika kosong = 0
            const originalPrice = parseFloat(selectedOption.getAttribute('data-price')) || 0;
            priceBox.value = originalPrice;
        }

        const inputPrice = parseFloat(priceBox.value) || 0;
        const qty = parseFloat(qtyBox.value) || 0;

        // Hitung Subtotal per baris
        subtotalBox.value = inputPrice * qty;

        calculateGrandTotal();
    }

    // 4. FUNGSI TOTAL HPP JENDERAL
    function calculateGrandTotal() {
        let total = 0;
        const subtotals = document.querySelectorAll('.item-subtotal');

        subtotals.forEach(box => {
            total += parseFloat(box.value) || 0;
        });

        document.getElementById('grandTotalDisplay').innerText = total.toLocaleString('id-ID');
    }
</script>
@endsection
