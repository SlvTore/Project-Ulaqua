<?php

namespace App\Http\Controllers;

use App\Models\Production;
use App\Models\Bom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductionController extends Controller
{
    public function index()
    {
        $page_title = 'Biaya Pabrik / Riwayat Produksi';
        $productions = Production::with(['item', 'user'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('finance.production.index', compact('productions', 'page_title'));
    }

    public function create()
    {
        $page_title = 'Catat Produksi Baru';
        // Ambil semua resep BOM yang aktif beserta produk jadinya
        $boms = Bom::with('product')->get();

        return view('finance.production.create', compact('boms', 'page_title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bom_id'          => 'required|exists:boms,id',
            'quantity'        => 'required|numeric|min:1',
            'production_date' => 'required|date',
            'notes'           => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Ambil data resep dan produk jadinya
            $bom = Bom::with('product')->findOrFail($request->bom_id);

            // Kalkulasi Total Biaya Pabrik (HPP Barang Jadi x Jumlah Produksi)
            $total_cost = $bom->product->default_price * $request->quantity;

            // Simpan Ke Tabel Produksi (Ini akan otomatis memanggil Trigger 'IN/OUT' Barang di Model!)
            Production::create([
                'reference_number' => 'PRD-' . date('YmdHis'),
                'production_date'  => $request->production_date,
                'item_id'          => $bom->item_id,
                'bom_id'           => $bom->id,
                'quantity'         => $request->quantity,
                'total_cost'       => $total_cost,
                'user_id'          => Auth::id(),
                'notes'            => $request->notes,
            ]);

            DB::commit();
            return redirect()->route('productions.index')->with('success', 'Produksi berhasil dicatat! Stok Bahan Baku otomatis dipotong & Stok Produk Jadi otomatis bertambah.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal mencatat produksi: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $page_title = 'Edit Rekapan Produksi';
        $production = Production::findOrFail($id);
        $boms = Bom::with('product')->get();

        return view('finance.production.edit', compact('production', 'boms', 'page_title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bom_id'          => 'required|exists:boms,id',
            'quantity'        => 'required|numeric|min:1',
            'production_date' => 'required|date',
            'notes'           => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $production = Production::findOrFail($id);
            $bom = Bom::with('product')->findOrFail($request->bom_id);

            $production->update([
                'production_date'  => $request->production_date,
                'item_id'          => $bom->item_id,
                'bom_id'           => $bom->id,
                'quantity'         => $request->quantity,
                'total_cost'       => $bom->product->default_price * $request->quantity,
                'notes'            => $request->notes,
            ]);

            DB::commit();
            return redirect()->route('productions.index')->with('success', 'Perubahan disimpan! Sistem telah berhasil melakukan Rekalkulasi (Undo & Redo) pada pergerakan stok gudang secara presisi.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal update produksi: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        Production::findOrFail($id)->delete();
        return redirect()->route('productions.index')->with('success', 'Rekapan Produksi Dibatalkan/Dihapus. Seluruh stok barang telah dikembalikan (Rollback) ke gudang sepenuhnya!');
    }
}
