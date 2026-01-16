<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,pm,member'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'avatar' => 'https://i.pravatar.cc/150?u=' . urlencode($request->email)
        ]);

        return redirect()->route('users.index')->with('status', 'User berhasil ditambahkan!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }
        
        $user->delete();
        return redirect()->route('users.index')->with('status', 'User berhasil dihapus!');
    }

    public function settings()
    {
        return view('settings.index');
    }

    public function profile()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update basic info
        $user->name = $request->name;
        $user->email = $request->email;

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/avatars'), $filename);
            $user->avatar = '/storage/avatars/' . $filename;
        }

        // Handle password change
        if ($request->filled('password')) {
            if (!$request->filled('current_password')) {
                return redirect()->back()->withErrors(['current_password' => 'Password saat ini diperlukan untuk mengubah password.']);
            }
            
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Password saat ini tidak cocok.']);
            }
            
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('status', 'Profil berhasil diperbarui!');
    }

    public function resetPassword(Request $request, User $user)
    {
        // Admin dapat reset password user
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk reset password.');
        }

        $newPassword = \Str::random(8);
        $user->update([
            'password' => Hash::make($newPassword)
        ]);

        // Di implementasi nyata, password baru dikirim via email
        // Untuk demo, tampilkan di session
        return redirect()->back()->with('status', "Password user {$user->name} berhasil direset. Password baru: {$newPassword}");
    }
}
