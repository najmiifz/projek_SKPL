<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>PMS</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">
  @if(auth()->check())
  <div class="flex min-h-screen">
    @php $u = auth()->user(); @endphp
    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-white min-h-screen flex flex-col">
      <!-- Header -->
      <div class="p-4 border-b border-slate-700">
        <h1 class="font-bold text-lg">PMS v1.0</h1>
      </div>
      
      <!-- Navigation -->
      <nav class="flex-1 p-4">
        <div class="space-y-2">
          <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-blue-600' : 'hover:bg-slate-800' }}">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
              <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
            </svg>
            Dashboard
          </a>
          
          @if($u->role === 'admin')
          <a href="{{ route('users.index') }}" class="flex items-center px-3 py-2 rounded-lg {{ request()->routeIs('users.*') ? 'bg-blue-600' : 'hover:bg-slate-800' }}">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
            </svg>
            Manajemen User
          </a>
          <a href="{{ route('settings') }}" class="flex items-center px-3 py-2 rounded-lg {{ request()->routeIs('settings') ? 'bg-blue-600' : 'hover:bg-slate-800' }}">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
            </svg>
            Konfigurasi
          </a>
          @endif
          
          @if($u->role === 'pm')
          <a href="{{ route('projects.index') }}" class="flex items-center px-3 py-2 rounded-lg {{ request()->routeIs('projects.*') ? 'bg-blue-600' : 'hover:bg-slate-800' }}">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
              <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
            </svg>
            Proyek Saya
          </a>
          @endif
          
          @if($u->role === 'member')
          <a href="{{ route('tasks.index') }}" class="flex items-center px-3 py-2 rounded-lg {{ request()->routeIs('tasks.*') ? 'bg-blue-600' : 'hover:bg-slate-800' }}">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
            </svg>
            Tugas Saya
          </a>
          @endif
        </div>
      </nav>
      
      <!-- User Profile -->
      <div class="p-4 border-t border-slate-700">
        <div class="flex items-center">
          <img src="{{ $u->avatar ?? 'https://i.pravatar.cc/40' }}" class="w-8 h-8 rounded-full mr-3" alt="">
          <div class="flex-1 min-w-0">
            <p class="text-sm font-medium truncate">{{ $u->name }}</p>
            <p class="text-xs text-slate-400 capitalize">{{ $u->role }}</p>
          </div>
          <form method="POST" action="{{ route('logout') }}" class="ml-3">
            @csrf
            <button type="submit" class="text-slate-400 hover:text-white">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
              </svg>
            </button>
          </form>
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1">
      <!-- Header -->
      <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between">
        <h2 class="text-xl font-semibold text-slate-800">
          @if(request()->routeIs('dashboard')) Dashboard Overview
          @elseif(request()->routeIs('users.*')) Manajemen Pengguna
          @elseif(request()->routeIs('projects.*')) Manajemen Proyek
          @elseif(request()->routeIs('tasks.*')) Manajemen Tugas
          @elseif(request()->routeIs('settings')) Konfigurasi Sistem
          @else {{ $page_title ?? 'Dashboard' }}
          @endif
        </h2>
        <div class="flex items-center space-x-4">
          <button class="relative p-2 text-slate-400 hover:text-slate-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
          </button>
        </div>
      </header>
      
      <!-- Page Content -->
      <div class="p-6">
        @if(session('status'))
          <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('status') }}</div>
        @endif
        @yield('content')
      </div>
    </main>
  </div>
  @else
  <div class="min-h-screen flex items-center justify-center bg-slate-50">
    <div class="max-w-md w-full p-6">
      @yield('content')
    </div>
  </div>
  @endif
</body>
</html>
