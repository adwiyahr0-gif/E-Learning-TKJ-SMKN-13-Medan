@php
    $logo = 'https://yt3.googleusercontent.com/D78HsxvMYN3Kx-iVptB1MMP7k0A-m74TdHKnUvbAuMYtN4HyZ4i7NUpLbXSC-tYHffaJMmPwhw=s900-c-k-c0x00ffffff-no-rj';
    $emailUser = optional(Auth::user())->email;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Email - SMK Negeri 13 Medan</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-serif:400|plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- CSS sendiri, tidak butuh Tailwind / npm run dev -->
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body { margin: 0; font-family: 'Plus Jakarta Sans', sans-serif; color: #1f2937; background: #fff; -webkit-font-smoothing: antialiased; }
        h1, h2, p { margin: 0; }
        a { color: inherit; text-decoration: none; }
        img, svg { display: block; max-width: 100%; }
        button, input { font: inherit; }
        button { cursor: pointer; border: 0; background: none; color: inherit; }
        :root { --c-main: #2b4c59; --c-main-2: #3f7186; --c-dark: #1e3640; --c-gold: #f59e0b; --c-gold-2: #fcd34d; --c-peach: #fff5ec; }
        :focus-visible { outline: 3px solid var(--c-gold); outline-offset: 3px; border-radius: 10px; }
        .display { font-family: 'Instrument Serif', serif; font-weight: 400; letter-spacing: -0.03em; }

        .page { min-height: 100vh; display: grid; grid-template-columns: 1fr; }
        @media (min-width: 960px) { .page { grid-template-columns: 1.05fr 1fr; } }

        /* ===== Panel kiri ===== */
        .side {
            position: relative; overflow: hidden; color: #fff;
            background: linear-gradient(160deg, var(--c-main-2), var(--c-main) 55%, var(--c-dark));
            padding: 2rem 1.5rem 2.5rem; display: flex; flex-direction: column; justify-content: space-between; gap: 2rem;
        }
        @media (min-width: 960px) { .side { padding: 3rem 3.5rem; } }
        .side-arcs { position: absolute; right: -10%; bottom: -30%; width: 120%; max-width: 46rem; opacity: .25; pointer-events: none; }
        .brand { position: relative; display: flex; align-items: center; gap: .75rem; }
        .brand img { width: 3rem; height: 3rem; border-radius: 50%; background: #fff; padding: 2px; object-fit: contain; flex-shrink: 0; }
        .brand b { display: block; font-size: 1.05rem; }
        .brand small { font-size: .75rem; color: #cfe0e6; }
        .side-body { position: relative; }
        .side-title { font-size: clamp(2.4rem, 5vw, 4.2rem); line-height: 1; }
        .side-text { margin-top: 1rem; color: #cfe0e6; max-width: 28rem; line-height: 1.6; display: none; }
        @media (min-width: 960px) { .side-text { display: block; } }
        .motto { position: relative; font-size: .9rem; color: var(--c-gold-2); font-weight: 600; display: none; }
        @media (min-width: 960px) { .motto { display: block; } }
        .spark { position: absolute; color: var(--c-gold-2); opacity: .8; animation: twinkle 3.5s ease-in-out infinite; }
        @keyframes twinkle { 50% { opacity: .25; transform: scale(.85) rotate(20deg); } }

        /* ===== Panel isi ===== */
        .main { display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 2.5rem 1.25rem; background: #fff; }
        .card { width: 100%; max-width: 26rem; }
        .badge { width: 3.4rem; height: 3.4rem; border-radius: 1.1rem; background: var(--c-peach); border: 1.5px solid #f1e3d3; display: grid; place-items: center; color: var(--c-main); margin-bottom: 1.25rem; animation: bob 3s ease-in-out infinite; }
        .badge svg { width: 1.7rem; height: 1.7rem; }
        @keyframes bob { 50% { transform: translateY(-5px); } }
        .title { font-size: 2.6rem; line-height: 1; color: var(--c-main); }
        .lead { color: #6b7280; margin-top: .6rem; line-height: 1.6; }
        .email-chip {
            display: inline-flex; align-items: center; gap: .5rem; margin: 1.25rem 0 1.75rem; max-width: 100%;
            padding: .55rem .9rem; border-radius: 999px; background: var(--c-peach); border: 1px solid #f1e3d3;
            font-weight: 600; font-size: .9rem; color: var(--c-main); word-break: break-all;
        }
        .email-chip svg { width: 1.1rem; height: 1.1rem; flex-shrink: 0; }
        .no-chip { height: 1.5rem; }

        .status { display: flex; gap: .7rem; align-items: flex-start; background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; border-radius: 1rem; padding: .85rem 1rem; font-size: .92rem; line-height: 1.5; margin-bottom: 1.5rem; }
        .status svg { width: 1.3rem; height: 1.3rem; flex-shrink: 0; margin-top: .1rem; }

        .steps { margin: 0 0 1.75rem; padding: 0; list-style: none; display: grid; gap: .6rem; }
        .steps li { display: flex; gap: .7rem; align-items: flex-start; font-size: .92rem; color: #4b5563; line-height: 1.5; }
        .steps li::before { content: ""; width: .5rem; height: .5rem; margin-top: .5rem; border-radius: 50%; background: var(--c-gold); flex-shrink: 0; }

        .btn-main {
            width: 100%; display: flex; align-items: center; justify-content: space-between; gap: .75rem; font-weight: 700; font-size: 1rem;
            padding: .4rem .4rem .4rem 1.4rem; border-radius: 1rem;
            background: linear-gradient(110deg, var(--c-gold-2), var(--c-gold)); color: #1f2937;
            transition: transform .2s, box-shadow .2s, opacity .2s, filter .2s;
        }
        .btn-main .arrow { width: 2.7rem; height: 2.7rem; border-radius: .8rem; background: #fff; display: grid; place-items: center; transition: transform .25s; }
        .btn-main .arrow svg { width: 1.2rem; height: 1.2rem; }
        .btn-main:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 12px 22px -10px rgba(245,158,11,.7); }
        .btn-main:hover:not(:disabled) .arrow { transform: translateX(3px); }
        .btn-main:disabled { filter: grayscale(.6); opacity: .7; cursor: not-allowed; }
        .btn-main.loading { opacity: .8; pointer-events: none; }
        .btn-main.loading .arrow svg { animation: spin 1s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }

        .logout-wrap { text-align: center; margin-top: 1.5rem; }
        .logout { font-size: .92rem; font-weight: 700; color: var(--c-main); padding: .4rem .8rem; border-radius: .6rem; }
        .logout:hover { background: var(--c-peach); }
        .foot { margin-top: 2.5rem; font-size: .8rem; color: #9ca3af; text-align: center; }

        @media (prefers-reduced-motion: reduce) { *, *::before, *::after { animation: none !important; transition: none !important; } }
    </style>
</head>
<body>
<div class="page">

    <!-- ============ PANEL KIRI ============ -->
    <aside class="side">
        <svg class="side-arcs" viewBox="0 0 600 600" fill="none" stroke="#fff" stroke-width="1" aria-hidden="true">
            <circle cx="300" cy="300" r="80"/><circle cx="300" cy="300" r="140"/><circle cx="300" cy="300" r="200"/>
            <circle cx="300" cy="300" r="260"/><circle cx="300" cy="300" r="320"/>
        </svg>
        <svg class="spark" style="right:12%; top:16%; width:2.4rem; height:2.4rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M12 2c.6 5.2 4.8 9.4 10 10-5.2.6-9.4 4.8-10 10-.6-5.2-4.8-9.4-10-10 5.2-.6 9.4-4.8 10-10z"/></svg>
        <svg class="spark" style="right:24%; top:30%; width:1.5rem; height:1.5rem; animation-delay:1.2s;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M12 2c.6 5.2 4.8 9.4 10 10-5.2.6-9.4 4.8-10 10-.6-5.2-4.8-9.4-10-10 5.2-.6 9.4-4.8 10-10z"/></svg>

        <a href="{{ url('/') }}" class="brand">
            <img src="{{ $logo }}" alt="Logo SMK Negeri 13 Medan" width="48" height="48">
            <div><b>SMKN 13 Medan</b><small>Portal E-Learning TJKT</small></div>
        </a>

        <div class="side-body">
            <h2 class="display side-title">Satu langkah lagi, cek emailmu</h2>
            <p class="side-text">Verifikasi email memastikan akun ini benar-benar milikmu, sehingga materi dan nilaimu aman.</p>
        </div>

        <p class="motto">Berkolaborasi, Berintegritas, Bersinergi</p>
    </aside>

    <!-- ============ PANEL ISI ============ -->
    <main class="main">
        <div class="card">

            <div class="badge" aria-hidden="true">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9 6 9-6"/></svg>
            </div>

            <h1 class="display title">Verifikasi email</h1>
            <p class="lead">Terima kasih sudah mendaftar! Sebelum mulai belajar, klik tautan verifikasi yang baru kami kirim ke emailmu.</p>

            @if ($emailUser)
                <div class="email-chip">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9 6 9-6"/></svg>
                    {{ $emailUser }}
                </div>
            @else
                <div class="no-chip"></div>
            @endif

            @if (session('status') == 'verification-link-sent')
                <div class="status" role="status">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M8.5 12.5l2.5 2.5 4.5-5"/></svg>
                    <span>Tautan verifikasi baru sudah dikirim ke email yang kamu daftarkan.</span>
                </div>
            @endif

            <ul class="steps">
                <li>Buka kotak masuk emailmu, lalu klik tautan verifikasi.</li>
                <li>Belum ada? Periksa juga folder Spam atau Promosi.</li>
            </ul>

            <form method="POST" action="{{ route('verification.send') }}" id="resend-form">
                @csrf
                <button type="submit" class="btn-main" id="resend-btn">
                    <span id="resend-text">Kirim ulang email verifikasi</span>
                    <span class="arrow"><svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg></span>
                </button>
            </form>

            <div class="logout-wrap">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout">Keluar dari akun</button>
                </form>
            </div>

            <p class="foot">Copyright © 2026 SMK Negeri 13 Medan.</p>
        </div>
    </main>
</div>

<script>
    (function () {
        const form = document.getElementById('resend-form');
        const btn = document.getElementById('resend-btn');
        const text = document.getElementById('resend-text');
        const LABEL = 'Kirim ulang email verifikasi';
        const KEY = 'smkn13_verify_resend_at';
        const WAIT = 60; // detik jeda sebelum bisa kirim ulang
        let timer;

        function tick() {
            let at = 0;
            try { at = parseInt(localStorage.getItem(KEY) || '0', 10); } catch (e) {}
            const left = WAIT - Math.floor((Date.now() - at) / 1000);
            if (left > 0) {
                btn.disabled = true;
                text.textContent = 'Kirim ulang dalam ' + left + ' detik';
                timer = setTimeout(tick, 1000);
            } else {
                btn.disabled = false;
                text.textContent = LABEL;
            }
        }
        tick();

        form.addEventListener('submit', function () {
            try { localStorage.setItem(KEY, Date.now()); } catch (e) {}
            btn.classList.add('loading');
            text.textContent = 'Mengirim...';
        });
    })();
</script>
</body>
</html>