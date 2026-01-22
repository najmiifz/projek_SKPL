@extends('layouts.app')

@section('title', 'Log Activities')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">
    <div class="bg-white rounded-3xl shadow-2xl border-2 border-slate-200 p-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8 pb-6 border-b-2 border-slate-100">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight italic uppercase">Aktivitas<span class="text-purple-600">Sistem</span></h1>
                <p class="text-sm text-slate-500 font-bold mt-1 tracking-widest uppercase">System Audit Logs</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <!-- Filter Dropdown -->
                <select class="border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm font-black text-slate-700 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all shadow-sm" onchange="filterActivities(this.value)">
                    <option value="all">SEMUA AKTIVITAS</option>
                    <option value="task_update">UPDATE TUGAS</option>
                    <option value="project_update">UPDATE PROYEK</option>
                </select>
                
                <!-- Refresh Button -->
                <button onclick="location.reload()" class="bg-slate-900 hover:bg-black text-white font-black py-2.5 px-5 rounded-xl flex items-center gap-2 shadow-lg hover:-translate-y-0.5 transition-all text-sm tracking-widest uppercase">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Refresh
                </button>
            </div>
        </div>

        <div class="bg-slate-50 rounded-3xl border-2 border-slate-200 shadow-inner overflow-hidden">
            <div class="p-6">
                @if($activities->count() > 0)
                    <div class="space-y-4">
                        @foreach($activities as $activity)
                        <div class="activity-item bg-white p-5 rounded-2xl border-2 border-slate-100 shadow-sm transition-all hover:border-blue-300 hover:shadow-xl group" data-activity-type="{{ $activity['type'] }}">
                            <a href="{{ $activity['link'] }}" class="flex items-center gap-6">
                                <!-- User Info -->
                                <div class="flex items-center gap-4 min-w-[200px]">
                                    <div class="relative">
                                        <img src="{{ $activity['user_avatar'] }}" class="w-12 h-12 rounded-2xl object-cover border-2 border-white shadow-md group-hover:scale-110 transition-transform" alt="{{ $activity['user'] }}">
                                        @if($activity['type'] == 'task_update')
                                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-amber-500 rounded-lg flex items-center justify-center text-white border-2 border-white shadow-sm scale-90">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/></svg>
                                            </div>
                                        @else
                                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-blue-500 rounded-lg flex items-center justify-center text-white border-2 border-white shadow-sm scale-90">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-900 uppercase tracking-tight">{{ $activity['user'] }}</p>
                                        <p class="text-[10px] font-black text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md uppercase tracking-widest mt-0.5">{{ $activity['user_role'] }}</p>
                                    </div>
                                </div>
                                
                                <!-- Activity Content -->
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <p class="text-sm font-bold text-slate-800 leading-tight">{{ $activity['title'] }}</p>
                                        <p class="text-[11px] font-black text-slate-400 bg-slate-50 px-2 py-1 rounded inline-flex items-center gap-1.5 whitespace-nowrap">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            {{ \Carbon\Carbon::parse($activity['timestamp'])->diffForHumans() }}
                                        </p>
                                    </div>
                                    
                                    <div class="flex flex-wrap items-center gap-4">
                                        <div class="text-[11px] font-bold text-slate-700 bg-blue-50 border border-blue-100 px-3 py-1 rounded-xl">
                                            📂 PROJECT: <span class="text-blue-800">{{ $activity['project'] }}</span>
                                        </div>
                                        
                                        @if(isset($activity['status']))
                                        <div class="px-3 py-1 rounded-xl text-[10px] font-black border uppercase tracking-wider
                                            @if($activity['status'] == 'Done') bg-green-100 text-green-800 border-green-200
                                            @elseif($activity['status'] == 'In Progress') bg-yellow-100 text-yellow-800 border-yellow-200
                                            @elseif($activity['status'] == 'Review') bg-blue-100 text-blue-800 border-blue-200
                                            @else bg-slate-100 text-slate-800 border-slate-200 @endif">
                                            ST: {{ $activity['status'] }}
                                        </div>
                                        @endif
                                        
                                        @if(isset($activity['progress']) && $activity['type'] == 'task_update')
                                        <div class="text-[11px] font-black text-emerald-800 bg-emerald-100 border border-emerald-200 px-3 py-1 rounded-xl">
                                            📈 PROGRESS: {{ $activity['progress'] }}%
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Arrow -->
                                <div class="w-10 h-10 flex items-center justify-center text-slate-300 group-hover:text-blue-600 transition-colors">
                                    <svg class="w-6 h-6 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-slate-200">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-dashed border-slate-300">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-slate-500 font-black uppercase tracking-widest">No activities recorded in logs</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function filterActivities(type) {
    const activities = document.querySelectorAll('.activity-item');
    
    activities.forEach(activity => {
        if (type === 'all' || activity.getAttribute('data-activity-type') === type) {
            activity.style.display = 'block';
        } else {
            activity.style.display = 'none';
        }
    });
}
</script>

<script>
function filterActivities(type) {
    const activities = document.querySelectorAll('[data-activity-type]');
    
    activities.forEach(activity => {
        if (type === 'all' || activity.getAttribute('data-activity-type') === type) {
            activity.style.display = 'block';
        } else {
            activity.style.display = 'none';
        }
    });
}

// Auto refresh every 30 seconds
setInterval(() => {
    const refreshIcon = document.querySelector('.refresh-icon');
    if (refreshIcon) {
        refreshIcon.classList.add('animate-spin');
        setTimeout(() => refreshIcon.classList.remove('animate-spin'), 1000);
    }
}, 30000);
</script>

@endsection