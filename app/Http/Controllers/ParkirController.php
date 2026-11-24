<?php

namespace App\Http\Controllers;
use App\Models\ParkingTransaction;

use App\Http\Requests\MasukRequest;
use App\Models\Slot;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ParkirController extends Controller
{
    public function index()
    {
        $parkir = ParkingTransaction::active()
            ->with(['vehicle', 'slot.block', 'entryUser'])
            ->orderBy('entered_at')
            ->get();

        return view('parkir.index', compact('parkir'));
    }

    public function masuk()
    {
        $slots = Slot::where('is_active', true)
            ->whereDoesntHave('transactions', fn ($q) => $q->whereNull('exited_at'))
            ->with('block')
            ->orderBy('block_id')
            ->orderBy('number')
            ->get();

        return view('parkir.masuk', compact('slots'));
    }

    public function storeMasuk(MasukRequest $request)
    {
        $data = $request->validated();

        try {
            DB::transaction(function () use ($data) {
                $slot = Slot::lockForUpdate()->findOrFail($data['slot_id']);

                if (! $slot->is_active) {
                    throw new \DomainException('Slot ini sedang nonaktif.');
                }

                if ($slot->transactions()->whereNull('exited_at')->exists()) {
                    throw new \DomainException('Slot sudah terisi, pilih slot lain.');
                }

                $vehicle = Vehicle::firstOrCreate(
                    ['plate_number' => $data['plate_number']],
                    ['owner_name'   => $data['owner_name'] ?: '-']
                );

                if (ParkingTransaction::active()->where('vehicle_id', $vehicle->id)->exists()) {
                    throw new \DomainException('Motor ini masih tercatat parkir.');
                }

                ParkingTransaction::create([
                    'vehicle_id'    => $vehicle->id,
                    'slot_id'       => $slot->id,
                    'entry_user_id' => auth()->id(),
                    'entered_at'    => now(),
                ]);
            });
        } catch (\DomainException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('parkir.index')->with('success', 'Kendaraan berhasil dicatat masuk.');
    }

    public function keluar()
    {
        return 'Halaman Kendaraan Keluar';
    }

    public function storeKeluar(Request $request)
    {
        //
    }
}