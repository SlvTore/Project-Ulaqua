<?php

namespace App\Http\Controllers;

use App\Models\InventoryTransaction;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Manager|Staff Gudang');
    }

    public function index()
    {
        $page_title = 'Barang Masuk & Keluar';

        // Menampilkan 50 riwayat transaksi logistik terakhir
        $transactions = InventoryTransaction::with(['item.unit', 'user'])
                            ->orderBy('created_at', 'desc')
                            ->take(50)
                            ->get();

        // Kirim data Items untuk dipasang di dalam Form Dropdown
        $items = Item::with('unit')->get();

        return view('warehouse.inventory.index', compact('transactions', 'items', 'page_title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id'          => 'required|exists:items,id',
            'type'             => 'required|in:IN,OUT',
            'qty'              => 'required|integer|min:1',
            'transaction_date' => 'required|date',
            'reference_number' => 'nullable|string|max:100',
            'notes'            => 'nullable|string',
        ]);

        $item = Item::findOrFail($request->item_id);

        // Validasi Pencegahan: Jika barang mau keluar, apakah stok gudang cukup?
        if ($request->type === 'OUT' && $item->expected_stock < $request->qty) {
            return redirect()->back()
                ->with('error', "Gagal! Sisa stok {$item->name} hanya {$item->expected_stock} {$item->unit->short_name}. Tidak bisa mengeluarkan {$request->qty}!");
        }

        // Jika lolos validasi, simpan ke buku log
        InventoryTransaction::create([
            'item_id'          => $request->item_id,
            'user_id'          => Auth::id(), // Rekam siapa yang login
            'type'             => $request->type,
            'qty'              => $request->qty,
            'transaction_date' => $request->transaction_date,
            'reference_number' => $request->reference_number,
            'notes'            => $request->notes,
        ]);

        // Catatan: Anda tidak perlu men-update stok item (expected_stock) di sini
        // karena Model InventoryTransaction sudah memilikinya secara *otomatis* di langkah 2 (booted event).

        return redirect()->back()->with('success', 'Transaksi barang berhasil diinput dan Saldo Stok telah terupdate otomatis!');
    }
}
