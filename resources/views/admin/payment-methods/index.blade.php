<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pembayaran - Basic Industry</title>
    <style>
        * { box-sizing: border-box; } body { margin: 0; font-family: Arial, sans-serif; color: #333; }
        .layout { display: flex; min-height: 100vh; } main { flex: 1; padding: 30px 22px; overflow-x: auto; }
        .header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; } h1 { color: #263238; font-size: 24px; font-weight: 600; }
        .button, .edit, .delete { display: inline-block; padding: 8px 12px; border: 0; border-radius: 5px; color: white; font-size: 12px; text-decoration: none; cursor: pointer; }
        .button, .edit { background: #126b7a; } .delete { background: #e31313; } .message { margin-bottom: 14px; padding: 11px 13px; border-radius: 5px; background: #e8f6ea; color: #246b30; }
        .panel { padding: 18px; border-radius: 8px; background: #fff; box-shadow: 0 4px 16px rgba(38,50,56,.08); } .table-wrap { overflow-x: auto; background: white; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; } th, td { padding: 11px 12px; border: 1px solid #d4dadd; text-align: left; vertical-align: top; } th { background: #eef2f3; color: #263238; font-weight: 600; }
        .actions { display: flex; gap: 6px; align-items: center; } .actions form { margin: 0; } .active { color: #16702a; } .inactive { color: #a00000; }
        @media (max-width: 600px) { .layout { display: block; } main { padding: 20px 12px; } .header { align-items: stretch; flex-direction: column; gap: 12px; } }
    </style>
</head>
<body>
<div class="layout">
    @include('admin.partials.sidebar')
    <main>
        <div class="header"><h1>Kelola Pembayaran</h1><a class="button" href="{{ route('admin.payment-methods.create') }}">Tambah Metode</a></div>
        @if (session('success')) <div class="message">{{ session('success') }}</div> @endif
        <section class="panel"><div class="table-wrap">
            @if ($paymentMethods->isEmpty())
                <p style="padding:18px;">Belum ada metode pembayaran.</p>
            @else
                <table><thead><tr><th>Metode Pembayaran</th><th>Detail Pembayaran</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
                @foreach ($paymentMethods as $paymentMethod)
                    <tr><td><strong>{{ $paymentMethod->name }}</strong><br>{{ $paymentMethod->description }}</td><td>{{ $paymentMethod->account_number }} @if ($paymentMethod->account_name)<br>a.n. {{ $paymentMethod->account_name }}@endif @if ($paymentMethod->details)<br>{{ $paymentMethod->details }}@endif</td><td class="{{ $paymentMethod->is_active ? 'active' : 'inactive' }}">{{ $paymentMethod->is_active ? 'Aktif' : 'Tidak Aktif' }}</td><td class="actions"><a class="edit" href="{{ route('admin.payment-methods.edit', $paymentMethod) }}">Edit</a><form action="{{ route('admin.payment-methods.destroy', $paymentMethod) }}" method="POST" onsubmit="return confirm('Hapus metode pembayaran ini?')">@csrf @method('DELETE')<button class="delete" type="submit">Hapus</button></form></td></tr>
                @endforeach
                </tbody></table>
            @endif
        </div></section>
    </main>
</div>
</body>
</html>
