<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Hanya Role 'Manager' yang boleh masuk ke menu ini
    public function __construct()
    {
        $this->middleware('role:Manager');
    }

    public function index()
    {
        $page_title = 'Staff';
        $page_description = 'Kelola akses dan akun pegawai';

        $users = User::with('roles')->get();
        $roles = Role::all();

        return view('eres.staff.staff', compact('users', 'roles', 'page_title', 'page_description'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role'     => 'required',
            'address'  => 'nullable|string|max:500' // Validasinya
        ]);

        // Buat user baru
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'address'  => $request->address, // Simpan alamat
        ]);

        // Assign/tempelkan Role ke user tersebut
        $user->assignRole($request->role);

        return redirect()->back()->with('success', 'Akun pegawai berhasil dibuat!');
    }

    // Fungsi Update Data Pegawai
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'role'  => 'required',
            'address' => 'nullable|string|max:500' // Validasinya
        ]);

        $user->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'address' => $request->address, // Update alamat
        ]);

        // Jika form password diisi, maka update passwordnya
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        // Update Rolenya (syncRoles akan menghapus role lama & mengganti dgn yg baru dari form)
        $user->syncRoles($request->role);

        return redirect()->back()->with('success', 'Akun berhasil diperbarui!');
    }

    // Fungsi Hapus Data Pegawai
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Akun berhasil dihapus!');
    }
}
