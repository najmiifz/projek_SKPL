@extends('layouts.app')

@section('content')
  <div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-4">
      <div>
        <h1 class="text-2xl font-bold">{{ $task->title }}</h1>
        <p class="text-sm text-slate-500">Project: {{ $task->project->name ?? $task->project_id }}</p>
      </div>
      <div class="text-sm text-slate-600">Status: <span class="font-semibold">{{ $task->status }}</span></div>
    </div>

    <div class="bg-white p-4 rounded shadow mb-4">
      <label class="block font-bold mb-2">Lampiran File</label>
      <form action="{{ route('tasks.upload', $task) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="border-2 border-dashed p-6 text-center rounded">
          <input type="file" name="file">
          <div class="mt-2 text-sm text-slate-500">Klik untuk upload bukti pekerjaan (Mockup)</div>
        </div>
        <div class="flex justify-end mt-3">
          <button class="bg-blue-600 text-white px-3 py-2 rounded">Upload</button>
        </div>
      </form>

      @if($task->files)
        <ul class="mt-3 text-sm text-blue-600">
          @foreach($task->files as $f)
            <li class="flex items-center mb-1"><a href="{{ asset('storage/'.$f['path']) }}" target="_blank">{{ $f['name'] }}</a></li>
          @endforeach
        </ul>
      @endif
    </div>

    <div class="bg-white p-4 rounded shadow">
      <h3 class="font-bold mb-3">Diskusi</h3>
      <div class="space-y-3 max-h-64 overflow-y-auto mb-4">
        @if($task->comments->isEmpty())
          <p class="text-xs text-slate-400">Belum ada komentar.</p>
        @endif
        @foreach($task->comments as $c)
          <div class="flex gap-3">
            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center">{{ strtoupper(substr($c->user->name,0,1)) }}</div>
            <div>
              <div class="text-sm font-semibold">{{ $c->user->name }}</div>
              <div class="text-sm text-slate-600">{{ $c->body }}</div>
              <div class="text-xs text-slate-400">{{ $c->created_at->diffForHumans() }}</div>
            </div>
          </div>
        @endforeach
      </div>

      <form method="POST" action="{{ route('tasks.comment', $task) }}">
        @csrf
        <div class="flex gap-2">
          <input type="text" name="body" class="flex-1 border rounded px-3 py-2" placeholder="Tulis komentar...">
          <button class="bg-blue-600 text-white px-3 py-2 rounded">Kirim</button>
        </div>
      </form>
    </div>
  </div>
@endsection
