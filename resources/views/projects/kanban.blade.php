@extends('layouts.app')

@section('title', 'Kanban Board - ' . $project->name)

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="border-4 border-dashed border-gray-200 rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Kanban Board</h1>
                    <p class="text-lg text-gray-600">{{ $project->name }}</p>
                </div>
                <a href="{{ route('projects.show', $project) }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Kembali ke Proyek
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- To Do Column -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">
                        To Do ({{ $todoTasks->count() }})
                    </h3>
                    <div class="space-y-3">
                        @foreach($todoTasks as $task)
                            <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-gray-400">
                                <h4 class="font-medium text-gray-900">{{ $task->title }}</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ $task->description }}</p>
                                <div class="flex justify-between items-center mt-3">
                                    <span class="text-xs text-gray-500">{{ $task->assignee->name ?? 'Unassigned' }}</span>
                                    <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">{{ $task->status }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- In Progress Column -->
                <div class="bg-yellow-50 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">
                        In Progress ({{ $inProgressTasks->count() }})
                    </h3>
                    <div class="space-y-3">
                        @foreach($inProgressTasks as $task)
                            <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-yellow-400">
                                <h4 class="font-medium text-gray-900">{{ $task->title }}</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ $task->description }}</p>
                                <div class="flex justify-between items-center mt-3">
                                    <span class="text-xs text-gray-500">{{ $task->assignee->name ?? 'Unassigned' }}</span>
                                    <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">{{ $task->status }}</span>
                                </div>
                                @if($task->progress)
                                    <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                                        <div class="bg-yellow-500 h-1.5 rounded-full" style="width: {{ $task->progress }}%"></div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Done Column -->
                <div class="bg-green-50 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">
                        Done ({{ $doneTasks->count() }})
                    </h3>
                    <div class="space-y-3">
                        @foreach($doneTasks as $task)
                            <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-green-400">
                                <h4 class="font-medium text-gray-900">{{ $task->title }}</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ $task->description }}</p>
                                <div class="flex justify-between items-center mt-3">
                                    <span class="text-xs text-gray-500">{{ $task->assignee->name ?? 'Unassigned' }}</span>
                                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">{{ $task->status }}</span>
                                </div>
                                @if($task->validated_at)
                                    <p class="text-xs text-green-600 mt-1">✓ Validated</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection