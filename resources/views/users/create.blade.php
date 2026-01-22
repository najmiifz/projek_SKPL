@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 px-4">
    <div class="flex items-center gap-4 mb-8 group">
        <a href="{{ route('users.index') }}" class="w-12 h-12 flex items-center justify-center bg-white border-2 border-slate-200 rounded-2xl text-slate-400 hover:text-blue-600 hover:border-blue-600 hover:shadow-lg transition-all">
            <svg class="w-6 h-6 stroke-[3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight italic uppercase">Registrasi<span class="text-blue-600">User</span></h1>
            <p class="text-sm text-slate-500 font-bold mt-1 tracking-widest uppercase">Create New System Account</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-2xl border-2 border-slate-200 overflow-hidden">
        <div class="p-8">
            <form method="POST" action="{{ route('users.store') }}" class="space-y-8 text-black">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Name Input -->
                    <div class="space-y-2">
                        <label for="name" class="block text-xs font-black text-slate-700 uppercase tracking-widest ml-1">Nama Lengkap</label>
                        <div class="relative group">
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   class="w-full pl-4 pr-4 py-4 bg-slate-50 border-2 border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold placeholder:text-slate-300 text-slate-800 @error('name') border-red-500 @enderror" 
                                   placeholder="Contoh: Ahmad Subagja"
                                   required>
                        </div>
                        @error('name')
                            <p class="mt-1 text-xs font-black text-red-600 uppercase tracking-tight ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Input -->
                    <div class="space-y-2">
                        <label for="email" class="block text-xs font-black text-slate-700 uppercase tracking-widest ml-1">Alamat Email</label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email') }}"
                               class="w-full pl-4 pr-4 py-4 bg-slate-50 border-2 border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold placeholder:text-slate-300 text-slate-800 @error('email') border-red-500 @enderror" 
                               placeholder="user@perusahaan.com"
                               required>
                        @error('email')
                            <p class="mt-1 text-xs font-black text-red-600 uppercase tracking-tight ml-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Role Selection -->
                <div class="space-y-2">
                    <label for="role" class="block text-xs font-black text-slate-700 uppercase tracking-widest ml-1">Role & Akses Pengguna</label>
                    <div class="relative">
                        <select name="role" 
                                id="role" 
                                class="w-full pl-4 pr-10 py-4 bg-slate-50 border-2 border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none appearance-none transition-all font-black text-slate-800 uppercase tracking-wider @error('role') border-red-500 @enderror"
                                required>
                            <option value="" class="font-bold">-- PILIH ROLE SYSTEM --</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>🛡️ ADMINISTRATOR</option>
                            <option value="pm" {{ old('role') === 'pm' ? 'selected' : '' }}>💼 PROJECT MANAGER</option>
                            <option value="member" {{ old('role') === 'member' ? 'selected' : '' }}>👥 TEAM MEMBER</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                    @error('role')
                        <p class="mt-1 text-xs font-black text-red-600 uppercase tracking-tight ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="password" class="block text-xs font-black text-slate-700 uppercase tracking-widest ml-1">Set Password</label>
                        <input type="password" 
                               name="password" 
                               id="password" 
                               class="w-full pl-4 pr-4 py-4 bg-slate-50 border-2 border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold placeholder:text-slate-300 text-slate-800 @error('password') border-red-500 @enderror" 
                               placeholder="Min. 8 Karakter"
                               required>
                        @error('password')
                            <p class="mt-1 text-xs font-black text-red-600 uppercase tracking-tight ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-xs font-black text-slate-700 uppercase tracking-widest ml-1">Konfirmasi Password</label>
                        <input type="password" 
                               name="password_confirmation" 
                               id="password_confirmation" 
                               class="w-full pl-4 pr-4 py-4 bg-slate-50 border-2 border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold placeholder:text-slate-300 text-slate-800" 
                               placeholder="Ulangi Password"
                               required>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-center gap-4 pt-4">
                    <button type="submit" 
                            class="w-full md:w-auto bg-slate-900 hover:bg-black text-white px-10 py-4 rounded-2xl font-black flex items-center justify-center gap-3 shadow-xl hover:-translate-y-1 transition-all uppercase tracking-[.2em] text-sm">
                        <svg class="w-6 h-6 stroke-[3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Simpan Akun
                    </button>
                    <a href="{{ route('users.index') }}" 
                       class="w-full md:w-auto bg-slate-100 text-slate-600 px-10 py-4 rounded-2xl hover:bg-slate-200 transition-all font-black uppercase tracking-[.2em] text-sm text-center border-2 border-slate-200">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
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