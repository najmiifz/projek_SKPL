@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">
    <div class="bg-white rounded-2xl shadow-xl border-2 border-slate-200 p-8">
        <div class="flex items-center justify-between mb-8 pb-6 border-b-2 border-slate-100">
            <h1 class="text-4xl font-black text-slate-900 tracking-tight italic uppercase">Admin<span class="text-blue-600">Console</span></h1>
            <div class="bg-slate-900 text-white px-4 py-2 rounded-xl font-bold text-sm shadow-lg tracking-widest uppercase">
                System Overview
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10 text-center">
            <div class="bg-white border-2 border-blue-500/30 rounded-2xl p-6 shadow-xl hover:translate-y-[-5px] transition-all">
                <div class="w-14 h-14 bg-blue-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl shadow-blue-500/50">
                    <svg class="w-8 h-8 font-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <p class="text-[11px] font-black text-blue-800 uppercase tracking-[0.2em] mb-1">Total Users</p>
                <p class="text-4xl font-black text-slate-900 tracking-tighter">{{ $totalUsers }}</p>
            </div>

            <div class="bg-white border-2 border-emerald-500/30 rounded-2xl p-6 shadow-xl hover:translate-y-[-5px] transition-all">
                <div class="w-14 h-14 bg-emerald-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl shadow-emerald-500/50">
                    <svg class="w-8 h-8 font-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <p class="text-[11px] font-black text-emerald-800 uppercase tracking-[0.2em] mb-1">Total Projects</p>
                <p class="text-4xl font-black text-slate-900 tracking-tighter">{{ $totalProjects }}</p>
            </div>

            <div class="bg-white border-2 border-amber-500/30 rounded-2xl p-6 shadow-xl hover:translate-y-[-5px] transition-all">
                <div class="w-14 h-14 bg-amber-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl shadow-amber-500/50">
                    <svg class="w-8 h-8 font-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <p class="text-[11px] font-black text-amber-800 uppercase tracking-[0.2em] mb-1">Total Tasks</p>
                <p class="text-4xl font-black text-slate-900 tracking-tighter">{{ $totalTasks }}</p>
            </div>

            <div class="bg-white border-2 border-indigo-500/30 rounded-2xl p-6 shadow-xl hover:translate-y-[-5px] transition-all">
                <div class="w-14 h-14 bg-indigo-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl shadow-indigo-500/50">
                    <svg class="w-8 h-8 font-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <p class="text-[11px] font-black text-indigo-800 uppercase tracking-[0.2em] mb-1">Active Projects</p>
                <p class="text-4xl font-black text-slate-900 tracking-tighter">{{ $activeProjects }}</p>
            </div>
        </div>

        <!-- Section Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
            <!-- Recent Activities -->
            <div class="lg:col-span-2 bg-slate-50 rounded-3xl border-2 border-slate-200 shadow-inner overflow-hidden flex flex-col">
                <div class="px-8 py-6 bg-white border-b-2 border-slate-200 flex items-center justify-between">
                    <h3 class="text-lg font-black text-slate-900 uppercase tracking-widest flex items-center gap-3">
                        <span class="w-5 h-5 bg-blue-600 rounded-lg"></span> Recent Activities
                    </h3>
                </div>
                <div class="flex-1 p-6">
                    @if($recentActivities->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentActivities->take(10) as $activity)
                            <div class="bg-white p-5 rounded-2xl border-2 border-slate-100 shadow-sm flex items-start gap-4">
                                <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center text-slate-700 font-black shadow-inner">
                                    {{ strtoupper(substr($activity->assignee->name ?? '?',0,1)) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-1">
                                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-tight leading-none">{{ $activity->title }}</h3>
                                        <p class="text-[10px] font-black text-slate-500 bg-slate-100 px-2 py-0.5 rounded uppercase tracking-wider">{{ $activity->updated_at->diffForHumans() }}</p>
                                    </div>
                                    <p class="text-[11px] text-slate-700 font-bold bg-blue-50 p-2 rounded-lg border border-blue-100 inline-block">
                                        👤 <strong>Assignee:</strong> {{ $activity->assignee->name ?? 'Unassigned' }} &nbsp;|&nbsp; 
                                        📂 <strong>Project:</strong> {{ $activity->project->name ?? 'Unknown' }} &nbsp;|&nbsp;
                                        ⚡ <strong>Status:</strong> <span class="text-blue-700 uppercase">{{ $activity->status }}</span>
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-slate-200">
                            <p class="text-slate-500 font-black uppercase tracking-widest">No activities recorded</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="space-y-6">
                <div class="bg-white rounded-3xl border-2 border-slate-200 p-8 shadow-xl">
                    <h3 class="text-lg font-black text-slate-900 uppercase tracking-widest mb-6 flex items-center gap-3">
                        <span class="w-5 h-5 bg-amber-500 rounded-lg"></span> Quick Actions
                    </h3>
                    <div class="space-y-4">
                        <a href="{{ route('users.index') }}" class="group flex items-center justify-between bg-blue-600 hover:bg-black text-white p-5 rounded-2xl shadow-xl hover:translate-x-2 transition-all">
                            <span class="font-black uppercase tracking-widest text-sm">Kelola Pengguna</span>
                            <svg class="w-6 h-6 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7-7 7"/></svg>
                        </a>
                        <a href="{{ route('admin.projects') }}" class="group flex items-center justify-between bg-emerald-600 hover:bg-black text-white p-5 rounded-2xl shadow-xl hover:translate-x-2 transition-all">
                            <span class="font-black uppercase tracking-widest text-sm">Semua Proyek</span>
                            <svg class="w-6 h-6 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7-7 7"/></svg>
                        </a>
                        <a href="{{ route('admin.logs') }}" class="group flex items-center justify-between bg-purple-600 hover:bg-black text-white p-5 rounded-2xl shadow-xl hover:translate-x-2 transition-all">
                            <span class="font-black uppercase tracking-widest text-sm">Log Aktivitas</span>
                            <svg class="w-6 h-6 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>

                <div class="bg-slate-900 rounded-3xl p-8 shadow-2xl text-white">
                    <h3 class="text-sm font-black uppercase tracking-[0.2em] text-slate-400 mb-4 items-center flex gap-2">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span> System Status
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between text-xs font-black">
                            <span class="text-slate-500 uppercase">Database</span>
                            <span class="text-green-500 tracking-tighter">ONLINE</span>
                        </div>
                        <div class="flex items-center justify-between text-xs font-black">
                            <span class="text-slate-500 uppercase">Latency</span>
                            <span class="text-white tracking-tighter">18ms</span>
                        </div>
                        <div class="w-full bg-slate-800 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-blue-600 h-full w-[85%] rounded-full shadow-[0_0_10px_rgba(37,99,235,0.5)]"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection