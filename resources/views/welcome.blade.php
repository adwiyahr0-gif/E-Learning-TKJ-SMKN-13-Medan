@php
    // ====== EDIT DATA SEKOLAH DI SINI ======
    $telepon = '08111018711';
    $alamat  = 'Jl. Seruwai No. 257, Kec. Medan Labuhan, Kota Medan, Sumatera Utara 20252';
    $email   = 'smkn13medan@gmail.com';
    $website = 'http://www.smkn13medan.sch.id/';
    $logo    = 'https://yt3.googleusercontent.com/D78HsxvMYN3Kx-iVptB1MMP7k0A-m74TdHKnUvbAuMYtN4HyZ4i7NUpLbXSC-tYHffaJMmPwhw=s900-c-k-c0x00ffffff-no-rj';

    // Foto sekolah di public/images (mengenali smkn13.jpg maupun smkn13.jpg.jpeg)
    $namaFoto = collect(['smkn13.jpg', 'smkn13.jpeg', 'smkn13.jpg.jpeg', 'smkn13.png'])
        ->first(fn ($f) => file_exists(public_path('images/' . $f))) ?? 'smkn13.jpg';
    $fotoHero = asset('images/' . $namaFoto);

    $r = fn ($name) => Route::has($name) ? route($name) : '#';
    $tel = preg_replace('/[^0-9+]/', '', $telepon);
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal E-Learning TJKT - SMK Negeri 13 Medan</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-serif:400|plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Halaman ini memakai CSS sendiri (tidak butuh Tailwind / npm run dev) -->
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { margin: 0; font-family: 'Plus Jakarta Sans', sans-serif; color: #1f2937; background: #fff; overflow-x: hidden; -webkit-font-smoothing: antialiased; }
        h1, h2, h3, h4, p, ul { margin: 0; padding: 0; }
        ul { list-style: none; }
        a { color: inherit; text-decoration: none; }
        img, svg { display: block; max-width: 100%; }
        button { font: inherit; cursor: pointer; border: 0; background: none; color: inherit; }
        hr { border: 0; border-top: 1px solid rgba(255,255,255,.2); margin: 2rem 0; }

        :root {
            --c-main: #2b4c59;
            --c-main-2: #3f7186;
            --c-dark: #1e3640;
            --c-gold: #f59e0b;
            --c-gold-2: #fcd34d;
            --c-peach: #fff5ec;
        }
        .display { font-family: 'Instrument Serif', serif; letter-spacing: -0.03em; font-weight: 400; }
        :focus-visible { outline: 3px solid var(--c-gold); outline-offset: 3px; border-radius: 10px; }
        .wrap { width: 100%; max-width: 80rem; margin: 0 auto; padding: 0 1.25rem; }
        @media (min-width: 1024px) { .wrap { padding: 0 2rem; } }
        .ic { width: 1.5rem; height: 1.5rem; flex-shrink: 0; }

        /* ===== Header ===== */
        .site-header { position: sticky; top: 0; z-index: 50; background: #fff; border-bottom: 1px solid #f3f0ea; transition: box-shadow .3s; }
        .site-header.scrolled { box-shadow: 0 6px 20px -12px rgba(0,0,0,.25); }
        .hdr-inner { height: 5rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem; }
        .brand { display: flex; align-items: center; gap: .75rem; flex-shrink: 0; }
        .brand img { width: 3rem; height: 3rem; border-radius: 50%; object-fit: contain; flex-shrink: 0; }
        .brand-name { font-weight: 700; font-size: 1.1rem; color: var(--c-main); line-height: 1.2; }
        .brand-sub { font-size: .75rem; color: #6b7280; }
        .nav-desktop, .hdr-right { display: none; align-items: center; }
        .nav-desktop { gap: 2rem; }
        .hdr-right { gap: 1.5rem; }
        .hdr-right form { margin: 0; }
        @media (min-width: 1024px) { .nav-desktop, .hdr-right { display: flex; } .menu-btn, #mobile-menu { display: none !important; } }
        .nav-a { font-weight: 500; color: #111827; padding: .25rem 0; position: relative; }
        .nav-a::after { content: ""; position: absolute; left: 0; bottom: -2px; height: 2px; width: 0; background: var(--c-gold); transition: width .25s; }
        .nav-a:hover::after, .nav-a.active::after { width: 100%; }
        .badge-user { background: var(--c-main); color: #fff; font-weight: 700; font-size: .8rem; padding: .15rem .6rem; border-radius: .4rem; text-transform: uppercase; }
        .tel { display: flex; align-items: center; gap: .5rem; font-weight: 600; }
        .tel .ic { color: var(--c-main); }
        .btn-main {
            display: inline-flex; align-items: center; gap: .75rem; font-weight: 600; font-size: 1rem;
            padding: .4rem .4rem .4rem 1.25rem; border-radius: 1rem;
            background: linear-gradient(110deg, var(--c-gold-2), var(--c-gold)); color: #1f2937;
            transition: transform .2s, box-shadow .2s;
        }
        .btn-main .arrow { width: 2.4rem; height: 2.4rem; border-radius: .8rem; background: #fff; display: grid; place-items: center; transition: transform .25s; }
        .btn-main .arrow svg { width: 1.2rem; height: 1.2rem; }
        .btn-main:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -8px rgba(245,158,11,.6); }
        .btn-main:hover .arrow { transform: translateX(3px); }
        .menu-btn { width: 2.75rem; height: 2.75rem; display: grid; place-items: center; border-radius: .75rem; }
        .menu-btn:hover { background: #f3f4f6; }
        .menu-btn svg { width: 1.5rem; height: 1.5rem; }
        #mobile-menu { border-top: 1px solid #f3f4f6; padding: .5rem 1.25rem 1.25rem; background: #fff; }
        #mobile-menu.is-hidden { display: none; }
        #mobile-menu a.m-link { display: block; padding: .75rem 0; font-weight: 600; }
        #mobile-menu .m-tel { padding: .75rem 0; font-size: .9rem; color: #6b7280; }
        #mobile-menu .btn-main { width: 100%; justify-content: space-between; }

        /* ===== Hero ===== */
        .hero { position: relative; overflow: hidden; background: #fff; min-height: calc(100vh - 5rem); }
        .arcs { position: absolute; inset: 0; width: 100%; height: 100%; pointer-events: none; opacity: .5; }
        .hero-grid { position: relative; z-index: 2; display: grid; gap: 2.5rem; align-items: center; min-height: inherit; padding-top: 3rem; padding-bottom: 3rem; }
        @media (min-width: 1024px) { .hero-grid { grid-template-columns: 1.1fr 1fr; padding-top: 0; padding-bottom: 0; } }
        .hero-text { padding-left: 0; }
        @media (min-width: 1024px) { .hero-text { padding-left: 1.5rem; } }
        .hero-title { font-size: clamp(3rem, 8vw, 6.2rem); line-height: .95; color: var(--c-main); }
        .hero-sub { font-size: clamp(1.05rem, 2vw, 1.4rem); color: #6b7280; margin-top: 1.5rem; max-width: 34rem; line-height: 1.4; }
        .hero-note { color: #6b7280; margin-top: 1.25rem; font-size: 1.05rem; }
        .hero-cta { margin-top: 2rem; }
        .spark { position: absolute; color: var(--c-dark); opacity: .85; }
        .dot { position: absolute; width: .8rem; height: .8rem; border-radius: 50%; background: #ec7ca7; left: 4%; top: 42%; animation: float 4s ease-in-out infinite; }
        @keyframes float { 50% { transform: translateY(-10px); } }

        /* ===== Hero: foto sekolah (rapi & formal) ===== */
        .hero-art {
            position: relative; width: calc(100% - 1.5rem); max-width: 38rem; aspect-ratio: 4 / 3;
            margin: 0 auto; align-self: center;
        }
        @media (min-width: 1024px) { .hero-art { margin: 0 1.5rem 0 auto; } }

        /* Blok biru di belakang (bergeser ke kanan-bawah) */
        .hero-shape {
            position: absolute; inset: 0; z-index: 1; transform: translate(1.5rem, 1.5rem);
            border-radius: 2rem;
            background: linear-gradient(160deg, var(--c-main-2), var(--c-main) 55%, var(--c-dark));
            animation: shape-in 1s cubic-bezier(.2,.7,.2,1) .1s both;
        }
        /* Garis emas tipis (bergeser ke kiri-atas) */
        .hero-art::before {
            content: ""; position: absolute; inset: 0; z-index: 1; transform: translate(-1rem, -1rem);
            border: 2px solid var(--c-gold); border-radius: 2rem;
            animation: fade-in 1s ease .9s both;
        }
        /* Bingkai foto */
        .hero-frame {
            position: absolute; inset: 0; z-index: 2; overflow: hidden;
            border-radius: 2rem; border: 6px solid #fff;
            background: var(--c-dark);
            box-shadow: 0 30px 50px -26px rgba(30,54,64,.65);
            animation: reveal 1.3s cubic-bezier(.77,0,.18,1) .3s both;
        }
        .hero-photo {
            position: absolute; inset: 0; width: 100%; height: 100%; max-width: none;
            object-fit: cover; object-position: center 60%;
            filter: contrast(1.05) saturate(1.08);
            animation: kenburns 26s ease-in-out 1.6s infinite alternate;
            will-change: transform;
        }
        /* Kilau cahaya tipis */
        .hero-sheen {
            position: absolute; inset: 0; pointer-events: none;
            background: linear-gradient(115deg, transparent 44%, rgba(255,255,255,.28) 50%, transparent 56%);
            transform: translateX(-130%);
            animation: sheen 9s ease-in-out 2.4s infinite;
        }
        .photo-empty { position: absolute; z-index: 4; left: 0; right: 0; bottom: 14%; color: #d9e6ea; text-align: center; font-size: .85rem; display: none; }

        /* Teks hero masuk bertahap */
        .hero-text > * { animation: rise .9s cubic-bezier(.2,.7,.2,1) both; }
        .hero-text > :nth-child(2) { animation-delay: .12s; }
        .hero-text > :nth-child(3) { animation-delay: .24s; }
        .hero-text > :nth-child(4) { animation-delay: .36s; }

        @keyframes shape-in { from { opacity: 0; transform: translate(3.5rem, 3.5rem); } to { opacity: 1; transform: translate(1.5rem, 1.5rem); } }
        @keyframes reveal   { from { clip-path: inset(0 100% 0 0 round 2rem); } to { clip-path: inset(0 0 0 0 round 2rem); } }
        @keyframes kenburns { from { transform: scale(1.02); } to { transform: scale(1.1) translate(-1%, -.8%); } }
        @keyframes sheen    { 0% { transform: translateX(-130%); } 35%, 100% { transform: translateX(130%); } }
        @keyframes fade-in  { from { opacity: 0; } to { opacity: 1; } }
        @keyframes rise     { from { opacity: 0; transform: translateY(26px); } to { opacity: 1; transform: none; } }

        /* ===== Aplikasi ===== */
        .apps { padding: 5rem 0; scroll-margin-top: 4rem; }
        @media (min-width: 1024px) { .apps { padding: 7rem 0; } }
        .apps-title { font-size: clamp(2.4rem, 5vw, 4rem); text-align: center; color: #111827; margin-bottom: 3rem; }
        .apps-grid { display: grid; gap: 1.25rem; grid-template-columns: repeat(2, 1fr); }
        @media (min-width: 1000px) { .apps-grid { grid-template-columns: repeat(4, 1fr); } }

        /* Teks berjalan ke samping */
        .band { background: #f8d21b; overflow: hidden; padding: 1.1rem 0; border-top: 1px solid rgba(30,54,64,.08); }
        .track { display: flex; width: max-content; animation: slide 45s linear infinite; }
        .band:hover .track { animation-play-state: paused; }
        .group { display: flex; align-items: center; gap: 2.5rem; padding-right: 2.5rem; }
        .band-item { font-family: 'Instrument Serif', serif; font-size: clamp(1.8rem, 3.6vw, 2.8rem); letter-spacing: -0.02em; line-height: 1.1; color: var(--c-dark); white-space: nowrap; }
        .band-star { width: 2.2rem; height: 2.2rem; flex-shrink: 0; color: var(--c-dark); transition: transform .6s; }
        .band:hover .band-star { transform: rotate(90deg); }
        @keyframes slide { to { transform: translateX(-50%); } }
        .app-card {
            position: relative; overflow: hidden; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 1.1rem;
            min-height: 16rem; padding: 1.5rem 1rem; border-radius: 1.6rem; background: var(--c-peach);
            text-align: center; transition: background .35s, transform .35s, box-shadow .35s;
        }
        .app-card svg { width: 3.4rem; height: 3.4rem; color: var(--c-main); transition: color .35s, transform .35s; }
        .app-card h3 { font-weight: 700; font-size: 1.1rem; color: #111827; transition: color .35s; }
        .app-card small { display: block; font-weight: 500; font-size: .78rem; color: #8a8f98; margin-top: .25rem; transition: color .35s; }
        .app-card::after {
            content: ""; position: absolute; right: 0; bottom: 0; width: 0; height: 0;
            background: linear-gradient(135deg, rgba(0,0,0,.25), var(--c-gold-2) 70%);
            clip-path: polygon(100% 0, 100% 100%, 0 100%); transition: width .35s, height .35s;
        }
        .app-card:hover, .app-card:focus-visible { background: linear-gradient(160deg, var(--c-main-2), var(--c-main)); transform: translateY(-6px); box-shadow: 0 18px 30px -14px rgba(43,76,89,.55); }
        .app-card:hover svg, .app-card:focus-visible svg { color: #fff; transform: scale(1.08); }
        .app-card:hover h3, .app-card:focus-visible h3 { color: #fff; }
        .app-card:hover small, .app-card:focus-visible small { color: #cfe0e6; }
        .app-card:hover::after, .app-card:focus-visible::after { width: 4.5rem; height: 4.5rem; }
        .soon { position: absolute; top: .9rem; right: .9rem; font-size: .65rem; font-weight: 700; padding: .15rem .55rem; border-radius: 999px; background: #fef3c7; color: #92400e; }

        /* ===== Footer ===== */
        .site-footer { background: var(--c-main); color: #fff; padding: 4rem 0 2rem; }
        .foot-grid { display: grid; gap: 3rem; }
        @media (min-width: 768px) { .foot-grid { grid-template-columns: 1fr auto; gap: 8rem; } }
        .site-footer h4 { font-size: 1.4rem; font-weight: 700; }
        .foot-label { margin-top: 1.75rem; }
        .foot-val { color: var(--c-gold-2); font-size: 1.2rem; text-decoration: underline; text-underline-offset: 4px; display: inline-block; margin-top: .25rem; }
        .foot-links { margin-top: 1rem; }
        .foot-links a { display: inline-block; padding: .45rem 0; transition: transform .2s, color .2s; }
        .foot-links a:hover { color: var(--c-gold-2); transform: translateX(4px); }
        .copy { font-size: .9rem; }
        #to-top { position: fixed; right: 1.5rem; bottom: 1.5rem; width: 3.2rem; height: 3.2rem; border-radius: 50%; background: var(--c-gold); color: #fff; display: grid; place-items: center; box-shadow: 0 10px 20px -8px rgba(0,0,0,.4); opacity: 0; transform: translateY(10px); pointer-events: none; transition: all .3s; z-index: 40; }
        #to-top svg { width: 1.3rem; height: 1.3rem; }
        #to-top.show { opacity: 1; transform: none; pointer-events: auto; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; }
            html { scroll-behavior: auto; }
            .track { width: auto; flex-wrap: wrap; justify-content: center; }
            .group[aria-hidden="true"] { display: none; }
            .group { flex-wrap: wrap; justify-content: center; }
        }
    </style>
</head>
<body>

    <!-- ================= HEADER ================= -->
    <header class="site-header" id="header">
        <div class="wrap hdr-inner">

            <a href="#beranda" class="brand">
                <img src="{{ $logo }}" alt="Logo SMK Negeri 13 Medan" width="48" height="48">
                <div>
                    <p class="brand-name">SMKN 13 Medan</p>
                    <p class="brand-sub">Portal E-Learning TJKT</p>
                </div>
            </a>

            <nav class="nav-desktop" aria-label="Navigasi utama">
                <a href="#beranda" class="nav-a active" data-nav="beranda">Beranda</a>
                <a href="#aplikasi" class="nav-a" data-nav="aplikasi">Aplikasi</a>
                @auth <span class="badge-user">{{ Str::limit(Auth::user()->name, 22) }}</span> @endauth
            </nav>

            <div class="hdr-right">
                <a href="tel:{{ $tel }}" class="tel">
                    <svg class="ic" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.3a1 1 0 01.95.68l1.5 4.5a1 1 0 01-.5 1.2l-2.26 1.13a11 11 0 005.52 5.52l1.13-2.26a1 1 0 011.2-.5l4.5 1.5a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C9.72 21 3 14.28 3 6V5z"/></svg>
                    {{ $telepon }}
                </a>

                @auth
                    <form method="POST" action="{{ route('logout') }}">@csrf
                        <button type="submit" class="btn-main">Logout <span class="arrow"><svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg></span></button>
                    </form>
                @else
                    <a href="{{ $r('login') }}" class="btn-main">Login <span class="arrow"><svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg></span></a>
                @endauth
            </div>

            <button id="menu-btn" class="menu-btn" aria-label="Buka menu" aria-expanded="false" aria-controls="mobile-menu">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>

        <div id="mobile-menu" class="is-hidden">
            <a href="#beranda" class="m-link">Beranda</a>
            <a href="#aplikasi" class="m-link">Aplikasi</a>
            <p class="m-tel">Telepon: {{ $telepon }}</p>
            @auth
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button type="submit" class="btn-main">Logout <span class="arrow">→</span></button>
                </form>
            @else
                <a href="{{ $r('login') }}" class="btn-main">Login <span class="arrow">→</span></a>
            @endauth
        </div>
    </header>

    <main>
        <!-- ================= HERO ================= -->
        <section id="beranda" class="hero">
            <svg class="arcs" viewBox="0 0 1440 700" preserveAspectRatio="xMidYMid slice" aria-hidden="true" fill="none" stroke="#9fc3cf" stroke-width="1">
                <circle cx="1250" cy="760" r="300"/><circle cx="1250" cy="760" r="400"/><circle cx="1250" cy="760" r="500"/>
                <circle cx="1250" cy="760" r="600"/><circle cx="1250" cy="760" r="700"/><circle cx="1250" cy="760" r="800"/>
            </svg>

            <svg class="spark" style="left:1.5rem; top:30%; width:2.6rem; height:2.6rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M12 2c.6 5.2 4.8 9.4 10 10-5.2.6-9.4 4.8-10 10-.6-5.2-4.8-9.4-10-10 5.2-.6 9.4-4.8 10-10z"/></svg>
            <svg class="spark" style="left:-.4rem; top:40%; width:2.2rem; height:2.2rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M12 2c.6 5.2 4.8 9.4 10 10-5.2.6-9.4 4.8-10 10-.6-5.2-4.8-9.4-10-10 5.2-.6 9.4-4.8 10-10z"/></svg>
            <span class="dot" aria-hidden="true"></span>

            <div class="wrap hero-grid">
                <div class="hero-text">
                    <h1 class="display hero-title">SMK Negeri<br>13 Medan</h1>
                    <p class="hero-sub">Portal E-Learning Teknik Jaringan Komputer dan Telekomunikasi</p>
                    <p class="hero-note">Silakan akses aplikasi yang terintegrasi di bawah ini.</p>
                    <div class="hero-cta">
                        <a href="#aplikasi" class="btn-main">Mulai belajar <span class="arrow"><svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m6-6l-6 6-6-6"/></svg></span></a>
                    </div>
                </div>

                <div class="hero-art">
                    <div class="hero-shape"></div>
                    <div class="hero-frame">
                        <img src="{{ $fotoHero }}" alt="Gerbang SMK Negeri 13 Medan" class="hero-photo" width="1537" height="1023" decoding="async" fetchpriority="high" onerror="this.style.display='none'; document.getElementById('photo-empty').style.display='block';">
                        <span class="hero-sheen" aria-hidden="true"></span>
                    </div>
                    <p id="photo-empty" class="photo-empty">Letakkan foto sekolah di <code>public/images/smkn13.jpg</code></p>
                </div>
            </div>
        </section>

        <!-- ================= PITA KUNING BERJALAN ================= -->
        @php
            $pita = ['Berkolaborasi', 'Berintegritas', 'Bersinergi', 'Teknik Jaringan Komputer', 'Routing', 'Switching', 'Subnetting', 'VLAN', 'Mikrotik', 'Fiber Optik'];
        @endphp
        <div class="band" aria-label="Motto dan topik pembelajaran TJKT">
            <div class="track">
                @foreach ([0, 1] as $salinan)
                    <div class="group" @if($salinan) aria-hidden="true" @endif>
                        @foreach ($pita as $teks)
                            <span class="band-item">{{ $teks }}</span>
                            <svg class="band-star" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 2c.6 5.2 4.8 9.4 10 10-5.2.6-9.4 4.8-10 10-.6-5.2-4.8-9.4-10-10 5.2-.6 9.4-4.8 10-10z"/></svg>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>

        <!-- ================= APLIKASI TERINTEGRASI ================= -->
        <section id="aplikasi" class="apps">
            <div class="wrap">
                <h2 class="display apps-title">Aplikasi Terintegrasi</h2>

                <div class="apps-grid">
                    <a href="{{ $r('materi.routing') }}" class="app-card">
                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.25v13m0-13C10.83 5.48 9.25 5 7.5 5S4.17 5.48 3 6.25v13C4.17 18.48 5.75 18 7.5 18s3.33.48 4.5 1.25m0-13C13.17 5.48 14.75 5 16.5 5c1.75 0 3.33.48 4.5 1.25v13C19.83 18.48 18.25 18 16.5 18c-1.75 0-3.33.48-4.5 1.25"/></svg>
                        <h3>Modul Materi<small>Materi routing</small></h3>
                    </a>

                    <a href="{{ $r('video.animasi') }}" class="app-card">
                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.75 11.17l-3.2-2.13A1 1 0 0010 9.87v4.26a1 1 0 001.55.83l3.2-2.13a1 1 0 000-1.66z"/><circle cx="12" cy="12" r="9"/></svg>
                        <h3>Video Animasi<small>Belajar sambil menonton</small></h3>
                    </a>

                    <a href="{{ $r('kuis.evaluasi') }}" class="app-card">
                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        <h3>Kuis Evaluasi<small>Uji pemahamanmu</small></h3>
                    </a>

                    <a href="{{ $r('ai.tutor.index') }}" class="app-card">
                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.42-4.03 8-9 8a9.9 9.9 0 01-4-.8L3 20l1.3-3.9A7.6 7.6 0 013 12c0-4.42 4.03-8 9-8s9 3.58 9 8z"/></svg>
                        <h3>AI Tutor Pintar<small>Tanya apa saja</small></h3>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- ================= FOOTER ================= -->
    <footer class="site-footer">
        <div class="wrap">
            <div class="foot-grid">
                <div>
                    <h4>Hubungi Kami</h4>
                    <p class="foot-label">Telepon</p>
                    <a href="tel:{{ $tel }}" class="foot-val">{{ $telepon }}</a>
                    <p class="foot-label">Alamat</p>
                    <p class="foot-val">{{ $alamat }}</p>
                    <p class="foot-label">Email</p>
                    <a href="mailto:{{ $email }}" class="foot-val">{{ $email }}</a>
                </div>
                <div>
                    <h4>Link Terkait</h4>
                    <ul class="foot-links">
                        <li><a href="{{ $website }}" target="_blank" rel="noopener">Website Sekolah</a></li>
                        <li><a href="#">Info Kelulusan</a></li>
                        <li><a href="#">PPDB Online</a></li>
                        <li><a href="#">Jurusan TJKT</a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <p class="copy">Copyright © 2026 SMK Negeri 13 Medan.</p>
        </div>
    </footer>

    <button id="to-top" aria-label="Kembali ke atas">
        <svg fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
    </button>

    <script>
        (function () {
            const header = document.getElementById('header');
            const toTop = document.getElementById('to-top');
            const links = document.querySelectorAll('[data-nav]');

            function onScroll() {
                header.classList.toggle('scrolled', window.scrollY > 10);
                toTop.classList.toggle('show', window.scrollY > 500);
            }
            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();

            toTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

            const io = new IntersectionObserver(es => es.forEach(e => {
                if (e.isIntersecting) links.forEach(l => l.classList.toggle('active', l.dataset.nav === e.target.id));
            }), { rootMargin: '-40% 0px -55% 0px' });
            ['beranda', 'aplikasi'].forEach(id => io.observe(document.getElementById(id)));

            const btn = document.getElementById('menu-btn'), menu = document.getElementById('mobile-menu');
            btn.addEventListener('click', () => {
                const open = menu.classList.toggle('is-hidden') === false;
                btn.setAttribute('aria-expanded', open);
            });
            document.querySelectorAll('.m-link').forEach(a => a.addEventListener('click', () => { menu.classList.add('is-hidden'); btn.setAttribute('aria-expanded', false); }));
        })();
    </script>
</body>
</html>