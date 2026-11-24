@extends('layouts.panel')

@section('title', 'Riwayat Parkir')
@section('heading', 'Riwayat Parkir')

@section('content')
    <div class="card">
        <div class="card-header">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-12 col-md-3">
                    <input type="text" name="q" value="{{ request('q') }}"
                           class="form-control form-control-sm" placeholder="Cari plat nomor">
                </div>
                <div class="col-6 col-md-2">
                    <input type="date" name="dari" value="{{ request('dari') }}" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-md-2">
                    <input type="date" name="sampai" value="{{ request('sampai') }}" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-md-2">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Semua status</option>
                        <option value="parkir" @selected(request('status') === 'parkir')>Masih parkir</option>
                        <option value="keluar" @selected(request('status') === 'keluar')>Sudah keluar</option>
                    </select>
                </div>
                <div class="col-6 col-md-3 d-flex gap-2">
                    <button class="btn btn-primary btn-sm">Filter</button>
                    <a href="{{ url('laporan/riwayat') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Plat</th>
                        <th>Slot</th>
                        <th>Masuk</th>
                        <th>Keluar</th>
                        <th>Durasi</th>
                        <th>Petugas Masuk</th>
                        <th>Petugas Keluar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayat as $r)
                        <tr>
                            <td class="fw-semibold">{{ $r->vehicle->plate_number }}</td>
                            <td>{{ $r->slot->block->code }}-{{ $r->slot->number }}</td>
                            <td>{{ $r->entered_at->format('d M Y, H:i') }}</td>
                            <td>{{ $r->exited_at?->format('d M Y, H:i') ?? '-' }}</td>
                            <td>
                                {{ $r->exited_at
                                    ? $r->entered_at->diffForHumans($r->exited_at, true)
                                    : $r->entered_at->diffForHumans(null, true) }}
                            </td>
                            <td>{{ $r->entryUser?->name ?? '-' }}</td>
                            <td>{{ $r->exitUser?->name ?? '-' }}</td>
                            <td>
                                @if ($r->exited_at)
                                    <span class="badge text-bg-secondary">Keluar</span>
                                @else
                                    <span class="badge text-bg-success">Parkir</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-body-secondary py-3">
                                Belum ada riwayat parkir.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($riwayat->hasPages())
            <div class="card-footer">{{ $riwayat->links() }}</div>
        @endif
    </div>
@endsection