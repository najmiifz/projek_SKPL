@extends('layouts.app')

@section('page-title', 'Dashboard Overview')

@section('content')
<div class="space-y-8">
    <div class="mb-2">
        <h1 class="text-2xl font-black text-[#0F172A] uppercase italic">DASHBOARD <span class="text-blue-600">OVERVIEW</span></h1>
        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-[0.2em]">System Performance & Statistics</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $stats = [
                ['label' => 'Total Proyek', 'value' => $projects, 'color' => 'bg-blue-600', 'icon' => 'M3 7V6a2 2 0 012-2h14a2 2 0 012 2v1M3 7v11a2 2 0 002 2h14a2 2 0 002-2V7M3 7h18'],
                ['label' => 'Tugas Aktif', 'value' => $activeTasks, 'color' => 'bg-orange-500', 'icon' => 'M9 17v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2m16 0v-2a4 4 0 00-4-4h-1a4 4 0 00-4 4v2'],
                ['label' => 'Menunggu Review', 'value' => $pendingReview, 'color' => 'bg-purple-600', 'icon' => 'M8 17l4-4 4 4m0 0V3m0 14a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Notifikasi', 'value' => $notifications->count(), 'color' => 'bg-emerald-500', 'icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9']
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:scale-110 transition-transform">
                <svg class="w-16 h-16 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $stat['icon'] }}"></path>
                </svg>
            </div>
            <div class="relative z-10">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">{{ $stat['label'] }}</p>
                <h3 class="text-3xl font-black text-slate-900 italic">{{ $stat['value'] }}</h3>
                <div class="mt-3 w-8 h-1 {{ $stat['color'] }} rounded-full"></div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="bg-[#0F172A] px-6 py-4 flex items-center justify-between">
                <h3 class="text-white font-black text-xs uppercase tracking-[0.2em] italic">Aktivitas Terbaru</h3>
                <span class="bg-blue-600 text-[9px] font-black text-white px-2 py-0.5 rounded uppercase">Live Feed</span>
            </div>
            <div class="p-6 divide-y divide-slate-100">
                @forelse($notifications->take(5) as $n)
                <div class="py-4 first:pt-0 last:pb-0 flex gap-4 group">
                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center border border-slate-100 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-slate-900 leading-snug">{{ $n->message }}</p>
                        <p class="text-[10px] text-slate-400 font-black uppercase mt-1">{{ $n->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <p class="text-center py-6 text-slate-400 text-xs font-bold uppercase italic tracking-widest">Tidak ada aktivitas</p>
                @endforelse
            </div>
        </div>

        <div class="lg:col-span-5 space-y-6">
            @if(auth()->user()->role === 'admin')
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="bg-[#0F172A] px-6 py-4">
                    <h3 class="text-white font-black text-xs uppercase tracking-[0.2em] italic">Status Server</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between p-4 bg-emerald-50 border border-emerald-100 rounded-xl group hover:bg-emerald-100 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 bg-emerald-500 rounded-full animate-ping"></div>
                            <span class="text-xs font-black text-emerald-800 uppercase tracking-tighter">Database Connected</span>
                        </div>
                        <span class="font-mono text-[10px] font-bold text-emerald-600">Lat: 24ms</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-blue-50 border border-blue-100 rounded-xl group hover:bg-blue-100 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                            <span class="text-xs font-black text-blue-800 uppercase tracking-tighter">API Service Online</span>
                        </div>
                        <span class="font-mono text-[10px] font-bold text-blue-600">Uptime: 99.9%</span>
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 p-6 rounded-2xl shadow-lg shadow-blue-200 relative overflow-hidden">
                <div class="relative z-10 text-white">
                    <h4 class="font-black italic uppercase text-lg tracking-tighter">Simpro Premium</h4>
                    <p class="text-xs font-bold opacity-80 mt-1">Gunakan fitur eksklusif untuk manajemen proyek yang lebih cepat.</p>
                </div>
                <svg class="absolute -bottom-4 -right-4 w-24 h-24 text-white opacity-10" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path>
                </svg>
            </div>
        </div>
    </div>
</div>
@endsection