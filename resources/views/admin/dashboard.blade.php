<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin - Basic Industry</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background: #ffffff;
            color: #333;
            min-height: 100vh;
        }

        /* =========================
           LAYOUT UTAMA
        ========================= */

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            width: 194px;
            min-height: 100vh;
            background: #126b7a;
            padding: 18px 13px;
            flex-shrink: 0;
        }

        .sidebar-title {
            color: white;
            font-size: 22px;
            font-weight: normal;
            margin-bottom: 15px;
            padding-left: 3px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .menu-link {
            width: 155px;
            height: 36px;
            border: 2px solid #79c1cc;
            border-radius: 7px;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding-left: 13px;
            font-size: 13px;
            transition: 0.2s;
        }

        .menu-link:hover {
            background: #ffffff;
            color: #126b7a;
        }

        .menu-link.active {
            background: #126b7a;
            color: white;
        }

        /* Tombol keluar */
        .logout {
            margin-top: 20px;
        }

        .logout button {
            width: 155px;
            height: 35px;
            border: none;
            border-radius: 7px;
            background: #ff0808;
            color: white;
            font-size: 14px;
            cursor: pointer;
        }

        .logout button:hover {
            background: #d90000;
        }

        /* =========================
           CONTENT
        ========================= */

        .content {
            flex: 1;
            padding: 30px 18px;
            overflow-x: auto;
        }

        .product-catalog {
            margin-top: 30px;
        }

        .catalog-title {
            margin-bottom: 14px;
            color: #222;
            font-size: 16px;
            font-weight: normal;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .product-card {
            overflow: hidden;
            border: 2px solid #111;
            background: #126b7a;
        }

        .product-card-image {
            height: 150px;
            display: grid;
            place-items: center;
            background: #dfe4e5;
            color: #777;
            font-size: 12px;
        }

        .product-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-card-body {
            padding: 10px;
            color: white;
        }

        .product-card-name {
            overflow: hidden;
            margin-bottom: 4px;
            font-size: 14px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .product-card-meta {
            margin-bottom: 9px;
            color: #e4f8fa;
            font-size: 12px;
        }

        .product-card-actions {
            display: flex;
            gap: 8px;
        }

        .product-card-actions a {
            flex: 1;
            padding: 8px 5px;
            background: white;
            color: #222;
            font-size: 12px;
            text-align: center;
            text-decoration: none;
        }

        .page-title {
            font-size: 14px;
            font-weight: normal;
            margin-bottom: 5px;
            color: #222;
        }

        /* =========================
           STATISTIC CARDS
        ========================= */

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .stat-card {
            min-height: 105px;
            padding: 18px;
            border-left: 4px solid #126b7a;
            border-radius: 7px;
            background: #fff;
            color: #263238;
            text-align: left;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(38,50,56,.08);
        }

        .stat-number {
            color: #126b7a;
            font-size: 24px;
            font-weight: bold;
            line-height: 1.25;
        }

        .stat-label {
            margin-top: 8px;
            color: #607177;
            font-size: 12px;
        }

        /* =========================
           GRAFIK
        ========================= */

        .section-title {
            color: #263238;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .chart-box {
            width: 100%;
            min-height: 205px;
            border-radius: 8px;
            background: #fff;
            padding: 17px 25px 12px;
            margin-bottom: 30px;
            box-shadow: 0 4px 16px rgba(38,50,56,.08);
        }

        .chart {
            width: 100%;
            height: 120px;
            display: block;
        }

        .chart-labels {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 4px;
            margin-top: 4px;
            color: #607177;
            font-size: 11px;
            text-align: center;
        }

        .chart-labels span { display: grid; gap: 3px; min-width: 0; }
        .chart-labels strong { overflow: hidden; font-size: 11px; text-overflow: ellipsis; white-space: nowrap; }
        .chart-labels small { overflow: hidden; color: #126b7a; font-size: 10px; text-overflow: ellipsis; white-space: nowrap; }

        /* =========================
           PESANAN TERBARU
        ========================= */

        .orders-box {
            width: 100%;
            padding: 18px;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 4px 16px rgba(38,50,56,.08);
        }

        .orders-title {
            color: #263238;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .table-wrapper {
            background: white;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            font-size: 13px;
        }

        th,
        td {
            border: 1px solid #d4dadd;
            height: auto;
            padding: 11px 12px;
            text-align: left;
        }

        th {
            color: #263238;
            font-weight: 600;
            background: #eef2f3;
        }

        td {
            color: #333;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            .sidebar {
                width: 180px;
            }

            .menu-link,
            .logout button {
                width: 150px;
            }

            .stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {

            .layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                min-height: auto;
            }

            .sidebar-title {
                text-align: center;
            }

            .menu {
                align-items: center;
                gap: 10px;
            }

            .logout {
                text-align: center;
            }

            .content {
                padding: 20px 12px;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .product-grid {
                grid-template-columns: 1fr;
            }

            .product-card-image {
                height: 190px;
            }
        }
    </style>
</head>

<body>

<div class="layout">

    <!-- =========================
         SIDEBAR
    ========================== -->

    @include('admin.partials.sidebar')

    {{--

        <div class="sidebar-title">
            Basic Industry
        </div>

        <nav class="menu">

            <a href="{{ route('admin.dashboard') }}"
               class="menu-link active">
                Dashboard
            </a>

            <a href="{{ route('admin.products.index') }}" class="menu-link">
                Kelola Produk
            </a>

            <a href="{{ route('admin.categories.index') }}" class="menu-link">
                Kelola Kategori
            </a>

            <a href="{{ route('admin.stocks.index') }}" class="menu-link">
                Kelola Stok
            </a>

            <a href="{{ route('admin.customers.index') }}" class="menu-link">
                Kelola Pelanggan
            </a>

            <a href="{{ route('admin.transactions.index') }}" class="menu-link">
                Kelola Transaksi
            </a>

            <a href="{{ route('admin.reports.index') }}" class="menu-link">
                Laporan Penjualan
            </a>

            <a href="{{ route('admin.users.index') }}" class="menu-link">
                Pengguna / Hak Akses
            </a>

        </nav>

        <!-- Logout -->
        <div class="logout">

            <form action="{{ route('logout') }}" method="POST">

                @csrf

                <button type="submit">
                    Keluar
                </button>

            </form>

        </div>

    </aside> --}}


    <!-- =========================
         CONTENT
    ========================== -->

    <main class="content">

        <h1 class="page-title">
            Dashboard
        </h1>


        <!-- =========================
             STATISTIK
        ========================== -->

        <div class="stats">

            <div class="stat-card">

                <div class="stat-number">
                    {{ $productCount }}
                </div>

                <div class="stat-label">
                    Stok Produk
                </div>

            </div>


            <div class="stat-card">

                <div class="stat-number">
                    {{ $orderCount }}
                </div>

                <div class="stat-label">
                    Pesanan
                </div>

            </div>


            <div class="stat-card">

                <div class="stat-number">
                    {{ $customerCount }}
                </div>

                <div class="stat-label">
                    Pelanggan
                </div>

            </div>


            <div class="stat-card">

                <div class="stat-number">
                    Rp {{ number_format($salesTotal, 0, ',', '.') }}
                </div>

                <div class="stat-label">
                    Penjualan
                </div>

            </div>

        </div>


        <!-- =========================
             GRAFIK PENJUALAN
        ========================== -->

        <div class="chart-box">

            <h2 class="section-title">
                Grafik Penjualan
            </h2>

            <svg
                class="chart"
                viewBox="0 0 900 100"
                preserveAspectRatio="none"
            >

                <defs>

                    <linearGradient
                        id="salesGradient"
                        x1="0"
                        y1="0"
                        x2="0"
                        y2="1"
                    >

                        <stop
                            offset="0%"
                            stop-color="#39ff00"
                        />

                        <stop
                            offset="55%"
                            stop-color="#baff00"
                        />

                        <stop
                            offset="100%"
                            stop-color="#ff1500"
                        />

                    </linearGradient>

                </defs>


                <polygon
                    points="
                    @foreach ($monthlySales as $index => $month)
                        {{ $index * 180 }},{{ 90 - (($month['total'] / $monthlySalesMax) * 75) }}
                    @endforeach
                    900,100 0,100
                    "
                    fill="url(#salesGradient)"
                    stroke="white"
                    stroke-width="4"
                />

            </svg>

            <div class="chart-labels">
                @foreach ($monthlySales as $month)
                    <span title="{{ $month['label'] }}: Rp {{ number_format($month['total'], 0, ',', '.') }}"><strong>{{ $month['label'] }}</strong><small>Rp {{ number_format($month['total'], 0, ',', '.') }}</small></span>
                @endforeach
            </div>

        </div>


        <!-- =========================
             PESANAN TERBARU
        ========================== -->

        <div class="orders-box">

            <h2 class="orders-title">
                Pesanan Terbaru
            </h2>


            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>
                                Nama Pelanggan
                            </th>

                            <th>
                                Nama Produk
                            </th>

                            <th>
                                Status Pesanan
                            </th>

                            <th>
                                Harga Pesanan
                            </th>

                            <th>
                                Tanggal Pesan
                            </th>

                        </tr>

                    </thead>


                    <tbody>
                        @forelse ($recentTransactions as $transaction)
                            <tr>
                                <td>{{ $transaction->customer?->name ?? 'Umum' }}</td>
                                <td>-</td>
                                <td>Selesai</td>
                                <td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                <td>{{ $transaction->transaction_date?->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5">Belum ada transaksi.</td></tr>
                        @endforelse
                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>

</body>
</html>