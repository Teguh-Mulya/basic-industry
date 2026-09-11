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
            margin-bottom: 45px;
        }

        .stat-card {
            height: 105px;
            background: #126b7a;
            border: 2px solid #111;
            color: white;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .stat-number {
            font-size: 40px;
            font-weight: normal;
            line-height: 42px;
        }

        .stat-label {
            font-size: 13px;
            margin-top: 2px;
        }

        /* =========================
           GRAFIK
        ========================= */

        .section-title {
            color: white;
            font-size: 14px;
            font-weight: normal;
            margin-bottom: 10px;
        }

        .chart-box {
            width: 100%;
            height: 145px;
            background: #126b7a;
            border: 2px solid #111;
            padding: 17px 25px 0;
            margin-bottom: 30px;
        }

        .chart {
            width: 100%;
            height: 95px;
            display: block;
        }

        /* =========================
           PESANAN TERBARU
        ========================= */

        .orders-box {
            width: 100%;
            background: #126b7a;
            border: 2px solid #111;
            padding: 17px 25px 7px;
        }

        .orders-title {
            color: white;
            font-size: 14px;
            font-weight: normal;
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
            font-size: 11px;
        }

        th,
        td {
            border: 2px solid #999;
            height: 25px;
            padding: 4px 8px;
            text-align: left;
        }

        th {
            color: #222;
            font-weight: normal;
            background: #ffffff;
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
        }
    </style>
</head>

<body>

<div class="layout">

    <!-- =========================
         SIDEBAR
    ========================== -->

    <aside class="sidebar">

        <div class="sidebar-title">
            Basic Industry
        </div>

        <nav class="menu">

            <a href="{{ route('admin.dashboard') }}"
               class="menu-link active">
                Dashboard
            </a>

            <a href="#" class="menu-link">
                Kelola Produk
            </a>

            <a href="#" class="menu-link">
                Kelola Kategori
            </a>

            <a href="#" class="menu-link">
                Kelola Pesanan
            </a>

            <a href="#" class="menu-link">
                Kelola Pembayaran
            </a>

            <a href="#" class="menu-link">
                Kelola Diskon
            </a>

            <a href="#" class="menu-link">
                Kelola Pelanggan
            </a>

            <a href="#" class="menu-link">
                Kelola Laporan
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

    </aside>


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
                    10
                </div>

                <div class="stat-label">
                    Stok Produk
                </div>

            </div>


            <div class="stat-card">

                <div class="stat-number">
                    10
                </div>

                <div class="stat-label">
                    Pesanan
                </div>

            </div>


            <div class="stat-card">

                <div class="stat-number">
                    10
                </div>

                <div class="stat-label">
                    Pelanggan
                </div>

            </div>


            <div class="stat-card">

                <div class="stat-number">
                    10
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
                    0,62
                    45,18
                    115,65
                    160,82
                    205,55
                    230,12
                    280,65
                    300,30
                    345,75
                    410,45
                    455,15
                    515,78
                    650,82
                    700,83
                    760,86
                    805,50
                    840,80
                    850,20
                    900,100
                    0,100
                    "
                    fill="url(#salesGradient)"
                    stroke="white"
                    stroke-width="4"
                />

            </svg>

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

                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>

</body>
</html>