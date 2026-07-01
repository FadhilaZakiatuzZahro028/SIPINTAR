<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['guru', 'guru_bk'])
            ->orderBy('name')
            ->get();

        return view('master.user.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:guru,guru_bk',
            'nip' => 'nullable|string|max:20|unique:users,nip',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->has('is_active');

        User::create($validated);

        return back()->with('success', 'Akun guru berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'role' => 'required|in:guru,guru_bk',
            'nip' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('users', 'nip')->ignore($user->id),
            ],
        ]);

        $validated['is_active'] = $request->has('is_active');

        $user->update($validated);

        return back()->with('success', 'Akun guru berhasil diperbarui.');
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil direset.');
    }

    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return back()->withErrors(['error' => 'Akun admin tidak bisa dihapus.']);
        }

        $user->delete();

        return back()->with('success', 'Akun guru berhasil dihapus.');
    }
}