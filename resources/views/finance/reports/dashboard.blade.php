@extends('layouts.default')
@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Rangkuman Singkat -->
        <div class="col-xl-6 col-xxl-6 col-sm-6">
            <div class="widget-stat card bg-success">
                <div class="card-body">
                    <div class="media">
                        <span class="mr-3"><i class="flaticon-381-diamond"></i></span>
                        <div class="media-body text-white">
                            <p class="ms-3">Total Kas Masuk (Penjualan)</p>
                            <h3 class="text-white ms-3">Rp {{ number_format(array_sum($salesData), 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-xxl-6 col-sm-6">
            <div class="widget-stat card bg-danger">
                <div class="card-body">
                    <div class="media">
                        <span class="mr-3"><i class="flaticon-381-calculator-1"></i></span>
                        <div class="media-body text-white">
                            <p class="mb-1">Total Pengeluaran (HPP Produksi)</p>
                            <h3 class="text-white">Rp {{ number_format(array_sum($productionCostData), 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Implementasi Chart J.S Bar Arus Kas -->
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h4 class="card-title">Grafik Arus Kas (6 Bulan Terakhir)</h4>
                </div>
                <div class="card-body">
                    <canvas id="cashflowChart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('vendor/chart.js/Chart.bundle.min.js') }}"></script>
<script>
    (function($) {
        "use strict"
        var ctx = document.getElementById("cashflowChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Pemasukan (Sales)',
                    data: {!! json_encode($salesData) !!},
                    backgroundColor: 'rgba(56, 194, 98, 0.8)', // Warna Hijau (Success) Template
                },
                {
                    label: 'Pengeluaran (Production Cost)',
                    data: {!! json_encode($productionCostData) !!},
                    backgroundColor: 'rgba(235, 76, 76, 0.8)', // Warna Merah (Danger) Template
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString(); // Format mata uang
                            }
                        }
                    }]
                }
            }
        });
    })(jQuery);
</script>
@endpush
