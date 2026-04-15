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
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label class="text-primary font-weight-bold">Produk Target Jadi (Output):</label>
                            <select name="item_id" class="form-control form-control-lg" required>
                                <option value="">-- Pilih Barang Jadi --</option>
                                @foreach($finishedGoods as $fg)
                                    <option value="{{ $fg->id }}">{{ $fg->name }} (SKU: {{ $fg->sku }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="text-primary font-weight-bold">Mode Kalkulasi HPP:</label>
                        <div class="d-flex align-items-center form-group border p-3 rounded" style="background:#f8f9fa;">
                            <div class="form-check me-4">
                                <input class="form-check-input" type="radio" name="calc_mode" id="modeAuto" value="auto" checked onchange="toggleMode()">
                                <label class="form-check-label" for="modeAuto">
                                    Otomatis (Hitung dari Resep Bahan Baku)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="calc_mode" id="modeManual" value="manual" onchange="toggleMode()">
                                <label class="form-check-label" for="modeManual">
                                    Manual (Input HPP Langsung)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="manualInputSection" style="display: none;" class="mb-4 bg-light p-4 rounded border-warning border">
                    <h5 class="text-warning">Nominal HPP Manual</h5>
                    <p class="text-muted fs-14">Masukkan Harga Pokok Produk (HPP) akhir secara eksplisit. Form resep bahan baku di bawah tidak akan diproses nominal harganya.</p>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-white">Rp</span>
                        <input type="text" name="total_hpp" id="manualHPP" class="form-control text-success fw-bold fs-20" placeholder="0" value="0">
                    </div>
                </div>

                <div id="autoInputSection">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="text-primary m-0">Daftar Bahan Baku / Material (Input)</h5>
                    </div>

                    <table class="table table-bordered mb-4" id="materialsTable">
                        <!-- STRUKTUR TABEL ANDA (SAMA SEPERTI SEBELUMNYA) -->
                        <thead class="bg-light">
                            <tr>
                                <th width="45%">Pilih Bahan Baku</th>
                                <th width="20%">Harga Murni</th>
                                <th width="20%">Jml Kebutuhan</th>
                                <th width="15%">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="materialsBody">
                            @for ($i = 0; $i < 3; $i++)
                            <tr>
                                <td>
                                    <select name="material_ids[]" class="form-control material-select">
                                        <option value="" data-price="0">-- Bebas Pilih --</option>
                                        @foreach($rawMaterials as $rm)
                                            <option value="{{ $rm->id }}" data-price="{{ (int)$rm->default_price }}">
                                                {{ $rm->name }} [Stok: {{ $rm->expected_stock }}]
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" class="form-control item-price border-0 bg-transparent text-secondary font-weight-bold" value="0" readonly>
                                    <input type="hidden" name="prices[]" class="hidden-price" value="0">
                                </td>
                                <td>
                                    <input type="number" name="quantities[]" class="form-control item-qty" placeholder="Qty" step="0.01" min="0" value="0">
                                </td>
                                <td>
                                    <input type="number" class="form-control item-subtotal bg-light border-0 text-success font-weight-bold" readonly value="0">
                                </td>
                            </tr>
                            @endfor
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <td colspan="3" class="text-end font-weight-bold text-primary align-middle h5 mb-0">GRAND TOTAL HPP (AUTO):</td>
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-text border-0 bg-transparent text-success font-weight-bold">Rp</span>
                                        <input type="text" id="grandTotalInput" class="form-control bg-transparent border-0 text-success font-weight-bold fs-18 p-0" readonly value="0">
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div> <!-- End Auto Section -->

                <div class="mt-3 border-top pt-3 text-end">
                    <a href="{{ route('boms.index') }}" class="btn btn-danger light me-2">Batal</a>
                    <button type="submit" class="btn btn-primary px-5">Simpan BOM & Terapkan Harga</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@push('scripts')
<script>
    // Fitur Hide/Show Ceklak-Ceklik
    function toggleMode() {
        const isManual = document.getElementById('modeManual').checked;
        const autoSection = document.getElementById('autoInputSection');
        const manualSection = document.getElementById('manualInputSection');

        if(isManual) {
            autoSection.style.display = 'none';
            manualSection.style.display = 'block';
        } else {
            autoSection.style.display = 'block';
            manualSection.style.display = 'none';
        }
    }

    // Fungsi Murni Kalkulasi Matematika
    function runMathCalculations() {
        var grandTotal = 0;
        $('#materialsBody tr').each(function() {
            var select = $(this).find('select.material-select');
            var priceBox = $(this).find('.item-price');
            var hiddenBox = $(this).find('.hidden-price');
            var qtyBox = $(this).find('.item-qty');
            var subtotalBox = $(this).find('.item-subtotal');

            if (select.length > 0 && qtyBox.length > 0) {
                var price = parseFloat(select.find('option:selected').attr('data-price')) || 0;
                var qty = parseFloat(qtyBox.val()) || 0;

                priceBox.val(price);
                if (hiddenBox.length) hiddenBox.val(price);

                var subtotal = price * qty;
                subtotalBox.val(subtotal);
                grandTotal += subtotal;
            }
        });
        $('#grandTotalInput').val(grandTotal.toLocaleString('id-ID'));
    }

    $(document).ready(function() {
        setInterval(runMathCalculations, 1000); // Polling JS yang sekarang PASTI berjalan!

        $(document).on('change', '.material-select', function() {
            var tr = $(this).closest('tr');
            var qtyBox = tr.find('.item-qty');
            var price = parseFloat($(this).find('option:selected').attr('data-price')) || 0;
            if (price > 0 && (parseFloat(qtyBox.val()) === 0 || qtyBox.val() === '')) {
                qtyBox.val(1);
            }
            runMathCalculations();
        });
    });
</script>
@endpush
@endsection

