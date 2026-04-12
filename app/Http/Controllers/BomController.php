<?php

namespace App\Http\Controllers;

use App\Models\Bom;
use App\Models\Item;
use App\Models\BomItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BomController extends Controller
{
    public function index()
    {
        // Menampilkan daftar semua resep
        $boms = Bom::with('product')->get();
        return view('warehouse.bom.index', compact('boms'));
    }

    public function create()
    {
        // Hanya ambil item "Barang Jadi" YANG BELUM PUNYA BOM
        $finishedGoods = \App\Models\Item::whereHas('category', function ($q) {
            $q->where('name', 'like', '%Jadi%')->orWhere('name', 'like', '%Produk%');
        })->doesntHave('boms')->get(); // <-- ini filter sakti anti-duplikat-nya

        // Hanya ambil item yang nama kategorinya mengandung kata "Bahan" / "Kemasan"
        $rawMaterials = Item::whereHas('category', function ($q) {
            $q->where('name', 'like', '%Bahan%')->orWhere('name', 'like', '%Kemasan%')->orWhere('name', 'like', '%Mentah%');
        })->get();

        return view('warehouse.bom.create', compact('finishedGoods', 'rawMaterials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id|unique:boms,item_id',
            'calc_mode' => 'required|in:auto,manual',
            'total_hpp' => 'required_if:calc_mode,manual', // <-- Hilangkan |numeric|min:0
        ], [
            'item_id.unique' => 'Produk ini SUDAH MEMILIKI resep Formula/BOM.',
        ]);

        try {
            DB::beginTransaction();

            $targetItem = \App\Models\Item::findOrFail($request->item_id);

            $bom = \App\Models\Bom::create([
                'name' => 'BOM - ' . $targetItem->name,
                'item_id' => $request->item_id,
            ]);

            $totalCost = 0;

            // Jika mode AUTO: hitung dari bahan baku
            if ($request->calc_mode === 'auto') {
                if ($request->has('material_ids')) {
                    foreach ($request->material_ids as $index => $material_id) {
                        if (!$material_id) continue;

                        $qty = $request->quantities[$index] ?? 0;
                        if ($qty <= 0) continue;

                        $materialData = \App\Models\Item::find($material_id);
                        $dbPrice = $materialData ? $materialData->default_price : 0;

                        \App\Models\BomItem::create([
                            'bom_id' => $bom->id,
                            'item_id' => $material_id,
                            'quantity' => $qty
                        ]);

                        $totalCost += ($dbPrice * $qty);
                    }
                }
            } else {
                // Jika mode MANUAL: Ambil langsung dari inputan teks yang diketik Anda!
                $totalCost = str_replace(',', '', $request->total_hpp); // Bersihkan format ribuan
                $totalCost = str_replace('.', '', $totalCost); // Jaga-jaga format titik
            }

            // Simpan harga Final ke target Item
            $targetItem->update(['default_price' => $totalCost]);

            DB::commit();
            return redirect()->route('boms.index')
                ->with('success', 'BOM tersimpan! Harga HPP menjadi Rp ' . number_format($totalCost, 0, ',', '.'));

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        // Hapus (otomatis menghapus bom_items karena on cascade di DB)
        Bom::findOrFail($id)->delete();
        return redirect()->route('boms.index')->with('success', 'Formula terhapus!');
    }

    public function edit($id)
    {
        $bom = \App\Models\Bom::with('components')->findOrFail($id);

        // Ambil "Barang Jadi" YANG BELUM PUNYA BOM, ATAU (OR) Barang yang memang milik BOM ini (agar bisa muncul saat di-edit)
        $finishedGoods = \App\Models\Item::whereHas('category', function ($q) {
            $q->where('name', 'like', '%Jadi%')->orWhere('name', 'like', '%Produk%');
        })->where(function ($q) use ($bom) {
            $q->doesntHave('boms')->orWhere('id', $bom->item_id);
        })->get();

        $rawMaterials = \App\Models\Item::whereHas('category', function ($q) {
            $q->where('name', 'like', '%Bahan%')->orWhere('name', 'like', '%Kemasan%')->orWhere('name', 'like', '%Mentah%');
        })->get();

        return view('warehouse.bom.edit', compact('bom', 'finishedGoods', 'rawMaterials'));
    }

    public function update(Request $request, $id)
    {
        // 1. Sesuaikan Validasi untuk Mode Manual
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'calc_mode' => 'required|in:auto,manual',
            'total_hpp' => 'nullable',  // <-- Hilangkan |numeric|min:0
        ]);

        try {
            DB::beginTransaction();

            $bom = \App\Models\Bom::findOrFail($id);
            $targetItem = \App\Models\Item::findOrFail($request->item_id);

            // Update Master BOM
            $bom->update([
                'name' => 'BOM - ' . $targetItem->name,
                'item_id' => $request->item_id,
            ]);

            // Selalu hapus racikan bahan baku lama saat diedit, untuk dimasukkan yang terbaru (kalau ada)
            \App\Models\BomItem::where('bom_id', $bom->id)->delete();

            $totalCost = 0;

            // 2. Cek Mode Auto vs Manual
            if ($request->calc_mode === 'auto') {
                if ($request->has('material_ids')) {
                    foreach ($request->material_ids as $index => $material_id) {
                        if (!$material_id) continue;

                        $qty = $request->quantities[$index] ?? 0;
                        if ($qty <= 0) continue;

                        // TARIK ULANG HARGA SAAT INI DARI DATABASE
                        $materialData = \App\Models\Item::find($material_id);
                        $dbPrice = $materialData ? $materialData->default_price : 0;

                        \App\Models\BomItem::create([
                            'bom_id' => $bom->id,
                            'item_id' => $material_id,
                            'quantity' => $qty
                        ]);

                        $totalCost += ($dbPrice * $qty); // Harga dijumlah otomatis
                    }
                }
            } else {
                // Kalkulasi Mode Manual HPP
                $totalCost = str_replace(',', '', $request->total_hpp); // Bersihkan format ribuan
                $totalCost = str_replace('.', '', $totalCost); // Jaga-jaga format titik yg mungkin ketik
                $totalCost = (float) $totalCost;
            }

            // 3. Update Harga HPP Target Item (Barang Jadi)
            $targetItem->update(['default_price' => $totalCost]);

            DB::commit();
            return redirect()->route('boms.index')
                ->with('success', 'BOM berhasil diperbarui! HPP dikunci di Rp ' . number_format($totalCost, 0, ',', '.'));

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memperbarui BOM: ' . $e->getMessage());
        }
    }
}
