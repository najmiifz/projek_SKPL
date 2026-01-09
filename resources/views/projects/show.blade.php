@extends('layouts.app')

@section('content')
  <div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-bold">{{ $project->name }}</h1>
    <a href="{{ route('projects.index') }}" class="text-sm text-slate-600">Kembali</a>
  </div>

  <div class="bg-white p-4 rounded shadow mb-4">
    <p class="text-sm text-slate-600">{{ $project->description }}</p>
  </div>

  <div class="bg-white p-4 rounded shadow">
    <h3 class="font-bold mb-2">Tugas</h3>
    <ul class="space-y-2">
      @foreach($tasks as $task)
        <li class="p-2 border rounded">{{ $task->title }} <span class="text-xs text-slate-400">{{ $task->status }}</span></li>
      @endforeach
    </ul>
  </div>
@endsection
