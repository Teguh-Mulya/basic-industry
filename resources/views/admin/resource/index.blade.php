<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Basic Industry</title>
    <style>
        * { box-sizing: border-box; } body { margin: 0; font-family: Arial, sans-serif; color: #333; background: #fff; }
        .layout { display: flex; min-height: 100vh; } .sidebar { width: 210px; flex-shrink: 0; padding: 20px 14px; background: #126b7a; color: #fff; }
        .brand { margin: 0 0 22px; font-size: 22px; font-weight: normal; } nav { display: grid; gap: 8px; }
        nav a { padding: 9px 10px; border: 1px solid #79c1cc; border-radius: 5px; color: #fff; text-decoration: none; font-size: 13px; }
        nav a:hover, nav a.active { background: #fff; color: #126b7a; } .logout { margin-top: 20px; }
        .logout button { width: 100%; padding: 9px; border: 0; border-radius: 5px; background: #e31313; color: #fff; cursor: pointer; }
        main { flex: 1; padding: 30px 22px; overflow-x: auto; } h1 { margin: 0 0 20px; font-size: 20px; font-weight: normal; }
        .panel { border: 2px solid #111; background: #126b7a; padding: 16px; } .table-wrap { overflow-x: auto; background: #fff; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; } th, td { padding: 10px 12px; border: 1px solid #aaa; text-align: left; white-space: nowrap; }
        .page-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; } th { background: #f2f2f2; font-weight: normal; } .empty { padding: 18px; text-align: center; color: #666; }
        .button, .edit, .delete { display: inline-block; padding: 7px 11px; border: 0; color: #fff; text-decoration: none; font-size: 12px; cursor: pointer; } .button, .edit { background: #126b7a; } .delete { background: #e31313; } .actions { display: flex; gap: 6px; align-items: center; } .actions form { margin: 0; } .message { margin-bottom: 14px; padding: 10px; border: 1px solid; } .success { border-color: #5ca66a; color: #246b30; background: #e8f6ea; } .error { border-color: #d66; color: #9b2222; background: #fff0f0; }
        @media (max-width: 650px) { .layout { display: block; } .sidebar { width: 100%; } main { padding: 20px 12px; } nav { grid-template-columns: repeat(2, 1fr); } }
    </style>
</head>
<body>
<div class="layout">
    @include('admin.partials.sidebar')
    <main class="content">
        <div class="page-header"><h1>{{ $title }}</h1><a class="button" href="{{ route('admin.'.$resource.'.create') }}">Tambah {{ $title }}</a></div>
        @if (session('success')) <div class="message success">{{ session('success') }}</div> @endif
        @if ($errors->any()) <div class="message error">{{ $errors->first() }}</div> @endif
        <section class="panel"><div class="table-wrap">
            @if ($records->isEmpty()) <div class="empty">Belum ada data.</div>
            @else
                <table><thead><tr>@foreach ($columns as $label => $column)<th>{{ $label }}</th>@endforeach<th>Aksi</th></tr></thead><tbody>
                @foreach ($records as $record)<tr>@foreach ($columns as $column)<td>{{ is_callable($column) ? $column($record) : data_get($record, $column) }}</td>@endforeach<td class="actions"><a class="edit" href="{{ route('admin.'.$resource.'.edit', $record) }}">Edit</a><form action="{{ route('admin.'.$resource.'.destroy', $record) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">@csrf @method('DELETE')<button class="delete" type="submit">Hapus</button></form></td></tr>@endforeach
                </tbody></table>
            @endif
        </div></section>
    </main>
</div>
</body>
</html>