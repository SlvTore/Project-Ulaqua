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

    // FUNGSI UNTUK MENAMPILKAN HALAMAN FORM STOK OPNAME
    public function opname()
    {
        $page_title = 'Stok Opname (Penyesuaian Fisik)';
        // Menampilkan semua barang untuk langsung di-opname sekalian
        $items = Item::with('category', 'unit')
            ->orderBy('category_id')
            ->get();

        return view('warehouse.inventory.opname', compact('items', 'page_title'));
    }

    // FUNGSI UNTUK MEMPROSES HASIL OPNAME
    public function storeOpname(Request $request)
    {
        $request->validate([
            'physical_stocks' => 'required|array', // Menerima deretan angka array dari form Opname
            'notes' => 'nullable|string'
        ]);

        $transactionCount = 0;

        foreach ($request->physical_stocks as $item_id => $physical_stock) {
            // Hindari data kosong/tidak diisi
            if ($physical_stock === null || $physical_stock === '') continue;

            $item = Item::findOrFail($item_id);
            $system_stock = $item->expected_stock;
            $physical_qty = (float) $physical_stock;

            // Apakah stok fisik BERBEDA dengan stok sistem web?
            if ($physical_qty !== $system_stock) {
                // Cari tahu apakah barang dinyatakan lebih (Masuk) atau hilang/kurang (Keluar)
                $difference = $physical_qty - $system_stock;

                $type = $difference > 0 ? 'IN' : 'OUT';
                $adjusted_qty = abs($difference); // abs() akan mengubah angka minus jadi plus murni

                // Otomatis bikin tiket Riwayat Transaksi (Sistem DB Anda otomatis nge-update barangnya!)
                \App\Models\InventoryTransaction::create([
                    'item_id'          => $item->id,
                    'user_id'          => \Illuminate\Support\Facades\Auth::id(),
                    'type'             => $type,
                    'qty'              => $adjusted_qty,
                    'transaction_date' => now(), // tanggal hari ini disaat opname terjadi
                    'reference_number' => 'OPN-' . date('Ymd-His'), // contoh kode nota "OPN-20230801-143000"
                    'notes'            => 'Penyesuaian Fisik Opname. ' . ($request->notes ?? 'Sistem melaporkan ' . $system_stock . ', aktual Gudang: ' . $physical_qty),
                ]);

                $transactionCount++;
            }
        }

        if ($transactionCount > 0) {
            return redirect()->back()->with('success', "Stok Opname berhasil diselesaikan! Terdapat {$transactionCount} pencatatan penyesuaian selisih stok gudang.");
        }

        return redirect()->back()->with('info', "Opname dikirim, namun tidak ada selisih. Jumlah stok fisik dan sistem terhitung klop/sinkron.");
    }
}
