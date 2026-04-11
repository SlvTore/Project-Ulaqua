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
        // Hanya ambil item yang nama kategorinya mengandung kata "Jadi" / "Produk"
        $finishedGoods = Item::whereHas('category', function ($q) {
            $q->where('name', 'like', '%Jadi%')->orWhere('name', 'like', '%Produk%');
        })->get();

        // Hanya ambil item yang nama kategorinya mengandung kata "Bahan" / "Kemasan"
        $rawMaterials = Item::whereHas('category', function ($q) {
            $q->where('name', 'like', '%Bahan%')->orWhere('name', 'like', '%Kemasan%')->orWhere('name', 'like', '%Mentah%');
        })->get();

        return view('warehouse.bom.create', compact('finishedGoods', 'rawMaterials'));
    }

    public function store(Request $request)
    {
        // Validasi tanpa input 'name'
        $request->validate([
            'item_id' => 'required|exists:items,id', // Produk Jadinya
            'material_ids' => 'required|array|min:1',
            'material_ids.*' => 'required|exists:items,id',
            'quantities' => 'required|array|min:1',
            'quantities.*' => 'required|numeric|min:0.01',
            'prices' => 'required|array|min:1',       // Tambahkan validasi array Harga Custom
            'prices.*' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Ambil data produk target
            $targetItem = Item::findOrFail($request->item_id);

            // 1. Simpan Data Induk BOM (Nama di-set otomatis)
            $bom = Bom::create([
                'name' => 'BOM - ' . $targetItem->name,
                'item_id' => $request->item_id,
            ]);

            $totalCost = 0;

            // 2. Simpan Detail Bahan Baku dan hitung total Harga Pokok (HPP)
            foreach ($request->material_ids as $index => $material_id) {
                $qty = $request->quantities[$index];
                $customPrice = $request->prices[$index]; // Ambil harga yang boleh diedit oleh user

                BomItem::create([
                    'bom_id' => $bom->id,
                    'item_id' => $material_id,
                    'quantity' => $qty
                ]);

                // Hitung total dengan harga custom yang ditarik dari form BOM
                $totalCost += ($customPrice * $qty);
            }

            // 3. Update Harga Produk Jadi (`default_price`) di master barang sesuai kalkulasi BOM!
            $targetItem->update([
                'default_price' => $totalCost
            ]);

            DB::commit();
            return redirect()->route('boms.index')
                ->with('success', 'BOM berhasil dibuat. Harga Pokok (HPP) otomatis diatur berdasarkan form ke Rp ' . number_format($totalCost, 0, ',', '.'));

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyimpan BOM: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        // Hapus (otomatis menghapus bom_items karena on cascade di DB)
        Bom::findOrFail($id)->delete();
        return redirect()->route('boms.index')->with('success', 'Formula terhapus!');
    }
}
