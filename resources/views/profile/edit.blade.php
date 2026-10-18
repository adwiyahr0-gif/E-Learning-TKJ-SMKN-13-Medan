<x-sidebar-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">
                {{ __('Pengaturan Akun') }}
            </h2>
        </div>
    </x-slot>

    <!-- CSS khusus halaman profil (diawali "pf-", tidak bergantung pada Tailwind) -->
    <style>
        @import url('https://fonts.bunny.net/css?family=instrument-serif:400');

        .pf, .pf *, .pf *::before, .pf *::after { box-sizing: border-box; }
        .pf {
            --c-main: #2b4c59; --c-main-2: #3f7186; --c-dark: #1e3640;
            --c-gold: #f59e0b; --c-gold-2: #fcd34d; --c-peach: #fff5ec; --c-line: #f1e3d3;
            background: #fff; min-height: 100%;
        }
        .pf h1, .pf h2, .pf h3, .pf p { margin: 0; }
        .pf :focus-visible { outline: 3px solid var(--c-gold); outline-offset: 3px; border-radius: 12px; }
        .pf-display { font-family: 'Instrument Serif', serif; font-weight: 400; letter-spacing: -0.03em; }
        .pf-wrap { max-width: 56rem; margin: 0 auto; padding: 1.5rem 1rem 3rem; display: grid; gap: 1.5rem; }
        @media (min-width: 640px) { .pf-wrap { padding: 2rem 1.5rem 3.5rem; } }

        /* ===== Banner ===== */
        .pf-banner {
            position: relative; overflow: hidden; color: #fff; border-radius: 1.75rem;
            background: linear-gradient(160deg, var(--c-main-2), var(--c-main) 55%, var(--c-dark));
            padding: 1.75rem 1.5rem; display: flex; align-items: center; gap: 1.25rem;
        }
        @media (min-width: 768px) { .pf-banner { padding: 2.25rem 2.5rem; gap: 1.75rem; } }
        .pf-arcs { position: absolute; right: -8%; bottom: -110%; width: 32rem; max-width: 90%; opacity: .2; pointer-events: none; }
        .pf-spark { position: absolute; right: 10%; top: 18%; width: 1.8rem; height: 1.8rem; color: var(--c-gold-2); opacity: .8; animation: pf-twinkle 3.5s ease-in-out infinite; pointer-events: none; }
        @keyframes pf-twinkle { 50% { opacity: .25; transform: scale(.85) rotate(20deg); } }
        .pf-avatar { position: relative; flex: none; width: 4.5rem; height: 4.5rem; border-radius: 1.4rem; display: grid; place-items: center; font-size: 2.2rem; color: #1f2937; background: linear-gradient(110deg, var(--c-gold-2), var(--c-gold)); box-shadow: 0 16px 26px -14px rgba(245,158,11,.8); }
        .pf-who { position: relative; min-width: 0; }
        .pf-live { display: inline-flex; align-items: center; gap: .55rem; font-size: .8rem; font-weight: 600; padding: .3rem .8rem; border-radius: 999px; background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.18); }
        .pf-dot { width: .5rem; height: .5rem; border-radius: 50%; background: #34d399; animation: pf-pulse 1.8s ease-in-out infinite; }
        @keyframes pf-pulse { 50% { opacity: .35; transform: scale(.8); } }
        .pf-name { margin-top: .7rem; font-size: clamp(1.8rem, 4vw, 2.8rem); line-height: 1.05; overflow-wrap: anywhere; }
        .pf-mail { margin-top: .4rem; color: #cfe0e6; font-size: .92rem; overflow-wrap: anywhere; }

        /* ===== Kartu bagian ===== */
        .pf-sec { padding: 1.5rem; border-radius: 1.5rem; background: var(--c-peach); border: 1px solid var(--c-line); }
        @media (min-width: 768px) { .pf-sec { padding: 2rem; } }
        .pf-sec-head { display: flex; align-items: center; gap: .9rem; margin-bottom: 1.25rem; padding-bottom: 1.1rem; border-bottom: 1px solid var(--c-line); }
        .pf-ic { flex: none; width: 3.2rem; height: 3.2rem; border-radius: 1rem; background: #fff; border: 1px solid var(--c-line); display: grid; place-items: center; color: var(--c-main); }
        .pf-ic svg { width: 1.6rem; height: 1.6rem; }
        .pf-sec-head h2 { font-size: 1.7rem; line-height: 1.05; color: var(--c-main); }
        .pf-sec-head p { margin-top: .25rem; font-size: .85rem; color: #6b7280; }
        .pf-body { max-width: 36rem; }

        .pf-sec.danger { background: #fff; border: 1.5px dashed #fecaca; }
        .pf-sec.danger .pf-ic { background: #fef2f2; border-color: #fecaca; color: #dc2626; }
        .pf-sec.danger .pf-sec-head { border-bottom-color: #fee2e2; }
        .pf-sec.danger .pf-sec-head h2 { color: #b91c1c; }

        /* ===== Gaya form bawaan (isi dari partial) ===== */
        .pf-body header h2 { font-size: 1rem !important; font-weight: 700 !important; color: #111827 !important; }
        .pf-body header p { color: #6b7280 !important; font-size: .85rem !important; line-height: 1.6; }
        .pf-body label, .pf-body .block.font-medium { color: #374151 !important; font-weight: 600 !important; font-size: .85rem !important; }
        .pf-body input:not([type="checkbox"]):not([type="radio"]) {
            border: 1.5px solid var(--c-line) !important; border-radius: 1rem !important; background: #fff !important;
            color: #374151 !important; padding: .7rem 1rem !important; box-shadow: none !important;
        }
        .pf-body input:not([type="checkbox"]):not([type="radio"]):focus { outline: none !important; border-color: var(--c-main-2) !important; box-shadow: 0 0 0 4px rgba(63,113,134,.15) !important; }
        .pf-body button.bg-gray-800 {
            background: linear-gradient(110deg, var(--c-gold-2), var(--c-gold)) !important; color: #1f2937 !important;
            border: 0 !important; border-radius: 1rem !important; padding: .75rem 1.4rem !important;
            font-weight: 700 !important; font-size: .85rem !important; letter-spacing: 0 !important; text-transform: none !important;
            transition: transform .2s, box-shadow .2s;
        }
        .pf-body button.bg-gray-800:hover { transform: translateY(-2px); box-shadow: 0 12px 22px -10px rgba(245,158,11,.7); }
        .pf-body button.bg-red-600 { border-radius: 1rem !important; padding: .75rem 1.4rem !important; font-weight: 700 !important; font-size: .85rem !important; letter-spacing: 0 !important; text-transform: none !important; }
        .pf-body a.underline { color: var(--c-main-2) !important; }

        @media (prefers-reduced-motion: reduce) { .pf *, .pf *::before, .pf *::after { animation: none !important; transition: none !important; } }
    </style>

    <div class="pf">
        <div class="pf-wrap">

            <!-- ============ BANNER ============ -->
            <section class="pf-banner" aria-label="Ringkasan akun">
                <svg class="pf-arcs" viewBox="0 0 600 600" fill="none" stroke="#fff" stroke-width="1" aria-hidden="true">
                    <circle cx="300" cy="300" r="80"/><circle cx="300" cy="300" r="140"/><circle cx="300" cy="300" r="200"/><circle cx="300" cy="300" r="260"/><circle cx="300" cy="300" r="320"/>
                </svg>
                <svg class="pf-spark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M12 2c.6 5.2 4.8 9.4 10 10-5.2.6-9.4 4.8-10 10-.6-5.2-4.8-9.4-10-10 5.2-.6 9.4-4.8 10-10z"/></svg>

                <div class="pf-avatar pf-display" aria-hidden="true">{{ strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}</div>
                <div class="pf-who">
                    <p class="pf-live"><span class="pf-dot"></span> Akun aktif</p>
                    <h1 class="pf-display pf-name">{{ \Illuminate\Support\Str::limit(Auth::user()->name, 32) }}</h1>
                    <p class="pf-mail">{{ Auth::user()->email }}</p>
                </div>
            </section>

            <!-- ============ INFORMASI PROFIL ============ -->
            <section class="pf-sec" aria-label="Informasi profil">
                <div class="pf-sec-head">
                    <div class="pf-ic" aria-hidden="true">
                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 100-8 4 4 0 000 8zm-7 9a7 7 0 0114 0"/></svg>
                    </div>
                    <div>
                        <h2 class="pf-display">Informasi profil</h2>
                        <p>Perbarui nama dan alamat email akunmu.</p>
                    </div>
                </div>
                <div class="pf-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </section>

            <!-- ============ KATA SANDI ============ -->
            <section class="pf-sec" aria-label="Ubah kata sandi">
                <div class="pf-sec-head">
                    <div class="pf-ic" aria-hidden="true">
                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="4" y="11" width="16" height="10" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M8 11V7a4 4 0 118 0v4"/></svg>
                    </div>
                    <div>
                        <h2 class="pf-display">Kata sandi</h2>
                        <p>Gunakan kata sandi yang panjang dan acak agar akunmu tetap aman.</p>
                    </div>
                </div>
                <div class="pf-body">
                    @include('profile.partials.update-password-form')
                </div>
            </section>

            <!-- ============ HAPUS AKUN ============ -->
            <section class="pf-sec danger" aria-label="Hapus akun">
                <div class="pf-sec-head">
                    <div class="pf-ic" aria-hidden="true">
                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.9L2.4 17.6A2 2 0 004.1 20.6h15.8a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z"/></svg>
                    </div>
                    <div>
                        <h2 class="pf-display">Hapus akun</h2>
                        <p>Tindakan ini permanen dan tidak bisa dibatalkan.</p>
                    </div>
                </div>
                <div class="pf-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </section>

        </div>
    </div>
</x-sidebar-layout>