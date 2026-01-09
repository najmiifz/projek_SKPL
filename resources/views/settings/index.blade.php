@extends('layouts.app')

@section('content')
  <h1 class="text-2xl font-bold mb-4">Konfigurasi Sistem</h1>
  <div class="bg-white p-4 rounded shadow">
    <form method="POST" action="#">
      @csrf
      <div class="mb-3">
        <label class="block text-sm">Nama Instansi</label>
        <input type="text" class="w-full border p-2 rounded" value="PT. Teknologi Maju">
      </div>
      <div class="flex justify-end">
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
      </div>
    </form>
  </div>
@endsection
