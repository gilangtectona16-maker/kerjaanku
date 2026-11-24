@extends('layouts.panel')

@section('title', 'Kendaraan Keluar')
@section('heading', 'Kendaraan Keluar')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="q" value="{{ request('q') }}"
                       class="form-control form-control-sm" placeholder="Cari plat nomor">
                <button class="btn btn-outline-secondary btn-sm">Cari</button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Plat</th>
                        <th>Slot</th>
                        <th>Masuk</th>
                        <th>Durasi</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($parkir as $p)
                        <tr>
                            <td class="fw-semibold">{{ $p->vehicle->plate_number }}</td>
                            <td>{{ $p->slot->block->code }}-{{ $p->slot->number }}</td>
                            <td>{{ $p->entered_at->format('d M, H:i') }}</td>
                            <td>{{ $p->entered_at->diffForHumans(null, true) }}</td>
                            <td class="text-end">
                                <form action="{{ route('parkir.keluar.store') }}" method="POST"
                                      onsubmit="return confirm('Catat {{ $p->vehicle->plate_number }} keluar?')">
                                    @csrf
                                    <input type="hidden" name="transaction_id" value="{{ $p->id }}">
                                    <button class="btn btn-success btn-sm">Keluarkan</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-body-secondary py-3">
                                Tidak ada motor yang sedang parkir.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection