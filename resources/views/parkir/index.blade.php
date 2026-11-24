@extends('layouts.panel')

@section('title', 'Daftar Terparkir')
@section('heading', 'Daftar Terparkir')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Sedang parkir: <strong>{{ $parkir->count() }}</strong> motor</span>
            <a href="{{ url('parkir/masuk') }}" class="btn btn-primary btn-sm">+ Kendaraan Masuk</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Plat</th>
                        <th>Pemilik</th>
                        <th>Slot</th>
                        <th>Masuk</th>
                        <th>Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($parkir as $p)
                        <tr>
                            <td class="fw-semibold">{{ $p->vehicle->plate_number }}</td>
                            <td>{{ $p->vehicle->owner_name }}</td>
                            <td>{{ $p->slot->block->code }}-{{ $p->slot->number }}</td>
                            <td>{{ $p->entered_at->format('d M, H:i') }}</td>
                            <td>{{ $p->entryUser?->name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-body-secondary py-3">
                                Belum ada motor yang parkir.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection