<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->query('role');
        $q = $request->query('q');

        $countSemua = User::count();
        $countPenggalang = User::where('role', 'penggalang')->count();
        $countDonatur = User::where('role', 'donatur')->count();
        $countAdmin = User::where('role', 'admin')->count();

        $query = User::query();

        if ($role && $role !== 'semua') {
            $query->where('role', $role);
        }

        if ($q !== null && $q !== '') {
            $query->where(function ($builder) use ($q) {
                $builder->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.user.index', compact(
            'users',
            'role',
            'q',
            'countSemua',
            'countPenggalang',
            'countDonatur',
            'countAdmin',
        ));
    }

    public function toggleStatus(string $id)
    {
        $user = User::findOrFail($id);

        if ((string) $user->id === (string) auth()->id()) {
            return redirect()
                ->back()
                ->with('error', 'Anda tidak bisa menonaktifkan akun Anda sendiri.');
        }

        $newStatus = ! $user->is_active;

        $user->update(['is_active' => $newStatus]);

        $message = $newStatus
            ? 'Akun berhasil diaktifkan kembali.'
            : 'Akun berhasil dinonaktifkan.';

        return redirect()
            ->back()
            ->with('success', $message);
    }
}
