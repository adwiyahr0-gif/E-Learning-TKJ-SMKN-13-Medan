<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- CSS khusus layout (diawali "sb-", tidak bergantung pada Tailwind) -->
        <style>
            [x-cloak] { display: none !important; }

            .sb-root {
                --c-main: #2b4c59; --c-main-2: #3f7186; --c-dark: #1e3640;
                --c-gold: #f59e0b; --c-gold-2: #fcd34d; --c-peach: #fff5ec; --c-line: #f1e3d3;
                min-height: 100vh; display: flex; background: #fff;
            }
            .sb-root, .sb-root *, .sb-root *::before, .sb-root *::after { box-sizing: border-box; }
            .sb-root a { text-decoration: none; color: inherit; }
            .sb-root button { font: inherit; cursor: pointer; border: 0; background: none; color: inherit; }
            .sb-root svg { display: block; flex: none; }
            .sb-root :focus-visible { outline: 3px solid var(--c-gold); outline-offset: 2px; border-radius: 12px; }

            /* ===== Sidebar ===== */
            .sb-aside {
                position: sticky; top: 0; height: 100vh; width: 5rem; flex: none; z-index: 50;
                display: flex; flex-direction: column; color: #cfe0e6;
                background: linear-gradient(180deg, var(--c-dark), #172b33 70%, #12222a);
                box-shadow: 8px 0 30px -18px rgba(30,54,64,.7);
                transition: width .3s ease, transform .3s ease;
            }
            .sb-aside.is-open { width: 16rem; }
            .sb-arcs { position: absolute; left: -45%; bottom: -12%; width: 26rem; opacity: .07; pointer-events: none; }

            .sb-top { position: relative; height: 4rem; display: flex; align-items: center; justify-content: space-between; gap: .5rem; padding: 0 1rem; border-bottom: 1px solid rgba(255,255,255,.08); }
            .sb-logo { display: flex; align-items: center; gap: .65rem; overflow: hidden; white-space: nowrap; }
            .sb-logo-ic { width: 2.4rem; height: 2.4rem; border-radius: .85rem; display: grid; place-items: center; color: #1f2937; background: linear-gradient(110deg, var(--c-gold-2), var(--c-gold)); box-shadow: 0 10px 18px -10px rgba(245,158,11,.8); }
            .sb-logo-ic svg { width: 1.3rem; height: 1.3rem; }
            .sb-logo-name { font-weight: 700; font-size: 1.02rem; color: #fff; letter-spacing: .01em; }
            .sb-toggle { width: 2.2rem; height: 2.2rem; border-radius: .75rem; display: grid; place-items: center; background: rgba(255,255,255,.08); color: #cfe0e6; transition: background .2s, color .2s; }
            .sb-toggle:hover { background: rgba(255,255,255,.16); color: #fff; }
            .sb-toggle svg { width: 1.15rem; height: 1.15rem; }

            .sb-nav { position: relative; flex: 1; padding: 1.25rem .75rem; display: grid; align-content: start; gap: .4rem; overflow-y: auto; overflow-x: hidden; }
            .sb-label { padding: 0 .75rem; margin-bottom: .35rem; font-size: .68rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: #6f8d99; }
            .sb-label.sb-label-gap { margin-top: 1rem; }
            .sb-divider { height: 1px; background: rgba(255,255,255,.08); margin: .75rem .5rem .25rem; }
            .sb-link { display: flex; align-items: center; gap: .85rem; padding: .75rem; border-radius: 1rem; font-size: .9rem; font-weight: 600; white-space: nowrap; color: #cfe0e6; transition: background .25s, color .25s, transform .25s; }
            .sb-link svg { width: 1.35rem; height: 1.35rem; }
            .sb-link:hover { background: rgba(255,255,255,.09); color: #fff; transform: translateX(3px); }
            .sb-link.active { color: #1f2937; background: linear-gradient(110deg, var(--c-gold-2), var(--c-gold)); box-shadow: 0 14px 22px -14px rgba(245,158,11,.8); }
            .sb-link.active:hover { transform: none; }
            .sb-aside:not(.is-open) .sb-link { justify-content: center; }
            .sb-aside:not(.is-open) .sb-top { justify-content: center; padding: 0; }
            .sb-aside:not(.is-open) .sb-logo { display: none; }

            .sb-foot { position: relative; padding: .85rem; border-top: 1px solid rgba(255,255,255,.08); background: rgba(0,0,0,.18); }
            .sb-user { display: flex; align-items: center; gap: .7rem; padding: 0 .35rem; margin-bottom: .75rem; }
            .sb-avatar { flex: none; width: 2.3rem; height: 2.3rem; border-radius: 50%; display: grid; place-items: center; font-weight: 700; font-size: .85rem; color: #1f2937; background: linear-gradient(110deg, var(--c-gold-2), var(--c-gold)); }
            .sb-user-name { font-size: .82rem; font-weight: 700; color: #fff; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
            .sb-user-mail { font-size: .68rem; color: #8fa9b4; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
            .sb-user > div:last-child { min-width: 0; }
            .sb-logout { width: 100%; display: flex; align-items: center; justify-content: center; gap: .55rem; padding: .6rem .75rem; border-radius: .9rem; font-size: .82rem; font-weight: 700; color: #cfe0e6; background: rgba(255,255,255,.08); transition: background .2s, color .2s; }
            .sb-logout:hover { background: rgba(239,68,68,.2); color: #fca5a5; }
            .sb-logout svg { width: 1.1rem; height: 1.1rem; }

            .sb-backdrop { position: fixed; inset: 0; z-index: 45; background: rgba(30,54,64,.55); backdrop-filter: blur(3px); }

            /* ===== Konten ===== */
            .sb-body { flex: 1; min-width: 0; display: flex; flex-direction: column; }
            .sb-header { position: sticky; top: 0; z-index: 30; height: 4rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding: 0 1rem; background: rgba(255,255,255,.88); backdrop-filter: blur(10px); border-bottom: 1px solid var(--c-line); }
            @media (min-width: 768px) { .sb-header { padding: 0 1.5rem; } }
            .sb-head-left { display: flex; align-items: center; gap: .75rem; min-width: 0; }
            .sb-burger { display: none; width: 2.4rem; height: 2.4rem; border-radius: .8rem; place-items: center; background: var(--c-peach); border: 1px solid var(--c-line); color: var(--c-main); }
            .sb-burger svg { width: 1.2rem; height: 1.2rem; }
            .sb-head-title { min-width: 0; overflow: hidden; }
            .sb-account { flex: none; display: inline-flex; align-items: center; gap: .5rem; padding: .5rem .95rem; border-radius: 999px; font-size: .8rem; font-weight: 700; color: var(--c-main); background: var(--c-peach); border: 1px solid var(--c-line); transition: background .2s, color .2s, border-color .2s; }
            .sb-account svg { width: 1rem; height: 1rem; }
            .sb-account:hover { background: var(--c-main); border-color: var(--c-main); color: #fff; }
            .sb-account span { display: none; }
            @media (min-width: 640px) { .sb-account span { display: inline; } }
            .sb-main { flex: 1; background: #fff; }

            /* ===== Mobile: sidebar jadi panel geser ===== */
            @media (max-width: 767px) {
                .sb-aside { position: fixed; left: 0; top: 0; width: 16rem; transform: translateX(-100%); }
                .sb-aside.is-open { transform: translateX(0); }
                .sb-burger { display: grid; }
            }
            @media (min-width: 768px) { .sb-backdrop { display: none !important; } }

            @media (prefers-reduced-motion: reduce) { .sb-root *, .sb-root *::before, .sb-root *::after { transition: none !important; animation: none !important; } }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-900" x-data="{ sidebarOpen: window.innerWidth >= 768 }">

        <div class="sb-root">

            <!-- Latar gelap di HP saat sidebar terbuka -->
            <div class="sb-backdrop" x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" aria-hidden="true"></div>

            <!-- ============ SIDEBAR ============ -->
            <aside class="sb-aside" :class="{ 'is-open': sidebarOpen }" aria-label="Menu utama">
                <svg class="sb-arcs" viewBox="0 0 600 600" fill="none" stroke="#fff" stroke-width="1" aria-hidden="true">
                    <circle cx="300" cy="300" r="80"/><circle cx="300" cy="300" r="140"/><circle cx="300" cy="300" r="200"/><circle cx="300" cy="300" r="260"/><circle cx="300" cy="300" r="320"/>
                </svg>

                <!-- Logo & tombol toggle -->
                <div class="sb-top">
                    <div class="sb-logo">
                        <span class="sb-logo-ic" aria-hidden="true">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4L2 9l10 5 10-5-10-5zM6 11.5V16c0 1.4 2.7 3 6 3s6-1.6 6-3v-4.5"/></svg>
                        </span>
                        <span class="sb-logo-name" x-show="sidebarOpen" x-cloak>MediaJaringan</span>
                    </div>
                    <button type="button" class="sb-toggle" @click="sidebarOpen = !sidebarOpen" title="Buka/tutup menu" aria-label="Buka atau tutup menu">
                        <svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>

                <!-- Navigasi -->
                <nav class="sb-nav">
                    <div class="sb-label" x-show="sidebarOpen" x-cloak>Menu utama</div>

                    <a href="{{ route('dashboard') }}" title="Dashboard" class="sb-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" @if(request()->routeIs('dashboard')) aria-current="page" @endif>
                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/></svg>
                        <span x-show="sidebarOpen" x-cloak>Dashboard</span>
                    </a>

                    <a href="{{ route('materi.routing') }}" title="Modul Materi" class="sb-link {{ request()->routeIs('materi.*') ? 'active' : '' }}" @if(request()->routeIs('materi.*')) aria-current="page" @endif>
                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.25v13m0-13C10.83 5.48 9.25 5 7.5 5S4.17 5.48 3 6.25v13C4.17 18.48 5.75 18 7.5 18s3.33.48 4.5 1.25m0-13C13.17 5.48 14.75 5 16.5 5c1.75 0 3.33.48 4.5 1.25v13C19.83 18.48 18.25 18 16.5 18c-1.75 0-3.33.48-4.5 1.25"/></svg>
                        <span x-show="sidebarOpen" x-cloak>Modul Materi</span>
                    </a>

                    <a href="{{ route('video.animasi') }}" title="Video Animasi" class="sb-link {{ request()->routeIs('video.*') ? 'active' : '' }}" @if(request()->routeIs('video.*')) aria-current="page" @endif>
                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.75 11.17l-3.2-2.13A1 1 0 0010 9.87v4.26a1 1 0 001.55.83l3.2-2.13a1 1 0 000-1.66z"/><circle cx="12" cy="12" r="9"/></svg>
                        <span x-show="sidebarOpen" x-cloak>Video Animasi</span>
                    </a>

                    <a href="{{ route('kuis.evaluasi') }}" title="Kuis Evaluasi" class="sb-link {{ request()->routeIs('kuis.*') ? 'active' : '' }}" @if(request()->routeIs('kuis.*')) aria-current="page" @endif>
                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        <span x-show="sidebarOpen" x-cloak>Kuis Evaluasi</span>
                    </a>

                    @if(Route::has('ai.tutor.index'))
                    <a href="{{ route('ai.tutor.index') }}" title="Tanya AI Tutor" class="sb-link {{ request()->routeIs('ai.*') ? 'active' : '' }}" @if(request()->routeIs('ai.*')) aria-current="page" @endif>
                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.42-4.03 8-9 8a9.9 9.9 0 01-4-.8L3 20l1.3-3.9A7.6 7.6 0 013 12c0-4.42 4.03-8 9-8s9 3.58 9 8z"/></svg>
                        <span x-show="sidebarOpen" x-cloak>Tanya AI Tutor</span>
                    </a>
                    @endif

                    {{-- ===== PANEL GURU (hanya tampil untuk guru) ===== --}}
                    @if(Auth::user()->role === 'guru' && Route::has('guru.nilai'))
                        <div class="sb-divider" x-show="!sidebarOpen" x-cloak></div>
                        <div class="sb-label sb-label-gap" x-show="sidebarOpen" x-cloak>Panel guru</div>

                        <a href="{{ route('guru.nilai') }}" title="Nilai Siswa" class="sb-link {{ request()->routeIs('guru.nilai') ? 'active' : '' }}" @if(request()->routeIs('guru.nilai')) aria-current="page" @endif>
                            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 20V10m6 10V4m6 16v-7m4 7H2"/></svg>
                            <span x-show="sidebarOpen" x-cloak>Nilai Siswa</span>
                        </a>

                        <a href="{{ route('guru.materi.index') }}" title="Kelola Materi" class="sb-link {{ request()->routeIs('guru.materi.*') ? 'active' : '' }}" @if(request()->routeIs('guru.materi.*')) aria-current="page" @endif>
                            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 3H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V8l-5-5zm0 0v5h5M12 11v6m-3-3h6"/></svg>
                            <span x-show="sidebarOpen" x-cloak>Kelola Materi</span>
                        </a>

                        <a href="{{ route('guru.siswa.index') }}" title="Akun Siswa" class="sb-link {{ request()->routeIs('guru.siswa.*') ? 'active' : '' }}" @if(request()->routeIs('guru.siswa.*')) aria-current="page" @endif>
                            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 20v-1a4 4 0 00-4-4H7a4 4 0 00-4 4v1m13-9a3.5 3.5 0 100-7m5 16v-1a4 4 0 00-3-3.9M9.5 11a3.5 3.5 0 100-7 3.5 3.5 0 000 7z"/></svg>
                            <span x-show="sidebarOpen" x-cloak>Akun Siswa</span>
                        </a>
                    @endif
                </nav>

                <!-- Info pengguna & keluar -->
                <div class="sb-foot">
                    <div class="sb-user" x-show="sidebarOpen" x-cloak>
                        <div class="sb-avatar">{{ strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}</div>
                        <div>
                            <p class="sb-user-name">{{ Auth::user()->name }}</p>
                            <p class="sb-user-mail">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="sb-logout" title="Keluar">
                            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12H3m0 0l4-4m-4 4l4 4M10 5V4a1 1 0 011-1h8a1 1 0 011 1v16a1 1 0 01-1 1h-8a1 1 0 01-1-1v-1"/></svg>
                            <span x-show="sidebarOpen" x-cloak>Keluar</span>
                        </button>
                    </form>
                </div>
            </aside>

            <!-- ============ KONTEN UTAMA ============ -->
            <div class="sb-body">

                <header class="sb-header">
                    <div class="sb-head-left">
                        <!-- Tombol menu khusus HP (sidebar tersembunyi di layar kecil) -->
                        <button type="button" class="sb-burger" @click="sidebarOpen = true" aria-label="Buka menu">
                            <svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        <div class="sb-head-title">
                            @isset($header)
                                <div class="font-bold text-lg text-gray-800 tracking-tight">
                                    {{ $header }}
                                </div>
                            @endisset
                        </div>
                    </div>

                    <a href="{{ route('profile.edit') }}" class="sb-account" title="Pengaturan akun">
                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 100-8 4 4 0 000 8zm-7 9a7 7 0 0114 0"/></svg>
                        <span>Pengaturan Akun</span>
                    </a>
                </header>

                <main class="sb-main">
                    {{ $slot }}
                </main>
            </div>

        </div>
    </body>
</html>