@php
    $tabs = [
        1 => 'Dasar Jaringan',
        2 => 'Perangkat',
        3 => 'Topologi',
        4 => 'Media & Kabel',
        5 => 'IP Address',
        6 => 'OSI & TCP/IP',
        7 => 'Konfigurasi',
    ];

    // Materi tambahan yang diunggah guru (aman jika tabel belum ada)
    $materiGuru = \Illuminate\Support\Facades\Schema::hasTable('materis')
        ? \App\Models\Materi::latest()->get()
        : collect();
@endphp

<x-sidebar-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">
                {{ __('Modul Materi') }}
            </h2>
        </div>
    </x-slot>

    <!-- CSS khusus halaman materi (diawali "md-", tidak bergantung pada Tailwind) -->
    <style>
        @import url('https://fonts.bunny.net/css?family=instrument-serif:400');

        .md, .md *, .md *::before, .md *::after { box-sizing: border-box; }
        .md {
            --c-main: #2b4c59; --c-main-2: #3f7186; --c-dark: #1e3640;
            --c-gold: #f59e0b; --c-gold-2: #fcd34d; --c-peach: #fff5ec; --c-line: #f1e3d3;
            background: #fff; min-height: 100%;
        }
        .md h1, .md h2, .md h3, .md h4, .md p { margin: 0; }
        .md a { text-decoration: none; color: inherit; }
        .md button { font: inherit; cursor: pointer; border: 0; background: none; color: inherit; }
        .md svg { display: block; }
        .md :focus-visible { outline: 3px solid var(--c-gold); outline-offset: 3px; border-radius: 12px; }
        .md [hidden] { display: none !important; }
        .md-display { font-family: 'Instrument Serif', serif; font-weight: 400; letter-spacing: -0.03em; }
        .md-wrap { max-width: 80rem; margin: 0 auto; padding: 1.5rem 1rem 3rem; display: grid; gap: 1.5rem; }
        @media (min-width: 640px) { .md-wrap { padding: 2rem 1.5rem 3.5rem; } }
        @media (min-width: 1024px) { .md-wrap { padding: 2.25rem 2rem 4rem; } }

        /* ===== Banner ===== */
        .md-banner {
            position: relative; overflow: hidden; color: #fff; border-radius: 1.75rem;
            background: linear-gradient(160deg, var(--c-main-2), var(--c-main) 55%, var(--c-dark));
            padding: 1.75rem 1.5rem; display: grid; gap: .9rem;
        }
        @media (min-width: 768px) { .md-banner { padding: 2.25rem 2.5rem; } }
        .md-arcs { position: absolute; right: -8%; bottom: -90%; width: 32rem; max-width: 90%; opacity: .2; pointer-events: none; }
        .md-spark { position: absolute; right: 12%; top: 16%; width: 1.8rem; height: 1.8rem; color: var(--c-gold-2); opacity: .8; animation: md-twinkle 3.5s ease-in-out infinite; pointer-events: none; }
        @keyframes md-twinkle { 50% { opacity: .25; transform: scale(.85) rotate(20deg); } }
        .md-live { position: relative; justify-self: start; display: inline-flex; align-items: center; gap: .55rem; font-size: .8rem; font-weight: 600; padding: .35rem .85rem; border-radius: 999px; background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.18); }
        .md-dot { width: .5rem; height: .5rem; border-radius: 50%; background: #34d399; animation: md-pulse 1.8s ease-in-out infinite; }
        @keyframes md-pulse { 50% { opacity: .35; transform: scale(.8); } }
        .md-title { position: relative; font-size: clamp(1.9rem, 4.5vw, 3rem); line-height: 1.05; }
        .md-title span { display: block; color: var(--c-gold-2); }
        .md-sub { position: relative; color: #cfe0e6; line-height: 1.65; max-width: 36rem; }

        /* ===== Layout ===== */
        .md-layout { display: grid; gap: 1.5rem; align-items: start; }
        @media (min-width: 1024px) { .md-layout { grid-template-columns: 2fr 1fr; } }
        .md-main { display: grid; gap: 1.25rem; min-width: 0; }

        /* ===== Tab ===== */
        .md-tabs { display: flex; gap: .5rem; padding: .5rem; border-radius: 1.25rem; background: var(--c-peach); border: 1px solid var(--c-line); overflow-x: auto; scrollbar-width: none; }
        .md-tabs::-webkit-scrollbar { display: none; }
        .md-tab { flex: none; padding: .65rem 1.1rem; border-radius: .9rem; font-size: .88rem; font-weight: 700; white-space: nowrap; color: #4b5563; transition: all .25s; }
        .md-tab:hover { background: #fff; color: var(--c-main); }
        .md-tab.active { background: linear-gradient(160deg, var(--c-main-2), var(--c-main)); color: #fff; box-shadow: 0 12px 20px -12px rgba(43,76,89,.7); }
        .md-tab.active span { color: var(--c-gold-2); }

        /* ===== Isi materi ===== */
        .md-content { padding: 1.5rem; border-radius: 1.5rem; background: #fff; border: 1px solid var(--c-line); min-height: 32rem; }
        @media (min-width: 768px) { .md-content { padding: 2.25rem 2.5rem; } }
        .md-panel { animation: md-in .4s ease; }
        @keyframes md-in { from { opacity: 0; transform: translateY(6px); } }
        .md-tag { display: inline-flex; font-size: .72rem; font-weight: 700; padding: .25rem .8rem; border-radius: 999px; background: var(--c-peach); border: 1px solid var(--c-line); color: var(--c-main); }
        .md-h2 { margin-top: .9rem; margin-bottom: 1.25rem; font-size: clamp(1.9rem, 3.4vw, 2.6rem); line-height: 1.08; color: var(--c-main); }

        .md-prose { line-height: 1.75; color: #374151; font-size: .96rem; }
        .md-prose > p { margin: 0 0 1rem; }
        .md-prose strong { color: #111827; }
        .md-prose h3 { margin: 2rem 0 .9rem; padding-bottom: .55rem; border-bottom: 1px solid var(--c-line); font-size: 1.2rem; font-weight: 700; color: var(--c-main); }
        .md-prose ul { margin: .5rem 0 1rem; padding-left: 1.3rem; }
        .md-prose li { margin: .4rem 0; }
        .md-prose code { padding: .15rem .45rem; border-radius: .5rem; background: var(--c-peach); border: 1px solid var(--c-line); font-size: .82rem; word-break: break-all; color: var(--c-main); }
        .md-note { font-size: .78rem; color: #6b7280; margin: -.4rem 0 1rem; }

        .md-callout { margin: 1.25rem 0; padding: 1rem 1.25rem; border-radius: 1.1rem; background: var(--c-peach); border: 1px solid var(--c-line); border-left: 4px solid var(--c-gold); }
        .md-callout p { font-weight: 700; color: var(--c-main); margin: 0; }
        .md-callout ul { font-size: .9rem; margin: .6rem 0 0; }

        .md-grid { display: grid; gap: 1rem; margin-top: 1rem; grid-template-columns: 1fr; }
        @media (min-width: 768px) { .md-grid { grid-template-columns: repeat(2, 1fr); } .md-span2 { grid-column: 1 / -1; } }
        .md-stack { display: grid; gap: 1rem; margin-top: 1rem; }
        .md-box { padding: 1.25rem; border-radius: 1.25rem; background: var(--c-peach); border: 1px solid var(--c-line); transition: transform .3s, box-shadow .3s; }
        .md-box:hover { transform: translateY(-3px); box-shadow: 0 16px 26px -16px rgba(43,76,89,.45); }
        .md-box h4 { display: flex; align-items: center; gap: .6rem; font-size: 1.05rem; font-weight: 700; color: #111827; }
        .md-box h4 .e { display: grid; place-items: center; width: 2.4rem; height: 2.4rem; border-radius: .8rem; background: #fff; border: 1px solid var(--c-line); font-size: 1.15rem; }
        .md-box > p { margin: .7rem 0 0; font-size: .9rem; line-height: 1.7; }
        .md-box.hl { border-left: 4px solid var(--c-gold); }
        .md-box.feature { background: linear-gradient(160deg, var(--c-main-2), var(--c-main) 60%, var(--c-dark)); border-color: var(--c-main); color: #cfe0e6; }
        .md-box.feature h4, .md-box.feature strong { color: #fff; }
        .md-box.feature h4 small { font-weight: 500; font-size: .8rem; color: var(--c-gold-2); }
        .md-box.feature > p { color: #cfe0e6; }
        .md-sub-h { margin-bottom: .2rem; font-weight: 700; color: var(--c-main); font-size: 1.02rem; }
        .md-box ul { margin: .6rem 0 0; padding-left: 1.2rem; font-size: .9rem; }
        .md-pc { margin-top: .8rem; display: grid; gap: .35rem; font-size: .84rem; line-height: 1.6; }
        .md-pc p { margin: 0; }
        .good { color: #059669; font-weight: 700; }
        .bad { color: #dc2626; font-weight: 700; }
        .md-pc2 { display: grid; gap: .75rem; margin-top: .8rem; font-size: .88rem; line-height: 1.65; }
        @media (min-width: 768px) { .md-pc2 { grid-template-columns: repeat(2, 1fr); } }
        .md-pc2 div { padding: .9rem 1rem; border-radius: 1rem; background: #fff; border: 1px solid var(--c-line); color: #374151; }
        .md-pc2 .good, .md-pc2 .bad { display: block; margin-bottom: .25rem; }

        /* Tabel */
        .md-table-wrap { overflow-x: auto; margin-top: 1rem; border-radius: 1.1rem; border: 1px solid var(--c-line); }
        .md-table { width: 100%; border-collapse: collapse; font-size: .88rem; min-width: 34rem; }
        .md-table th { padding: .8rem 1rem; text-align: left; background: var(--c-main); color: #fff; font-weight: 700; }
        .md-table td { padding: .8rem 1rem; border-top: 1px solid var(--c-line); }
        .md-table tr:nth-child(even) td { background: var(--c-peach); }
        .md-table td.c { text-align: center; }

        /* Lapisan OSI */
        .md-layers { display: grid; gap: .6rem; margin-top: 1rem; }
        .md-layer { display: flex; align-items: center; gap: .9rem; padding: .8rem 1rem; border-radius: 1rem; background: #fff; border: 1.5px solid var(--c-line); transition: transform .25s; }
        .md-layer:hover { transform: translateX(4px); }
        .md-layer .n { flex: none; width: 2.4rem; height: 2.4rem; border-radius: .8rem; display: grid; place-items: center; font-weight: 700; background: #e8f1f5; color: var(--c-main); }
        .md-layer b { color: #111827; font-size: .95rem; }
        .md-layer p { margin: .15rem 0 0; font-size: .8rem; line-height: 1.55; color: #6b7280; }
        .md-layer.t .n { background: #d1fae5; color: #047857; }
        .md-layer.n3 { border-color: #fecaca; } .md-layer.n3 .n { background: #fee2e2; color: #b91c1c; }
        .md-layer.n2 { border-color: #bfdbfe; } .md-layer.n2 .n { background: #dbeafe; color: #1d4ed8; }
        .md-layer.n1 .n { background: #f3f4f6; color: #4b5563; }

        /* Terminal */
        .md-cmds { display: grid; gap: .9rem; margin: 1rem 0; padding: 0; list-style: none; }
        .md-cmd { padding: 1rem 1.2rem; border-radius: 1.1rem; background: var(--c-dark); color: #6ee7b7; font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-size: .88rem; box-shadow: 0 14px 24px -16px rgba(30,54,64,.8); }
        .md-cmd b { color: #fff; }
        .md-cmd p { margin: .6rem 0 0; font-family: system-ui, sans-serif; font-size: .8rem; line-height: 1.65; color: #b6cbd3; }
        .md-cmd p strong { color: var(--c-gold-2); }
        .md-mono { margin-top: .5rem; padding: .5rem; border-radius: .7rem; background: #fff; border: 1px solid var(--c-line); text-align: center; font-family: ui-monospace, monospace; font-size: .78rem; font-weight: 700; color: var(--c-main); }
        .md-seq { margin-top: .6rem; text-align: center; font-size: .75rem; font-weight: 600; }

        /* Navigasi bab */
        .md-nav { display: flex; align-items: center; justify-content: space-between; gap: .75rem; margin-top: 2rem; padding-top: 1.25rem; border-top: 1px solid var(--c-line); }
        .md-btn {
            display: inline-flex; align-items: center; gap: .7rem; font-weight: 700; font-size: .92rem;
            padding: .35rem .35rem .35rem 1.15rem; border-radius: 1rem; color: #1f2937;
            background: linear-gradient(110deg, var(--c-gold-2), var(--c-gold)); transition: transform .2s, box-shadow .2s;
        }
        .md-btn .ar { width: 2.2rem; height: 2.2rem; border-radius: .75rem; background: #fff; display: grid; place-items: center; transition: transform .25s; }
        .md-btn .ar svg { width: 1.1rem; height: 1.1rem; }
        .md-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 22px -10px rgba(245,158,11,.7); }
        .md-btn:hover .ar { transform: translateX(3px); }
        .md-ghost { padding: .7rem 1.2rem; border-radius: 1rem; font-weight: 700; font-size: .9rem; border: 1.5px solid var(--c-main); color: var(--c-main); transition: background .2s, color .2s; }
        .md-ghost:hover { background: var(--c-main); color: #fff; }

        /* ===== Materi tambahan dari guru ===== */
        .md-gr { padding: 1.5rem; border-radius: 1.5rem; background: #fff; border: 1.5px dashed var(--c-line); }
        @media (min-width: 768px) { .md-gr { padding: 2rem 2.5rem; } }
        .md-gr-h { margin-top: .9rem; margin-bottom: 1.1rem; font-size: clamp(1.7rem, 3vw, 2.2rem); line-height: 1.08; color: var(--c-main); }
        .md-gr-list { display: grid; gap: .9rem; }
        .md-gr-item { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem; padding: 1.1rem 1.25rem; border-radius: 1.25rem; background: var(--c-peach); border: 1px solid var(--c-line); border-left: 4px solid var(--c-gold); }
        .md-gr-body { min-width: 0; flex: 1 1 16rem; }
        .md-gr-body h4 { font-size: 1.02rem; font-weight: 700; color: #111827; }
        .md-gr-body p { margin-top: .35rem; font-size: .88rem; line-height: 1.65; color: #4b5563; white-space: pre-line; overflow-wrap: anywhere; }
        .md-gr-body small { display: block; margin-top: .4rem; font-size: .74rem; color: #9ca3af; }

        /* ===== AI Tutor ===== */
        .md-side { min-width: 0; }
        .md-ai { position: relative; overflow: hidden; border-radius: 1.5rem; color: #fff; background: linear-gradient(160deg, var(--c-main-2), var(--c-main) 55%, var(--c-dark)); }
        @media (min-width: 1024px) { .md-ai { position: sticky; top: 6rem; } }
        .md-ai .md-arcs { bottom: -70%; right: -30%; width: 22rem; }
        .md-ai-head { position: relative; display: flex; align-items: center; gap: .9rem; padding: 1.25rem 1.25rem .6rem; }
        .md-ai-ic { flex: none; width: 3.2rem; height: 3.2rem; border-radius: 1rem; background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.2); display: grid; place-items: center; color: var(--c-gold-2); }
        .md-ai-ic svg { width: 1.6rem; height: 1.6rem; }
        .md-ai-head h3 { font-size: 1.05rem; font-weight: 700; }
        .md-ai-head p { display: flex; align-items: center; gap: .4rem; margin-top: .2rem; font-size: .74rem; color: #cfe0e6; }
        .md-ai-head p i { width: .45rem; height: .45rem; border-radius: 50%; background: #34d399; animation: md-pulse 1.8s ease-in-out infinite; }
        .md-ai-body { position: relative; padding: .6rem 1.25rem 1.25rem; display: grid; gap: .9rem; }
        .md-ai-body > p { font-size: .88rem; line-height: 1.65; color: #cfe0e6; }
        .md-ai textarea { width: 100%; padding: .9rem 1rem; border-radius: 1rem; border: 1.5px solid rgba(255,255,255,.22); background: rgba(255,255,255,.1); color: #fff; font: inherit; font-size: .88rem; line-height: 1.55; resize: vertical; }
        .md-ai textarea::placeholder { color: #a9c3cd; }
        .md-ai textarea:focus { outline: none; border-color: var(--c-gold-2); background: rgba(255,255,255,.16); }
        .md-ai .md-btn { justify-content: space-between; }

        @media (prefers-reduced-motion: reduce) { .md *, .md *::before, .md *::after { animation: none !important; transition: none !important; } }
    </style>

    <div class="md">
        <div class="md-wrap">

            <!-- ============ BANNER ============ -->
            <section class="md-banner" aria-label="Modul materi">
                <svg class="md-arcs" viewBox="0 0 600 600" fill="none" stroke="#fff" stroke-width="1" aria-hidden="true">
                    <circle cx="300" cy="300" r="80"/><circle cx="300" cy="300" r="140"/><circle cx="300" cy="300" r="200"/><circle cx="300" cy="300" r="260"/><circle cx="300" cy="300" r="320"/>
                </svg>
                <svg class="md-spark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M12 2c.6 5.2 4.8 9.4 10 10-5.2.6-9.4 4.8-10 10-.6-5.2-4.8-9.4-10-10 5.2-.6 9.4-4.8 10-10z"/></svg>
                <p class="md-live"><span class="md-dot"></span> {{ count($tabs) }} bab materi</p>
                <h1 class="md-display md-title"><span>Modul Materi</span> Jaringan Komputer Terpadu</h1>
                <p class="md-sub">Pelajari konsep dasar, perangkat, topologi, pengalamatan IP, hingga konfigurasi jaringan. Ada yang membingungkan? Tanya AI Tutor di samping.</p>
            </section>

            <div class="md-layout">

                <!-- ============ KOLOM KIRI: MATERI ============ -->
                <div class="md-main">

                    <div class="md-tabs" role="tablist" aria-label="Daftar bab">
                        @foreach($tabs as $i => $label)
                            <button type="button" role="tab" id="tab-btn-{{ $i }}" class="md-tab tab-btn {{ $i === 1 ? 'active' : '' }}" aria-selected="{{ $i === 1 ? 'true' : 'false' }}" onclick="switchTab({{ $i }})"><span>{{ $i }}.</span> {{ $label }}</button>
                        @endforeach
                    </div>

                    <div class="md-content" id="md-content">

                        <!-- ================= MODUL 1 ================= -->
                        <div id="modul-1" class="md-panel modul-content">
                            <span class="md-tag">Bab 1</span>
                            <h2 class="md-display md-h2">Konsep Dasar Jaringan Komputer</h2>
                            <div class="md-prose">
                                <p><strong>Jaringan Komputer (Computer Network)</strong> adalah suatu sistem yang terdiri dari dua atau lebih komputer yang saling terhubung satu sama lain melalui media transmisi atau media komunikasi sehingga dapat saling berbagi data, aplikasi, maupun perangkat keras (seperti printer dan scanner).</p>

                                <div class="md-callout">
                                    <p>💡 Tujuan Utama Jaringan Komputer:</p>
                                    <ul>
                                        <li><strong>Resource Sharing:</strong> Berbagi sumber daya keras maupun lunak.</li>
                                        <li><strong>High Reliability:</strong> Memiliki sumber alternatif persediaan data (backup).</li>
                                        <li><strong>Saving Money:</strong> Menghemat pengeluaran perusahaan (misal: 1 printer untuk 10 komputer).</li>
                                        <li><strong>Communication:</strong> Memudahkan komunikasi antar pengguna (email, chat, video call).</li>
                                    </ul>
                                </div>

                                <h3>A. Klasifikasi Jaringan Berdasarkan Geografis</h3>
                                <ul>
                                    <li><strong>1. PAN (Personal Area Network)</strong><br>Jaringan dengan jarak sangat dekat, biasanya hanya dalam hitungan meter. Contoh: Menghubungkan HP ke laptop menggunakan Bluetooth, atau perangkat <em>Smart Home</em>.</li>
                                    <li><strong>2. LAN (Local Area Network)</strong><br>Jaringan yang mencakup wilayah kecil seperti satu ruangan, lab komputer, gedung kantor, atau sekolah. Biasanya dibangun menggunakan teknologi Ethernet (kabel UTP) atau Wi-Fi (WLAN). Kecepatannya sangat tinggi (hingga 10 Gbps).</li>
                                    <li><strong>3. MAN (Metropolitan Area Network)</strong><br>Gabungan dari beberapa LAN yang mencakup sebuah kota. Jangkauannya bisa mencapai 10 hingga 50 km. Contoh: Jaringan antar kantor cabang bank di satu kota.</li>
                                    <li><strong>4. WAN (Wide Area Network)</strong><br>Jaringan komputer yang mencakup area yang sangat luas, meliputi antar kota, negara, hingga benua. WAN umumnya membutuhkan perangkat router dan saluran komunikasi publik seperti satelit atau kabel bawah laut. Internet adalah contoh WAN terbesar di dunia.</li>
                                </ul>

                                <h3>B. Klasifikasi Berdasarkan Arsitektur (Peranan Komputer)</h3>
                                <div class="md-grid">
                                    <div class="md-box">
                                        <h4><span class="e">🖥️</span> Client - Server</h4>
                                        <p>Terdapat satu atau beberapa komputer yang bertindak khusus sebagai pelayan (Server) yang menyediakan resource, dan komputer lain bertindak sebagai penerima/klien (Client). Keamanan terpusat dan manajemen data lebih mudah.</p>
                                    </div>
                                    <div class="md-box">
                                        <h4><span class="e">🤝</span> Peer to Peer (P2P)</h4>
                                        <p>Setiap komputer dalam jaringan memiliki kedudukan yang sama. Sebuah komputer bisa menjadi server sekaligus client dalam waktu bersamaan. Cocok untuk jaringan skala kecil (di bawah 10 komputer).</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ================= MODUL 2 ================= -->
                        <div id="modul-2" class="md-panel modul-content" hidden>
                            <span class="md-tag">Bab 2</span>
                            <h2 class="md-display md-h2">Perangkat Keras Jaringan (Network Hardware)</h2>
                            <div class="md-prose">
                                <p>Untuk menghubungkan komputer-komputer sehingga menjadi sebuah jaringan yang utuh, dibutuhkan alat-alat fisik yang memiliki kecerdasan dan fungsi spesifik. Berikut adalah komponen vital penyusun jaringan:</p>

                                <div class="md-stack">
                                    <div class="md-box">
                                        <h4><span class="e">🔌</span> 1. NIC (Network Interface Card)</h4>
                                        <p>Dikenal juga sebagai LAN Card. Merupakan perangkat yang dipasang pada motherboard komputer agar dapat terhubung ke jaringan. NIC mengubah aliran data paralel dalam komputer menjadi aliran serial untuk ditransmisikan melalui kabel jaringan. Setiap NIC memiliki identitas fisik unik yang disebut <strong>MAC Address</strong> (48-bit).</p>
                                    </div>
                                    <div class="md-box">
                                        <h4><span class="e">🖨️</span> 2. Hub (Dumb Switch)</h4>
                                        <p>Perangkat penyambung (konsentrator) pada topologi Star. Hub bekerja di <strong>Physical Layer (Layer 1)</strong>. Hub sangat "bodoh" karena ia tidak membaca MAC Address tujuan; setiap data yang masuk ke satu port akan di-<em>broadcast</em> (dikirim ke semua port lainnya), sehingga sering memicu tabrakan data (<em>Collision</em>) dan menurunkan performa jaringan.</p>
                                    </div>
                                    <div class="md-box hl">
                                        <h4><span class="e">🎛️</span> 3. Switch</h4>
                                        <p>Merupakan evolusi dari Hub. Switch bekerja di <strong>Data Link Layer (Layer 2)</strong>. Berbeda dengan Hub, Switch menyimpan <strong>MAC Address Table</strong>. Saat paket data datang, Switch membaca MAC Address tujuan dan hanya mengirimkan data ke port yang sesuai. Ini menghilangkan <em>Collision</em> dan membuat jaringan jauh lebih cepat dan aman.</p>
                                    </div>
                                    <div class="md-box hl">
                                        <h4><span class="e">📡</span> 4. Router</h4>
                                        <p>Perangkat yang paling cerdas dalam jaringan LAN. Router bekerja pada <strong>Network Layer (Layer 3)</strong>. Fungsinya adalah menghubungkan <strong>dua atau lebih jaringan yang memiliki Subnet/Network ID berbeda</strong>. Router menggunakan <strong>Routing Table</strong> dan IP Address untuk menentukan rute (jalur) tercepat menuju jaringan tujuan.</p>
                                    </div>
                                    <div class="md-box">
                                        <h4><span class="e">📶</span> 5. Access Point (AP)</h4>
                                        <p>Berfungsi sebagai Hub/Switch namun untuk jaringan nirkabel (Wireless). AP memancarkan sinyal SSID dan mengizinkan perangkat ber-Wi-Fi untuk terhubung ke jaringan kabel (LAN) di belakangnya.</p>
                                    </div>
                                    <div class="md-box">
                                        <h4><span class="e">🔋</span> 6. Repeater</h4>
                                        <p>Fungsi utamanya adalah menerima sinyal yang sudah melemah (karena jarak kabel terlalu jauh), lalu memperkuatnya kembali dan memancarkannya agar sinyal bisa menjangkau jarak yang lebih jauh lagi.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ================= MODUL 3 ================= -->
                        <div id="modul-3" class="md-panel modul-content" hidden>
                            <span class="md-tag">Bab 3</span>
                            <h2 class="md-display md-h2">Topologi Jaringan</h2>
                            <div class="md-prose">
                                <p><strong>Topologi Jaringan</strong> adalah metode, pola, atau struktur geometris yang digunakan untuk menghubungkan komputer-komputer dalam suatu jaringan. Pemilihan topologi sangat bergantung pada biaya, skalabilitas, dan keandalan yang dibutuhkan perusahaan.</p>

                                <div class="md-grid">
                                    <div class="md-box">
                                        <h4><span class="e">🚌</span> Topologi Bus</h4>
                                        <p>Menggunakan sebuah kabel utama (kabel backbone) berjenis Coaxial yang panjang, dan semua komputer dihubungkan ke kabel utama tersebut menggunakan konektor BNC/T-Connector. Di ujung kabel harus ditutup dengan <em>Terminator</em>.</p>
                                        <div class="md-pc">
                                            <p><span class="good">Kelebihan:</span> Sangat hemat kabel, instalasi mudah, murah.</p>
                                            <p><span class="bad">Kekurangan:</span> Jika kabel utama putus, SELURUH jaringan mati total. Sering terjadi tabrakan data (collision).</p>
                                        </div>
                                    </div>

                                    <div class="md-box">
                                        <h4><span class="e">⭕</span> Topologi Ring (Cincin)</h4>
                                        <p>Setiap komputer terhubung ke dua komputer lainnya, membentuk lingkaran tertutup seperti cincin. Data mengalir dalam satu arah melewati setiap node menggunakan mekanisme "Token".</p>
                                        <div class="md-pc">
                                            <p><span class="good">Kelebihan:</span> Tidak ada tabrakan data karena aliran data satu arah teratur.</p>
                                            <p><span class="bad">Kekurangan:</span> Jika satu komputer/node mati, aliran data terputus dan jaringan lumpuh seluruhnya.</p>
                                        </div>
                                    </div>

                                    <div class="md-box feature md-span2">
                                        <h4><span class="e">⭐</span> <span>Topologi Star (Bintang) <small>&mdash; Paling umum digunakan</small></span></h4>
                                        <p>Setiap komputer ditarik kabel masing-masing dan dihubungkan secara terpusat ke perangkat konsentrator sentral, yaitu <strong>Switch atau Hub</strong>.</p>
                                        <div class="md-pc2">
                                            <div><span class="good">Kelebihan utama:</span> Tingkat keamanan tinggi. Jika satu kabel dari komputer A putus, jaringan komputer B, C, D tidak akan terpengaruh sama sekali. Sangat mudah menambah komputer baru (skalabilitas tinggi).</div>
                                            <div><span class="bad">Kekurangan:</span> Membutuhkan kabel (UTP) yang sangat banyak (biaya lebih tinggi). Bergantung penuh pada sentral (jika Switch rusak, seluruh jaringan hancur).</div>
                                        </div>
                                    </div>

                                    <div class="md-box">
                                        <h4><span class="e">🕸️</span> Topologi Mesh (Jala)</h4>
                                        <p>Topologi yang sangat ekstrim dimana setiap komputer terhubung secara <strong>langsung (Dedicated Link)</strong> ke setiap komputer lain di jaringan tersebut.</p>
                                        <div class="md-pc">
                                            <p><span class="good">Kelebihan:</span> Kecepatan transfer super cepat, privasi sangat aman, fault tolerance mutlak (anti down).</p>
                                            <p><span class="bad">Kekurangan:</span> Biaya sangat luar biasa mahal, kabel rumit dan menumpuk, konfigurasi paling sulit.</p>
                                        </div>
                                    </div>

                                    <div class="md-box">
                                        <h4><span class="e">🌳</span> Topologi Tree (Pohon / Hierarki)</h4>
                                        <p>Gabungan dari topologi Star dan Bus. Biasa digunakan di gedung bertingkat atau perusahaan besar. Memiliki tingkatan (Root, Core, Distribution, Access).</p>
                                        <div class="md-pc">
                                            <p><span class="good">Kelebihan:</span> Manajemen data berpusat dan mudah diatur dalam skala sangat besar.</p>
                                            <p><span class="bad">Kekurangan:</span> Jika kabel utama (backbone) atau switch atas (Root) mati, seluruh cabang di bawahnya akan terputus.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ================= MODUL 4 ================= -->
                        <div id="modul-4" class="md-panel modul-content" hidden>
                            <span class="md-tag">Bab 4</span>
                            <h2 class="md-display md-h2">Media Transmisi dan Pengkabelan</h2>
                            <div class="md-prose">
                                <p>Media transmisi adalah jalur fisik atau non-fisik yang dilalui oleh data dari pengirim ke penerima. Media terbagi menjadi dua kategori utama:</p>

                                <h3>1. Guided Media (Wired / Kabel Fisik)</h3>
                                <div class="md-stack">
                                    <div class="md-box">
                                        <p class="md-sub-h">A. Kabel Coaxial</p>
                                        <p>Mirip kabel antena televisi. Terdiri dari inti tembaga tunggal, lapisan isolator plastik, anyaman kawat pelindung (shield), dan jaket luar. Konektornya disebut <strong>BNC</strong>. Dulu dipakai untuk topologi Bus, sekarang jarang dipakai untuk jaringan LAN, dialihkan untuk CCTV Analog.</p>
                                    </div>
                                    <div class="md-box">
                                        <p class="md-sub-h">B. Kabel Twisted Pair (Kabel Pilin)</p>
                                        <p>Kabel tembaga yang dipilin berpasangan untuk mengurangi gangguan interferensi elektromagnetik (EMI). Ini adalah kabel paling standar untuk topologi Star (Ethernet). Konektor yang digunakan adalah <strong>RJ-45</strong>. Terbagi menjadi 2 jenis:</p>
                                        <ul>
                                            <li><strong>UTP (Unshielded Twisted Pair):</strong> Tidak memiliki pelindung aluminium foil. Paling murah dan fleksibel. Standar untuk indoor. Kategori yang populer: Cat5e (1 Gbps) dan Cat6 (10 Gbps).</li>
                                            <li><strong>STP/FTP (Shielded/Foiled):</strong> Memiliki lapisan pelindung foil logam. Digunakan untuk luar ruangan (outdoor) atau area pabrik yang memiliki gangguan elektromagnetik tinggi.</li>
                                        </ul>
                                    </div>
                                    <div class="md-box">
                                        <p class="md-sub-h">C. Fiber Optic (Serat Optik)</p>
                                        <p>Tidak menggunakan tembaga/listrik, melainkan <strong>serat kaca atau plastik murni setipis rambut</strong>. Data dikirim menggunakan pulsa CAHAYA (Laser/LED). Sangat revolusioner.</p>
                                        <ul>
                                            <li><strong>Kelebihan:</strong> Kecepatan bandwidth gigabit hingga terabit, tidak bisa disadap, tidak terpengaruh petir atau cuaca, bisa menempuh jarak ratusan kilometer (kabel bawah laut).</li>
                                            <li><strong>Jenis:</strong> <em>Singlemode</em> (jarak sangat jauh, inti kaca sangat kecil) dan <em>Multimode</em> (jarak dekat/menengah, inti kaca lebih besar).</li>
                                        </ul>
                                    </div>
                                </div>

                                <h3>2. Unguided Media (Wireless / Nirkabel)</h3>
                                <p>Media yang mentransmisikan gelombang elektromagnetik tanpa menggunakan konduktor fisik (kabel). Media perantaranya adalah hampa udara.</p>
                                <ul>
                                    <li><strong>Gelombang Radio (Wi-Fi):</strong> Standar 802.11 (a/b/g/n/ac/ax). Berjalan di frekuensi 2.4 GHz (jangkauan luas, rawan gangguan) dan 5 GHz (kecepatan tinggi, jangkauan pendek).</li>
                                    <li><strong>Gelombang Mikro (Microwave):</strong> Menggunakan parabola point-to-point antar gedung. Butuh kondisi Line of Sight (tanpa halangan gedung/pohon).</li>
                                    <li><strong>Satelit:</strong> Untuk menjangkau area pegunungan, tengah laut, atau pedalaman yang tidak tersentuh fiber optic (Contoh: Starlink, VSAT).</li>
                                </ul>
                            </div>
                        </div>

                        <!-- ================= MODUL 5 ================= -->
                        <div id="modul-5" class="md-panel modul-content" hidden>
                            <span class="md-tag">Bab 5</span>
                            <h2 class="md-display md-h2">IP Address dan Pengalamatan Logis</h2>
                            <div class="md-prose">
                                <p><strong>IP Address (Internet Protocol Address)</strong> adalah deretan bilangan biner yang menjadi alamat identifikasi (alamat logika) untuk setiap host komputer di dalam jaringan komputer. IP bertindak layaknya nomor rumah atau nomor plat kendaraan di dunia nyata.</p>

                                <h3>1. IPv4 (Internet Protocol version 4)</h3>
                                <p>Terdiri dari panjang angka biner <strong>32-bit</strong> yang dibagi menjadi 4 kelompok (oktet). Setiap oktet bernilai desimal 0 hingga 255 (Misal: 192.168.1.10). IPv4 dibagi menjadi Kelas (Classful):</p>

                                <div class="md-table-wrap">
                                    <table class="md-table">
                                        <thead>
                                            <tr>
                                                <th>Kelas</th>
                                                <th>Rentang Oktet Pertama</th>
                                                <th>Default Subnet Mask</th>
                                                <th>Penggunaan Skala</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr><td class="c"><strong>A</strong></td><td class="c">1 - 126</td><td class="c">255.0.0.0</td><td>Jaringan raksasa (Jutaan Host)</td></tr>
                                            <tr><td class="c"><strong>B</strong></td><td class="c">128 - 191</td><td class="c">255.255.0.0</td><td>Jaringan menengah besar (Kampus/Korporat)</td></tr>
                                            <tr><td class="c"><strong>C</strong></td><td class="c">192 - 223</td><td class="c">255.255.255.0</td><td>Jaringan kecil (Warnet/Rumah max 254 Host)</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <p class="md-note" style="margin-top:.6rem">Catatan: IP 127.x.x.x di-reserve untuk Loopback/Localhost (mendiagnosa diri sendiri).</p>

                                <h3>2. Subnetting &amp; Pembagian IP</h3>
                                <p>Setiap IP Address pasti tersusun atas 2 bagian yang dipisahkan oleh Subnet Mask:</p>
                                <ul>
                                    <li><strong>Network ID:</strong> Identitas jalan/komplek jaringan. (Komputer yang bisa saling ping langsung tanpa router harus berada di Network ID yang sama).</li>
                                    <li><strong>Host ID:</strong> Identitas nomor rumah/komputer di dalam komplek tersebut. (Host ID tidak boleh bernilai 0 atau 255).</li>
                                </ul>
                                <p><strong>Subnetting</strong> adalah teknik meminjam bit Host ID untuk dijadikan Network ID tambahan. Tujuannya untuk menghemat IP publik, memecah broadcast domain, dan meningkatkan keamanan (segresi jaringan).</p>

                                <h3>3. IPv6 (Internet Protocol version 6)</h3>
                                <p>Karena kuota ~4,2 miliar IPv4 dunia telah habis, dunia sedang bermigrasi ke IPv6. Panjang bitnya mencapai <strong>128-bit</strong> (jumlah IP yang tercipta adalah 2<sup>128</sup> atau 340 Triliun Triliun Triliun alamat). Ditulis menggunakan <strong>Heksadesimal</strong> dipisah titik dua (:). Contoh: <code>2001:0db8:85a3:0000:0000:8a2e:0370:7334</code>.</p>
                            </div>
                        </div>

                        <!-- ================= MODUL 6 ================= -->
                        <div id="modul-6" class="md-panel modul-content" hidden>
                            <span class="md-tag">Bab 6</span>
                            <h2 class="md-display md-h2">Model Referensi OSI dan Arsitektur TCP/IP</h2>
                            <div class="md-prose">
                                <p>Pada tahun 1980-an, banyak vendor komputer (IBM, Apple) menciptakan protokol jaringan sendiri sehingga komputer beda merk tidak bisa "ngobrol". Oleh karena itu, ISO (International Organization for Standardization) membuat standar universal yang disebut <strong>Model OSI (Open Systems Interconnection)</strong>.</p>

                                <h3>A. 7 Lapisan (Layer) OSI Model</h3>
                                <p>Mekanisme pengiriman data dipecah menjadi 7 lapisan yang berurutan. Saat mengirim data (dari atas ke bawah) prosesnya disebut <em>Encapsulation</em>. Saat menerima (dari bawah ke atas) disebut <em>Decapsulation</em>.</p>

                                <div class="md-layers">
                                    <div class="md-layer"><div class="n">7</div><div><b>Application Layer</b><p>Antarmuka langsung dengan pengguna (Browser, Email). Protokol: HTTP, FTP, SMTP, DNS.</p></div></div>
                                    <div class="md-layer"><div class="n">6</div><div><b>Presentation Layer</b><p>Menerjemahkan, mengompresi, dan mengenkripsi data (Format ASCII, JPG, SSL/TLS).</p></div></div>
                                    <div class="md-layer"><div class="n">5</div><div><b>Session Layer</b><p>Membuka, menjaga, dan menutup sesi komunikasi dialog antar 2 perangkat.</p></div></div>
                                    <div class="md-layer t"><div class="n">4</div><div><b>Transport Layer</b><p>Memecah data menjadi <strong>Segmen</strong>. Menjamin data sampai (Protokol: TCP lambat tapi aman, UDP cepat tanpa garansi sampai).</p></div></div>
                                    <div class="md-layer n3"><div class="n">3</div><div><b>Network Layer (Perangkat: Router)</b><p>Menambahkan IP Address. Data menjadi <strong>Paket</strong>. Menentukan rute jalan terbaik (Routing).</p></div></div>
                                    <div class="md-layer n2"><div class="n">2</div><div><b>Data Link Layer (Perangkat: Switch)</b><p>Menambahkan MAC Address. Data dibentuk menjadi <strong>Frame</strong>. Mendeteksi error fisik.</p></div></div>
                                    <div class="md-layer n1"><div class="n">1</div><div><b>Physical Layer (Perangkat: Hub, Kabel)</b><p>Merubah Frame biner (0101) menjadi sinyal listrik, cahaya, atau gelombang radio untuk dikirim ke kabel.</p></div></div>
                                </div>

                                <h3>B. Model TCP/IP (Implementasi Nyata di Dunia)</h3>
                                <p>Model OSI hanya sebatas teori. Di dunia nyata (Internet), standar yang diimplementasikan adalah <strong>TCP/IP Model</strong> yang menyederhanakan 7 Layer OSI menjadi 4 Layer saja:</p>
                                <ul>
                                    <li><strong>Application Layer</strong> (Gabungan Layer 5, 6, 7 OSI)</li>
                                    <li><strong>Transport Layer</strong> (Sama dengan Layer 4 OSI)</li>
                                    <li><strong>Internet Layer</strong> (Sama dengan Layer 3 OSI - IP Protocol)</li>
                                    <li><strong>Network Access Layer</strong> (Gabungan Layer 1, 2 OSI)</li>
                                </ul>
                            </div>
                        </div>

                        <!-- ================= MODUL 7 ================= -->
                        <div id="modul-7" class="md-panel modul-content" hidden>
                            <span class="md-tag">Bab 7</span>
                            <h2 class="md-display md-h2">Dasar Instalasi dan Command Konfigurasi</h2>
                            <div class="md-prose">
                                <p>Seorang Administrator Jaringan dituntut untuk memiliki keterampilan hardware (crimping) dan software (Command Line) dasar.</p>

                                <h3>A. Standar Crimping Kabel UTP (RJ-45)</h3>
                                <p>Dalam pemasangan konektor LAN, organisasi EIA/TIA menetapkan dua standar paten urutan warna, yaitu <strong>T568A</strong> dan <strong>T568B</strong>.</p>

                                <div class="md-grid">
                                    <div class="md-box">
                                        <p class="md-sub-h">1. Kabel Straight-Through</p>
                                        <p>Digunakan menghubungkan <strong>perangkat berbeda jenis</strong> (Misal: PC ke Switch, Router ke Switch).</p>
                                        <p class="md-mono">KEDUA UJUNG = T568B</p>
                                        <p class="md-seq" style="color:#c2410c">PO - O - PH - B - PB - H - PC - C</p>
                                    </div>
                                    <div class="md-box">
                                        <p class="md-sub-h">2. Kabel Crossover</p>
                                        <p>Digunakan menghubungkan <strong>perangkat sejenis</strong> (Misal: PC ke PC, Switch ke Switch, Router ke Router).</p>
                                        <p class="md-mono">UJUNG A = T568B | UJUNG B = T568A</p>
                                        <p class="md-seq" style="color:#047857">PH - H - PO - B - PB - O - PC - C</p>
                                    </div>
                                </div>

                                <h3>B. Utility Command Prompt (CMD) Administrator</h3>
                                <p>Alat-alat (tools) troubleshooting jaringan bawaan sistem operasi Windows/Linux:</p>
                                <ul class="md-cmds">
                                    <li class="md-cmd"><b>C:\&gt;</b> ipconfig /all
                                        <p><strong>Fungsi:</strong> Menampilkan detail super lengkap konfigurasi network card, mulai dari IPv4, IPv6, Subnet Mask, Default Gateway (IP Router), hingga MAC Address (Physical Address) dan DNS Server.</p></li>
                                    <li class="md-cmd"><b>C:\&gt;</b> ping google.com
                                        <p><strong>Fungsi:</strong> Menggunakan protokol ICMP untuk mengirim pesan Echo Request. Jika muncul tulisan "Reply from...", artinya koneksi jaringan sehat dan sukses terhubung.</p></li>
                                    <li class="md-cmd"><b>C:\&gt;</b> tracert google.com
                                        <p><strong>Fungsi:</strong> Trace Route. Menampilkan seluruh titik lompatan (Hops/Router) yang dilalui oleh paket data kita dari komputer lokal hingga mendarat tepat di server tujuan (Google).</p></li>
                                    <li class="md-cmd"><b>C:\&gt;</b> nslookup google.com
                                        <p><strong>Fungsi:</strong> Memeriksa dan memecahkan nama domain ke IP Address (menginterogasi DNS Server untuk mencari tahu berapa sebenarnya IP publik dari google.com).</p></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Navigasi antar bab -->
                        <div class="md-nav">
                            <button type="button" id="md-prev" class="md-ghost" onclick="stepTab(-1)" hidden>&larr; Bab sebelumnya</button>
                            <span style="flex:1"></span>
                            <button type="button" id="md-next" class="md-btn" onclick="stepTab(1)">Bab berikutnya <span class="ar"><svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg></span></button>
                        </div>

                    </div>

                    <!-- ============ MATERI TAMBAHAN DARI GURU ============ -->
                    @if($materiGuru->count())
                    <section class="md-gr" aria-label="Materi tambahan dari guru">
                        <span class="md-tag">Dari guru</span>
                        <h2 class="md-display md-gr-h">Materi Tambahan</h2>
                        <div class="md-gr-list">
                            @foreach($materiGuru as $m)
                                <article class="md-gr-item">
                                    <div class="md-gr-body">
                                        <h4>{{ $m->judul }}</h4>
                                        @if($m->deskripsi)
                                            <p>{{ $m->deskripsi }}</p>
                                        @endif
                                        <small>Ditambahkan {{ $m->created_at->format('d M Y') }}</small>
                                    </div>
                                    @if($m->file_path)
                                        <a href="{{ asset('storage/' . $m->file_path) }}" target="_blank" rel="noopener" class="md-ghost">Buka materi</a>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    </section>
                    @endif
                </div>

                <!-- ============ KOLOM KANAN: AI TUTOR ============ -->
                <aside class="md-side">
                    <section class="md-ai" aria-label="AI Tutor">
                        <svg class="md-arcs" viewBox="0 0 600 600" fill="none" stroke="#fff" stroke-width="1" aria-hidden="true">
                            <circle cx="300" cy="300" r="80"/><circle cx="300" cy="300" r="140"/><circle cx="300" cy="300" r="200"/><circle cx="300" cy="300" r="260"/>
                        </svg>
                        <div class="md-ai-head">
                            <div class="md-ai-ic" aria-hidden="true">
                                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.42-4.03 8-9 8a9.9 9.9 0 01-4-.8L3 20l1.3-3.9A7.6 7.6 0 013 12c0-4.42 4.03-8 9-8s9 3.58 9 8z"/></svg>
                            </div>
                            <div>
                                <h3>AI Tutor Jaringan</h3>
                                <p><i></i> Online &amp; siap membantu</p>
                            </div>
                        </div>
                        <div class="md-ai-body">
                            <p>Ada modul di samping yang bahasanya terlalu rumit? Tanya saja ke Asisten AI, ia akan menjelaskannya dengan perumpamaan sederhana.</p>
                            <form action="{{ route('ai.tutor.ask') }}" method="POST" style="display:grid; gap:.9rem;">
                                @csrf
                                <textarea name="question" rows="4" placeholder="Contoh: Tolong jelaskan perbedaan Layer 2 dan Layer 3 pada OSI dengan bahasa orang awam..." required></textarea>
                                <button type="submit" class="md-btn">Tanyakan ke AI <span class="ar"><svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg></span></button>
                            </form>
                        </div>
                    </section>
                </aside>

            </div>
        </div>
    </div>

    <script>
        const totalTabs = {{ count($tabs) }};
        let activeTab = 1;

        function switchTab(tabId) {
            activeTab = tabId;

            document.querySelectorAll('.modul-content').forEach(el => el.hidden = true);
            document.getElementById('modul-' + tabId).hidden = false;

            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
                btn.setAttribute('aria-selected', 'false');
            });
            const activeBtn = document.getElementById('tab-btn-' + tabId);
            activeBtn.classList.add('active');
            activeBtn.setAttribute('aria-selected', 'true');
            activeBtn.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });

            document.getElementById('md-prev').hidden = (tabId === 1);
            document.getElementById('md-next').hidden = (tabId === totalTabs);
        }

        function stepTab(dir) {
            const next = activeTab + dir;
            if (next < 1 || next > totalTabs) return;
            switchTab(next);
            document.querySelector('.md-tabs').scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    </script>
</x-sidebar-layout>