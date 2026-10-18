@php
    $pg = [
        ['Berapakah panjang maksimal dari sebuah IPv4?', ['16-bit', '32-bit', '64-bit', '128-bit']],
        ['Subnet mask default untuk IP Address Kelas C adalah...', ['255.0.0.0', '255.255.0.0', '255.255.255.0', '255.255.255.255']],
        ['Perangkat yang berfungsi menghubungkan dua atau lebih jaringan dengan subnet berbeda adalah...', ['Hub', 'Switch', 'Router', 'Access Point']],
        ['Perintah di Command Prompt untuk melihat konfigurasi IP Address pada Windows adalah...', ['ping', 'ifconfig', 'ipconfig', 'tracert']],
        ['Layanan yang memberikan IP Address secara otomatis kepada client disebut...', ['DNS Server', 'DHCP Server', 'FTP Server', 'Web Server']],
        ['Lapisan (Layer) OSI yang bertanggung jawab untuk pengalamatan logis (IP) dan routing adalah...', ['Data Link Layer', 'Network Layer', 'Transport Layer', 'Physical Layer']],
        ['Alamat IP 127.0.0.1 biasanya digunakan untuk kebutuhan...', ['Default Gateway', 'Broadcast Network', 'Localhost / Loopback', 'Multicast']],
        ['Topologi jaringan yang menggunakan Switch sebagai titik pusat dinamakan topologi...', ['Ring', 'Bus', 'Mesh', 'Star']],
        ['Berapakah panjang bit dari sebuah MAC Address?', ['16-bit', '32-bit', '48-bit', '64-bit']],
        ['Protokol yang digunakan oleh perintah ping untuk menguji konektivitas adalah...', ['TCP', 'UDP', 'ICMP', 'HTTP']],
    ];
    $essay = [
        'Jelaskan perbedaan mendasar antara IPv4 dan IPv6 secara teknis maupun fungsinya!',
        'Apa yang dimaksud dengan proses Subnetting dalam jaringan, dan apa tujuan utamanya?',
        'Ceritakan secara singkat bagaimana sebuah DHCP Server memberikan alamat IP otomatis (proses DORA)!',
        'Mengapa penggunaan Switch dianggap lebih baik dan lebih efisien dibandingkan Hub?',
        'Jelaskan fungsi Routing Table pada sebuah router dalam menentukan jalur data!',
    ];
    $totalPg = count($pg);
    $total = $totalPg + count($essay);
@endphp

