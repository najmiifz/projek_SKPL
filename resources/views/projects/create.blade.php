@extends('layouts.app')

@section('content')
<div class="space-y-6">
  <div class="flex items-center space-x-4">
    <a href="{{ route('projects.index') }}" class="text-slate-500 hover:text-slate-700">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
    </a>
    <h1 class="text-2xl font-bold text-slate-800">Buat Proyek Baru</h1>
  </div>

  <div class="max-w-3xl">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
      <form method="POST" action="{{ route('projects.store') }}" class="space-y-6">
        @csrf
        
        <div>
          <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Nama Proyek</label>
          <input type="text" 
                 name="name" 
                 id="name" 
                 value="{{ old('name') }}"
                 class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('name') border-red-300 @enderror" 
                 placeholder="Masukkan nama proyek"
                 required>
          @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="description" class="block text-sm font-medium text-slate-700 mb-2">Deskripsi Proyek</label>
          <textarea name="description" 
                    id="description" 
                    rows="4"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('description') border-red-300 @enderror" 
                    placeholder="Jelaskan tujuan dan scope proyek ini...">{{ old('description') }}</textarea>
          @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="start_date" class="block text-sm font-medium text-slate-700 mb-2">Tanggal Mulai</label>
            <input type="date" 
                   name="start_date" 
                   id="start_date" 
                   value="{{ old('start_date') }}"
                   class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('start_date') border-red-300 @enderror">
            @error('start_date')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="end_date" class="block text-sm font-medium text-slate-700 mb-2">Tanggal Selesai</label>
            <input type="date" 
                   name="end_date" 
                   id="end_date" 
                   value="{{ old('end_date') }}"
                   class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('end_date') border-red-300 @enderror">
            @error('end_date')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
          <h3 class="font-medium text-slate-700 mb-2">Informasi Project Manager</h3>
          <div class="flex items-center space-x-3">
            <img src="{{ auth()->user()->avatar ?? 'https://i.pravatar.cc/40?u=' . urlencode(auth()->user()->email) }}" 
                 class="w-10 h-10 rounded-full object-cover" alt="">
            <div>
              <div class="font-medium text-slate-800">{{ auth()->user()->name }}</div>
              <div class="text-sm text-slate-500">{{ auth()->user()->email }}</div>
            </div>
          </div>
          <p class="text-xs text-slate-500 mt-2">Anda akan menjadi Project Manager untuk proyek ini</p>
        </div>

        <div class="flex items-center space-x-4 pt-4">
          <button type="submit" 
                  class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-medium flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Buat Proyek
          </button>
          <a href="{{ route('projects.index') }}" 
             class="bg-slate-200 text-slate-700 px-6 py-3 rounded-lg hover:bg-slate-300 transition font-medium">
            Batal
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

@if ($errors->any())
<div class="fixed top-4 right-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg shadow-lg">
  <div class="font-medium">Terjadi kesalahan:</div>
  <ul class="list-disc list-inside text-sm mt-1">
    @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
@endsection