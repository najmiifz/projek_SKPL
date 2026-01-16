@extends('layouts.app')

@section('page-title', 'Detail Proyek')

@section('content')
  <div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-bold">{{ $project->name }}</h1>
    <div class="flex space-x-2">
      <a href="{{ route('projects.gantt', $project) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
        Gantt Chart
      </a>
      <a href="{{ route('projects.kanban', $project) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
        Kanban Board
      </a>
      <a href="
        @if(auth()->user()->role === 'admin')
          {{ route('admin.projects') }}
        @else
          {{ route('projects.index') }}
        @endif
      " class="text-sm text-slate-600 py-2 px-4 border rounded hover:bg-slate-50">Kembali</a>
    </div>
  </div>

  <div class="bg-white p-4 rounded shadow mb-4">
    <p class="text-sm text-slate-600">{{ $project->description }}</p>
    <div class="mt-4 grid grid-cols-4 gap-4">
      <div class="text-center">
        <div class="text-lg font-bold">{{ $project->status }}</div>
        <div class="text-sm text-slate-600">Status Proyek</div>
      </div>
      <div class="text-center">
        <div class="text-lg font-bold">{{ $tasks->count() }}</div>
        <div class="text-sm text-slate-600">Total Tugas</div>
      </div>
      <div class="text-center">
        <div class="text-lg font-bold">{{ $tasks->where('status', 'Done')->count() }}</div>
        <div class="text-sm text-slate-600">Tugas Selesai</div>
      </div>
      <div class="text-center">
        @php
            $totalTasks = $tasks->count();
            $doneTasks = $tasks->where('status', 'Done')->count();
            $progress = $totalTasks > 0 ? round(($doneTasks / $totalTasks) * 100) : 0;
        @endphp
        <div class="text-lg font-bold">{{ $progress }}%</div>
        <div class="text-sm text-slate-600">Progress</div>
      </div>
    </div>
  </div>

  <!-- Add Task Form for PM -->
  @if(auth()->user()->role === 'pm')
  <div class="bg-white p-4 rounded shadow mb-4" x-data="{ open: false }">
    <div class="flex justify-between items-center">
      <h3 class="font-bold">Tambah Tugas Baru</h3>
      <button @click="open = !open" class="text-blue-600 hover:text-blue-800 text-sm">
        <span x-show="!open">+ Tambah</span>
        <span x-show="open">- Tutup</span>
      </button>
    </div>
    
    <form x-show="open" action="{{ route('tasks.store') }}" method="POST" class="mt-4 space-y-4">
      @csrf
      <input type="hidden" name="project_id" value="{{ $project->id }}">
      
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Judul Tugas</label>
          <input type="text" name="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Assignee</label>
          <select name="assignee_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="">-- Pilih Member --</option>
            @foreach($members as $member)
            <option value="{{ $member->id }}">{{ $member->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
      
      <div>
        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
        <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
      </div>
      
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
          <input type="date" name="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Deadline</label>
          <input type="date" name="due_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
      </div>
      
      <div class="flex justify-end">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
          Simpan Tugas
        </button>
      </div>
    </form>
  </div>
  @endif

  <div class="bg-white p-4 rounded shadow">
    <h3 class="font-bold mb-4">Tugas dalam Proyek</h3>
    
    @if($tasks->count() > 0)
    <div class="space-y-3">
      @foreach($tasks as $task)
        <a href="{{ route('tasks.show', $task) }}" class="block p-4 border rounded-lg hover:bg-gray-50">
          <div class="flex justify-between items-start">
            <div class="flex-1">
              <h4 class="font-medium text-slate-800">{{ $task->title }}</h4>
              <p class="text-sm text-gray-600 mt-1">{{ Str::limit($task->description, 100) }}</p>
              <div class="flex items-center mt-2 space-x-4">
                <span class="text-xs text-gray-500 flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                  </svg>
                  {{ $task->assignee->name ?? 'Belum ditugaskan' }}
                </span>
                <span class="px-2 py-1 text-xs rounded-full 
                  @if($task->status == 'Done') bg-green-100 text-green-800
                  @elseif($task->status == 'In Progress') bg-yellow-100 text-yellow-800
                  @elseif($task->status == 'Review') bg-blue-100 text-blue-800
                  @else bg-gray-100 text-gray-800 @endif">
                  {{ $task->status }}
                </span>
                @if($task->due_date)
                <span class="text-xs {{ \Carbon\Carbon::parse($task->due_date)->isPast() ? 'text-red-600' : 'text-gray-500' }}">
                  Deadline: {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                </span>
                @endif
              </div>
            </div>
            @if(auth()->user()->role === 'pm' && $task->status === 'Review')
            <div class="ml-4" onclick="event.preventDefault(); event.stopPropagation();">
              <a href="{{ route('tasks.validate', [$project, $task]) }}" 
                 class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">
                Validasi
              </a>
            </div>
            @endif
          </div>
        </a>
      @endforeach
    </div>
    @else
    <p class="text-gray-500 text-center py-8">Belum ada tugas dalam proyek ini.</p>
    @endif
  </div>
  
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection
