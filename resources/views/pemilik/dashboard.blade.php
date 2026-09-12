<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Pemilik - Basic Industry</title>

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
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 195px;
            height: 100vh;
            background: #126b7b;
            color: white;
            padding: 18px 13px;
        }

        .sidebar-title {
            text-align: center;
            font-size: 23px;
            margin-bottom: 18px;
            font-weight: normal;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .menu a {
            display: block;
            text-decoration: none;
            color: white;
            border: 2px solid #8ed0da;
            border-radius: 7px;
            padding: 9px 13px;
            font-size: 14px;
            transition: 0.2s;
        }

        .menu a:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .menu a.active {
            background: rgba(255, 255, 255, 0.08);
        }

        /* LOGOUT */
        .logout {
            position: absolute;
            bottom: 18px;
            left: 13px;
            right: 13px;
        }

        .logout button {
            width: 100%;
            border: none;
            border-radius: 7px;
            padding: 10px;
            background: #ff1111;
            color: white;
            font-size: 14px;
            cursor: pointer;
        }

        .logout button:hover {
            background: #d90000;
        }

        /* CONTENT */
        .content {
            margin-left: 195px;
            padding: 30px 18px;
            min-height: 100vh;
        }

        .page-title {
            font-size: 16px;
            font-weight: normal;
            margin-bottom: 5px;
        }

        .user-info {
            font-size: 13px;
            color: #777;
            margin-bottom: 12px;
        }

        /* STATISTICS */
        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 45px;
        }

        .card {
            height: 105px;
            background: #126b7b;
            border: 2px solid #111;
            color: white;
            text-align: center;
            padding: 10px;
        }

        .card-number {
            font-size: 42px;
            font-weight: normal;
            margin-top: 2px;
        }

        .card-title {
            font-size: 13px;
            margin-top: 0;
        }

        /* SECTION */
        .section {
            background: #126b7b;
            border: 2px solid #111;
            color: white;
            margin-bottom: 30px;
        }

        .section-title {
            padding: 15px 25px;
            font-size: 14px;
        }

        /* SIMPLE GRAPH */
        .graph {
            height: 145px;
            position: relative;
            overflow: hidden;
            background: #126b7b;
        }

        .graph svg {
            width: 100%;
            height: 100%;
        }

        /* TABLE */
        .table-container {
            padding: 0 6px 6px 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            color: #333;
            font-size: 11px;
        }

        table th,
        table td {
            border: 1px solid #999;
            padding: 7px;
            text-align: left;
        }

        table th {
            font-weight: normal;
            background: #f5f5f5;
        }

        table td {
            height: 27px;
        }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .sidebar {
                width: 180px;
            }

            .content {
                margin-left: 180px;
            }

            .cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .logout {
                position: relative;
                left: auto;
                right: auto;
                bottom: auto;
                margin-top: 20px;
            }

            .content {
                margin-left: 0;
                padding: 20px;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .menu {
                gap: 10px;
            }
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="sidebar-title">
            Basic Industry
        </div>

        <nav class="menu">

            <a href="#" class="active">
                Dashboard
            </a>

            <a href="#">
                Lihat Produk
            </a>

            <a href="#">
                Lihat Stok
            </a>

            <a href="#">
                Lihat Transaksi
            </a>

            <a href="#">
                Laporan
            </a>

            <a href="#">
                Cetak Laporan
            </a>

        </nav>

        <!-- LOGOUT -->
        <div class="logout">

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit">
                    Keluar
                </button>
            </form>

        </div>

    </aside>


    <!-- CONTENT -->
    <main class="content">

        <h1 class="page-title">
            Dashboard
        </h1>

        <div class="user-info">
            Selamat datang, {{ auth()->user()->name }}
        </div>


        <!-- STATISTIC CARDS -->
        <div class="cards">

            <div class="card">
                <div class="card-number">
                    0
                </div>

                <div class="card-title">
                    Produk
                </div>
            </div>


            <div class="card">
                <div class="card-number">
                    0
                </div>

                <div class="card-title">
                    Stok Produk
                </div>
            </div>


            <div class="card">
                <div class="card-number">
                    0
                </div>

                <div class="card-title">
                    Transaksi
                </div>
            </div>


            <div class="card">
                <div class="card-number">
                    0
                </div>

                <div class="card-title">
                    Penjualan
                </div>
            </div>

        </div>


        <!-- GRAFIK PENJUALAN -->
        <section class="section">

            <div class="section-title">
                Grafik Penjualan
            </div>

            <div class="graph">

                <svg viewBox="0 0 1000 150"
                     preserveAspectRatio="none">

                    <defs>

                        <linearGradient
                            id="gradient"
                            x1="0"
                            y1="0"
                            x2="0"
                            y2="1">

                            <stop
                                offset="0%"
                                stop-color="#52ff00" />

                            <stop
                                offset="65%"
                                stop-color="#ffff00" />

                            <stop
                                offset="100%"
                                stop-color="#ff0000" />

                        </linearGradient>

                    </defs>

                    <polygon
                        points="
                        0,120
                        45,50
                        90,90
                        135,115
                        180,80
                        225,105
                        270,45
                        315,90
                        360,55
                        405,100
                        450,75
                        495,35
                        540,90
                        585,95
                        630,95
                        675,100
                        720,100
                        765,105
                        810,80
                        855,110
                        900,55
                        945,115
                        990,50
                        1000,120
                        1000,150
                        0,150
                        "
                        fill="url(#gradient)"
                        stroke="white"
                        stroke-width="4" />

                </svg>

            </div>

        </section>


        <!-- TRANSAKSI TERBARU -->
        <section class="section">

            <div class="section-title">
                Transaksi Terbaru
            </div>

            <div class="table-container">

                <table>

                    <thead>

                        <tr>
                            <th>
                                Kode Transaksi
                            </th>

                            <th>
                                Nama Pelanggan
                            </th>

                            <th>
                                Total
                            </th>

                            <th>
                                Metode Pembayaran
                            </th>

                            <th>
                                Tanggal
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

        </section>

    </main>

</body>
</html>