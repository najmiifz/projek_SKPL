@extends('layouts.app')

@section('content')
<div class="space-y-6">
  <div class="flex items-center justify-between">
    <h1 class="text-2xl font-bold text-slate-800">Daftar Proyek</h1>
    <a href="{{ route('projects.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center">
      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
      </svg>
      Buat Proyek
    </a>
  </div>

  @if($projects->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($projects as $project)
        <a href="{{ route('projects.show', $project) }}" class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-all hover:-translate-y-1 block group">
          <div class="flex justify-between items-start mb-3">
            <span class="px-3 py-1 text-xs font-black rounded-full bg-blue-200 text-blue-900 border border-blue-300 uppercase tracking-tighter">
              {{ ucfirst($project->status ?? 'To Do') }}
            </span>
            <span class="text-xs text-slate-600 font-bold bg-slate-100 px-2 py-1 rounded">{{ $project->start_date ?? 'TBD' }} - {{ $project->end_date ?? 'TBD' }}</span>
          </div>
          <h3 class="font-black text-xl text-slate-900 mb-2 group-hover:text-blue-700 transition leading-tight">{{ $project->name }}</h3>
          <p class="text-slate-700 text-sm mb-5 line-clamp-2 font-medium leading-relaxed">{{ $project->description ?? 'Tidak ada deskripsi.' }}</p>
          
          <div class="space-y-2 bg-slate-50 p-3 rounded-lg border border-slate-100">
            <div class="flex justify-between text-xs font-black text-slate-800 uppercase tracking-wider">
              <span>Progress</span>
              <span>0%</span>
            </div>
            <div class="w-full bg-slate-200 rounded-full h-2.5 overflow-hidden border border-slate-300">
              <div class="bg-blue-600 h-full rounded-full transition-all duration-500 shadow-sm" style="width: 0%"></div>
            </div>
          </div>
          
          <div class="mt-5 pt-4 border-t border-slate-200 flex items-center justify-between text-xs text-slate-700 font-bold">
            <span class="flex items-center gap-1.5">
              <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
              </svg>
              0 Tugas
            </span>
            <span class="flex items-center gap-1.5">
              <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
              </svg>
              0 Member
            </span>
          </div>
        </a>
      @endforeach
    </div>
  @else
    <div class="text-center py-12">
      <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
      </svg>
      <h3 class="text-lg font-medium text-slate-900 mb-2">Belum ada proyek</h3>
      <p class="text-slate-500 mb-4">Mulai dengan membuat proyek pertama Anda</p>
      <a href="{{ route('projects.create') }}" class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Buat Proyek Pertama
      </a>
    </div>
  @endif
</div>
@endsection
