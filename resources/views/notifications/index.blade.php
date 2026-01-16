@extends('layouts.app')

@section('page-title', 'Notifikasi')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-800">Semua Notifikasi</h2>
                @if($notifications->where('read', false)->count() > 0)
                <form action="{{ route('notifications.read-all') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-blue-600 hover:text-blue-800">
                        Tandai semua sudah dibaca
                    </button>
                </form>
                @endif
            </div>
        </div>
        
        <div class="divide-y divide-slate-100">
            @forelse($notifications as $notification)
            <div class="p-4 {{ $notification->read ? 'bg-white' : 'bg-blue-50' }} hover:bg-slate-50 transition">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        @if(!$notification->read)
                        <span class="w-3 h-3 bg-blue-500 rounded-full block"></span>
                        @else
                        <span class="w-3 h-3 bg-slate-300 rounded-full block"></span>
                        @endif
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-slate-700">{{ $notification->message }}</p>
                        <p class="text-xs text-slate-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                    @if(!$notification->read)
                    <form action="{{ route('notifications.read', $notification) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs text-blue-600 hover:text-blue-800">
                            Tandai dibaca
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="p-8 text-center">
                <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                </svg>
                <p class="text-slate-500">Tidak ada notifikasi</p>
            </div>
            @endforelse
        </div>
        
        @if($notifications->hasPages())
        <div class="p-4 border-t border-slate-200">
            {{ $notifications->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
