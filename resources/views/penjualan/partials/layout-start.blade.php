<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Basic Industry</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #f5f7f8; color: #263238; font-family: Arial, sans-serif; }
        .sales-layout { display: flex; min-height: 100vh; }
        .sales-sidebar { width: 220px; flex: 0 0 220px; padding: 22px 14px; background: #126b7a; color: #fff; }
        .sales-brand { margin: 0 0 24px; text-align: center; font-size: 22px; font-weight: normal; }
        .sales-toggle { display: flex; align-items: center; justify-content: center; width: 100%; min-height: 34px; margin: 0 0 12px; border: 1px solid #79c1cc; border-radius: 6px; background: transparent; color: #fff; cursor: pointer; }
        .sales-toggle:hover { background: #fff; color: #126b7a; }
        .sales-toggle-icon, .sales-toggle-icon::before, .sales-toggle-icon::after { display: block; width: 18px; height: 2px; border-radius: 2px; background: currentColor; }
        .sales-toggle-icon { position: relative; }
        .sales-toggle-icon::before, .sales-toggle-icon::after { position: absolute; left: 0; content: ''; }
        .sales-toggle-icon::before { top: -6px; } .sales-toggle-icon::after { top: 6px; }
        .sales-label { white-space: nowrap; }
        .sales-short { display: none; }
        .sales-nav { display: grid; gap: 8px; }
        .sales-nav a { padding: 10px 11px; border: 1px solid #79c1cc; border-radius: 6px; color: #fff; font-size: 13px; text-decoration: none; }
        .sales-nav a:hover, .sales-nav a.active { background: #fff; color: #126b7a; }
        .sales-logout { margin-top: 26px; }
        .sales-logout button { width: 100%; padding: 10px; border: 0; border-radius: 6px; background: #e31313; color: #fff; cursor: pointer; }
        .sales-main { flex: 1; min-width: 0; padding: 30px clamp(16px, 4vw, 42px); }
        .sales-sidebar.is-collapsed { width: 68px; flex-basis: 68px; padding-right: 9px; padding-left: 9px; }
        .sales-sidebar.is-collapsed .sales-brand { overflow: hidden; font-size: 0; white-space: nowrap; }
        .sales-sidebar.is-collapsed .sales-brand::after { font-size: 22px; content: 'BI'; }
        .sales-sidebar.is-collapsed .sales-label { display: none; }
        .sales-sidebar.is-collapsed .sales-short { display: inline; }
        .sales-sidebar.is-collapsed .sales-nav a { justify-content: center; padding-right: 4px; padding-left: 4px; text-align: center; }
        .sales-sidebar.is-collapsed .sales-logout button { overflow: hidden; padding-right: 4px; padding-left: 4px; font-size: 0; }
        .sales-sidebar.is-collapsed .sales-logout button::after { font-size: 13px; content: 'Keluar'; }
        .sales-main h1 { margin: 0 0 20px; font-size: 24px; font-weight: 600; }
        .sales-panel { padding: 18px; border-radius: 8px; background: #fff; box-shadow: 0 4px 16px rgba(38,50,56,.08); }
        .sales-table-wrap { overflow-x: auto; }
        .sales-table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .sales-table th, .sales-table td { padding: 11px 12px; border: 1px solid #d4dadd; text-align: left; vertical-align: middle; white-space: nowrap; }
        .sales-table th { background: #eef2f3; font-weight: 600; }
        .sales-button { display: inline-flex; min-height: 38px; align-items: center; justify-content: center; padding: 9px 14px; border: 0; border-radius: 5px; background: #126b7a; color: #fff; text-decoration: none; cursor: pointer; }
        .sales-button:hover { background: #0e5967; }
        .sales-form { display: grid; gap: 14px; max-width: 620px; }
        .sales-form label { display: grid; gap: 6px; font-size: 13px; font-weight: 600; }
        .sales-form input, .sales-form select { width: 100%; padding: 10px; border: 1px solid #aab6ba; border-radius: 4px; font: inherit; }
        .sales-message { margin-bottom: 16px; padding: 11px 13px; border-radius: 5px; background: #e8f6ea; color: #246b30; }
        .sales-toolbar { display: flex; align-items: center; justify-content: space-between; gap: 14px; margin-bottom: 16px; }
        .sales-search { display: flex; gap: 8px; }
        .sales-search input { width: min(300px, 100%); padding: 9px; border: 1px solid #aab6ba; border-radius: 4px; }
        .status-form { display: flex; gap: 6px; align-items: center; }
        .status-form select, .status-form button { min-height: 32px; padding: 6px 8px; border: 1px solid #126b7a; border-radius: 4px; font-size: 12px; }
        .status-form button { background: #126b7a; color: #fff; cursor: pointer; }
        @media (max-width: 700px) { .sales-layout { display: block; } .sales-sidebar { width: 100%; } .sales-sidebar.is-collapsed { width: 100%; height: 58px; padding: 10px 12px; } .sales-sidebar.is-collapsed .sales-brand { display: none; } .sales-sidebar.is-collapsed .sales-toggle { width: auto; margin: 0 auto; } .sales-sidebar.is-collapsed .sales-nav, .sales-sidebar.is-collapsed .sales-logout { display: none; } .sales-main { padding: 22px 12px; } .sales-toolbar { align-items: stretch; flex-direction: column; } .sales-search { width: 100%; } .sales-search input { flex: 1; width: auto; } }
    </style>
</head>
<body>
<div class="sales-layout">
    <aside class="sales-sidebar">
        <h2 class="sales-brand">Basic Industry</h2>
        <button class="sales-toggle" type="button" aria-label="Minimalkan sidebar" title="Minimalkan sidebar" aria-expanded="true"><span class="sales-toggle-icon" aria-hidden="true"></span></button>
        <nav class="sales-nav">
            <a href="{{ route('penjualan.dashboard') }}" class="{{ request()->routeIs('penjualan.dashboard') ? 'active' : '' }}"><span class="sales-label">Dashboard</span><span class="sales-short">D</span></a>
            <a href="{{ route('penjualan.products') }}" class="{{ request()->routeIs('penjualan.products') ? 'active' : '' }}"><span class="sales-label">Melihat Produk</span><span class="sales-short">P</span></a>
            <a href="{{ route('penjualan.stocks') }}" class="{{ request()->routeIs('penjualan.stocks') ? 'active' : '' }}"><span class="sales-label">Melihat Stok</span><span class="sales-short">S</span></a>
            <a href="{{ route('penjualan.customers') }}" class="{{ request()->routeIs('penjualan.customers') ? 'active' : '' }}"><span class="sales-label">Mengelola Pelanggan</span><span class="sales-short">L</span></a>
            <a href="{{ route('penjualan.transactions.create') }}" class="{{ request()->routeIs('penjualan.transactions.create') ? 'active' : '' }}"><span class="sales-label">Membuat Transaksi Penjualan</span><span class="sales-short">T</span></a>
            <a href="{{ route('penjualan.transactions.history') }}" class="{{ request()->routeIs('penjualan.transactions.history') ? 'active' : '' }}"><span class="sales-label">Melihat Riwayat Transaksi</span><span class="sales-short">R</span></a>
            <a href="{{ route('penjualan.report') }}" class="{{ request()->routeIs('penjualan.report') ? 'active' : '' }}"><span class="sales-label">Laporan Penjualan</span><span class="sales-short">L</span></a>
            <a href="{{ route('penjualan.orders') }}" class="{{ request()->routeIs('penjualan.orders') ? 'active' : '' }}"><span class="sales-label">Mengelola Pesanan</span><span class="sales-short">O</span></a>
        </nav>
        <form class="sales-logout" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Keluar</button>
        </form>
    </aside>
    <main class="sales-main">
        <script>
            (() => {
                const sidebar = document.querySelector('.sales-sidebar');
                const toggle = document.querySelector('.sales-toggle');
                const storageKey = 'sales-sidebar-collapsed';
                if (!sidebar || !toggle) return;
                const setCollapsed = (collapsed) => {
                    sidebar.classList.toggle('is-collapsed', collapsed);
                    toggle.setAttribute('aria-expanded', String(!collapsed));
                    toggle.setAttribute('aria-label', `${collapsed ? 'Maksimalkan' : 'Minimalkan'} sidebar`);
                    toggle.setAttribute('title', `${collapsed ? 'Maksimalkan' : 'Minimalkan'} sidebar`);
                    localStorage.setItem(storageKey, String(collapsed));
                };
                setCollapsed(localStorage.getItem(storageKey) === 'true');
                toggle.addEventListener('click', () => setCollapsed(!sidebar.classList.contains('is-collapsed')));
            })();
        </script>
        @if (session('success')) <div class="sales-message">{{ session('success') }}</div> @endif
        @if ($errors->any()) <div class="sales-message" style="background:#ffe4e4;color:#8b0000;">{{ $errors->first() }}</div> @endif
