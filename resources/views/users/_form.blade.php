<div class="mb-3">
    <label class="form-label">Nama</label>
    <input type="text" name="name" value="{{ old('name', $user->name) }}"
           class="form-control @error('name') is-invalid @enderror">
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" value="{{ old('email', $user->email) }}"
           class="form-control @error('email') is-invalid @enderror">
    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Role</label>
    <select name="role" class="form-select @error('role') is-invalid @enderror">
        @foreach (['admin' => 'Admin', 'petugas' => 'Petugas'] as $val => $label)
            <option value="{{ $val }}" @selected(old('role', $user->role) === $val)>{{ $label }}</option>
        @endforeach
    </select>
    @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Password {{ $user->exists ? '(kosongkan jika tidak diubah)' : '' }}</label>
    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Konfirmasi Password</label>
    <input type="password" name="password_confirmation" class="form-control">
</div>

<div class="form-check mb-3">
    <input type="checkbox" name="is_active" value="1" id="is_active" class="form-check-input"
           @checked(old('is_active', $user->is_active))>
    <label for="is_active" class="form-check-label">Akun aktif</label>
</div>

<button class="btn btn-primary">Simpan</button>
<a href="{{ route('users.index') }}" class="btn btn-link">Batal</a>