<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index()
    {
        $page_title = 'Daftar Penjualan (Kas Masuk)';
        $sales = Sale::with(['item', 'user'])->latest()->get();
        return view('finance.sales.index', compact('page_title', 'sales'));
    }

    public function create()
    {
        $page_title = 'Rekap Penjualan Baru';

        // Hanya ambil barang yang nama kategorinya BUKAN Bahan Baku atau Kemasan.
        $items = Item::with(['category', 'unit'])
                    ->whereHas('category', function($q) {
                        $q->where('name', 'not like', '%Bahan Baku%')
                          ->where('name', 'not like', '%Kemasan%');
                    })->get();

        return view('finance.sales.create', compact('page_title', 'items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_date'      => 'required|date',
            'item_id'        => 'required|exists:items,id',
            'quantity'       => 'required|numeric|min:1',
            'price_per_unit' => 'required|numeric|min:0',
            'notes'          => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $item = Item::findOrFail($request->item_id);

            // Cegah penjualan jika stok di gudang tidak mencukupi
            if ($item->expected_stock < $request->quantity) {
                return back()->with('error', 'Stok tidak cukup! Sisa stok di gudang saat ini: ' . $item->expected_stock)->withInput();
            }

            // Generate nomor urut invoice unik
            $latestSale = Sale::latest('id')->first();
            $nextId = $latestSale ? $latestSale->id + 1 : 1;
            $referenceNumber = 'INV-' . date('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

            $totalAmount = $request->quantity * $request->price_per_unit;

            Sale::create([
                'reference_number' => $referenceNumber,
                'sale_date'        => $request->sale_date,
                'item_id'          => $request->item_id,
                'quantity'         => $request->quantity,
                'price_per_unit'   => $request->price_per_unit,
                'total_amount'     => $totalAmount,
                'user_id'          => Auth::id() ?? 1,
                'notes'            => $request->notes,
            ]);

            DB::commit();
            return redirect()->route('sales.index')->with('success', 'Penjualan berhasil dicatat. Stok gudang dan Kas Masuk otomatis terupdate!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyimpan penjualan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        // Fitur Rollback: Jika dihapus, fungsi deleting() di Model akan membatalkan status barang keluar (OUT).
        Sale::findOrFail($id)->delete();
        return redirect()->route('sales.index')->with('success', 'Catatan Penjualan dihapus. Pemasukan dibatalkan dan Stok dikembalikan ke gudang otomatis!');
    }

    public function edit($id)
    {
        $page_title = 'Koreksi (Edit) Penjualan';
        $sale = Sale::findOrFail($id);
        
        // Filter yang sama untuk mode edit
        $items = Item::with(['category', 'unit'])
                    ->whereHas('category', function($q) {
                        $q->where('name', 'not like', '%Bahan Baku%')
                          ->where('name', 'not like', '%Kemasan%');
                    })->get();

        return view('finance.sales.edit', compact('page_title', 'sale', 'items'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sale_date'      => 'required|date',
            'item_id'        => 'required|exists:items,id',
            'quantity'       => 'required|numeric|min:1',
            'price_per_unit' => 'required|numeric|min:0',
            'notes'          => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $sale = Sale::findOrFail($id);
            $item = Item::findOrFail($request->item_id);

            // Validasi stok cerdik: Kembalikan dulu stok lama di memori (Simulasi Undo)
            $currentStock = $item->expected_stock;
            if ($sale->item_id == $item->id) {
                 $currentStock += $sale->quantity;
            }

            if ($currentStock < $request->quantity) {
                 return back()->with('error', 'Stok tidak cukup untuk pembaruan ini! Sisa stok riil: ' . $currentStock)->withInput();
            }

            $totalAmount = $request->quantity * $request->price_per_unit;

            $sale->update([
                'sale_date'        => $request->sale_date,
                'item_id'          => $request->item_id,
                'quantity'         => $request->quantity,
                'price_per_unit'   => $request->price_per_unit,
                'total_amount'     => $totalAmount,
                'notes'            => $request->notes,
            ]);

            DB::commit();
            return redirect()->route('sales.index')->with('success', 'Catatan Penjualan berhasil diubah! Sistem telah melakukan rekalkulasi (Redo) stok gudang secara otomatis.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal mengubah penjualan: ' . $e->getMessage())->withInput();
        }
    }
}
