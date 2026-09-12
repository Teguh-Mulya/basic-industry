<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Basic Industry</title>
    <style>
        * { box-sizing: border-box; } body { margin: 0; font-family: Arial, sans-serif; color: #333; background: #fff; }
        .layout { display: flex; min-height: 100vh; } .content { flex: 1; padding: 30px 22px; } h1 { margin: 0 0 20px; color: #263238; font-size: 24px; font-weight: 600; }
        .form-panel { max-width: 760px; padding: 22px; border-radius: 8px; background: #fff; box-shadow: 0 4px 16px rgba(38,50,56,.08); } .field { margin-bottom: 16px; } label { display: block; margin-bottom: 7px; color: #526166; font-size: 13px; font-weight: 600; }
        input, select, textarea { width: 100%; padding: 10px 11px; border: 1px solid #aab6ba; border-radius: 4px; color: #263238; background: #fff; font: inherit; } input:focus, select:focus, textarea:focus { border-color: #126b7a; outline: 2px solid rgba(18,107,122,.15); } textarea { min-height: 90px; resize: vertical; } .form-actions { display: flex; gap: 8px; margin-top: 20px; }
        button, .cancel { padding: 10px 15px; border: 0; border-radius: 5px; color: white; text-decoration: none; cursor: pointer; font-size: 13px; } button { background: #126b7a; } button:hover { background: #0e5967; } .cancel { background: #607177; }
        .error { margin-bottom: 15px; padding: 11px 13px; border-radius: 5px; background: #fff0f0; color: #8b0000; } @media (max-width: 650px) { .layout { display: block; } .content { padding: 20px 12px; } .form-panel { padding: 16px; } .form-actions { flex-direction: column; } .form-actions button, .form-actions .cancel { width: 100%; text-align: center; } }
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
