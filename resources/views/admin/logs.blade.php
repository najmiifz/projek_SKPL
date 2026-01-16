@extends('layouts.app')

@section('title', 'Log Activities')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="border-4 border-dashed border-gray-200 rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Log Activities</h1>
                <div class="flex space-x-3">
                    <!-- Filter Dropdown -->
                    <select class="border border-gray-300 rounded-md px-3 py-2 text-sm" onchange="filterActivities(this.value)">
                        <option value="all">Semua Aktivitas</option>
                        <option value="task_update">Task Updates</option>
                        <option value="project_update">Project Updates</option>
                    </select>
                    
                    <!-- Refresh Button -->
                    <button onclick="location.reload()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Refresh
                    </button>
                    
                    <a href="{{ route('admin.dashboard') }}" 
                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 sm:p-6">
                    @if($activities->count() > 0)
                        <ul class="divide-y divide-gray-200">
                            @foreach($activities as $activity)
                            <li class="py-4" data-activity-type="{{ $activity['type'] }}">
                                <a href="{{ $activity['link'] }}" class="block hover:bg-gray-50 rounded-lg p-3 transition-colors">
                                    <div class="flex space-x-4">
                                        <!-- User Avatar -->
                                        <div class="flex-shrink-0">
                                            <img src="{{ $activity['user_avatar'] }}" class="w-10 h-10 rounded-full object-cover" alt="{{ $activity['user'] }}">
                                        </div>
                                        
                                        <!-- Activity Type Icon -->
                                        <div class="flex-shrink-0">
                                            @if($activity['type'] == 'task_update')
                                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Content -->
                                        <div class="flex-1 space-y-1">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h3 class="text-sm font-semibold text-gray-900">
                                                        {{ $activity['user'] }}
                                                    </h3>
                                                    <span class="text-xs text-gray-500">{{ $activity['user_role'] }}</span>
                                                </div>
                                                <p class="text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($activity['timestamp'])->diffForHumans() }}
                                                </p>
                                            </div>
                                            
                                            <p class="text-sm text-gray-700 font-medium">{{ $activity['title'] }}</p>
                                            
                                            <div class="flex items-center space-x-4 text-xs text-gray-500">
                                                <span>Project: {{ $activity['project'] }}</span>
                                                
                                                @if(isset($activity['status']))
                                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                                    @if($activity['status'] == 'Done') bg-green-100 text-green-800
                                                    @elseif($activity['status'] == 'In Progress') bg-yellow-100 text-yellow-800
                                                    @elseif($activity['status'] == 'Review') bg-blue-100 text-blue-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ $activity['status'] }}
                                                </span>
                                                @endif
                                                
                                                @if(isset($activity['progress']) && $activity['type'] == 'task_update')
                                                <span>Progress: {{ $activity['progress'] }}%</span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <!-- Arrow Icon -->
                                        <div class="flex-shrink-0">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 text-center py-8">Belum ada aktivitas yang tercatat.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

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