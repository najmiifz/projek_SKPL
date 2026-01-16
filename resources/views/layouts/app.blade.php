<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>SIMPRO - Project Management System</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">
  @if(auth()->check())
  <div class="flex min-h-screen">
    @php $u = auth()->user(); @endphp
    <!-- Sidebar -->
    <aside class="w-72 bg-[#0F172A] text-white min-h-screen flex flex-col shadow-2xl transition-all duration-300 relative group overflow-hidden">
      <!-- Background pattern -->
      <div class="absolute inset-0 opacity-[0.03] pointer-events-none group-hover:opacity-[0.05] transition-opacity duration-500" style="background-image: url('data:image/svg+xml,%3Csvg width=%2760%27 height=%2760%27 viewBox=%270 0 60 60%27 xmlns=%27http://www.w3.org/2000/svg%27%3E%3Cg fill=%27none%27 fill-rule=%27evenodd%27%3E%3Cg fill=%27%23ffffff%27 fill-opacity=%271%27%3E%3Cpath d=%27M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z%27/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"></div>
      
      <!-- Header -->
      <div class="p-6 border-b border-slate-800/50 flex flex-col gap-4 relative">
        <div class="flex items-center gap-3">
          <div class="relative">
            <div class="absolute inset-0 bg-blue-500 blur-md opacity-20 rounded-xl"></div>
            <img src="{{ asset('img/logo simpro.jpeg') }}" alt="SIMPRO Logo" class="relative w-12 h-12 rounded-xl object-cover shadow-2xl border border-slate-700/50 transform group-hover:scale-105 transition duration-500">
          </div>
          <div>
            <h1 class="font-black text-2xl tracking-tighter text-white uppercase italic">SIM<span class="text-blue-500">PRO</span></h1>
            <div class="flex items-center gap-1.5 mt-0.5">
              <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
              <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em]">System v1.0</p>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Navigation -->
      <nav class="flex-1 px-4 py-6 overflow-y-auto custom-scrollbar relative">
        <div class="space-y-6">
          
          {{-- ========== ADMIN MENU ========== --}}
          @if($u->role === 'admin')
          <div class="space-y-2">
            <p class="px-4 text-[11px] font-black text-slate-500 uppercase tracking-[0.2em] flex items-center gap-2">
                <span class="w-4 h-[1px] bg-slate-800"></span> Admin Console
            </p>
            
            <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.dashboard') || request()->routeIs('dashboard') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-900/40' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
              <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors {{ request()->routeIs('admin.dashboard') || request()->routeIs('dashboard') ? 'bg-white/20' : 'bg-slate-800 group-hover:bg-slate-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
              </div>
              <span class="font-semibold tracking-wide">Dashboard Global</span>
              @if(request()->routeIs('admin.dashboard') || request()->routeIs('dashboard'))
                <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
              @endif
            </a>
            
            <a href="{{ route('users.index') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('users.*') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-900/40' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
              <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors {{ request()->routeIs('users.*') ? 'bg-white/20' : 'bg-slate-800 group-hover:bg-slate-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
              </div>
              <span class="font-semibold tracking-wide">Kelola Pengguna</span>
            </a>
            
            <a href="{{ route('admin.projects') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.projects') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-900/40' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
              <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors {{ request()->routeIs('admin.projects') ? 'bg-white/20' : 'bg-slate-800 group-hover:bg-slate-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
              </div>
              <span class="font-semibold tracking-wide">Semua Proyek</span>
            </a>
            
            <a href="{{ route('admin.logs') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.logs') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-900/40' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
              <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors {{ request()->routeIs('admin.logs') ? 'bg-white/20' : 'bg-slate-800 group-hover:bg-slate-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
              </div>
              <span class="font-semibold tracking-wide">Log Aktivitas</span>
            </a>
          </div>
          @endif
          
          {{-- ========== PROJECT MANAGER MENU ========== --}}
          @if($u->role === 'pm')
          <div class="space-y-2">
            <p class="px-4 text-[11px] font-black text-slate-500 uppercase tracking-[0.2em] flex items-center gap-2">
                <span class="w-4 h-[1px] bg-slate-800"></span> Management
            </p>
            
            <a href="{{ route('dashboard') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-900/40' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
              <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors {{ request()->routeIs('dashboard') ? 'bg-white/20' : 'bg-slate-800 group-hover:bg-slate-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
              </div>
              <span class="font-semibold tracking-wide">Dashboard</span>
            </a>
            
            <a href="{{ route('projects.index') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('projects.index') || request()->routeIs('projects.create') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-900/40' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
              <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors {{ request()->routeIs('projects.index') || request()->routeIs('projects.create') ? 'bg-white/20' : 'bg-slate-800 group-hover:bg-slate-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
              </div>
              <span class="font-semibold tracking-wide">Kelola Proyek</span>
            </a>
            
            <a href="{{ route('tasks.index') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('tasks.index') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-900/40' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
              <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors {{ request()->routeIs('tasks.index') ? 'bg-white/20' : 'bg-slate-800 group-hover:bg-slate-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
              </div>
              <span class="font-semibold tracking-wide">Kelola Tugas</span>
            </a>
          </div>
          @endif
          
          {{-- ========== MEMBER/ANGGOTA MENU ========== --}}
          @if($u->role === 'member')
          <div class="space-y-2">
            <p class="px-4 text-[11px] font-black text-slate-500 uppercase tracking-[0.2em] flex items-center gap-2">
                <span class="w-4 h-[1px] bg-slate-800"></span> Workspace
            </p>
            
            <a href="{{ route('dashboard') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-900/40' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
              <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors {{ request()->routeIs('dashboard') ? 'bg-white/20' : 'bg-slate-800 group-hover:bg-slate-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
              </div>
              <span class="font-semibold tracking-wide">Dashboard</span>
            </a>
            
            <a href="{{ route('tasks.my-tasks') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('tasks.my-tasks') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-900/40' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
              <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors {{ request()->routeIs('tasks.my-tasks') ? 'bg-white/20' : 'bg-slate-800 group-hover:bg-slate-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
              </div>
              <span class="font-semibold tracking-wide">Tugas Saya</span>
            </a>
          </div>
          @endif
          
          {{-- ========== COMMON MENU ========== --}}
          <div class="space-y-2">
            <p class="px-4 text-[11px] font-black text-slate-500 uppercase tracking-[0.2em] flex items-center gap-2">
                <span class="w-4 h-[1px] bg-slate-800"></span> Personal
            </p>
            
            <a href="{{ route('notifications') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('notifications') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-900/40' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
              <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors {{ request()->routeIs('notifications') ? 'bg-white/20' : 'bg-slate-800 group-hover:bg-slate-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
              </div>
              <span class="font-semibold tracking-wide">Notifikasi</span>
              @php $unreadCount = \App\Models\NotificationItem::where('user_id', $u->id)->where('read', false)->count(); @endphp
              @if($unreadCount > 0)
                <span class="ml-auto bg-red-500 text-[10px] font-bold px-2 py-0.5 rounded-full ring-2 ring-[#0F172A]">{{ $unreadCount }}</span>
              @endif
            </a>
            
            <a href="{{ route('profile.edit') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('profile.*') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-900/40' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
              <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors {{ request()->routeIs('profile.*') ? 'bg-white/20' : 'bg-slate-800 group-hover:bg-slate-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
              </div>
              <span class="font-semibold tracking-wide">Profil Saya</span>
            </a>
          </div>
        </div>
      </nav>
      
      <!-- User Profile Footer -->
      <div class="p-6 border-t border-slate-800/50 bg-slate-800/10 relative">
        <div class="flex items-center gap-3">
          <div class="relative group">
            <div class="absolute inset-0 bg-blue-500 blur-sm opacity-0 group-hover:opacity-30 transition-opacity duration-300 rounded-full"></div>
            <img src="{{ $u->avatar ?? 'https://i.pravatar.cc/40?u='.$u->email }}" class="relative w-11 h-11 rounded-full border-2 border-slate-700 object-cover shadow-xl" alt="">
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-sm font-bold text-white truncate leading-tight">{{ $u->name }}</p>
            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider mt-0.5">{{ $u->role === 'pm' ? 'Project Manager' : ($u->role === 'admin' ? 'Administrator' : 'Team Member') }}</p>
          </div>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="p-2 text-slate-500 hover:text-red-400 hover:bg-red-400/10 rounded-xl transition-all duration-300" title="Logout">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
              </svg>
            </button>
          </form>
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col bg-[#F8FAFC]">
      <!-- CSS Overrides -->
      <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.05); border-radius: 10px; }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); }
      </style>
      
      <!-- Header -->
      <header class="bg-white/80 backdrop-blur-md border-b border-slate-200 px-8 py-5 flex items-center justify-between sticky top-0 z-40 shadow-sm">
        <h2 class="text-xl font-semibold text-slate-800">
          @yield('page-title', 'Dashboard')
        </h2>
        <div class="flex items-center space-x-4">
          <a href="{{ route('notifications') }}" class="relative p-2 text-slate-400 hover:text-slate-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            @if(isset($unreadCount) && $unreadCount > 0)
            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            @endif
          </a>
          <span class="text-sm text-slate-500">{{ now()->format('d M Y') }}</span>
        </div>
      </header>
      
      <!-- Page Content -->
      <div class="flex-1 p-6 overflow-y-auto">
        @if(session('status'))
          <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('status') }}
          </div>
        @endif
        @if(session('error'))
          <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
            {{ session('error') }}
          </div>
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
