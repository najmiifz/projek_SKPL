@extends('layouts.app')

@section('content')
<div class="space-y-6">
  <h1 class="text-2xl font-bold mb-4">Dashboard Overview</h1>

  <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
    @php
      $icons = [
        '<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7V6a2 2 0 012-2h14a2 2 0 012 2v1M3 7v11a2 2 0 002 2h14a2 2 0 002-2V7M3 7h18" /></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2m16 0v-2a4 4 0 00-4-4h-1a4 4 0 00-4 4v2" /></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17l4-4 4 4m0 0V3m0 14a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>'
      ];
      $colors = ['bg-blue-500','bg-orange-500','bg-purple-500','bg-green-500'];
      $labels = ['Total Proyek','Tugas Aktif','Menunggu Review','Notifikasi'];
      $values = [$projects, $activeTasks, $pendingReview, $notifications->count()];
    @endphp
    @foreach(range(0,3) as $i)
      <x-stat-card :icon="$icons[$i]" :label="$labels[$i]" :value="$values[$i]" :color="$colors[$i]" />
    @endforeach
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
      <h3 class="font-bold mb-4">Aktivitas Terbaru</h3>
      <div class="space-y-3">
        @foreach($notifications->take(5) as $n)
          <div class="flex items-start text-sm p-2 bg-slate-50 rounded">
            <div class="bg-blue-100 p-1 rounded-full mr-2 text-blue-600">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
            </div>
            <div>
              <p class="text-slate-800">{{ $n->message }}</p>
              <span class="text-xs text-slate-400">{{ $n->created_at->diffForHumans() }}</span>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    @if(auth()->user()->role === 'admin')
      <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
        <h3 class="font-bold mb-4">Status Server</h3>
        <div class="flex items-center justify-between p-3 bg-green-50 border border-green-200 rounded-lg text-green-700 mb-2">
          <span class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" /></svg> Database Connected</span>
          <span class="font-mono text-xs">Lat: 24ms</span>
        </div>
        <div class="flex items-center justify-between p-3 bg-green-50 border border-green-200 rounded-lg text-green-700">
          <span class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" /></svg> API Service Online</span>
          <span class="font-mono text-xs">Uptime: 99.9%</span>
        </div>
      </div>
    @endif
  </div>
</div>
@endsection
