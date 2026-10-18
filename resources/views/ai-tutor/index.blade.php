@php
    $history = $history ?? session('ai_history', []);
    $pertanyaan = session('ai_question');   // pertanyaan yang gagal dijawab
    $galat = session('ai_error');

    $saran = [
        // ...tetap sama
    ];
@endphp

<x-sidebar-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">
                {{ __('AI Tutor') }}
            </h2>
        </div>
    </x-slot>

    <!-- CSS khusus halaman AI Tutor (diawali "at-", tidak bergantung pada Tailwind) -->
    <style>
        @import url('https://fonts.bunny.net/css?family=instrument-serif:400');

        .at, .at *, .at *::before, .at *::after { box-sizing: border-box; }
        .at {
            --c-main: #2b4c59; --c-main-2: #3f7186; --c-dark: #1e3640;
            --c-gold: #f59e0b; --c-gold-2: #fcd34d; --c-peach: #fff5ec; --c-line: #f1e3d3;
            background: #fff; min-height: 100%;
        }
        .at h1, .at h2, .at h3, .at p { margin: 0; }
        .at button { font: inherit; cursor: pointer; border: 0; background: none; color: inherit; text-align: left; }
        .at svg { display: block; flex: none; }
        .at :focus-visible { outline: 3px solid var(--c-gold); outline-offset: 3px; border-radius: 12px; }
        .at-display { font-family: 'Instrument Serif', serif; font-weight: 400; letter-spacing: -0.03em; }
        .at-wrap { max-width: 56rem; margin: 0 auto; padding: 1.5rem 1rem 3rem; display: grid; gap: 1.5rem; }
        @media (min-width: 640px) { .at-wrap { padding: 2rem 1.5rem 3.5rem; } }

        /* ===== Banner ===== */
        .at-banner {
            position: relative; overflow: hidden; color: #fff; border-radius: 1.75rem;
            background: linear-gradient(160deg, var(--c-main-2), var(--c-main) 55%, var(--c-dark));
            padding: 1.75rem 1.5rem; display: grid; gap: .9rem;
        }
        @media (min-width: 768px) { .at-banner { padding: 2.25rem 2.5rem; } }
        .at-arcs { position: absolute; right: -8%; bottom: -90%; width: 32rem; max-width: 90%; opacity: .2; pointer-events: none; }
        .at-spark { position: absolute; right: 12%; top: 16%; width: 1.8rem; height: 1.8rem; color: var(--c-gold-2); opacity: .8; animation: at-twinkle 3.5s ease-in-out infinite; pointer-events: none; }
        @keyframes at-twinkle { 50% { opacity: .25; transform: scale(.85) rotate(20deg); } }
        .at-live { position: relative; justify-self: start; display: inline-flex; align-items: center; gap: .55rem; font-size: .8rem; font-weight: 600; padding: .35rem .85rem; border-radius: 999px; background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.18); }
        .at-dot { width: .5rem; height: .5rem; border-radius: 50%; background: #34d399; animation: at-pulse 1.8s ease-in-out infinite; }
        @keyframes at-pulse { 50% { opacity: .35; transform: scale(.8); } }
        .at-title { position: relative; font-size: clamp(1.9rem, 4.5vw, 3rem); line-height: 1.05; }
        .at-title span { display: block; color: var(--c-gold-2); }
        .at-sub { position: relative; color: #cfe0e6; line-height: 1.65; max-width: 36rem; }

        /* ===== Percakapan ===== */
        .at-chat { display: grid; gap: 1rem; }
        .at-row { display: flex; gap: .85rem; align-items: flex-start; }
        .at-row.me { flex-direction: row-reverse; }
        .at-av { flex: none; width: 2.8rem; height: 2.8rem; border-radius: 1rem; display: grid; place-items: center; }
        .at-av svg { width: 1.4rem; height: 1.4rem; }
        .at-row.ai .at-av { background: #fff; border: 1px solid var(--c-line); color: var(--c-main); }
        .at-row.me .at-av { background: linear-gradient(110deg, var(--c-gold-2), var(--c-gold)); color: #1f2937; }
        .at-bubble { min-width: 0; max-width: 100%; padding: 1.1rem 1.3rem; border-radius: 1.4rem; line-height: 1.75; font-size: .95rem; }
        .at-row.me .at-bubble { background: linear-gradient(160deg, var(--c-main-2), var(--c-main)); color: #fff; border-top-right-radius: .4rem; overflow-wrap: anywhere; white-space: pre-line; }
        .at-row.ai .at-bubble { flex: 1; background: var(--c-peach); border: 1px solid var(--c-line); color: #374151; border-top-left-radius: .4rem; }
        .at-row.err .at-av { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }
        .at-row.err .at-bubble { flex: 1; background: #fff; border: 1.5px dashed #fecaca; color: #b91c1c; }
        .at-who { display: block; margin-bottom: .45rem; font-size: .75rem; font-weight: 700; color: var(--c-main); }

        /* Hasil markdown dari AI */
        .at-md > :first-child { margin-top: 0; }
        .at-md > :last-child { margin-bottom: 0; }
        .at-md p { margin: 0 0 .85rem; }
        .at-md strong { color: #111827; }
        .at-md h1, .at-md h2, .at-md h3, .at-md h4 { margin: 1.3rem 0 .5rem; font-size: 1.05rem; font-weight: 700; color: var(--c-main); }
        .at-md ul, .at-md ol { margin: .4rem 0 .9rem; padding-left: 1.3rem; }
        .at-md li { margin: .3rem 0; }
        .at-md code { padding: .12rem .4rem; border-radius: .45rem; background: #fff; border: 1px solid var(--c-line); font-size: .82rem; color: var(--c-main); }
        .at-md pre { margin: .8rem 0; padding: 1rem 1.1rem; border-radius: 1rem; background: var(--c-dark); color: #6ee7b7; overflow-x: auto; font-size: .82rem; line-height: 1.6; }
        .at-md pre code { padding: 0; border: 0; background: none; color: inherit; }
        .at-md table { width: 100%; border-collapse: collapse; margin: .8rem 0; font-size: .85rem; display: block; overflow-x: auto; }
        .at-md th { padding: .55rem .8rem; background: var(--c-main); color: #fff; text-align: left; }
        .at-md td { padding: .55rem .8rem; border-top: 1px solid var(--c-line); }
        .at-md blockquote { margin: .8rem 0; padding: .5rem 1rem; border-left: 4px solid var(--c-gold); background: #fff; border-radius: 0 .8rem .8rem 0; }

        /* ===== Kartu tanya ===== */
        .at-ask { padding: 1.5rem; border-radius: 1.5rem; background: #fff; border: 1.5px dashed var(--c-line); }
        .at-ask-head { display: flex; align-items: center; gap: .9rem; margin-bottom: 1rem; }
        .at-badge { flex: none; width: 3.2rem; height: 3.2rem; border-radius: 1rem; background: var(--c-peach); border: 1px solid var(--c-line); display: grid; place-items: center; color: var(--c-gold); }
        .at-badge svg { width: 1.6rem; height: 1.6rem; }
        .at-ask-head h2 { font-size: 1.7rem; line-height: 1.05; color: var(--c-main); }
        .at-ask-head p { margin-top: .2rem; font-size: .85rem; color: #6b7280; }
        .at-text { display: block; width: 100%; padding: 1rem 1.1rem; border-radius: 1rem; border: 1.5px solid var(--c-line); background: var(--c-peach); font: inherit; font-size: .95rem; line-height: 1.6; color: #374151; resize: vertical; min-height: 7rem; }
        .at-text:focus { outline: none; border-color: var(--c-main-2); background: #fff; box-shadow: 0 0 0 4px rgba(63,113,134,.15); }
        .at-err { margin-top: .5rem; font-size: .82rem; font-weight: 600; color: #dc2626; }
        .at-foot { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: .75rem; margin-top: 1rem; }
        .at-count { font-size: .78rem; color: #9ca3af; font-variant-numeric: tabular-nums; }
        .at-btn {
            display: inline-flex; align-items: center; gap: .7rem; font-weight: 700; font-size: .95rem;
            padding: .35rem .35rem .35rem 1.15rem; border-radius: 1rem; color: #1f2937;
            background: linear-gradient(110deg, var(--c-gold-2), var(--c-gold)); transition: transform .2s, box-shadow .2s;
        }
        .at-btn .ar { width: 2.2rem; height: 2.2rem; border-radius: .75rem; background: #fff; display: grid; place-items: center; transition: transform .25s; }
        .at-btn .ar svg { width: 1.1rem; height: 1.1rem; }
        .at-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 22px -10px rgba(245,158,11,.7); }
        .at-btn:hover .ar { transform: translateX(3px); }
        .at-btn:disabled { opacity: .75; cursor: not-allowed; transform: none; box-shadow: none; }

        .at-sug-label { margin: 1.25rem 0 .6rem; font-size: .78rem; font-weight: 700; color: var(--c-main); }
        .at-sug { display: flex; flex-wrap: wrap; gap: .5rem; }
        .at-chip { padding: .5rem .95rem; border-radius: 999px; font-size: .82rem; font-weight: 600; background: var(--c-peach); border: 1px solid var(--c-line); color: var(--c-main); transition: all .25s; }
        .at-chip:hover { background: var(--c-main); border-color: var(--c-main); color: #fff; transform: translateY(-2px); }

        @media (prefers-reduced-motion: reduce) { .at *, .at *::before, .at *::after { animation: none !important; transition: none !important; } }
    </style>

    <div class="at">
        <div class="at-wrap">

            <!-- ============ BANNER ============ -->
            <section class="at-banner" aria-label="AI Tutor">
                <svg class="at-arcs" viewBox="0 0 600 600" fill="none" stroke="#fff" stroke-width="1" aria-hidden="true">
                    <circle cx="300" cy="300" r="80"/><circle cx="300" cy="300" r="140"/><circle cx="300" cy="300" r="200"/><circle cx="300" cy="300" r="260"/><circle cx="300" cy="300" r="320"/>
                </svg>
                <svg class="at-spark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M12 2c.6 5.2 4.8 9.4 10 10-5.2.6-9.4 4.8-10 10-.6-5.2-4.8-9.4-10-10 5.2-.6 9.4-4.8 10-10z"/></svg>
                <p class="at-live"><span class="at-dot"></span> AI Tutor online</p>
                <h1 class="at-display at-title"><span>Tanya AI Tutor</span> Jaringan Komputer</h1>
                <p class="at-sub">Ada materi yang belum dipahami? Tulis pertanyaanmu, dan AI akan menjelaskannya dengan bahasa yang mudah dipahami.</p>
            </section>

            <!-- ============ JAWABAN ============ -->
            <!-- ============ PERCAKAPAN ============ -->
@if(count($history) || $galat)
<section class="at-chat" aria-label="Percakapan" aria-live="polite">

    @foreach($history as $msg)
        @if($msg['role'] === 'user')
        <div class="at-row me">
            <div class="at-av" aria-hidden="true">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 100-8 4 4 0 000 8zm-7 9a7 7 0 0114 0"/></svg>
            </div>
            <div class="at-bubble">{{ $msg['text'] }}</div>
        </div>
        @else
        <div class="at-row ai">
            <div class="at-av" aria-hidden="true">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.42-4.03 8-9 8a9.9 9.9 0 01-4-.8L3 20l1.3-3.9A7.6 7.6 0 013 12c0-4.42 4.03-8 9-8s9 3.58 9 8z"/></svg>
            </div>
            <div class="at-bubble">
                <span class="at-who">AI Tutor</span>
                <div class="at-md">{!! \Illuminate\Support\Str::markdown($msg['text'], ['html_input' => 'escape', 'allow_unsafe_links' => false]) !!}</div>
            </div>
        </div>
        @endif
    @endforeach

    {{-- Pertanyaan yang gagal dijawab + pesan error --}}
    @if($galat)
        @if($pertanyaan)
        <div class="at-row me">
            <div class="at-av" aria-hidden="true">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 100-8 4 4 0 000 8zm-7 9a7 7 0 0114 0"/></svg>
            </div>
            <div class="at-bubble">{{ $pertanyaan }}</div>
        </div>
        @endif
        <div class="at-row err" role="alert">
            <div class="at-av" aria-hidden="true">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.9L2.4 17.6A2 2 0 004.1 20.6h15.8a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z"/></svg>
            </div>
            <div class="at-bubble">
                <span class="at-who" style="color:#b91c1c">Terjadi masalah</span>
                {{ $galat }}
            </div>
        </div>
    @endif

    @if(count($history))
    <form method="POST" action="{{ route('ai.tutor.clear') }}" style="justify-self:end">
        @csrf
        <button type="submit" class="at-chip">Mulai topik baru</button>
    </form>
    @endif
</section>
@endif

            <!-- ============ FORM TANYA ============ -->
            <section class="at-ask" aria-label="Form pertanyaan">
                <div class="at-ask-head">
                    <div class="at-badge" aria-hidden="true">
                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 18h6m-5 3h4M12 3a6 6 0 00-3.5 10.9c.6.5 1 1.2 1 2V16h5v-.1c0-.8.4-1.5 1-2A6 6 0 0012 3z"/></svg>
                    </div>
                    <div>
                        <h2 class="at-display">{{ count($history) ? 'Tanya lagi' : 'Tulis pertanyaanmu' }}</h2>
                        <p>Semakin jelas pertanyaannya, semakin tepat jawabannya.</p>
                    </div>
                </div>

                <form action="{{ route('ai.tutor.ask') }}" method="POST" id="at-form">
                    @csrf
                    <textarea id="at-q" name="question" class="at-text" rows="4" maxlength="1000" required
                        placeholder="Contoh: Tolong jelaskan perbedaan Layer 2 dan Layer 3 pada OSI dengan bahasa orang awam...">{{ old('question') }}</textarea>
                    @error('question')
                        <p class="at-err" role="alert">{{ $message }}</p>
                    @enderror

                    <div class="at-foot">
                        <span class="at-count"><span id="at-n">0</span>/1000 karakter</span>
                        <button type="submit" id="at-submit" class="at-btn">
                            <span id="at-submit-text">Kirim pertanyaan</span>
                            <span class="ar"><svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg></span>
                        </button>
                    </div>
                </form>

                <p class="at-sug-label">Coba tanyakan:</p>
                <div class="at-sug">
                    @foreach($saran as $s)
                        <button type="button" class="at-chip" data-q="{{ $s }}">{{ $s }}</button>
                    @endforeach
                </div>
            </section>

        </div>
    </div>

    <script>
        (function () {
            const q = document.getElementById('at-q');
            const n = document.getElementById('at-n');
            const form = document.getElementById('at-form');
            const btn = document.getElementById('at-submit');

            function count() { n.textContent = q.value.length; }
            q.addEventListener('input', count);
            count();

            // Klik saran: isi kolom pertanyaan
            document.querySelectorAll('.at-chip').forEach(chip => {
                chip.addEventListener('click', () => {
                    q.value = chip.dataset.q;
                    count();
                    q.focus();
                });
            });

            // Tampilkan status menunggu (jawaban AI butuh beberapa detik)
            form.addEventListener('submit', () => {
                if (!q.value.trim()) return;
                btn.disabled = true;
                document.getElementById('at-submit-text').textContent = 'AI sedang menjawab...';
            });

            // Gulir ke pertanyaan terakhir agar jawaban barunya langsung terlihat
const rows = document.querySelectorAll('.at-row.me');
if (rows.length) rows[rows.length - 1].scrollIntoView({ behavior: 'smooth', block: 'start' });
        })();
    </script>
</x-sidebar-layout>