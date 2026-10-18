@php
    $logo = 'https://yt3.googleusercontent.com/D78HsxvMYN3Kx-iVptB1MMP7k0A-m74TdHKnUvbAuMYtN4HyZ4i7NUpLbXSC-tYHffaJMmPwhw=s900-c-k-c0x00ffffff-no-rj';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Siswa - SMK Negeri 13 Medan</title>

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

        /* ===== Panel form ===== */
        .main { display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 2.5rem 1.25rem; background: #fff; }
        .card { width: 100%; max-width: 26rem; }
        .back { display: inline-flex; align-items: center; gap: .4rem; font-size: .9rem; font-weight: 600; color: var(--c-main); margin-bottom: 2rem; }
        .back svg { width: 1rem; height: 1rem; transition: transform .2s; }
        .back:hover svg { transform: translateX(-3px); }
        .title { font-size: 2.6rem; line-height: 1; color: var(--c-main); }
        .lead { color: #6b7280; margin-top: .6rem; margin-bottom: 2rem; }

        .field { margin-bottom: 1.25rem; }
        .field label.lbl { display: block; font-weight: 600; font-size: .9rem; margin-bottom: .4rem; }
        .input-wrap { position: relative; }
        .input-wrap > .lead-ic { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); width: 1.25rem; height: 1.25rem; color: #9ca3af; pointer-events: none; transition: color .2s; }
        .input {
            width: 100%; padding: .9rem 1rem .9rem 2.9rem; border-radius: 1rem;
            background: var(--c-peach); border: 1.5px solid #f1e3d3; color: #111827;
            transition: border-color .2s, background .2s, box-shadow .2s;
        }
        .input.has-eye { padding-right: 3.2rem; }
        .input::placeholder { color: #b8a999; }
        .input:focus { outline: none; background: #fff; border-color: var(--c-main); box-shadow: 0 0 0 4px rgba(43,76,89,.12); }
        .input-wrap:focus-within > .lead-ic { color: var(--c-main); }
        .input.invalid { border-color: #dc2626; background: #fef2f2; }
        .eye {
            position: absolute; right: .5rem; top: 50%; transform: translateY(-50%);
            width: 2.4rem; height: 2.4rem; display: grid; place-items: center; border-radius: .75rem; color: #6b7280; transition: background .2s, color .2s;
        }
        .eye:hover { background: #f1e3d3; color: var(--c-main); }
        .eye svg { width: 1.3rem; height: 1.3rem; }
        .eye .off { display: none; }
        .eye.on .off { display: block; }
        .eye.on .show { display: none; }
        .error { color: #dc2626; font-size: .85rem; margin-top: .4rem; }
        .caps { display: none; color: #b45309; font-size: .82rem; margin-top: .4rem; font-weight: 600; }
        .status { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; border-radius: .9rem; padding: .75rem 1rem; font-size: .9rem; margin-bottom: 1.25rem; }

        .row { display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap; margin-bottom: 1.5rem; }
        .check { display: inline-flex; align-items: center; gap: .55rem; font-size: .9rem; color: #4b5563; cursor: pointer; }
        .check input { width: 1.1rem; height: 1.1rem; accent-color: var(--c-main); }
        .forgot { font-size: .9rem; font-weight: 600; color: var(--c-main); }
        .forgot:hover { text-decoration: underline; text-underline-offset: 3px; }

        .btn-main {
            width: 100%; display: flex; align-items: center; justify-content: space-between; gap: .75rem; font-weight: 700; font-size: 1rem;
            padding: .4rem .4rem .4rem 1.4rem; border-radius: 1rem;
            background: linear-gradient(110deg, var(--c-gold-2), var(--c-gold)); color: #1f2937;
            transition: transform .2s, box-shadow .2s, opacity .2s;
        }
        .btn-main .arrow { width: 2.7rem; height: 2.7rem; border-radius: .8rem; background: #fff; display: grid; place-items: center; transition: transform .25s; }
        .btn-main .arrow svg { width: 1.2rem; height: 1.2rem; }
        .btn-main:hover { transform: translateY(-2px); box-shadow: 0 12px 22px -10px rgba(245,158,11,.7); }
        .btn-main:hover .arrow { transform: translateX(3px); }
        .btn-main.loading { opacity: .8; pointer-events: none; }
        .btn-main.loading .arrow svg { animation: spin 1s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }

        .switch { text-align: center; margin-top: 1.5rem; font-size: .92rem; color: #6b7280; }
        .switch a { color: var(--c-main); font-weight: 700; }
        .switch a:hover { text-decoration: underline; text-underline-offset: 3px; }
        .foot { margin-top: 2.5rem; font-size: .8rem; color: #9ca3af; text-align: center; }

        /* ===== Tab peran (Siswa / Guru) ===== */
        .role-tabs { display: grid; grid-template-columns: 1fr 1fr; gap: .4rem; padding: .3rem; background: var(--c-peach); border: 1.5px solid #f1e3d3; border-radius: 1rem; margin-bottom: 1.5rem; }
        .role-tab { padding: .7rem; border-radius: .75rem; font-weight: 700; font-size: .9rem; color: #6b7280; text-align: center; transition: background .2s, color .2s; }
        .role-tab:hover { color: var(--c-main); }
        .role-tab.active { background: linear-gradient(110deg, var(--c-gold-2), var(--c-gold)); color: #1f2937; }

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
            <h2 class="display side-title">Selamat datang kembali</h2>
            <p class="side-text">Masuk untuk membuka modul materi, video animasi, kuis evaluasi, dan AI Tutor Teknik Jaringan Komputer dan Telekomunikasi.</p>
        </div>

        <p class="motto">Berkolaborasi, Berintegritas, Bersinergi</p>
    </aside>

    <!-- ============ PANEL FORM ============ -->
    <main class="main">
        <div class="card">
            <a href="{{ url('/') }}" class="back">
                <svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m6-6l-6 6 6 6"/></svg>
                Kembali ke beranda
            </a>

            <h1 class="display title" id="login-title">Login Siswa</h1>
            <p class="lead">Masukkan email dan kata sandi akunmu.</p>

            @if (session('status'))
                <div class="status" role="status">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="login-form">
                @csrf

                <!-- Pilih peran -->
                <input type="hidden" name="role" id="role" value="{{ old('role', 'siswa') }}">
                <div class="role-tabs" role="tablist" aria-label="Masuk sebagai">
                    <button type="button" class="role-tab" data-role="siswa" role="tab">Siswa</button>
                    <button type="button" class="role-tab" data-role="guru" role="tab">Guru</button>
                </div>
                @error('role') <p class="error" style="margin-top:-1rem; margin-bottom:1rem;">{{ $message }}</p> @enderror

                <!-- Email -->
                <div class="field">
                    <label class="lbl" for="email">Email</label>
                    <div class="input-wrap">
                        <svg class="lead-ic" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9 6 9-6"/></svg>
                        <input id="email" class="input @error('email') invalid @enderror" type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus autocomplete="username">
                    </div>
                    @error('email') <p class="error">{{ $message }}</p> @enderror
                </div>

                <!-- Password -->
                <div class="field">
                    <label class="lbl" for="password">Kata sandi</label>
                    <div class="input-wrap">
                        <svg class="lead-ic" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="10" width="16" height="10" rx="2"/><path stroke-linecap="round" d="M8 10V7a4 4 0 018 0v3"/></svg>
                        <input id="password" class="input has-eye @error('password') invalid @enderror" type="password" name="password" placeholder="Masukkan kata sandi" required autocomplete="current-password">

                        <!-- Tombol ikon mata -->
                        <button type="button" id="toggle-pass" class="eye" aria-label="Tampilkan kata sandi" aria-pressed="false" aria-controls="password">
                            <svg class="show" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg class="off" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.6 5.1A9.9 9.9 0 0112 5c6.4 0 10 7 10 7a17 17 0 01-3.3 4.2M6.5 6.6C3.7 8.4 2 12 2 12s3.6 7 10 7c1.6 0 3-.4 4.3-1M9.9 9.9a3 3 0 004.2 4.2"/></svg>
                        </button>
                    </div>
                    <p class="caps" id="caps-note">Caps Lock sedang aktif.</p>
                    @error('password') <p class="error">{{ $message }}</p> @enderror
                </div>

                <div class="row">
                    <label class="check" for="remember_me">
                        <input id="remember_me" type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                        Ingat saya
                    </label>

                    @if (Route::has('password.request'))
                        <a class="forgot" href="{{ route('password.request') }}">Lupa kata sandi?</a>
                    @endif
                </div>

                <button type="submit" class="btn-main" id="submit-btn">
                    <span id="submit-text">Masuk</span>
                    <span class="arrow"><svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg></span>
                </button>
            </form>

            @if (Route::has('register'))
                <p class="switch" id="switch-note">Belum punya akun? <a href="{{ route('register') }}">Buat akun</a></p>
            @endif

            <p class="foot">Copyright © 2026 SMK Negeri 13 Medan.</p>
        </div>
    </main>
</div>

<script>
    (function () {
        const pass = document.getElementById('password');
        const eye = document.getElementById('toggle-pass');
        const caps = document.getElementById('caps-note');
        const form = document.getElementById('login-form');
        const btn = document.getElementById('submit-btn');

        // Tampilkan / sembunyikan kata sandi
        eye.addEventListener('click', function () {
            const show = pass.type === 'password';
            pass.type = show ? 'text' : 'password';
            eye.classList.toggle('on', show);
            eye.setAttribute('aria-pressed', show);
            eye.setAttribute('aria-label', show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
            pass.focus();
        });

        // Peringatan Caps Lock
        function checkCaps(e) {
            caps.style.display = (e.getModifierState && e.getModifierState('CapsLock')) ? 'block' : 'none';
        }
        pass.addEventListener('keyup', checkCaps);
        pass.addEventListener('keydown', checkCaps);
        pass.addEventListener('blur', () => caps.style.display = 'none');

        // Ingat saya: isi otomatis email yang tersimpan (kata sandi tidak pernah disimpan)
        const email = document.getElementById('email');
        const remember = document.getElementById('remember_me');
        const KEY = 'smkn13_remember_email';
        try {
            const saved = localStorage.getItem(KEY);
            if (saved && !email.value) {
                email.value = saved;
                remember.checked = true;
                pass.focus();
            }
        } catch (e) {}

        // Pilih peran: Siswa / Guru
        const roleInput = document.getElementById('role');
        const tabs = document.querySelectorAll('.role-tab');
        const title = document.getElementById('login-title');
        const switchNote = document.getElementById('switch-note');

        function setRole(role) {
            roleInput.value = role;
            tabs.forEach(function (t) {
                const on = t.dataset.role === role;
                t.classList.toggle('active', on);
                t.setAttribute('aria-selected', on);
            });
            title.textContent = role === 'guru' ? 'Login Guru' : 'Login Siswa';
            document.title = title.textContent + ' - SMK Negeri 13 Medan';
            if (switchNote) switchNote.style.display = role === 'guru' ? 'none' : '';
        }
        tabs.forEach(function (t) {
            t.addEventListener('click', function () { setRole(t.dataset.role); });
        });
        setRole(roleInput.value === 'guru' ? 'guru' : 'siswa');

        // Status memuat saat tombol Masuk ditekan
        form.addEventListener('submit', function () {
            try {
                if (remember.checked) localStorage.setItem(KEY, email.value);
                else localStorage.removeItem(KEY);
            } catch (e) {}
            btn.classList.add('loading');
            document.getElementById('submit-text').textContent = 'Memproses...';
        });
    })();
</script>
</body>
</html>