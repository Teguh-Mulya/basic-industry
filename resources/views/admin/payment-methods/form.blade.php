<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $paymentMethod ? 'Edit' : 'Tambah' }} Pembayaran - Basic Industry</title>
    <style>
        * { box-sizing: border-box; } body { margin: 0; font-family: Arial, sans-serif; color: #333; }
        .layout { display: flex; min-height: 100vh; } main { flex: 1; padding: 30px 22px; } h1 { margin-bottom: 20px; font-size: 20px; font-weight: normal; }
        .panel { max-width: 650px; padding: 20px 25px; border: 2px solid #111; background: #126b7a; } label { display: block; margin-bottom: 6px; color: white; font-size: 13px; }
        .field { margin-bottom: 15px; } input, select, textarea { width: 100%; padding: 9px; border: 1px solid #aaa; font: inherit; } textarea { min-height: 80px; resize: vertical; } .checkbox { display: flex; align-items: center; gap: 8px; color: white; }
        .checkbox input { width: auto; } button, .cancel { display: inline-block; padding: 9px 15px; border: 0; color: white; text-decoration: none; cursor: pointer; } button { background: #126b7a; } .cancel { background: #777; margin-left: 6px; }
        .conditional-field { display: none; } .conditional-field.visible { display: block; } #qris-preview { margin-top: 10px; padding: 12px; background: white; text-align: center; } #qrcode { display: inline-block; }
        .error { margin-bottom: 15px; padding: 10px; background: #ffe4e4; color: #8b0000; }
        @media (max-width: 600px) { .layout { display: block; } main { padding: 20px 12px; } }
    </style>
</head>
<body>
<div class="layout">
    @include('admin.partials.sidebar')
    <main>
        <h1>{{ $paymentMethod ? 'Edit' : 'Tambah' }} Metode Pembayaran</h1>
        @if ($errors->any()) <div class="error">{{ $errors->first() }}</div> @endif
        <section class="panel">
            <form action="{{ $paymentMethod ? route('admin.payment-methods.update', $paymentMethod) : route('admin.payment-methods.store') }}" method="POST">
                @csrf
                @if ($paymentMethod) @method('PUT') @endif
                <div class="field"><label for="name">Nama Metode Pembayaran</label><select id="name" name="name" required>
                    @foreach (['Tunai', 'Transfer Bank', 'QRIS', 'E-Wallet'] as $methodName)
                        <option value="{{ $methodName }}" @selected(old('name', $paymentMethod?->name) === $methodName)>{{ $methodName }}</option>
                    @endforeach
                </select></div>
                <div class="field"><label for="description">Deskripsi</label><textarea id="description" name="description">{{ old('description', $paymentMethod?->description) }}</textarea></div>
                <div id="account-number-field" class="field conditional-field"><label id="account-number-label" for="account_number">Nomor Rekening / Nomor QRIS / Nomor E-Wallet</label><input id="account_number" name="account_number" value="{{ old('account_number', $paymentMethod?->account_number) }}" maxlength="100"></div>
                <div id="account-name-field" class="field conditional-field"><label for="account_name">Nama Pemilik Rekening / Akun</label><input id="account_name" name="account_name" value="{{ old('account_name', $paymentMethod?->account_name) }}" maxlength="100"></div>
                <div class="field"><label for="details">Detail Tambahan</label><textarea id="details" name="details">{{ old('details', $paymentMethod?->details) }}</textarea></div>
                <div id="qris-preview" class="conditional-field"><div id="qrcode"></div><p style="margin-top:8px;">QRIS dibuat dari nomor/payload di atas.</p></div>
                <label class="checkbox"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $paymentMethod?->is_active ?? true))> Aktif</label>
                <div style="margin-top:20px;"><button type="submit">Simpan</button><a class="cancel" href="{{ route('admin.payment-methods.index') }}">Batal</a></div>
            </form>
        </section>
    </main>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    const methodSelect = document.getElementById('name');
    const accountNumberField = document.getElementById('account-number-field');
    const accountNameField = document.getElementById('account-name-field');
    const accountNumberLabel = document.getElementById('account-number-label');
    const accountNumber = document.getElementById('account_number');
    const qrisPreview = document.getElementById('qris-preview');
    const qrCode = document.getElementById('qrcode');
    let qrInstance;

    function updatePaymentFields() {
        const method = methodSelect.value;
        const needsAccount = ['Transfer Bank', 'QRIS', 'E-Wallet'].includes(method);
        accountNumberField.classList.toggle('visible', needsAccount);
        accountNameField.classList.toggle('visible', method === 'Transfer Bank' || method === 'E-Wallet');
        qrisPreview.classList.toggle('visible', method === 'QRIS' && accountNumber.value.trim() !== '');
        accountNumberLabel.textContent = method === 'Transfer Bank' ? 'Nomor Rekening' : method === 'QRIS' ? 'Nomor / Payload QRIS' : 'Nomor E-Wallet';
        if (method === 'QRIS' && accountNumber.value.trim() !== '') {
            qrCode.innerHTML = '';
            qrInstance = new QRCode(qrCode, { text: accountNumber.value.trim(), width: 180, height: 180 });
        } else {
            qrCode.innerHTML = '';
        }
    }

    methodSelect.addEventListener('change', updatePaymentFields);
    accountNumber.addEventListener('input', updatePaymentFields);
    updatePaymentFields();
</script>
</body>
</html>
