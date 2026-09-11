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
            background: #f4f6f8;
        }

        .navbar {
            background: #222;
            color: white;
            padding: 18px 30px;
            display: flex;
            justify-content: space-between;
        }

        .container {
            padding: 30px;
        }

        .welcome {
            margin-bottom: 25px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .card,
        .report {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0,0,0,.06);
        }

        .card h3 {
            color: #777;
            font-size: 15px;
            margin-bottom: 12px;
        }

        .card p {
            font-size: 28px;
            font-weight: bold;
        }

        .report h2 {
            margin-bottom: 20px;
        }

        .report-item {
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .logout {
            margin-top: 25px;
        }

        button {
            padding: 10px 18px;
            background: #222;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <strong>Basic Industry</strong>
        <span>Pemilik</span>
    </div>

    <div class="container">

        <div class="welcome">
            <h1>Dashboard Pemilik</h1>
            <p>Selamat datang, {{ auth()->user()->name }}.</p>
        </div>

        <div class="cards">

            <div class="card">
                <h3>Total Penjualan</h3>
                <p>Rp 0</p>
            </div>

            <div class="card">
                <h3>Total Transaksi</h3>
                <p>0</p>
            </div>

            <div class="card">
                <h3>Total Produk</h3>
                <p>0</p>
            </div>

        </div>

        <div class="report">

            <h2>Informasi Sistem</h2>

            <div class="report-item">
                <strong>Laporan Penjualan</strong>
                <p>Informasi penjualan akan ditampilkan di sini.</p>
            </div>

            <div class="report-item">
                <strong>Laporan Stok</strong>
                <p>Informasi persediaan produk akan ditampilkan di sini.</p>
            </div>

            <div class="report-item">
                <strong>Produk</strong>
                <p>Informasi produk akan ditampilkan di sini.</p>
            </div>

            <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit">
                Logout
            </button>
        </form>
        </div>

    </div>

</body>
</html>