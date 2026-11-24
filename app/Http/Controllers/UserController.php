<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create', ['user' => new User(['is_active' => true])]);
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['password']  = Hash::make($data['password']);
        $data['is_active'] = $request->boolean('is_active');

        User::create($data);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        if (empty($data['password'])) {
            unset($data['password']); // kosong = password tidak diubah
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        // Jangan sampai admin menonaktifkan / menurunkan dirinya sendiri
        if ($user->id === Auth::id()) {
            $data['role']      = $user->role;
            $data['is_active'] = true;
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Kamu tidak bisa menghapus akun sendiri.');
        }

        // Pengguna yang sudah punya transaksi tidak dihapus, cukup dinonaktifkan
        $dipakai = \App\Models\ParkingTransaction::where('entry_user_id', $user->id)
            ->orWhere('exit_user_id', $user->id)->exists();

        if ($dipakai) {
            return back()->with('error', 'Pengguna punya riwayat parkir, nonaktifkan saja ya.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}