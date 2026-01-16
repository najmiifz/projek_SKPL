@extends('layouts.app')

@section('content')
<div class="space-y-6">
  <div class="flex items-center justify-between">
    <h1 class="text-2xl font-bold text-slate-800">Manajemen Pengguna</h1>
    <a href="{{ route('users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center">
      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
      </svg>
      Tambah User
    </a>
  </div>

  <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-4 border-b border-slate-200 bg-slate-50">
      <h3 class="font-semibold text-slate-800">Daftar Pengguna</h3>
    </div>
    
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-slate-100 text-slate-600 text-sm font-medium">
          <tr>
            <th class="text-left p-4">User</th>
            <th class="text-left p-4">Role</th>
            <th class="text-left p-4">Status</th>
            <th class="text-right p-4">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @foreach($users as $user)
          <tr class="hover:bg-slate-50 transition">
            <td class="p-4">
              <div class="flex items-center space-x-3">
                <img src="{{ $user->avatar ?? 'https://i.pravatar.cc/40?u=' . urlencode($user->email) }}" 
                     class="w-10 h-10 rounded-full object-cover" alt="">
                <div>
                  <div class="font-medium text-slate-800">{{ $user->name }}</div>
                  <div class="text-sm text-slate-500">{{ $user->email }}</div>
                </div>
              </div>
            </td>
            <td class="p-4">
              <span class="px-3 py-1 text-xs font-medium rounded-full
                @if($user->role === 'admin') bg-purple-100 text-purple-700
                @elseif($user->role === 'pm') bg-indigo-100 text-indigo-700  
                @else bg-teal-100 text-teal-700
                @endif">
                {{ ucfirst($user->role ?? 'member') }}
              </span>
            </td>
            <td class="p-4">
              <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                Active
              </span>
            </td>
            <td class="p-4 text-right">
              <div class="flex items-center justify-end space-x-2">
                @if($user->id !== auth()->id())
                  <!-- Reset Password Button -->
                  <form method="POST" action="{{ route('users.reset-password', $user) }}" class="inline" onsubmit="return confirm('Yakin ingin reset password user ini?')">
                    @csrf
                    <button type="submit" class="p-2 text-yellow-600 hover:text-yellow-800 hover:bg-yellow-50 rounded transition" title="Reset Password User">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v-2L2.257 8.257a2 2 0 010-2.828L7.172 0.515a2 2 0 012.828 0L17.743 8.257A6 6 0 0121 9z"/>
                      </svg>
                    </button>
                  </form>
                  
                  <!-- Delete Button -->
                  <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded transition" title="Hapus User">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                      </svg>
                    </button>
                  </form>
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
