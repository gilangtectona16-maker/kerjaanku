@extends('layouts.panel')

@section('title', 'Kendaraan Masuk')
@section('heading', 'Kendaraan Masuk')

@section('content')
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('parkir.masuk.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Plat Nomor</label>
                    <input type="text" name="plate_number" value="{{ old('plate_number') }}"
                           class="form-control text-uppercase @error('plate_number') is-invalid @enderror"
                           placeholder="contoh: P 1234 AB" maxlength="12" autofocus>
                    @error('plate_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Pemilik <span class="text-body-secondary">(opsional)</span></label>
                    <input type="text" name="owner_name" value="{{ old('owner_name') }}"
                           class="form-control @error('owner_name') is-invalid @enderror">
                    @error('owner_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Slot</label>
                    <select name="slot_id" class="form-select @error('slot_id') is-invalid @enderror">
                        <option value="">-- pilih slot kosong --</option>
                        @foreach ($slots as $s)
                            <option value="{{ $s->id }}" @selected(old('slot_id') == $s->id)>
                                Blok {{ $s->block->code }} - Slot {{ $s->number }}
                            </option>
                        @endforeach
                    </select>
                    @error('slot_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    @if ($slots->isEmpty())
                        <div class="form-text text-danger">Semua slot penuh atau belum ada slot!</div>
                    @endif
                </div>

                <button class="btn btn-primary" @disabled($slots->isEmpty())>Catat Masuk</button>
                <a href="{{ url('parkir') }}" class="btn btn-link">Batal</a>
            </form>
        </div>
    </div>
@endsection