@extends('layouts.app')

@section('page-title', 'Notifikasi')

@section('content')
<div class="max-w-5xl mx-auto py-6 px-4 text-black">
    <div class="bg-white rounded-3xl shadow-2xl border-2 border-slate-200 overflow-hidden">
        <div class="p-8 border-b-2 border-slate-100 bg-slate-50 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight italic uppercase">Pusat<span class="text-blue-600">Notifikasi</span></h1>
                <p class="text-sm text-slate-500 font-bold mt-1 tracking-widest uppercase">System Alerts & Updates</p>
            </div>
            @if($notifications->where('read', false)->count() > 0)
            <form action="{{ route('notifications.read-all') }}" method="POST">
                @csrf
                <button type="submit" class="bg-slate-900 hover:bg-black text-white px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-lg transition-all hover:-translate-y-0.5">
                    Tandai Semua Selesai
                </button>
            </form>
            @endif
        </div>
        
        <div class="divide-y-2 divide-slate-100">
            @forelse($notifications as $notification)
            <div class="p-6 {{ $notification->read ? 'bg-white' : 'bg-blue-50/50' }} hover:bg-slate-50 transition-all group">
                <div class="flex items-start gap-6">
                    <div class="flex-shrink-0 mt-1">
                        @if(!$notification->read)
                        <div class="relative">
                            <span class="w-4 h-4 bg-blue-600 rounded-full block animate-pulse"></span>
                            <span class="absolute inset-0 w-4 h-4 bg-blue-600 rounded-full block animate-ping opacity-25"></span>
                        </div>
                        @else
                        <span class="w-4 h-4 bg-slate-200 rounded-full block border-2 border-white shadow-sm"></span>
                        @endif
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start gap-4">
                            <p class="text-base font-bold text-slate-800 leading-relaxed">{{ $notification->message }}</p>
                            <span class="text-[10px] font-black text-slate-400 bg-white border border-slate-100 px-3 py-1 rounded-lg uppercase tracking-wider whitespace-nowrap shadow-sm group-hover:text-slate-900 transition-colors">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                        </div>
                        
                        @if(!$notification->read)
                        <div class="mt-4 flex items-center gap-4">
                            <form action="{{ route('notifications.read', $notification) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-[10px] font-black text-blue-600 hover:text-blue-800 uppercase tracking-widest flex items-center gap-1.5 group/btn">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    Konfirmasi Baca
                                </button>
                            </form>
                            <div class="w-1 h-1 bg-slate-300 rounded-full"></div>
                            <span class="text-[10px] font-bold text-blue-600/50 uppercase tracking-widest">Urgent Update</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="p-24 text-center">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 border-2 border-dashed border-slate-200">
                    <svg class="w-12 h-12 text-slate-200" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tight italic">Hening...</h3>
                <p class="text-slate-400 font-bold mt-1 uppercase text-sm tracking-widest">Tidak ada notifikasi baru untuk Anda</p>
            </div>
            @endforelse
        </div>
        
        @if($notifications->hasPages())
        <div class="p-8 border-t-2 border-slate-100 bg-slate-50/50">
            {{ $notifications->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
@endsection
