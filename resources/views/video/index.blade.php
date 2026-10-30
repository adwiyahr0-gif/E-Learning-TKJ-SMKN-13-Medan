@php
    $videos = [
        [
            'id' => 'dcuJZxuBHMA', 'badge' => 'Dasar Jaringan', 'durasi' => '03:45',
            'short' => 'Cara Kerja Switch vs Hub',
            'title' => 'Cara Kerja Switch vs Hub (Simulasi)',
            'desc' => 'Video simulasi ini membedah cara kerja Hub dan Switch, serta mempraktikkan tipe komunikasi unicast, multicast, dan broadcast dalam jaringan komputer secara visual.',
        ],
        [
            'id' => 'iYHBl2gJMzM', 'badge' => 'Routing', 'durasi' => '05:12',
            'short' => 'Cara Kerja Routing Animasi',
            'title' => 'Cara Kerja Routing (Animasi)',
            'desc' => 'Visualisasi tentang bagaimana paket data diberi alamat IP dan melintasi berbagai router jaringan untuk sampai ke tujuan.',
        ],
        [
            'id' => 'L8y-zL9hSbM', 'badge' => 'IP Address', 'durasi' => '08:30',
            'short' => 'Konsep Subnetting IPv4',
            'title' => 'Belajar Subnetting IPv4',
            'desc' => 'Materi komprehensif untuk memahami konsep dasar subnetting (Network ID dan Host Address) sebagai pondasi sistem pengalamatan IP.',
        ],
    ];
    $first = $videos[0];
@endphp

