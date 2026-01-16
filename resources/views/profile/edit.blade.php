@extends('layouts.app')

@section('page-title', 'Edit Profil')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-slate-200">
            <h2 class="text-lg font-semibold text-slate-800">Edit Profil</h2>
            <p class="text-sm text-slate-500 mt-1">Perbarui informasi profil dan password Anda</p>
        </div>
        
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Avatar -->
            <div class="flex items-center space-x-6">
                <div class="shrink-0">
                    <img class="h-16 w-16 object-cover rounded-full" 
                         src="{{ $user->avatar ?? 'https://i.pravatar.cc/150?u=' . urlencode($user->email) }}" 
                         alt="Avatar">
                </div>
                <label class="block">
                    <span class="sr-only">Pilih foto profil</span>
                    <input type="file" name="avatar" 
                           class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                </label>
            </div>
            
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700">Nama</label>
                <input type="text" name="name" id="name" 
                       value="{{ old('name', $user->name) }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                <input type="email" name="email" id="email" 
                       value="{{ old('email', $user->email) }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Role (Read Only) -->
            <div>
                <label class="block text-sm font-medium text-slate-700">Role</label>
                <input type="text" value="{{ ucfirst($user->role) }}" disabled
                       class="mt-1 block w-full rounded-md border-gray-200 bg-gray-50 shadow-sm text-slate-500">
                <p class="mt-1 text-xs text-slate-500">Role tidak dapat diubah oleh pengguna sendiri</p>
            </div>
            
            <hr class="border-slate-200">
            
            <!-- Password Section -->
            <div>
                <h3 class="text-md font-medium text-slate-800 mb-4">Ubah Password</h3>
                <p class="text-sm text-slate-500 mb-4">Kosongkan jika tidak ingin mengubah password</p>
                
                <div class="space-y-4">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-slate-700">Password Saat Ini</label>
                        <input type="password" name="current_password" id="current_password" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700">Password Baru</label>
                        <input type="password" name="password" id="password" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 border border-slate-300 rounded-md text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
    
    @if(session('status'))
    <div class="mt-4 p-4 bg-green-100 text-green-700 rounded-lg">
        {{ session('status') }}
    </div>
    @endif
</div>
@endsection
