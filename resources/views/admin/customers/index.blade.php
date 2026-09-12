<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelanggan Terdaftar - Basic Industry</title>
    <style>
        * { box-sizing: border-box; } body { margin: 0; font-family: Arial, sans-serif; color: #333; background: #fff; }
        .layout { display: flex; min-height: 100vh; } .content { flex: 1; min-width: 0; padding: 30px 22px; overflow-x: auto; }
        .header { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 20px; } h1 { font-size: 20px; font-weight: normal; }
        .search { width: 250px; padding: 9px 10px; border: 2px solid #555; font-size: 13px; } .panel { padding: 16px; border: 2px solid #111; background: #126b7a; }
        .table-wrap { overflow-x: auto; background: #fff; } table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th, td { padding: 10px 12px; border: 1px solid #aaa; text-align: left; white-space: nowrap; } th { background: #f2f2f2; font-weight: normal; }
        .active { color: #16702a; font-weight: bold; } .empty { padding: 18px; color: #666; text-align: center; }
        .note { margin-bottom: 14px; padding: 10px; background: #e8f6ea; color: #246b30; font-size: 13px; }
        @media (max-width: 600px) { .layout { display: block; } .content { padding: 20px 12px; } .header { align-items: stretch; flex-direction: column; } .search { width: 100%; } }
    </style>
</head>
<body>
<div class="layout">
    @include('admin.partials.sidebar')
    <main class="content">
        <div class="header">
            <h1>Pelanggan Terdaftar</h1>
            <form method="GET" action="{{ route('admin.customers.index') }}">
                <input class="search" type="search" name="search" value="{{ $search }}" placeholder="Cari nama atau email">
            </form>
        </div>
        <div class="note">Data pelanggan diambil otomatis dari akun yang melakukan registrasi dengan role customer.</div>
        <section class="panel"><div class="table-wrap">
            @if ($customers->isEmpty())
                <div class="empty">Belum ada customer terdaftar.</div>
            @else
                <table>
                    <thead><tr><th>Nama Lengkap</th><th>Email</th><th>Status</th><th>Terdaftar Sejak</th></tr></thead>
                    <tbody>
                    @foreach ($customers as $customer)
                        <tr><td>{{ $customer->name }}</td><td>{{ $customer->email }}</td><td class="active">Aktif</td><td>{{ $customer->created_at?->format('d/m/Y H:i') }}</td></tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div></section>
    </main>
</div>
</body>
</html>
