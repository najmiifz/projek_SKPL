@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-12">
  <div class="bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Login</h2>
    <form method="POST" action="{{ route('login.attempt') }}">
      @csrf
      <div class="mb-3">
        <label class="block text-sm">Email</label>
        <input type="email" name="email" class="w-full border p-2 rounded" required>
      </div>
      <div class="mb-3">
        <label class="block text-sm">Password</label>
        <input type="password" name="password" class="w-full border p-2 rounded" required>
      </div>
      <div class="flex justify-end">
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Login</button>
      </div>
    </form>
  </div>
</div>
@endsection
