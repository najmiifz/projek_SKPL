@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight italic uppercase">Manajemen<span class="text-blue-600">Pengguna</span></h1>
            <p class="text-sm text-slate-500 font-bold mt-1 tracking-widest uppercase">User & Team Management</p>
        </div>
        <a href="{{ route('users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-black py-3 px-6 rounded-2xl flex items-center gap-3 shadow-lg shadow-blue-200 transition-all hover:-translate-y-0.5 uppercase tracking-widest text-sm">
            <svg class="w-6 h-6 stroke-[3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah Pengguna
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-2xl border-2 border-slate-200 overflow-hidden transition-all duration-300">
        <div class="p-6 border-b-2 border-slate-100 bg-slate-50 flex items-center justify-between">
            <h3 class="font-black text-slate-900 uppercase tracking-widest flex items-center gap-2 text-sm text-center">
                <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
                Daftar Pengguna Aktif
            </h3>
            <span class="bg-slate-900 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-tighter">TOTAL: {{ $users->count() }}</span>
        </div>
        
        <div class="overflow-x-auto overflow-y-visible">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-900 text-white uppercase text-[11px] font-black tracking-[0.2em]">
                        <th class="text-left p-6 first:rounded-tl-none">Informasi User</th>
                        <th class="text-left p-6">Jabatan / Role</th>
                        <th class="text-left p-6">Status Sistem</th>
                        <th class="text-right p-6 last:rounded-tr-none">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-slate-100">
                    @foreach($users as $user)
                    <tr class="hover:bg-blue-50/50 transition-all group">
                        <td class="p-6">
                            <div class="flex items-center space-x-4">
                                <div class="relative">
                                    <img src="{{ $user->avatar ?? 'https://i.pravatar.cc/100?u=' . urlencode($user->email) }}" 
                                         class="w-14 h-14 rounded-2xl object-cover border-2 border-white shadow-md group-hover:scale-110 transition-transform duration-300" alt="">
                                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                                </div>
                                <div>
                                    <div class="font-black text-slate-900 text-lg uppercase tracking-tight">{{ $user->name }}</div>
                                    <div class="text-xs font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded inline-block mt-1 lowercase">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-6">
                            <div class="inline-flex items-center">
                                <span class="px-4 py-1 text-[10px] font-black rounded-xl uppercase tracking-widest border-2
                                    @if($user->role === 'admin') bg-purple-50 text-purple-700 border-purple-200
                                    @elseif($user->role === 'pm') bg-indigo-50 text-indigo-700 border-indigo-200
                                    @else bg-emerald-50 text-emerald-700 border-emerald-200
                                    @endif">
                                    {{ $user->role ?? 'member' }}
                                </span>
                            </div>
                        </td>
                        <td class="p-6">
                            <span class="flex items-center gap-2 text-[10px] font-black text-emerald-700 uppercase tracking-widest">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                ACTIVE SESSION
                            </span>
                        </td>
                        <td class="p-6">
                            <div class="flex items-center justify-end gap-2 px-1">
                                @if($user->id !== auth()->id())
                                    <!-- Reset Password -->
                                    <form method="POST" action="{{ route('users.reset-password', $user) }}" onsubmit="return confirm('Yakin ingin reset password user ini?')">
                                        @csrf
                                        <button type="submit" class="w-10 h-10 flex items-center justify-center bg-amber-50 text-amber-600 rounded-xl border-2 border-amber-100 hover:bg-amber-600 hover:text-white hover:border-amber-600 transition-all shadow-sm" title="Reset Password">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v-2L2.257 8.257a2 2 0 010-2.828L7.172 0.515a2 2 0 012.828 0L17.743 8.257A6 6 0 0121 9z"/>
                                            </svg>
                                        </button>
                                    </form>
                                    
                                    <!-- Delete -->
                                    <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-10 h-10 flex items-center justify-center bg-red-50 text-red-600 rounded-xl border-2 border-red-100 hover:bg-red-600 hover:text-white hover:border-red-600 transition-all shadow-sm" title="Hapus User">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-[10px] font-black text-slate-400 italic uppercase tracking-widest border-2 border-slate-100 px-3 py-2 rounded-xl">YOU</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
