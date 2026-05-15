<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(Request $request): View
    {
        $role = $request->query('role', 'all');
        
        $query = User::query();

        if ($role !== 'all') {
            $query->where('role', $role);
        }

        $users = $query->withCount('orders')->latest()->paginate(20);

        $stats = [
            'admin' => User::where('role', 'admin')->count(),
            'moderator' => User::where('role', 'moderator')->count(),
            'seller' => User::where('role', 'seller')->count(),
            'buyer' => User::where('role', 'buyer')->count(),
            'total' => User::count(),
        ];

        return view('admin.users.index', compact('users', 'stats', 'role'));
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'role' => 'required|in:admin,moderator,seller,buyer',
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->route('admin.users.index')
            ->with('success', "Role pengguna {$user->name} berhasil diubah menjadi " . ucfirst($request->role));
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "Pengguna {$user->name} berhasil dihapus.");
    }
}
