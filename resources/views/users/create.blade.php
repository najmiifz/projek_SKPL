@extends('layouts.app')

@section('content')
<div class="space-y-6">
  <div class="flex items-center space-x-4">
    <a href="{{ route('users.index') }}" class="text-slate-500 hover:text-slate-700">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
    </a>
    <h1 class="text-2xl font-bold text-slate-800">Tambah User Baru</h1>
  </div>

  <div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
      <form method="POST" action="{{ route('users.store') }}" class="space-y-6">
        @csrf
        
        <div>
          <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
          <input type="text" 
                 name="name" 
                 id="name" 
                 value="{{ old('name') }}"
                 class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('name') border-red-300 @enderror" 
                 placeholder="Masukkan nama lengkap"
                 required>
          @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
          <input type="email" 
                 name="email" 
                 id="email" 
                 value="{{ old('email') }}"
                 class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('email') border-red-300 @enderror" 
                 placeholder="user@example.com"
                 required>
          @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="role" class="block text-sm font-medium text-slate-700 mb-2">Role Pengguna</label>
          <select name="role" 
                  id="role" 
                  class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('role') border-red-300 @enderror"
                  required>
            <option value="">Pilih Role</option>
            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
            <option value="pm" {{ old('role') === 'pm' ? 'selected' : '' }}>Project Manager</option>
            <option value="member" {{ old('role') === 'member' ? 'selected' : '' }}>Member</option>
          </select>
          @error('role')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
          <input type="password" 
                 name="password" 
                 id="password" 
                 class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('password') border-red-300 @enderror" 
                 placeholder="Minimal 8 karakter"
                 required>
          @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password</label>
          <input type="password" 
                 name="password_confirmation" 
                 id="password_confirmation" 
                 class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" 
                 placeholder="Ulangi password yang sama"
                 required>
        </div>

        <div class="flex items-center space-x-4 pt-4">
          <button type="submit" 
                  class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-medium flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Simpan User
          </button>
          <a href="{{ route('users.index') }}" 
             class="bg-slate-200 text-slate-700 px-6 py-3 rounded-lg hover:bg-slate-300 transition font-medium">
            Batal
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

@if ($errors->any())
<div class="fixed top-4 right-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg shadow-lg">
  <div class="font-medium">Terjadi kesalahan:</div>
  <ul class="list-disc list-inside text-sm mt-1">
    @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
@endsection