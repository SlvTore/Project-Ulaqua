<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    // Hanya Role 'Manager' atau 'Staff Gudang' yang boleh akses
    public function __construct()
    {
        // Spatie middleware multiple roles:
        $this->middleware('role:Manager|Staff Gudang');
    }

    public function index()
    {
        $page_title = 'Master Barang (Warehouse)';

        // Ambil semua barang BESERTA data Kategori dan Unit-nya (Eager Loading agar cepat)
        $items = Item::with(['category', 'unit'])->get();

        // Kita siapkan juga data Kategori dan Unit untuk form pop-up "Tambah Barang"
        $categories = Category::all();
        $units = Unit::all();

        return view('warehouse.items.index', compact('items', 'categories', 'units', 'page_title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255|unique:items,name',
            'sku'           => 'nullable|string|unique:items,sku',
            'category_id'   => 'required|exists:categories,id',
            'unit_id'       => 'required|exists:units,id',
            'min_alert'     => 'required|integer|min:0',
        ], [
            'name.unique' => 'Nama barang ini sudah pernah diregistrasikan. Tolong gunakan nama lain atau edit barang yang sudah ada.'
        ]);

        Item::create([
            'name'           => $request->name,
            'sku'            => $request->sku,
            'category_id'    => $request->category_id,
            'unit_id'        => $request->unit_id,
            'min_alert'      => $request->min_alert,
            'expected_stock' => 0,
            'default_price'  => $request->default_price ?? 0,
        ]);

        // Deteksi kategori untuk menentukan pesan Success
        $category = \App\Models\Category::find($request->category_id);
        $isFinishedGood = str_contains(strtolower($category->name), 'jadi') || str_contains(strtolower($category->name), 'produk');

        if ($isFinishedGood) {
            $msg = 'Barang <b>'.$request->name.'</b> berhasil ditambahkan. Karena ini Barang Jadi, <a href="'.route('boms.create').'" class="text-white text-decoration-underline"><b>Jangan lupa atur Resep BOM-nya di sini!</b></a>';
        } else {
            $msg = 'Barang master <b>'.$request->name.'</b> berhasil ditambahkan ke dalam sistem.';
        }

        return redirect()->back()->with('success_item', $msg);
    }

    public function destroy($id)
    {
        try {
            $item = Item::findOrFail($id);
            $itemName = $item->name;
            $item->delete();

            return redirect()->back()->with('success', 'Barang ' . $itemName . ' berhasil dihapus secara permanen!');

        } catch (\Illuminate\Database\QueryException $e) {
            // Error code 23000 adalah kode standar SQL untuk masalah Foreign Key Constraint (Data saling terikat)
            if($e->getCode() == "23000"){
                return redirect()->back()->with('error', 'GAGAL MENGHAPUS: Barang ini tidak dapat dihapus karena sudah memiliki riwayat Transaksi Gudang atau terikat dalam resep Formula BOM. Jika tidak digunakan lagi, ubah namanya dengan tambahan kata "(Nonaktif)".');
            }

            // Tangkap error database lainnya
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'name'          => 'required|string|max:255|unique:items,name,'.$id,
            'sku'           => 'nullable|string|unique:items,sku,'.$id,
            'category_id'   => 'required|exists:categories,id',
            'unit_id'       => 'required|exists:units,id',
            'min_alert'     => 'required|integer|min:0',
        ], [
            'name.unique' => 'Gagal mengubah karena nama tersebut sudah dipakai oleh produk master lain.'
        ]);

        // Simpan harga baru jika field tersebut dikirim (hanya dikirim jika kategori Bahan Baku)
        $newPrice = $request->has('default_price') ? $request->default_price : $item->default_price;

        $item->update([
            'name'          => $request->name,
            'sku'           => $request->sku,
            'category_id'   => $request->category_id,
            'unit_id'       => $request->unit_id,
            'min_alert'     => $request->min_alert,
            'default_price' => $newPrice,
        ]);

        return redirect()->back()->with('success', 'Data barang berhasil diperbarui!');
    }

    public function toggleStatus($id)
    {
        $item = Item::findOrFail($id);

        $item->is_active = !$item->is_active;

        if (!$item->is_active) {
            // Jika mematikan: Tambahkan teks (Nonaktif) ke akhir nama barang jika belum ada
            if (!str_ends_with($item->name, ' (Nonaktif)')) {
                $item->name = $item->name . ' (Nonaktif)';
            }
        } else {
            // Jika menghidupkan kembali: Hapus teks "(Nonaktif)"
            $item->name = str_replace(' (Nonaktif)', '', $item->name);
        }

        $item->save();

        $statusText = $item->is_active ? 'Diaktifkan' : 'Dinonaktifkan';

        return redirect()->back()->with('success', 'Status barang "' . $item->name . '" berhasil ' . $statusText . '!');
    }
}
