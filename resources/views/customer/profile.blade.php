@include('customer.partials.layout-start', ['title' => 'Kelola Profil'])

<h1>Kelola Profil</h1>

@if (session('success'))
	<div class="message">{{ session('success') }}</div>
@endif

@if ($errors->any())
	<div class="message">{{ $errors->first() }}</div>
@endif

<section class="panel">
	<div class="inner">
		<form action="{{ route('customer.profile.update') }}" method="POST">
			@csrf
			@method('PUT')

			<p>
				<label for="name">Nama</label>
				<input id="name" style="width:100%;padding:9px" name="name" value="{{ old('name', auth()->user()->name) }}" required>
			</p>

			<p>
				<label for="email">Email</label>
				<input id="email" style="width:100%;padding:9px" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
			</p>

			<p>
				<label for="phone">Telepon</label>
				<input id="phone" style="width:100%;padding:9px" name="phone" value="{{ old('phone', $profile->phone) }}">
			</p>

			<p>
				<label for="address">Alamat</label>
				<textarea id="address" style="width:100%;padding:9px" name="address">{{ old('address', $profile->address) }}</textarea>
			</p>

			<button class="button" type="submit">Simpan Profil</button>
		</form>
	</div>
</section>

@include('customer.partials.layout-end')
