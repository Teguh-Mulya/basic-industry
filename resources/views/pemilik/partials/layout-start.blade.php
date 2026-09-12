<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Basic Industry</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #f5f7f8; color: #263238; font-family: Arial, sans-serif; }
        .owner-layout { display: flex; min-height: 100vh; }
        .owner-sidebar { width: 220px; flex: 0 0 220px; padding: 22px 14px; background: #126b7a; color: #fff; }
        .owner-brand { margin: 0 0 24px; text-align: center; font-size: 22px; font-weight: normal; }
        .owner-toggle { display: flex; align-items: center; justify-content: center; width: 100%; min-height: 34px; margin: 0 0 12px; border: 1px solid #79c1cc; border-radius: 6px; background: transparent; color: #fff; cursor: pointer; }
        .owner-toggle:hover { background: #fff; color: #126b7a; }
        .owner-toggle-icon, .owner-toggle-icon::before, .owner-toggle-icon::after { display: block; width: 18px; height: 2px; border-radius: 2px; background: currentColor; }
        .owner-toggle-icon { position: relative; }
        .owner-toggle-icon::before, .owner-toggle-icon::after { position: absolute; left: 0; content: ''; }
        .owner-toggle-icon::before { top: -6px; } .owner-toggle-icon::after { top: 6px; }
        .owner-label { white-space: nowrap; }
        .owner-short { display: none; }
        .owner-nav { display: grid; gap: 8px; }
        .owner-nav a { padding: 10px 11px; border: 1px solid #79c1cc; border-radius: 6px; color: #fff; font-size: 13px; text-decoration: none; }
        .owner-nav a:hover, .owner-nav a.active { background: #fff; color: #126b7a; }
        .owner-logout { margin-top: 26px; }
        .owner-logout button { width: 100%; padding: 10px; border: 0; border-radius: 6px; background: #e31313; color: #fff; cursor: pointer; }
        .owner-main { flex: 1; min-width: 0; padding: 30px clamp(16px, 4vw, 42px); }
        .owner-sidebar.is-collapsed { width: 68px; flex-basis: 68px; padding-right: 9px; padding-left: 9px; }
        .owner-sidebar.is-collapsed .owner-brand { overflow: hidden; font-size: 0; white-space: nowrap; }
        .owner-sidebar.is-collapsed .owner-brand::after { font-size: 22px; content: 'BI'; }
        .owner-sidebar.is-collapsed .owner-label { display: none; }
        .owner-sidebar.is-collapsed .owner-short { display: inline; }
        .owner-sidebar.is-collapsed .owner-nav a { justify-content: center; padding-right: 4px; padding-left: 4px; text-align: center; }
        .owner-sidebar.is-collapsed .owner-logout button { overflow: hidden; padding-right: 4px; padding-left: 4px; font-size: 0; }
        .owner-sidebar.is-collapsed .owner-logout button::after { font-size: 13px; content: 'Keluar'; }
        .owner-main h1 { margin: 0 0 20px; font-size: 24px; font-weight: 600; }
        .owner-panel { padding: 18px; border-radius: 8px; background: #fff; box-shadow: 0 4px 16px rgba(38,50,56,.08); }
        .owner-table-wrap { overflow-x: auto; }
        .owner-table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .owner-table th, .owner-table td { padding: 11px 12px; border: 1px solid #d4dadd; text-align: left; vertical-align: middle; white-space: nowrap; }
        .owner-table th { background: #eef2f3; font-weight: 600; }
        .owner-button { display: inline-flex; min-height: 38px; align-items: center; justify-content: center; padding: 9px 14px; border: 0; border-radius: 5px; background: #126b7a; color: #fff; text-decoration: none; cursor: pointer; }
        .owner-button:hover { background: #0e5967; }
        .owner-filter { display: flex; flex-wrap: wrap; align-items: end; gap: 12px; margin-bottom: 18px; }
        .owner-filter label { display: grid; gap: 6px; color: #526166; font-size: 13px; }
        .owner-filter input { padding: 9px; border: 1px solid #aab6ba; border-radius: 4px; font: inherit; }
        .owner-message { margin-bottom: 16px; padding: 11px 13px; border-radius: 5px; background: #e8f6ea; color: #246b30; }
        @media (max-width: 700px) { .owner-layout { display: block; } .owner-sidebar { width: 100%; } .owner-sidebar.is-collapsed { width: 100%; height: 58px; padding: 10px 12px; } .owner-sidebar.is-collapsed .owner-brand { display: none; } .owner-sidebar.is-collapsed .owner-toggle { width: auto; margin: 0 auto; } .owner-sidebar.is-collapsed .owner-nav, .owner-sidebar.is-collapsed .owner-logout { display: none; } .owner-main { padding: 22px 12px; } .owner-filter { align-items: stretch; flex-direction: column; } .owner-filter label, .owner-filter input, .owner-filter .owner-button { width: 100%; } }
    </style>
</head>
<body>
<div class="owner-layout">
    <aside class="owner-sidebar">
        <h2 class="owner-brand">Basic Industry</h2>
        <button class="owner-toggle" type="button" aria-label="Minimalkan sidebar" title="Minimalkan sidebar" aria-expanded="true"><span class="owner-toggle-icon" aria-hidden="true"></span></button>
        <nav class="owner-nav">
            <a href="{{ route('pemilik.dashboard') }}" class="{{ request()->routeIs('pemilik.dashboard') ? 'active' : '' }}"><span class="owner-label">Dashboard</span><span class="owner-short">D</span></a>
            <a href="{{ route('pemilik.products') }}" class="{{ request()->routeIs('pemilik.products') ? 'active' : '' }}"><span class="owner-label">Melihat Produk</span><span class="owner-short">P</span></a>
            <a href="{{ route('pemilik.stocks') }}" class="{{ request()->routeIs('pemilik.stocks') ? 'active' : '' }}"><span class="owner-label">Melihat Stok</span><span class="owner-short">S</span></a>
            <a href="{{ route('pemilik.transactions') }}" class="{{ request()->routeIs('pemilik.transactions') ? 'active' : '' }}"><span class="owner-label">Melihat Transaksi</span><span class="owner-short">T</span></a>
            <a href="{{ route('pemilik.report') }}" class="{{ request()->routeIs('pemilik.report') ? 'active' : '' }}"><span class="owner-label">Melihat Laporan Penjualan</span><span class="owner-short">L</span></a>
        </nav>
        <form class="owner-logout" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Keluar</button>
        </form>
    </aside>
    <main class="owner-main">
        <script>
            (() => {
                const sidebar = document.querySelector('.owner-sidebar');
                const toggle = document.querySelector('.owner-toggle');
                const storageKey = 'owner-sidebar-collapsed';
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
        @if (session('success')) <div class="owner-message">{{ session('success') }}</div> @endif
