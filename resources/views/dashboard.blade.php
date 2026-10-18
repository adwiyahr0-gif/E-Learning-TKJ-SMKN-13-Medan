@php
    $r = fn ($name) => Route::has($name) ? route($name) : '#';
    $namaUser = Auth::user()->name;
@endphp

<x-sidebar-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">
                {{ __('Dashboard Utama') }}
            </h2>
        </div>
    </x-slot>

    <!-- CSS khusus dashboard (diawali "db-", tidak bergantung pada Tailwind) -->
    <style>
        @import url('https://fonts.bunny.net/css?family=instrument-serif:400');

        .db, .db *, .db *::before, .db *::after { box-sizing: border-box; }
        .db {
            --c-main: #2b4c59; --c-main-2: #3f7186; --c-dark: #1e3640;
            --c-gold: #f59e0b; --c-gold-2: #fcd34d; --c-peach: #fff5ec; --c-line: #f1e3d3;
            background: #fff; min-height: 100%;
        }
        .db h1, .db h2, .db h3, .db p { margin: 0; }
        .db a { text-decoration: none; color: inherit; }
        .db button { font: inherit; cursor: pointer; border: 0; background: none; color: inherit; }
        .db svg { display: block; }
        .db :focus-visible { outline: 3px solid var(--c-gold); outline-offset: 3px; border-radius: 12px; }
        .db-display { font-family: 'Instrument Serif', serif; font-weight: 400; letter-spacing: -0.03em; }
        .db-wrap { max-width: 80rem; margin: 0 auto; padding: 1.5rem 1rem 3rem; display: grid; gap: 1.75rem; }
        @media (min-width: 640px) { .db-wrap { padding: 2rem 1.5rem 3.5rem; } }
        @media (min-width: 1024px) { .db-wrap { padding: 2.25rem 2rem 4rem; } }

        /* ===== Banner ===== */
        .db-banner {
            position: relative; overflow: hidden; color: #fff; border-radius: 1.75rem;
            background: linear-gradient(160deg, var(--c-main-2), var(--c-main) 55%, var(--c-dark));
            padding: 2rem 1.5rem; display: grid; gap: 1.75rem; align-items: center;
        }
        @media (min-width: 768px) { .db-banner { grid-template-columns: 1fr auto; padding: 2.75rem 2.75rem; } }
        .db-arcs { position: absolute; right: -8%; bottom: -60%; width: 36rem; max-width: 90%; opacity: .2; pointer-events: none; }
        .db-spark { position: absolute; color: var(--c-gold-2); opacity: .8; animation: db-twinkle 3.5s ease-in-out infinite; pointer-events: none; }
        @keyframes db-twinkle { 50% { opacity: .25; transform: scale(.85) rotate(20deg); } }

        .db-live { position: relative; display: inline-flex; align-items: center; gap: .55rem; font-size: .8rem; font-weight: 600; padding: .35rem .85rem; border-radius: 999px; background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.18); }
        .db-dot { width: .5rem; height: .5rem; border-radius: 50%; background: #34d399; animation: db-pulse 1.8s ease-in-out infinite; }
        @keyframes db-pulse { 50% { opacity: .35; transform: scale(.8); } }
        .db-hello { position: relative; font-size: clamp(2.2rem, 5vw, 3.6rem); line-height: 1.02; margin-top: 1rem; }
        .db-hello span { display: block; color: var(--c-gold-2); }
        .db-sub { position: relative; margin-top: 1rem; color: #cfe0e6; max-width: 34rem; line-height: 1.65; }
        .db-actions { position: relative; display: flex; flex-wrap: wrap; gap: .75rem; margin-top: 1.5rem; }
        .db-btn {
            display: inline-flex; align-items: center; gap: .7rem; font-weight: 700; font-size: .95rem;
            padding: .35rem .35rem .35rem 1.15rem; border-radius: 1rem; color: #1f2937;
            background: linear-gradient(110deg, var(--c-gold-2), var(--c-gold)); transition: transform .2s, box-shadow .2s;
        }
        .db-btn .ar { width: 2.2rem; height: 2.2rem; border-radius: .75rem; background: #fff; display: grid; place-items: center; transition: transform .25s; }
        .db-btn .ar svg { width: 1.1rem; height: 1.1rem; }
        .db-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 22px -10px rgba(245,158,11,.7); }
        .db-btn:hover .ar { transform: translateX(3px); }
        .db-btn-ghost { display: inline-flex; align-items: center; padding: .7rem 1.2rem; border-radius: 1rem; font-weight: 600; font-size: .95rem; border: 1.5px solid rgba(255,255,255,.35); transition: background .2s, border-color .2s; }
        .db-btn-ghost:hover { background: rgba(255,255,255,.12); border-color: #fff; }

        .db-clock { position: relative; text-align: center; padding: 1.25rem 1.75rem; border-radius: 1.4rem; background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.18); min-width: 12rem; }
        .db-time { font-size: 3rem; line-height: 1; font-variant-numeric: tabular-nums; }
        .db-date { margin-top: .5rem; font-size: .85rem; color: #cfe0e6; }
        .db-motto { margin-top: .9rem; padding-top: .9rem; border-top: 1px solid rgba(255,255,255,.18); font-size: .75rem; color: var(--c-gold-2); font-weight: 600; line-height: 1.5; }

        /* ===== Judul bagian ===== */
        .db-head { display: flex; align-items: end; justify-content: space-between; gap: 1rem; margin-bottom: 1rem; }
        .db-h2 { font-size: clamp(1.8rem, 3vw, 2.4rem); color: var(--c-main); line-height: 1.05; }
        .db-hint { color: #6b7280; font-size: .9rem; margin-top: .35rem; }

        /* ===== Kartu menu ===== */
        .db-grid { display: grid; gap: 1.1rem; grid-template-columns: 1fr; }
        @media (min-width: 640px) { .db-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 1100px) { .db-grid { grid-template-columns: repeat(4, 1fr); } }
        .db-card {
            position: relative; overflow: hidden; display: flex; flex-direction: column; gap: .8rem; min-height: 15rem;
            padding: 1.5rem; border-radius: 1.5rem; background: var(--c-peach); border: 1px solid var(--c-line);
            transition: background .35s, border-color .35s, transform .35s, box-shadow .35s;
        }
        .db-ic { width: 3.4rem; height: 3.4rem; border-radius: 1.1rem; background: #fff; border: 1px solid var(--c-line); display: grid; place-items: center; color: var(--c-main); transition: all .35s; }
        .db-ic svg { width: 1.7rem; height: 1.7rem; }
        .db-card h3 { font-weight: 700; font-size: 1.15rem; color: #111827; transition: color .35s; margin-top: .4rem; }
        .db-card p { font-size: .88rem; line-height: 1.6; color: #6b7280; transition: color .35s; }
        .db-go { margin-top: auto; display: inline-flex; align-items: center; gap: .4rem; font-size: .85rem; font-weight: 700; color: var(--c-main); transition: color .35s; }
        .db-go svg { width: 1rem; height: 1rem; transition: transform .3s; }
        .db-card::after {
            content: ""; position: absolute; right: 0; bottom: 0; width: 0; height: 0;
            background: linear-gradient(135deg, rgba(0,0,0,.25), var(--c-gold-2) 70%);
            clip-path: polygon(100% 0, 100% 100%, 0 100%); transition: width .35s, height .35s;
        }
        .db-card:hover, .db-card:focus-visible { background: linear-gradient(160deg, var(--c-main-2), var(--c-main)); border-color: var(--c-main); transform: translateY(-6px); box-shadow: 0 18px 30px -14px rgba(43,76,89,.55); }
        .db-card:hover .db-ic, .db-card:focus-visible .db-ic { background: var(--c-dark); border-color: var(--c-gold); color: var(--c-gold-2); transform: scale(1.06); }
        .db-card:hover h3, .db-card:focus-visible h3 { color: #fff; }
        .db-card:hover p, .db-card:focus-visible p { color: #cfe0e6; }
        .db-card:hover .db-go, .db-card:focus-visible .db-go { color: var(--c-gold-2); }
        .db-card:hover .db-go svg { transform: translateX(4px); }
        .db-card:hover::after, .db-card:focus-visible::after { width: 4.5rem; height: 4.5rem; }
        .db-soon { position: absolute; top: 1rem; right: 1rem; font-size: .65rem; font-weight: 700; padding: .15rem .55rem; border-radius: 999px; background: #fef3c7; color: #92400e; }

        /* ===== Tips ===== */
        .db-tip {
            display: grid; gap: 1.25rem; align-items: center; padding: 1.5rem; border-radius: 1.5rem;
            background: #fff; border: 1.5px dashed var(--c-line);
        }
        @media (min-width: 768px) { .db-tip { grid-template-columns: auto 1fr auto; padding: 1.5rem 1.75rem; } }
        .db-tip-badge { width: 3.2rem; height: 3.2rem; border-radius: 1rem; background: var(--c-peach); border: 1px solid var(--c-line); display: grid; place-items: center; color: var(--c-gold); }
        .db-tip-badge svg { width: 1.6rem; height: 1.6rem; }
        .db-tip-label { font-size: .8rem; font-weight: 700; color: var(--c-main); }
        .db-tip-text { margin-top: .3rem; font-size: 1.02rem; line-height: 1.6; color: #374151; min-height: 3.2rem; transition: opacity .25s, transform .25s; }
        .db-tip-text.out { opacity: 0; transform: translateY(6px); }
        .db-tip-side { display: flex; align-items: center; gap: 1rem; }
        .db-dots { display: flex; gap: .35rem; }
        .db-dots i { width: .45rem; height: .45rem; border-radius: 50%; background: var(--c-line); transition: background .3s, width .3s; }
        .db-dots i.on { width: 1.2rem; border-radius: 999px; background: var(--c-gold); }
        .db-next { padding: .6rem 1.1rem; border-radius: .9rem; border: 1.5px solid var(--c-main); color: var(--c-main); font-weight: 700; font-size: .88rem; transition: background .2s, color .2s; white-space: nowrap; }
        .db-next:hover { background: var(--c-main); color: #fff; }

        @media (prefers-reduced-motion: reduce) { .db *, .db *::before, .db *::after { animation: none !important; transition: none !important; } }
    </style>

    <div class="db">
        <div class="db-wrap">

            <!-- ============ BANNER ============ -->
            <section class="db-banner" aria-label="Selamat datang">
                <svg class="db-arcs" viewBox="0 0 600 600" fill="none" stroke="#fff" stroke-width="1" aria-hidden="true">
                    <circle cx="300" cy="300" r="80"/><circle cx="300" cy="300" r="140"/><circle cx="300" cy="300" r="200"/><circle cx="300" cy="300" r="260"/><circle cx="300" cy="300" r="320"/>
                </svg>
                <svg class="db-spark" style="right:30%; top:14%; width:2rem; height:2rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M12 2c.6 5.2 4.8 9.4 10 10-5.2.6-9.4 4.8-10 10-.6-5.2-4.8-9.4-10-10 5.2-.6 9.4-4.8 10-10z"/></svg>

                <div>
                    <p class="db-live"><span class="db-dot"></span> Sistem pembelajaran aktif</p>
                    <h1 class="db-display db-hello">
                        <span id="db-greet">Halo,</span>
                        {{ \Illuminate\Support\Str::limit($namaUser, 28) }}
                    </h1>
                    <p class="db-sub">Selamat datang di pusat media pembelajaran Jaringan Komputer. Pilih menu di bawah untuk belajar materi, menonton video, mengerjakan kuis, atau bertanya pada AI Tutor.</p>
                    <div class="db-actions">
                        <a href="{{ $r('materi.routing') }}" class="db-btn">Mulai belajar <span class="ar"><svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg></span></a>
                        <a href="{{ $r('ai.tutor.index') }}" class="db-btn-ghost">Tanya AI Tutor</a>
                    </div>
                </div>

                <div class="db-clock" aria-live="off">
                    <p class="db-display db-time" id="db-time">--:--</p>
                    <p class="db-date" id="db-date">&nbsp;</p>
                    <p class="db-motto">Berkolaborasi, Berintegritas, Bersinergi</p>
                </div>
            </section>

            <!-- ============ MENU ============ -->
            <section aria-label="Menu belajar">
                <div class="db-head">
                    <div>
                        <h2 class="db-display db-h2">Menu belajar</h2>
                        <p class="db-hint">Pilih salah satu untuk mulai.</p>
                    </div>
                </div>

                <div class="db-grid">
                    <a href="{{ $r('materi.routing') }}" class="db-card">
                        <div class="db-ic"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.25v13m0-13C10.83 5.48 9.25 5 7.5 5S4.17 5.48 3 6.25v13C4.17 18.48 5.75 18 7.5 18s3.33.48 4.5 1.25m0-13C13.17 5.48 14.75 5 16.5 5c1.75 0 3.33.48 4.5 1.25v13C19.83 18.48 18.25 18 16.5 18c-1.75 0-3.33.48-4.5 1.25"/></svg></div>
                        <h3>Modul Materi</h3>
                        <p>Pelajari konsep dasar jaringan komputer, topologi, dan routing secara mendalam.</p>
                        <span class="db-go">Mulai belajar <svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg></span>
                    </a>

                    <a href="{{ $r('video.animasi') }}" class="db-card">
                        <div class="db-ic"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.75 11.17l-3.2-2.13A1 1 0 0010 9.87v4.26a1 1 0 001.55.83l3.2-2.13a1 1 0 000-1.66z"/><circle cx="12" cy="12" r="9"/></svg></div>
                        <h3>Video Animasi</h3>
                        <p>Tonton simulasi visual pergerakan paket data pada jaringan komputer.</p>
                        <span class="db-go">Tonton video <svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg></span>
                    </a>

                    <a href="{{ $r('kuis.evaluasi') }}" class="db-card">
                        <div class="db-ic"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg></div>
                        <h3>Kuis Evaluasi</h3>
                        <p>Uji pemahamanmu. Jawaban essay akan dianalisis dan dinilai langsung oleh AI.</p>
                        <span class="db-go">Kerjakan kuis <svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg></span>
                    </a>

                    <a href="{{ $r('ai.tutor.index') }}" class="db-card">
                        <div class="db-ic"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.42-4.03 8-9 8a9.9 9.9 0 01-4-.8L3 20l1.3-3.9A7.6 7.6 0 013 12c0-4.42 4.03-8 9-8s9 3.58 9 8z"/></svg></div>
                        <h3>Tanya AI Tutor</h3>
                        <p>Ada materi yang belum dipahami? Tanya langsung ke asisten pintar kapan saja.</p>
                        <span class="db-go">Buka chat AI <svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg></span>
                    </a>
                </div>
            </section>

            <!-- ============ TIPS JARINGAN ============ -->
            <section class="db-tip" aria-label="Tips jaringan">
                <div class="db-tip-badge" aria-hidden="true">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 18h6m-5 3h4M12 3a6 6 0 00-3.5 10.9c.6.5 1 1.2 1 2V16h5v-.1c0-.8.4-1.5 1-2A6 6 0 0012 3z"/></svg>
                </div>
                <div>
                    <p class="db-tip-label">Tips jaringan</p>
                    <p class="db-tip-text" id="db-tip-text" aria-live="polite"></p>
                </div>
                <div class="db-tip-side">
                    <div class="db-dots" id="db-dots" aria-hidden="true"></div>
                    <button type="button" class="db-next" id="db-next">Tips lainnya</button>
                </div>
            </section>

        </div>
    </div>

    <script>
        (function () {
            // Sapaan sesuai jam di perangkat siswa
            const greet = document.getElementById('db-greet');
            const timeEl = document.getElementById('db-time');
            const dateEl = document.getElementById('db-date');

            function tick() {
                const now = new Date();
                const h = now.getHours();
                greet.textContent = (h < 11 ? 'Selamat pagi,' : h < 15 ? 'Selamat siang,' : h < 18 ? 'Selamat sore,' : 'Selamat malam,');
                timeEl.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }).replace('.', ':');
                dateEl.textContent = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
            }
            tick();
            setInterval(tick, 15000);

            // Tips berganti otomatis, bisa diganti manual
            const tips = [
                'Subnet mask /24 (255.255.255.0) menyediakan 254 alamat host yang bisa dipakai perangkat.',
                'Router bekerja di Layer 3 (Network) model OSI, sedangkan switch umumnya di Layer 2 (Data Link).',
                'Gunakan ping untuk menguji konektivitas, dan tracert (Windows) atau traceroute untuk melihat jalur paket.',
                'Alamat IP privat: 10.0.0.0/8, 172.16.0.0/12, dan 192.168.0.0/16. Alamat ini tidak dirutekan di internet.',
                'DHCP membagikan alamat IP secara otomatis, sedangkan DNS menerjemahkan nama domain menjadi alamat IP.',
                'VLAN memisahkan jaringan secara logis di dalam satu switch fisik, misalnya VLAN guru dan VLAN siswa.',
                'Default gateway adalah alamat router yang dipakai perangkat untuk keluar dari jaringan lokal.',
                'Kabel UTP straight umumnya dipakai untuk perangkat berbeda jenis (PC ke switch), sedangkan cross untuk perangkat sejenis.'
            ];
            const textEl = document.getElementById('db-tip-text');
            const dotsEl = document.getElementById('db-dots');
            const nextBtn = document.getElementById('db-next');
            let idx = Math.floor(Math.random() * tips.length);
            let timer;

            tips.forEach(() => dotsEl.appendChild(document.createElement('i')));

            function show(i, animate) {
                idx = (i + tips.length) % tips.length;
                const apply = () => {
                    textEl.textContent = tips[idx];
                    [...dotsEl.children].forEach((d, n) => d.classList.toggle('on', n === idx));
                    textEl.classList.remove('out');
                };
                if (animate) { textEl.classList.add('out'); setTimeout(apply, 220); } else { apply(); }
            }
            function auto() { clearInterval(timer); timer = setInterval(() => show(idx + 1, true), 12000); }

            nextBtn.addEventListener('click', () => { show(idx + 1, true); auto(); });
            textEl.parentElement.parentElement.addEventListener('mouseenter', () => clearInterval(timer));
            textEl.parentElement.parentElement.addEventListener('mouseleave', auto);

            show(idx, false);
            auto();
        })();
    </script>
</x-sidebar-layout>