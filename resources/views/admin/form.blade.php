<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Basic Industry</title>
    <style>
        * { box-sizing: border-box; } body { margin: 0; font-family: Arial, sans-serif; color: #333; background: #fff; }
        .layout { display: flex; min-height: 100vh; } .content { flex: 1; padding: 30px 22px; } h1 { margin: 0 0 20px; font-size: 20px; font-weight: normal; }
        .form-panel { max-width: 760px; border: 2px solid #111; background: #126b7a; padding: 20px 25px; } .field { margin-bottom: 14px; } label { display: block; margin-bottom: 6px; color: white; font-size: 13px; }
        input, select, textarea { width: 100%; padding: 9px; border: 1px solid #999; font: inherit; } textarea { min-height: 90px; resize: vertical; } .form-actions { display: flex; gap: 8px; margin-top: 20px; }
        button, .cancel { padding: 9px 15px; border: 0; color: white; text-decoration: none; cursor: pointer; font-size: 13px; } button { background: #126b7a; } .cancel { background: #777; }
        .error { margin-bottom: 15px; padding: 10px; background: #ffe4e4; color: #8b0000; } @media (max-width: 650px) { .layout { display: block; } .content { padding: 20px 12px; } }
    </style>
</head>
<body>
<div class="layout">
    @include('admin.partials.sidebar')
    <main class="content">
        <h1>{{ $title }}</h1>
        @if ($errors->any()) <div class="error">{{ $errors->first() }}</div> @endif
        <section class="form-panel">
            <form action="{{ route($action, $routeParameters) }}" method="POST" @if (collect($fields)->contains(fn ($field) => $field['type'] === 'file')) enctype="multipart/form-data" @endif>
                @csrf
                @if ($record) @method('PUT') @endif
                @foreach ($fields as $field)
                    @php
                        $value = old($field['name'], data_get($record, $field['name']));
                        if ($field['type'] === 'datetime-local' && $value) {
                            $value = \Illuminate\Support\Carbon::parse($value)->format('Y-m-d\\TH:i');
                        }
                    @endphp
                    <div class="field">
                        <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                        @if ($field['type'] === 'textarea')
                            <textarea id="{{ $field['name'] }}" name="{{ $field['name'] }}">{{ $value }}</textarea>
                        @elseif ($field['type'] === 'file')
                            <input id="{{ $field['name'] }}" type="file" name="{{ $field['name'] }}" @isset($field['accept']) accept="{{ $field['accept'] }}" @endisset>
                            @if ($value)
                                <img src="{{ asset('storage/'.$value) }}" alt="Gambar produk" style="display:block; width:120px; height:120px; margin-top:8px; object-fit:cover; background:#fff;">
                                <small style="display:block; margin-top:6px; color:#fff;">Gambar saat ini</small>
                            @endif
                        @elseif ($field['type'] === 'select')
                            <select id="{{ $field['name'] }}" name="{{ $field['name'] }}" @required($field['required'] ?? false)>
                                @foreach ($field['options'] as $optionValue => $optionLabel)
                                    <option value="{{ $optionValue }}" @selected((string) $value === (string) $optionValue)>{{ $optionLabel }}</option>
                                @endforeach
                            </select>
                        @else
                            <input id="{{ $field['name'] }}" type="{{ $field['type'] }}" name="{{ $field['name'] }}" value="{{ $field['type'] === 'password' ? '' : $value }}" @required($field['required'] ?? false) @isset($field['step']) step="{{ $field['step'] }}" @endisset>
                        @endif
                    </div>
                @endforeach
                <div class="form-actions"><button type="submit">Simpan</button><a class="cancel" href="{{ url()->previous() }}">Batal</a></div>
            </form>
        </section>
    </main>
</div>
</body>
</html>
