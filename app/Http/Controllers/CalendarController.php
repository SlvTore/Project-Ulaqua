<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    // Menampilkan halaman kalender
    public function index()
    {
        return view('clients.calendar');
    }

    // Mengambil data untuk JSON FullCalendar
    public function getEvents(Request $request)
    {
        $events = collect();

        // 1. Data Acara / Kegiatan Umum
        $kegiatan = \App\Models\Event::all()->map(function ($item) {
            return [
                'id' => 'evt_' . $item->id,
                'title' => $item->title,
                'start' => $item->start_date,
                'end' => $item->end_date,
                'allDay' => true,
                'className' => ($item->color ?? 'bg-primary') . ' text-white border-0 shadow-sm', // Warna Badge
                'extendedProps' => [
                    'type' => 'Kegiatan',
                    'description' => 'Kegiatan rutin atau jadwal libur.'
                ]
            ];
        });
        $events = $events->merge($kegiatan);

        // 2. Data Penjualan (Sales) - Contoh
        // (Pastikan Model Sale & relasi client sudah ada)
        $sales = \App\Models\Sale::with('client')->get()->map(function ($item) {
            return [
                'id' => 'sale_' . $item->id,
                'title' => 'Sales: ' . ($item->client->name ?? 'Walk-in'),
                'start' => $item->created_at->format('Y-m-d'), // Tanggal aktivitas
                'allDay' => true,
                'className' => 'bg-success text-white border-0 shadow-sm', // Warna Badge Hijau
                'extendedProps' => [
                    'type' => 'Penjualan',
                    'description' => 'Transaksi Penjualan status: ' . $item->payment_status
                ]
            ];
        });
        $events = $events->merge($sales);

        // 3. Tambahkan data lain (Stock Opname, Produksi) dengan cara yang sama...
        // $stock = \App\Models\StockOpname::all()->map(...)
        // $events = $events->merge($stock);

        return response()->json($events);
    }

    // Fungsi AJAX untuk drag & drop (pindah tanggal)
    public function updateEventDrop(Request $request, $id)
    {
        // Hanya bisa update id yang prefixnya evt_ (tabel events)
        $realId = str_replace('evt_', '', $id);
        $event = Event::findOrFail($realId);

        $event->update([
            'start_date' => $request->start,
            'end_date' => $request->end,
        ]);

        return response()->json(['message' => 'Jadwal berhasil diperbarui!']);
    }

    // Fungsi AJAX untuk menyimpan (Drop pertama kali dari Sidebar)
    public function storeEvent(Request $request)
    {
        // Pastikan warna tag Libur menjadi danger, sisanya secondary.
        $title = $request->title ?: 'Event Baru';
        $color = (stripos(strtolower($title), 'libur') !== false) ? 'bg-danger' : 'bg-secondary';

        $event = Event::create([
            'title' => $title,
            'start_date' => $request->start,
            'end_date' => $request->end,
            'color' => $color
        ]);

        return response()->json([
            'message' => 'Berhasil ditambahkan',
            'event' => [
                'id' => 'evt_' . $event->id,
                'title' => $event->title,
                'start' => $event->start_date,
                'end' => $event->end_date,
                'allDay' => true,
                'className' => $event->color . ' text-white border-0 shadow-sm',
                'extendedProps' => [
                    'type' => 'Kegiatan',
                    'description' => 'Aktivitas ditambahkan manual.'
                ]
            ]
        ]);
    }

    // Fungsi AJAX untuk HAPUS Event dari Popover
    public function destroyEvent($id)
    {
        // Hanya hapus jika dari tabel events (evt_)
        if (str_starts_with($id, 'evt_')) {
            $realId = str_replace('evt_', '', $id);
            Event::destroy($realId);
            return response()->json(['message' => 'Agenda berhasil dihapus!']);
        }

        return response()->json(['message' => 'Hanya kegiatan manual yang bisa dihapus.'], 403);
    }
}
