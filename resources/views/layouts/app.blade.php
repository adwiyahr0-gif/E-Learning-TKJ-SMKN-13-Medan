<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-100 text-gray-900">
        <!-- Alpine.js wrapper untuk mengontrol buka-tutup sidebar secara reaktif -->
        <div class="min-h-screen flex" x-data="{ sidebarOpen: true }">

            <!-- SIDEBAR KIRI -->
            <aside :class="sidebarOpen ? 'translate-x-0 w-64' : '-translate-x-full lg:translate-x-0 lg:w-20'" 
                   class="fixed inset-y-0 left-0 z-50 bg-slate-900 text-slate-300 transition-all duration-300 ease-in-out flex flex-col shadow-xl overflow-hidden">
                
                <!-- Logo & Brand -->
                <div class="h-16 flex items-center justify-between px-6 bg-slate-950 border-b border-slate-800 shrink-0">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 font-bold text-lg text-white tracking-wide overflow-hidden whitespace-nowrap">
                        <span class="bg-blue-600 text-white p-1.5 rounded-lg text-sm shadow-md shrink-0">🎓</span>
                        <span x-show="sidebarOpen" class="transition-opacity duration-200">MediaJaringan</span>
                    </a>
                    <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Navigasi Menu Sidebar -->
                <div class="flex-1 px-4 py-6 space-y-2 overflow-y-auto overflow-x-hidden">
                    <div x-show="sidebarOpen" class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-3 mb-2">Menu Utama</div>
                    
                    <a href="{{ route('dashboard') }}" title="Dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                        <span class="text-lg shrink-0">📊</span> 
                        <span x-show="sidebarOpen" class="whitespace-nowrap">Dashboard</span>
                    </a>

                    <a href="{{ route('materi.routing') }}" title="Modul Materi" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('materi.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                        <span class="text-lg shrink-0">📖</span> 
                        <span x-show="sidebarOpen" class="whitespace-nowrap">Modul Materi</span>
                    </a>

                    <a href="{{ route('video.pembelajaran') }}" title="Video Pembelajaran" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-800 hover:text-white transition-colors">
                        <span class="text-lg shrink-0">▶️</span> 
                        <span x-show="sidebarOpen" class="whitespace-nowrap">Video Pembelajaran</span>
                    </a>

                    <a href="#" title="Kuis Evaluasi" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-800 hover:text-white transition-colors">
                        <span class="text-lg shrink-0">📝</span> 
                        <span x-show="sidebarOpen" class="whitespace-nowrap">Kuis Evaluasi</span>
                    </a>
                </div>

                <!-- Footer Sidebar / User Info -->
                <div class="p-4 bg-slate-950 border-t border-slate-800 shrink-0">
                    <div x-show="sidebarOpen" class="flex items-center gap-3 mb-3 px-2">
                        <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm shadow-md shrink-0">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[11px] text-slate-400 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Keluar" class="w-full bg-slate-800 hover:bg-red-600/20 hover:text-red-400 text-slate-300 text-xs font-bold py-2 px-3 rounded-lg transition-colors flex items-center justify-center gap-2">
                            <span class="text-base shrink-0">🚪</span> 
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Keluar / Logout</span>
                        </button>
                    </form>
                </div>
            </aside>

            <!-- KONTEN UTAMA DI KANAN -->
            <div class="flex-1 flex flex-col min-w-0 transition-all duration-300">
                
                <!-- Top Header dengan Tombol Hamburger Utama -->
                <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 sticky top-0 z-30 shadow-sm">
                    <div class="flex items-center gap-4">
                        <!-- Tombol Hamburger (Dijamin Tampil) -->
                        <button @click="sidebarOpen = !sidebarOpen" class="bg-blue-600 text-white hover:bg-blue-700 p-2.5 rounded-xl focus:outline-none transition-colors shadow-md flex items-center justify-center cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        
                        @isset($header)
                            <div class="font-bold text-lg text-gray-800 tracking-tight">
                                {{ $header }}
                            </div>
                        @endisset
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('profile.edit') }}" class="text-xs font-semibold bg-blue-50 text-blue-700 px-3.5 py-2 rounded-full hover:bg-blue-100 transition-colors shadow-sm">
                            ⚙️ Pengaturan Akun
                        </a>
                    </div>
                </header>

                <!-- Konten Utama Halaman -->
                <main class="flex-1">
                    {{ $slot }}
                </main>
            </div>

            <!-- Backdrop Mobile -->
            <div @click="sidebarOpen = false" :class="sidebarOpen ? 'block' : 'hidden'" class="fixed inset-0 z-40 bg-black/50 lg:hidden backdrop-blur-sm"></div>

        </div>
    </body>
</html>