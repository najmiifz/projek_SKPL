@extends('layouts.app')

@section('content')
  <h1 class="text-2xl font-bold mb-4">Daftar Tugas</h1>
  <div class="bg-white p-4 rounded shadow">
    <table class="w-full text-left text-sm">
      <thead class="text-slate-500"><tr><th class="p-2">Judul</th><th class="p-2">Project</th><th class="p-2">Assignee</th><th class="p-2">Status</th></tr></thead>
      <tbody>
        @foreach($tasks as $task)
          <tr class="border-t"><td class="p-2">{{ $task->title }}</td><td class="p-2">{{ $task->project->name ?? $task->project_id }}</td><td class="p-2">{{ $task->assignee->name ?? $task->assignee_id }}</td><td class="p-2">{{ $task->status }}</td></tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection
