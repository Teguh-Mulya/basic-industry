<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Customer' }} - Basic Industry</title>
    <style>
        :root { --teal: #126b7a; --teal-light: #79c1cc; --red: #e31313; --border: #d4dadd; }
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; background: #f7f9fa; color: #263238; font-family: Arial, sans-serif; }
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 194px; flex: 0 0 194px; padding: 18px 13px; background: var(--teal); color: #fff; }
        .sidebar-title { margin: 0 0 22px 3px; font-size: 22px; font-weight: normal; }
        .menu { display: flex; flex-direction: column; gap: 10px; }
        .menu a { display: flex; align-items: center; min-height: 36px; padding: 8px 12px; border: 2px solid var(--teal-light); border-radius: 7px; color: #fff; text-decoration: none; font-size: 13px; }
        .menu a:hover, .menu a.active { background: #fff; color: var(--teal); }
        .logout { margin-top: 22px; }
        .logout button { width: 100%; min-height: 38px; border: 0; border-radius: 7px; background: #ff1111; color: #fff; font-size: 14px; cursor: pointer; }
        .content { flex: 1; min-width: 0; padding: 32px clamp(16px, 3vw, 36px); overflow-x: hidden; }
        h1 { margin: 0 0 20px; font-size: clamp(20px, 2vw, 26px); font-weight: 600; }
        h2 { margin: 0 0 14px; font-size: 18px; }
        .panel { padding: 18px; border: 1px solid #0b4e59; border-radius: 8px; background: var(--teal); color: #fff; box-shadow: 0 4px 12px rgba(18,107,122,.12); }
        .inner { padding: 16px; border-radius: 5px; background: #fff; color: #263238; }
        .table-scroll { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
        table { width: 100%; min-width: 600px; border-collapse: collapse; background: #fff; font-size: 13px; }
        th, td { padding: 11px 12px; border: 1px solid var(--border); text-align: left; vertical-align: middle; }
        th { background: #eef2f3; color: #263238; font-weight: 600; }
        input, select, textarea { width: 100%; max-width: 100%; padding: 10px 11px; border: 1px solid #aab6ba; border-radius: 4px; font: inherit; }
        input:focus, select:focus, textarea:focus { border-color: var(--teal); outline: 2px solid rgba(18,107,122,.15); }
        .button { display: inline-flex; align-items: center; justify-content: center; min-height: 40px; padding: 10px 14px; border: 0; border-radius: 4px; background: var(--teal); color: #fff; text-decoration: none; cursor: pointer; }
        .button:hover { background: #0e5967; } .danger { background: var(--red); }
        .message { margin-bottom: 14px; padding: 11px 13px; border-radius: 4px; background: #e8f6ea; color: #246b30; }
        .stack { display: grid; gap: 14px; }
        .toolbar { display: flex; align-items: center; gap: 12px; }
        .toolbar input { width: 260px; }
        .search-button { min-height: 42px; padding: 10px 18px; border: 0; border-radius: 4px; background: var(--teal); color: #fff; font-weight: bold; cursor: pointer; }
        .search-button:hover { background: #0e5967; }
        .product-grid { display: grid; grid-template-columns: repeat(3, minmax(220px, 1fr)); gap: 18px; }
        .product-card { overflow: hidden; border: 1px solid #d8e1e3; border-radius: 10px; background: #fff; box-shadow: 0 5px 14px rgba(38,50,56,.10); transition: transform .2s ease, box-shadow .2s ease; }
        .product-card:hover { transform: translateY(-3px); box-shadow: 0 10px 22px rgba(38,50,56,.16); }
        .product-card-image { position: relative; aspect-ratio: 4 / 3; display: grid; place-items: center; background: #edf2f3; color: #718085; font-size: 12px; }
        .product-card-image img { width: 100%; height: 100%; object-fit: cover; }
        .product-card-image::after { position: absolute; top: 10px; right: 10px; padding: 5px 8px; border-radius: 999px; background: rgba(18,107,122,.92); color: #fff; content: 'Produk'; font-size: 10px; }
        .product-card-caption { position: absolute; right: 12px; bottom: 12px; left: 12px; color: white; text-align: left; text-shadow: 0 1px 4px rgba(0,0,0,.55); }
        .product-card-name { overflow: hidden; margin-bottom: 5px; font-size: 15px; font-weight: bold; text-overflow: ellipsis; white-space: nowrap; }
        .product-card-meta { color: #fff; font-size: 12px; }
        .product-card-body { padding: 12px; color: #263238; }
        .product-card-actions { display: flex; gap: 8px; }
        .product-card-actions form { flex: 1; }
        .product-card-actions .button { width: 100%; min-height: 38px; padding: 9px 6px; border: 1px solid var(--teal); background: var(--teal); color: #fff; font-size: 12px; font-weight: bold; text-align: center; }
        .product-card-actions .button:hover { background: #0e5967; }
        @media (max-width: 700px) {
            .layout { display: block; }
            .sidebar { width: 100%; padding: 14px 12px; }
            .sidebar-title { margin-bottom: 14px; text-align: center; }
            .menu { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 8px; }
            .menu a { width: auto; min-height: 42px; justify-content: center; padding: 8px 6px; text-align: center; }
            .logout { width: min(280px, 100%); margin: 12px auto 0; }
            .content { padding: 22px 12px; }
            .panel { padding: 10px; } .inner { padding: 10px; }
            .toolbar, .header { align-items: stretch !important; flex-direction: column !important; }
            .toolbar > *, .header > * { width: 100% !important; }
            .toolbar input { width: 100%; }
            .search-button { width: 100%; }
            .button { width: 100%; }
            .product-grid { grid-template-columns: 1fr; gap: 14px; }
        }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <div class="sidebar-title">Basic Industry</div>
        <nav class="menu">
            <a href="{{ route('customer.dashboard') }}" class="{{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('customer.cart') }}" class="{{ request()->routeIs('customer.cart*') ? 'active' : '' }}">Keranjang</a>
            <a href="{{ route('customer.checkout') }}" class="{{ request()->routeIs('customer.checkout') ? 'active' : '' }}">Pemesanan</a>
            <a href="{{ route('customer.orders.index') }}" class="{{ request()->routeIs('customer.orders.*') ? 'active' : '' }}">Pesanan Saya</a>
            <a href="{{ route('customer.profile') }}" class="{{ request()->routeIs('customer.profile*') ? 'active' : '' }}">Kelola Profil</a>
        </nav>
        <form class="logout" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Keluar</button>
        </form>
    </aside>
    <main class="content">
