<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pembayaran - Basic Industry</title>
    <style>
        * { box-sizing: border-box; } body { margin: 0; font-family: Arial, sans-serif; color: #333; }
        .layout { display: flex; min-height: 100vh; } main { flex: 1; padding: 30px 22px; overflow-x: auto; }
        .header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; } h1 { font-size: 20px; font-weight: normal; }
        .button, .edit, .delete { display: inline-block; padding: 8px 12px; border: 0; color: white; font-size: 12px; text-decoration: none; cursor: pointer; }
        .button, .edit { background: #126b7a; } .delete { background: #e31313; } .message { margin-bottom: 14px; padding: 10px; background: #e8f6ea; color: #246b30; }
        .panel { padding: 16px; border: 2px solid #111; background: #126b7a; } .table-wrap { overflow-x: auto; background: white; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; } th, td { padding: 10px 12px; border: 1px solid #aaa; text-align: left; vertical-align: top; } th { background: #f2f2f2; font-weight: normal; }
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
