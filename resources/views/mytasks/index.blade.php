@extends('layouts.app')

@section('content')
  <h1 class="text-2xl font-bold mb-4">Tugas Saya</h1>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    @foreach(['To Do','In Progress','Done'] as $status)
      <div class="bg-white p-4 rounded shadow">
        <h3 class="font-bold mb-2">{{ $status }}</h3>
        <ul class="space-y-2">
          @foreach($tasks->where('status',$status) as $task)
            <li class="p-2 border rounded">{{ $task->title }}</li>
          @endforeach
        </ul>
      </div>
    @endforeach
  </div>
@endsection
