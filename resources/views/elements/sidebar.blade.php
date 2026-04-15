<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <!-- Menu Dashboard -->
            <li><a href="{{ url('/') }}" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Home</span>
                </a>
            </li>

            <!-- Menu Staff / HR -->
            <li><a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="flaticon-381-id-card-4"></i>
                    <span class="nav-text">Staff</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('users.index') }}">Manajemen Staff</a></li>
                </ul>
            </li>

            <li><a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="flaticon-381-network"></i>
                    <span class="nav-text">Klien</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('clients.index') }}">Daftar Klien</a></li>
                    <li><a href="{{ route('clients.calendar') }}">Calendar</a></li>        <!-- Rute Calendar Menyusul -->
                </ul>
            </li>

            <!-- Menu WAREHOUSE -->
            <li><a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="flaticon-381-box-2"></i>
                    <span class="nav-text">Gudang</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('items.index') }}">Katalog Barang</a></li>
                    <li><a href="{{ route('boms.index') }}">Bill of Materials (BOM)</a></li>
                    <li><a href="{{ route('inventory.index') }}">Barang Masuk / Keluar</a></li>

                    <!-- BENTUK YANG BENAR (Arahkan rute ke halaman Opname) -->
                    <li><a href="{{ route('inventory.opname') }}">Stok Opname</a></li>
                </ul>
            </li>

            <!-- Menu FINANCE -->
            <li><a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="flaticon-381-calculator"></i>
                    <span class="nav-text">Keuangan</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('productions.index') }}">Produksi</a></li>
                    <li><a href="{{ route('sales.index') }}">Penjualan</a></li>
                    <li><a href="{{ route('finance.reports.cashflow') }}">Laporan Arus Keuangan</a></li>
                </ul>
            </li>
        </ul>

        <div class="copyright">
            <p class="fs-14 font-w200"><strong class="font-w400">AMDK Admin Dashboard</strong> © 2026 All Rights Reserved</p>
        </div>
    </div>
</div>
