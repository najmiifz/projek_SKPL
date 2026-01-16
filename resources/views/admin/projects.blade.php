@extends('layouts.app')

@section('page-title', 'Semua Proyek')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Semua Proyek</h1>
        <a href="{{ route('admin.dashboard') }}" 
           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Kembali ke Dashboard
        </a>
    </div>

    @if($projects->count() > 0)
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @foreach($projects as $project)
                <li class="hover:bg-gray-50 transition-colors">
                    <a href="{{ route('projects.show', $project) }}" class="block px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center flex-1">
                                <div>
                                    <p class="text-lg font-medium text-indigo-600 hover:text-indigo-800">
                                        {{ $project->name }}
                                    </p>
                                    <p class="text-sm text-gray-500 mt-1">
                                        <span class="font-semibold">PM:</span> {{ $project->pmUser->name ?? 'Unassigned' }}
                                    </p>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ $project->description }}
                                    </p>
                                </div>
                            </div>
                            <div class="ml-2 flex-shrink-0 flex items-center space-x-4">
                                <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($project->status == 'Done') bg-green-100 text-green-800
                                    @elseif($project->status == 'In Progress') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $project->status }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-2 flex items-center text-sm text-gray-500 space-x-4">
                            <span>📋 Tasks: {{ $project->tasks->count() }}</span>
                            <span>✓ Selesai: {{ $project->tasks->where('status', 'Done')->count() }}</span>
                            <span>📅 Created: {{ $project->created_at->format('d/m/Y') }}</span>
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="currentColor" viewBox="0 0 20 20">
                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
            </svg>
            <p class="text-gray-500 text-lg">Belum ada proyek yang dibuat.</p>
        </div>
    @endif
</div>
@endsection