<x-sidebar-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">
                {{ __('Video Pembelajaran') }}
            </h2>
        </div>
    </x-slot>

    <!-- CSS khusus halaman video (diawali "vd-", tidak bergantung pada Tailwind) -->
    <style>
        @import url('https://fonts.bunny.net/css?family=instrument-serif:400');

        .vd, .vd *, .vd *::before, .vd *::after { box-sizing: border-box; }
        .vd {
            --c-main: #2b4c59; --c-main-2: #3f7186; --c-dark: #1e3640;
            --c-gold: #f59e0b; --c-gold-2: #fcd34d; --c-peach: #fff5ec; --c-line: #f1e3d3;
            background: #fff; min-height: 100%;
        }
        .vd h1, .vd h2, .vd h3, .vd h4, .vd p { margin: 0; }
        .vd a { text-decoration: none; color: inherit; }
        .vd button { font: inherit; cursor: pointer; border: 0; background: none; color: inherit; text-align: left; }
        .vd svg { display: block; }
        .vd :focus-visible { outline: 3px solid var(--c-gold); outline-offset: 3px; border-radius: 12px; }
        .vd-display { font-family: 'Instrument Serif', serif; font-weight: 400; letter-spacing: -0.03em; }
        .vd-wrap { max-width: 80rem; margin: 0 auto; padding: 1.5rem 1rem 3rem; display: grid; gap: 1.5rem; }
        @media (min-width: 640px) { .vd-wrap { padding: 2rem 1.5rem 3.5rem; } }
        @media (min-width: 1024px) { .vd-wrap { padding: 2.25rem 2rem 4rem; } }

        /* ===== Banner ===== */
        .vd-banner {
            position: relative; overflow: hidden; color: #fff; border-radius: 1.75rem;
            background: linear-gradient(160deg, var(--c-main-2), var(--c-main) 55%, var(--c-dark));
            padding: 1.75rem 1.5rem; display: grid; gap: .9rem;
        }
        @media (min-width: 768px) { .vd-banner { padding: 2.25rem 2.5rem; } }
        .vd-arcs { position: absolute; right: -8%; bottom: -90%; width: 32rem; max-width: 90%; opacity: .2; pointer-events: none; }
        .vd-spark { position: absolute; right: 12%; top: 16%; width: 1.8rem; height: 1.8rem; color: var(--c-gold-2); opacity: .8; animation: vd-twinkle 3.5s ease-in-out infinite; pointer-events: none; }
        @keyframes vd-twinkle { 50% { opacity: .25; transform: scale(.85) rotate(20deg); } }
        .vd-live { position: relative; justify-self: start; display: inline-flex; align-items: center; gap: .55rem; font-size: .8rem; font-weight: 600; padding: .35rem .85rem; border-radius: 999px; background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.18); }
        .vd-dot { width: .5rem; height: .5rem; border-radius: 50%; background: #34d399; animation: vd-pulse 1.8s ease-in-out infinite; }
        @keyframes vd-pulse { 50% { opacity: .35; transform: scale(.8); } }
        .vd-title { position: relative; font-size: clamp(1.9rem, 4.5vw, 3rem); line-height: 1.05; }
        .vd-title span { display: block; color: var(--c-gold-2); }
        .vd-sub { position: relative; color: #cfe0e6; line-height: 1.65; max-width: 36rem; }

        /* ===== Layout ===== */
        .vd-layout { display: grid; gap: 1.5rem; align-items: start; }
        @media (min-width: 1024px) { .vd-layout { grid-template-columns: 2fr 1fr; } }
        .vd-col { display: grid; gap: 1.5rem; min-width: 0; }

        /* ===== Player ===== */
        .vd-player { border-radius: 1.5rem; overflow: hidden; background: var(--c-peach); border: 1px solid var(--c-line); }
        .vd-frame { position: relative; width: 100%; padding-bottom: 56.25%; height: 0; background: #000; overflow: hidden; }
        .vd-frame iframe { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; }
        .vd-info { padding: 1.5rem; }
        @media (min-width: 768px) { .vd-info { padding: 1.75rem 2rem; } }
        .vd-meta { display: flex; flex-wrap: wrap; align-items: center; gap: .75rem; }
        .vd-badge { font-size: .72rem; font-weight: 700; padding: .3rem .8rem; border-radius: 999px; background: var(--c-main); color: var(--c-gold-2); }
        .vd-meta small { display: inline-flex; align-items: center; gap: .35rem; font-size: .8rem; font-weight: 600; color: #6b7280; }
        .vd-meta small svg { width: 1rem; height: 1rem; }
        .vd-vtitle { margin-top: .9rem; font-size: clamp(1.7rem, 3vw, 2.3rem); line-height: 1.1; color: var(--c-main); }
        .vd-vdesc { margin-top: .7rem; line-height: 1.7; color: #4b5563; font-size: .95rem; }

        /* ===== Catatan ===== */
        .vd-note { padding: 1.5rem; border-radius: 1.5rem; background: #fff; border: 1.5px dashed var(--c-line); }
        .vd-note-head { display: flex; align-items: center; gap: .9rem; }
        .vd-badge-ic { flex: none; width: 3.2rem; height: 3.2rem; border-radius: 1rem; background: var(--c-peach); border: 1px solid var(--c-line); display: grid; place-items: center; color: var(--c-gold); }
        .vd-badge-ic svg { width: 1.6rem; height: 1.6rem; }
        .vd-note h3 { font-size: 1.05rem; font-weight: 700; color: #111827; }
        .vd-note p.vd-hint { margin-top: .15rem; font-size: .82rem; color: #6b7280; }
        .vd-text { display: block; width: 100%; margin-top: 1rem; padding: 1rem 1.1rem; border-radius: 1rem; border: 1.5px solid var(--c-line); background: var(--c-peach); font: inherit; font-size: .92rem; line-height: 1.6; color: #374151; resize: vertical; min-height: 6.5rem; }
        .vd-text:focus { outline: none; border-color: var(--c-main-2); background: #fff; box-shadow: 0 0 0 4px rgba(63,113,134,.15); }
        .vd-saved { font-size: .82rem; font-weight: 600; color: #059669; opacity: 0; transition: opacity .3s; }
        .vd-saved.on { opacity: 1; }
        .vd-row { display: flex; align-items: center; justify-content: flex-end; gap: 1rem; margin-top: 1rem; }

        .vd-btn {
            display: inline-flex; align-items: center; gap: .7rem; font-weight: 700; font-size: .92rem;
            padding: .35rem .35rem .35rem 1.15rem; border-radius: 1rem; color: #1f2937;
            background: linear-gradient(110deg, var(--c-gold-2), var(--c-gold)); transition: transform .2s, box-shadow .2s;
        }
        .vd-btn .ar { width: 2.2rem; height: 2.2rem; border-radius: .75rem; background: #fff; display: grid; place-items: center; transition: transform .25s; }
        .vd-btn .ar svg { width: 1.1rem; height: 1.1rem; }
        .vd-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 22px -10px rgba(245,158,11,.7); }
        .vd-btn:hover .ar { transform: translateX(3px); }

        /* ===== Playlist ===== */
        .vd-list { border-radius: 1.5rem; background: var(--c-peach); border: 1px solid var(--c-line); overflow: hidden; }
        .vd-list-head { display: flex; align-items: center; gap: .8rem; padding: 1.1rem 1.25rem; border-bottom: 1px solid var(--c-line); }
        .vd-list-head .vd-badge-ic { width: 2.6rem; height: 2.6rem; background: #fff; color: var(--c-main); }
        .vd-list-head .vd-badge-ic svg { width: 1.3rem; height: 1.3rem; }
        .vd-list-head h3 { font-size: 1.05rem; font-weight: 700; color: #111827; }
        .vd-list-head p { font-size: .78rem; color: #6b7280; margin-top: .1rem; }
        .vd-items { display: grid; gap: .5rem; padding: .75rem; max-height: 24rem; overflow-y: auto; }
        .vd-items::-webkit-scrollbar { width: 6px; }
        .vd-items::-webkit-scrollbar-thumb { background: var(--c-line); border-radius: 8px; }
        .vd-item { display: flex; gap: .8rem; padding: .6rem; border-radius: 1.1rem; background: #fff; border: 1.5px solid transparent; transition: all .3s; }
        .vd-item:hover { border-color: var(--c-main-2); transform: translateX(3px); }
        .vd-thumb { position: relative; flex: none; width: 6.8rem; height: 4rem; border-radius: .8rem; overflow: hidden; background: #e5e7eb; }
        .vd-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .vd-play { position: absolute; inset: 0; display: grid; place-items: center; background: rgba(30,54,64,.45); color: #fff; transition: background .3s; }
        .vd-play svg { width: 1.3rem; height: 1.3rem; }
        .vd-item:hover .vd-play { background: rgba(245,158,11,.85); }
        .vd-item h4 { font-size: .88rem; font-weight: 700; line-height: 1.3; color: #374151; transition: color .3s; }
        .vd-item small { display: block; margin-top: .3rem; font-size: .68rem; font-weight: 700; letter-spacing: .06em; color: #9ca3af; }
        .vd-item.active { background: linear-gradient(160deg, var(--c-main-2), var(--c-main)); border-color: var(--c-main); box-shadow: 0 14px 24px -14px rgba(43,76,89,.7); }
        .vd-item.active h4 { color: #fff; }
        .vd-item.active small { color: var(--c-gold-2); }
        .vd-item.active .vd-play { background: rgba(245,158,11,.85); }

        /* ===== AI Tutor ===== */
        .vd-ai { position: relative; overflow: hidden; border-radius: 1.5rem; color: #fff; background: linear-gradient(160deg, var(--c-main-2), var(--c-main) 55%, var(--c-dark)); }
        .vd-ai .vd-arcs { bottom: -70%; right: -30%; width: 22rem; }
        .vd-ai-head { position: relative; display: flex; align-items: center; gap: .9rem; padding: 1.25rem 1.25rem 1rem; }
        .vd-ai-head .vd-badge-ic { background: rgba(255,255,255,.12); border-color: rgba(255,255,255,.2); color: var(--c-gold-2); }
        .vd-ai-head h3 { font-size: .98rem; font-weight: 700; }
        .vd-ai-head p { display: flex; align-items: center; gap: .4rem; margin-top: .2rem; font-size: .72rem; color: #cfe0e6; }
        .vd-ai-head p i { width: .45rem; height: .45rem; border-radius: 50%; background: #34d399; animation: vd-pulse 1.8s ease-in-out infinite; }
        .vd-ai form { position: relative; display: grid; gap: .8rem; padding: 0 1.25rem 1.25rem; }
        .vd-ai textarea { width: 100%; padding: .9rem 1rem; border-radius: 1rem; border: 1.5px solid rgba(255,255,255,.22); background: rgba(255,255,255,.1); color: #fff; font: inherit; font-size: .88rem; line-height: 1.55; resize: none; }
        .vd-ai textarea::placeholder { color: #a9c3cd; }
        .vd-ai textarea:focus { outline: none; border-color: var(--c-gold-2); background: rgba(255,255,255,.16); }
        .vd-ai .vd-btn { justify-self: stretch; justify-content: space-between; }

        @media (prefers-reduced-motion: reduce) { .vd *, .vd *::before, .vd *::after { animation: none !important; transition: none !important; } }
    </style>

    <div class="vd">
        <div class="vd-wrap">

            <!-- ============ BANNER ============ -->
            <section class="vd-banner" aria-label="Ruang Pembelajaran">
                <svg class="vd-arcs" viewBox="0 0 600 600" fill="none" stroke="#fff" stroke-width="1" aria-hidden="true">
                    <circle cx="300" cy="300" r="80"/><circle cx="300" cy="300" r="140"/><circle cx="300" cy="300" r="200"/><circle cx="300" cy="300" r="260"/><circle cx="300" cy="300" r="320"/>
                </svg>
                <svg class="vd-spark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M12 2c.6 5.2 4.8 9.4 10 10-5.2.6-9.4 4.8-10 10-.6-5.2-4.8-9.4-10-10 5.2-.6 9.4-4.8 10-10z"/></svg>
                <p class="vd-live"><span class="vd-dot"></span> {{ count($videos) }} video tersedia</p>
                <h1 class="vd-display vd-title"><span>Ruang Pembelajaran</span> &amp; Simulasi Jaringan</h1>
                <p class="vd-sub">Tonton simulasi visual pergerakan paket data, catat intisarinya, dan tanya AI Tutor kalau ada yang belum jelas.</p>
            </section>

            <div class="vd-layout">

                <!-- ============ KOLOM KIRI ============ -->
                <div class="vd-col">
                    <section class="vd-player" aria-label="Pemutar video">
                        <div class="vd-frame">
                            <iframe id="main-video" src="https://www.youtube.com/embed/{{ $first['id'] }}?rel=0" title="Video pembelajaran" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <div class="vd-info">
                            <div class="vd-meta">
                                <span id="video-badge" class="vd-badge">{{ $first['badge'] }}</span>
                                <small>
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Video pembelajaran
                                </small>
                            </div>
                            <h2 id="video-title" class="vd-display vd-vtitle">{{ $first['title'] }}</h2>
                            <p id="video-desc" class="vd-vdesc">{{ $first['desc'] }}</p>
                        </div>
                    </section>

                    <section class="vd-note" aria-label="Buku catatan digital">
                        <div class="vd-note-head">
                            <div class="vd-badge-ic" aria-hidden="true">
                                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.9 3.6a2 2 0 112.8 2.8L8 18l-4 1 1-4L16.9 3.6z"/></svg>
                            </div>
                            <div>
                                <h3>Buku Catatan Digital</h3>
                                <p class="vd-hint">Ketik intisari video agar materinya lebih mudah diingat.</p>
                            </div>
                        </div>
                        <textarea id="note-text" class="vd-text" rows="3" placeholder="Contoh: Kesimpulannya, Switch jauh lebih pintar dari Hub karena bisa mengingat alamat MAC..."></textarea>
                        <div class="vd-row">
                            <span id="note-saved" class="vd-saved" role="status">Catatan berhasil disimpan!</span>
                            <button type="button" class="vd-btn" onclick="saveNote()">Simpan catatan <span class="ar"><svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12l5 5L20 7"/></svg></span></button>
                        </div>
                    </section>
                </div>

                <!-- ============ KOLOM KANAN ============ -->
                <div class="vd-col">
                    <section class="vd-list" aria-label="Daftar materi video">
                        <div class="vd-list-head">
                            <div class="vd-badge-ic" aria-hidden="true">
                                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.75 11.17l-3.2-2.13A1 1 0 0010 9.87v4.26a1 1 0 001.55.83l3.2-2.13a1 1 0 000-1.66z"/><circle cx="12" cy="12" r="9"/></svg>
                            </div>
                            <div>
                                <h3>Daftar Materi Video</h3>
                                <p>Pilih video untuk diputar.</p>
                            </div>
                        </div>
                        <div class="vd-items">
                            @foreach($videos as $v)
                                <button type="button"
                                    class="vd-item playlist-btn {{ $loop->first ? 'active' : '' }}"
                                    data-id="{{ $v['id'] }}"
                                    data-badge="{{ $v['badge'] }}"
                                    data-title="{{ $v['title'] }}"
                                    data-desc="{{ $v['desc'] }}"
                                    onclick="changeVideo(this)">
                                    <span class="vd-thumb">
                                        <img src="https://img.youtube.com/vi/{{ $v['id'] }}/mqdefault.jpg" alt="Thumbnail {{ $v['short'] }}" loading="lazy">
                                        <span class="vd-play"><svg fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg></span>
                                    </span>
                                    <span>
                                        <h4>{{ $v['short'] }}</h4>
                                        <small>{{ $v['durasi'] }}</small>
                                    </span>
                                </button>
                            @endforeach
                        </div>
                    </section>

                    <section class="vd-ai" aria-label="Diskusi dengan AI">
                        <svg class="vd-arcs" viewBox="0 0 600 600" fill="none" stroke="#fff" stroke-width="1" aria-hidden="true">
                            <circle cx="300" cy="300" r="80"/><circle cx="300" cy="300" r="140"/><circle cx="300" cy="300" r="200"/><circle cx="300" cy="300" r="260"/>
                        </svg>
                        <div class="vd-ai-head">
                            <div class="vd-badge-ic" aria-hidden="true">
                                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.42-4.03 8-9 8a9.9 9.9 0 01-4-.8L3 20l1.3-3.9A7.6 7.6 0 013 12c0-4.42 4.03-8 9-8s9 3.58 9 8z"/></svg>
                            </div>
                            <div>
                                <h3>Diskusi Video bersama AI</h3>
                                <p><i></i> Tanya seputar video</p>
                            </div>
                        </div>
                        <form action="{{ route('ai.tutor.ask') }}" method="POST">
                            @csrf
                            <textarea name="question" rows="3" placeholder="Masih bingung dengan video di atas? Ketik pertanyaanmu di sini..." required></textarea>
                            <button type="submit" class="vd-btn">Kirim pertanyaan <span class="ar"><svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg></span></button>
                        </form>
                    </section>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Ganti video tanpa reload
        function changeVideo(btn) {
            document.getElementById('main-video').src =
                'https://www.youtube.com/embed/' + btn.dataset.id + '?autoplay=1&rel=0';
            document.getElementById('video-badge').innerText = btn.dataset.badge;
            document.getElementById('video-title').innerText = btn.dataset.title;
            document.getElementById('video-desc').innerText = btn.dataset.desc;

            document.querySelectorAll('.playlist-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // Di HP, gulir ke pemutar
            if (window.innerWidth < 1024) {
                const top = document.getElementById('main-video').getBoundingClientRect().top + window.scrollY - 80;
                window.scrollTo({ top: top, behavior: 'smooth' });
            }
        }

        // Catatan (hanya tampilan, sama seperti kode asli)
        function saveNote() {
            const el = document.getElementById('note-saved');
            el.classList.add('on');
            setTimeout(() => el.classList.remove('on'), 2500);
        }
    </script>
</x-sidebar-layout>