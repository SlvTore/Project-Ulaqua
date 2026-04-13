<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Production;
use Carbon\Carbon;

class FinanceReportController extends Controller
{
    public function dashboard()
    {
        $page_title = 'Laporan Arus Kas & Penjualan';

        // Contoh Pengambilan Data 6 Bulan Terakhir untuk Chart
        $salesData = [];
        $productionCostData = [];
        $labels = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->translatedFormat('F Y');

            // Pemasukan Penjualan
            $sales = Sale::whereYear('sale_date', $month->year)
                         ->whereMonth('sale_date', $month->month)
                         ->sum('total_amount');
            $salesData[] = $sales;

            // Pengeluaran Produksi (HPP)
            $production = Production::whereYear('production_date', $month->year)
                                    ->whereMonth('production_date', $month->month)
                                    ->sum('total_cost');
            $productionCostData[] = $production;
        }

        return view('finance.reports.dashboard', compact('page_title', 'labels', 'salesData', 'productionCostData'));
    }
}