<x-sidebar-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">
                {{ __('Kuis Evaluasi') }}
            </h2>
        </div>
    </x-slot>

    <!-- CSS khusus kuis (diawali "kq-", tidak bergantung pada Tailwind) -->
    <style>
        @import url('https://fonts.bunny.net/css?family=instrument-serif:400');

        .kq, .kq *, .kq *::before, .kq *::after { box-sizing: border-box; }
        .kq {
            --c-main: #2b4c59; --c-main-2: #3f7186; --c-dark: #1e3640;
            --c-gold: #f59e0b; --c-gold-2: #fcd34d; --c-peach: #fff5ec; --c-line: #f1e3d3;
            background: #fff; min-height: 100%;
        }
        .kq h1, .kq h2, .kq h3, .kq h4, .kq p { margin: 0; }
        .kq a { text-decoration: none; color: inherit; }
        .kq button { font: inherit; cursor: pointer; border: 0; background: none; color: inherit; }
        .kq svg { display: block; }
        .kq :focus-visible { outline: 3px solid var(--c-gold); outline-offset: 3px; border-radius: 12px; }
        .kq [hidden] { display: none !important; }
        .kq-display { font-family: 'Instrument Serif', serif; font-weight: 400; letter-spacing: -0.03em; }
        .kq-wrap { max-width: 56rem; margin: 0 auto; padding: 1.5rem 1rem 3rem; display: grid; gap: 1.5rem; }
        @media (min-width: 640px) { .kq-wrap { padding: 2rem 1.5rem 3.5rem; } }

        /* ===== Banner ===== */
        .kq-banner {
            position: relative; overflow: hidden; color: #fff; border-radius: 1.75rem;
            background: linear-gradient(160deg, var(--c-main-2), var(--c-main) 55%, var(--c-dark));
            padding: 1.75rem 1.5rem; display: grid; gap: 1.25rem;
        }
        @media (min-width: 768px) { .kq-banner { padding: 2.25rem 2.5rem; } }
        .kq-arcs { position: absolute; right: -8%; bottom: -80%; width: 32rem; max-width: 90%; opacity: .2; pointer-events: none; }
        .kq-spark { position: absolute; right: 12%; top: 14%; width: 1.8rem; height: 1.8rem; color: var(--c-gold-2); opacity: .8; animation: kq-twinkle 3.5s ease-in-out infinite; pointer-events: none; }
        @keyframes kq-twinkle { 50% { opacity: .25; transform: scale(.85) rotate(20deg); } }

        .kq-top { position: relative; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: .75rem; }
        .kq-live { display: inline-flex; align-items: center; gap: .55rem; font-size: .8rem; font-weight: 600; padding: .35rem .85rem; border-radius: 999px; background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.18); }
        .kq-dot { width: .5rem; height: .5rem; border-radius: 50%; background: #34d399; animation: kq-pulse 1.8s ease-in-out infinite; }
        @keyframes kq-pulse { 50% { opacity: .35; transform: scale(.8); } }
        .kq-timer { font-size: .8rem; font-weight: 700; padding: .35rem .85rem; border-radius: 999px; background: rgba(245,158,11,.18); border: 1px solid rgba(252,211,77,.45); color: var(--c-gold-2); font-variant-numeric: tabular-nums; }
        .kq-title { position: relative; font-size: clamp(1.9rem, 4.5vw, 3rem); line-height: 1.05; }
        .kq-title span { display: block; color: var(--c-gold-2); }
        .kq-sub { position: relative; color: #cfe0e6; line-height: 1.65; max-width: 34rem; }

        .kq-prog { position: relative; }
        .kq-prog-row { display: flex; justify-content: space-between; font-size: .85rem; font-weight: 600; color: #cfe0e6; margin-bottom: .6rem; }
        .kq-prog-row b { color: var(--c-gold-2); }
        .kq-bar { height: .65rem; border-radius: 999px; background: rgba(255,255,255,.15); overflow: hidden; }
        .kq-bar i { display: block; height: 100%; width: 0; border-radius: 999px; background: linear-gradient(110deg, var(--c-gold-2), var(--c-gold)); transition: width .5s; }

        /* ===== Kartu soal ===== */
        .kq-card { padding: 1.5rem; border-radius: 1.5rem; background: var(--c-peach); border: 1px solid var(--c-line); animation: kq-in .35s ease; }
        @media (min-width: 640px) { .kq-card { padding: 2rem; } }
        @keyframes kq-in { from { opacity: 0; transform: translateY(8px); } }
        .kq-tag { display: inline-flex; align-items: center; gap: .4rem; font-size: .72rem; font-weight: 700; padding: .25rem .75rem; border-radius: 999px; background: #fff; border: 1px solid var(--c-line); color: var(--c-main); }
        .kq-tag.essay { background: #fef3c7; border-color: #fde68a; color: #92400e; }
        .kq-q { margin-top: 1rem; font-size: 1.2rem; font-weight: 700; line-height: 1.5; color: #111827; }
        .kq-opts { display: grid; gap: .7rem; margin-top: 1.25rem; }
        .kq-opt { position: relative; display: block; cursor: pointer; }
        .kq-opt input { position: absolute; opacity: 0; inset: 0; width: 100%; height: 100%; margin: 0; cursor: pointer; }
        .kq-opt-in { display: flex; align-items: center; gap: .9rem; padding: .85rem 1rem; border-radius: 1rem; background: #fff; border: 1.5px solid var(--c-line); color: #374151; font-size: .95rem; transition: all .25s; }
        .kq-opt-in b { flex: none; width: 2.2rem; height: 2.2rem; border-radius: .75rem; display: grid; place-items: center; font-size: .85rem; background: var(--c-peach); border: 1px solid var(--c-line); color: var(--c-main); transition: all .25s; }
        .kq-opt:hover .kq-opt-in { border-color: var(--c-main-2); transform: translateX(4px); }
        .kq-opt input:focus-visible + .kq-opt-in { outline: 3px solid var(--c-gold); outline-offset: 2px; }
        .kq-opt input:checked + .kq-opt-in { background: linear-gradient(160deg, var(--c-main-2), var(--c-main)); border-color: var(--c-main); color: #fff; box-shadow: 0 14px 24px -14px rgba(43,76,89,.7); }
        .kq-opt input:checked + .kq-opt-in b { background: var(--c-dark); border-color: var(--c-gold); color: var(--c-gold-2); }

        .kq-text { display: block; width: 100%; margin-top: 1.25rem; padding: 1rem 1.1rem; border-radius: 1rem; border: 1.5px solid var(--c-line); background: #fff; font: inherit; font-size: .95rem; line-height: 1.6; color: #374151; resize: vertical; min-height: 9rem; }
        .kq-text:focus { outline: none; border-color: var(--c-main-2); box-shadow: 0 0 0 4px rgba(63,113,134,.15); }
        .kq-note { display: flex; gap: .75rem; align-items: flex-start; margin-top: 1.25rem; padding: 1rem; border-radius: 1rem; background: #fff; border: 1.5px dashed var(--c-line); font-size: .85rem; line-height: 1.6; color: #374151; }
        .kq-note svg { flex: none; width: 1.4rem; height: 1.4rem; color: var(--c-gold); }

        /* ===== Navigasi ===== */
        .kq-nav { display: flex; align-items: center; justify-content: space-between; gap: .75rem; }
        .kq-btn {
            display: inline-flex; align-items: center; gap: .7rem; font-weight: 700; font-size: .95rem;
            padding: .35rem .35rem .35rem 1.15rem; border-radius: 1rem; color: #1f2937;
            background: linear-gradient(110deg, var(--c-gold-2), var(--c-gold)); transition: transform .2s, box-shadow .2s;
        }
        .kq-btn .ar { width: 2.2rem; height: 2.2rem; border-radius: .75rem; background: #fff; display: grid; place-items: center; transition: transform .25s; }
        .kq-btn .ar svg { width: 1.1rem; height: 1.1rem; }
        .kq-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 22px -10px rgba(245,158,11,.7); }
        .kq-btn:hover .ar { transform: translateX(3px); }
        .kq-btn:disabled { opacity: .7; cursor: not-allowed; transform: none; }
        .kq-ghost { padding: .7rem 1.2rem; border-radius: 1rem; font-weight: 700; font-size: .92rem; border: 1.5px solid var(--c-main); color: var(--c-main); transition: background .2s, color .2s; }
        .kq-ghost:hover { background: var(--c-main); color: #fff; }

        /* ===== Modal peringatan ===== */
        .kq-modal { position: fixed; inset: 0; z-index: 60; display: none; align-items: center; justify-content: center; padding: 1rem; background: rgba(30,54,64,.6); backdrop-filter: blur(4px); opacity: 0; transition: opacity .25s; }
        .kq-modal.show { display: flex; }
        .kq-modal.vis { opacity: 1; }
        .kq-modal-box { width: 100%; max-width: 24rem; text-align: center; padding: 2rem 1.5rem; border-radius: 1.75rem; background: #fff; border: 1px solid var(--c-line); transform: scale(.95); transition: transform .25s; }
        .kq-modal.vis .kq-modal-box { transform: scale(1); }
        .kq-modal-ic { width: 4rem; height: 4rem; margin: 0 auto; border-radius: 1.2rem; background: var(--c-peach); border: 1px solid var(--c-line); display: grid; place-items: center; color: var(--c-gold); }
        .kq-modal-ic svg { width: 2rem; height: 2rem; }
        .kq-modal h3 { margin-top: 1rem; font-size: 1.6rem; color: var(--c-main); }
        .kq-modal p { margin-top: .6rem; font-size: .92rem; line-height: 1.65; color: #6b7280; }
        .kq-modal .kq-btn { margin-top: 1.5rem; }

        /* ===== Hasil ===== */
        .kq-score { position: relative; justify-self: start; text-align: center; padding: 1.25rem 2.25rem; border-radius: 1.4rem; background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.18); }
        .kq-score small { font-size: .75rem; font-weight: 700; letter-spacing: .12em; color: var(--c-gold-2); }
        .kq-score-num { font-size: 4.5rem; line-height: 1; font-variant-numeric: tabular-nums; }
        .kq-score-num span { font-size: 1.6rem; color: #cfe0e6; }
        .kq-grid { display: grid; gap: 1.1rem; grid-template-columns: 1fr; }
        @media (min-width: 640px) { .kq-grid { grid-template-columns: repeat(2, 1fr); } }
        .kq-res { padding: 1.5rem; border-radius: 1.5rem; background: var(--c-peach); border: 1px solid var(--c-line); }
        .kq-res small { display: block; font-size: .78rem; font-weight: 700; color: var(--c-main); }
        .kq-res-num { margin-top: .4rem; font-size: 3.2rem; line-height: 1; color: var(--c-main); }
        .kq-res-num span { font-size: 1.3rem; color: #9ca3af; }
        .kq-res p { margin-top: .5rem; font-size: .88rem; color: #6b7280; }
        .kq-ai { display: grid; gap: 1.1rem; align-items: start; padding: 1.5rem; border-radius: 1.5rem; background: #fff; border: 1.5px dashed var(--c-line); }
        @media (min-width: 640px) { .kq-ai { grid-template-columns: auto 1fr; } }
        .kq-ai-badge { width: 3.2rem; height: 3.2rem; border-radius: 1rem; background: var(--c-peach); border: 1px solid var(--c-line); display: grid; place-items: center; color: var(--c-gold); }
        .kq-ai-badge svg { width: 1.6rem; height: 1.6rem; }
        .kq-ai h4 { font-size: .85rem; font-weight: 700; color: var(--c-main); }
        .kq-ai p { margin-top: .4rem; line-height: 1.7; color: #374151; white-space: pre-line; }

        @media (prefers-reduced-motion: reduce) { .kq *, .kq *::before, .kq *::after { animation: none !important; transition: none !important; } }
    </style>

    <!-- Modal peringatan -->
    <div id="kq-modal" class="kq-modal" role="alertdialog" aria-modal="true" aria-labelledby="kq-modal-title">
        <div class="kq-modal-box">
            <div class="kq-modal-ic" aria-hidden="true">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.9L2.4 17.6A2 2 0 004.1 20.6h15.8a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z"/></svg>
            </div>
            <h3 id="kq-modal-title" class="kq-display">Tunggu dulu!</h3>
            <p id="kq-modal-msg">Pesan peringatan akan muncul di sini.</p>
            <button type="button" class="kq-btn" onclick="closeAlert()">Baik, saya mengerti <span class="ar"><svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12l5 5L20 7"/></svg></span></button>
        </div>
    </div>

    <div class="kq">
        <div class="kq-wrap">

            @if(session('success'))
            <!-- ============ HASIL ============ -->
            <section class="kq-banner" aria-label="Hasil evaluasi">
                <svg class="kq-arcs" viewBox="0 0 600 600" fill="none" stroke="#fff" stroke-width="1" aria-hidden="true">
                    <circle cx="300" cy="300" r="80"/><circle cx="300" cy="300" r="140"/><circle cx="300" cy="300" r="200"/><circle cx="300" cy="300" r="260"/><circle cx="300" cy="300" r="320"/>
                </svg>
                <svg class="kq-spark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M12 2c.6 5.2 4.8 9.4 10 10-5.2.6-9.4 4.8-10 10-.6-5.2-4.8-9.4-10-10 5.2-.6 9.4-4.8 10-10z"/></svg>
                <div class="kq-top"><p class="kq-live"><span class="kq-dot"></span> Evaluasi selesai</p></div>
                <h1 class="kq-display kq-title"><span>Kerja bagus!</span> Evaluasi Selesai</h1>
                <p class="kq-sub">Jawabanmu sudah direkam dan dievaluasi langsung oleh sistem AI.</p>
                <div class="kq-score">
                    <small>NILAI AKHIR</small>
                    <p class="kq-display kq-score-num">{{ session('nilai_akhir') }}<span>/100</span></p>
                </div>
            </section>

            <section aria-label="Rincian penilaian">
                <div class="kq-grid">
                    <div class="kq-res">
                        <small>Pilihan Ganda</small>
                        <p class="kq-display kq-res-num">{{ session('skor') }}<span>/100</span></p>
                        <p>Benar {{ session('benar') }} dari {{ $totalPg }}</p>
                    </div>
                    <div class="kq-res">
                        <small>Essay (dinilai AI)</small>
                        <p class="kq-display kq-res-num">{{ session('skor_essay') }}<span>/100</span></p>
                        <p>Dinilai otomatis oleh AI</p>
                    </div>
                </div>
            </section>

            <section class="kq-ai" aria-label="Ulasan AI Tutor">
                <div class="kq-ai-badge" aria-hidden="true">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.42-4.03 8-9 8a9.9 9.9 0 01-4-.8L3 20l1.3-3.9A7.6 7.6 0 013 12c0-4.42 4.03-8 9-8s9 3.58 9 8z"/></svg>
                </div>
                <div>
                    <h4>Ulasan AI Tutor</h4>
                    <p>{{ session('feedback_ai') }}</p>
                </div>
            </section>

            <div>
                <a href="{{ route('dashboard') }}" class="kq-btn">Kembali ke Dashboard <span class="ar"><svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg></span></a>
            </div>

            @else
            <!-- ============ SOAL ============ -->
            <section class="kq-banner" aria-label="Ujian evaluasi">
                <svg class="kq-arcs" viewBox="0 0 600 600" fill="none" stroke="#fff" stroke-width="1" aria-hidden="true">
                    <circle cx="300" cy="300" r="80"/><circle cx="300" cy="300" r="140"/><circle cx="300" cy="300" r="200"/><circle cx="300" cy="300" r="260"/><circle cx="300" cy="300" r="320"/>
                </svg>
                <svg class="kq-spark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M12 2c.6 5.2 4.8 9.4 10 10-5.2.6-9.4 4.8-10 10-.6-5.2-4.8-9.4-10-10 5.2-.6 9.4-4.8 10-10z"/></svg>

                <div class="kq-top">
                    <p class="kq-live"><span class="kq-dot"></span> Ujian sedang berlangsung</p>
                    <p class="kq-timer">Waktu tersisa: 60:00</p>
                </div>
                <h1 class="kq-display kq-title"><span>Ujian Evaluasi</span> IP Address &amp; Jaringan Komputer</h1>
                <p class="kq-sub">{{ $totalPg }} soal pilihan ganda dan {{ count($essay) }} soal essay. Essay akan dinilai langsung oleh AI Tutor.</p>

                <div class="kq-prog">
                    <div class="kq-prog-row">
                        <span id="progress-text">Pertanyaan 1 dari {{ $total }}</span>
                        <b id="progress-pct">0% selesai</b>
                    </div>
                    <div class="kq-bar"><i id="progress-bar"></i></div>
                </div>
            </section>

            <form action="{{ route('kuis.submit') }}" method="POST" id="quiz-form" style="display:grid; gap:1.25rem;">
                @csrf

                {{-- Pilihan ganda --}}
                @foreach($pg as $i => $soal)
                    @php $n = $i + 1; @endphp
                    <div id="step-{{ $n }}" class="kq-card question-card" @if($n > 1) hidden @endif>
                        <span class="kq-tag">Pilihan Ganda &middot; Soal {{ $n }}</span>
                        <h3 class="kq-q">{{ $soal[0] }}</h3>
                        <div class="kq-opts" role="radiogroup">
                            @foreach($soal[1] as $k => $opsi)
                                <label class="kq-opt">
                                    <input type="radio" name="pg_{{ $n }}" value="{{ chr(65 + $k) }}">
                                    <span class="kq-opt-in"><b>{{ chr(65 + $k) }}</b>{{ $opsi }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                {{-- Essay --}}
                @foreach($essay as $j => $teks)
                    @php $n = $totalPg + $j + 1; $e = $j + 1; @endphp
                    <div id="step-{{ $n }}" class="kq-card question-card" hidden>
                        <span class="kq-tag essay">Essay &middot; Soal {{ $n }}@if($n === $total) (terakhir)@endif</span>
                        <h3 class="kq-q">{{ $teks }}</h3>
                        <textarea name="essay_{{ $e }}" class="kq-text" rows="5" placeholder="Ketik penjelasanmu di sini..."></textarea>

                        @if($n === $total)
                            <div class="kq-note">
                                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 18h6m-5 3h4M12 3a6 6 0 00-3.5 10.9c.6.5 1 1.2 1 2V16h5v-.1c0-.8.4-1.5 1-2A6 6 0 0012 3z"/></svg>
                                <p>Pastikan semua jawaban sudah terisi. Saat kuis dikumpulkan, AI Tutor akan langsung memberikan skor essay dan ulasannya!</p>
                            </div>
                        @endif
                    </div>
                @endforeach

                <!-- Navigasi -->
                <div class="kq-nav">
                    <button type="button" id="btn-prev" class="kq-ghost" onclick="prevStep()" hidden>&larr; Sebelumnya</button>
                    <span style="flex:1"></span>
                    <button type="button" id="btn-next" class="kq-btn" onclick="nextStep()">Selanjutnya <span class="ar"><svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg></span></button>
                    <button type="submit" id="btn-submit" class="kq-btn" onclick="showLoadingState(this)" hidden><span id="submit-text">Simpan &amp; Evaluasi dengan AI</span> <span class="ar"><svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12l5 5L20 7"/></svg></span></button>
                </div>
            </form>
            @endif

        </div>
    </div>

    @if(!session('success'))
    <script>
        let currentStep = 1;
        const totalSteps = {{ $total }};
        const totalPg = {{ $totalPg }};

        function showCustomAlert(message) {
            document.getElementById('kq-modal-msg').innerText = message;
            const modal = document.getElementById('kq-modal');
            modal.classList.add('show');
            setTimeout(() => modal.classList.add('vis'), 10);
        }

        function closeAlert() {
            const modal = document.getElementById('kq-modal');
            modal.classList.remove('vis');
            setTimeout(() => modal.classList.remove('show'), 250);
        }

        function updateUI() {
            document.querySelectorAll('.question-card').forEach(card => card.hidden = true);
            document.getElementById('step-' + currentStep).hidden = false;

            document.getElementById('btn-prev').hidden = (currentStep === 1);
            document.getElementById('btn-next').hidden = (currentStep === totalSteps);
            document.getElementById('btn-submit').hidden = (currentStep !== totalSteps);

            const pct = Math.round(((currentStep - 1) / totalSteps) * 100);
            document.getElementById('progress-bar').style.width = Math.max(pct, 4) + '%';
            document.getElementById('progress-text').innerText = 'Pertanyaan ' + currentStep + ' dari ' + totalSteps;
            document.getElementById('progress-pct').innerText = pct + '% selesai';
        }

        function validateCurrentStep() {
            if (currentStep <= totalPg) {
                if (!document.querySelector('input[name="pg_' + currentStep + '"]:checked')) {
                    showCustomAlert('Kamu harus memilih salah satu jawaban pilihan ganda sebelum bisa lanjut ke soal berikutnya!');
                    return false;
                }
            } else {
                const essayNumber = currentStep - totalPg;
                const essayText = document.querySelector('textarea[name="essay_' + essayNumber + '"]').value.trim();
                if (essayText === '') {
                    showCustomAlert('Kamu harus mengetik jawaban essay terlebih dahulu sebelum bisa lanjut!');
                    return false;
                }
            }
            return true;
        }

        function nextStep() {
            if (!validateCurrentStep()) return;
            if (currentStep < totalSteps) { currentStep++; updateUI(); window.scrollTo({ top: 0, behavior: 'smooth' }); }
        }

        function prevStep() {
            if (currentStep > 1) { currentStep--; updateUI(); window.scrollTo({ top: 0, behavior: 'smooth' }); }
        }

        function showLoadingState(btn) {
            if (!validateCurrentStep()) return;
            btn.style.opacity = '.7';
            document.getElementById('submit-text').innerText = 'AI sedang mengoreksi...';
        }

        document.getElementById('quiz-form').addEventListener('submit', function (e) {
            if (!validateCurrentStep()) e.preventDefault();
        });

        document.addEventListener('DOMContentLoaded', updateUI);
    </script>
    @endif
</x-sidebar-layout>