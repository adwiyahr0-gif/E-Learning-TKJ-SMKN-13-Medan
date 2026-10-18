<style>
    .gr, .gr *, .gr *::before, .gr *::after { box-sizing: border-box; }
    .gr { --c-main:#2b4c59; --c-main-2:#3f7186; --c-gold:#f59e0b; --c-gold-2:#fcd34d; --c-peach:#fff5ec; --c-line:#f1e3d3; max-width: 64rem; margin: 0 auto; padding: 1.5rem 1rem 3rem; display: grid; gap: 1.25rem; }
    .gr h2, .gr h3, .gr p { margin: 0; }
    .gr-tabs { display: flex; gap: .4rem; flex-wrap: wrap; padding: .3rem; background: var(--c-peach); border: 1.5px solid var(--c-line); border-radius: 1rem; width: fit-content; }
    .gr-tabs a { padding: .6rem 1.1rem; border-radius: .75rem; font-weight: 700; font-size: .9rem; color: #6b7280; text-decoration: none; }
    .gr-tabs a:hover { color: var(--c-main); }
    .gr-tabs a.on { background: linear-gradient(110deg, var(--c-gold-2), var(--c-gold)); color: #1f2937; }
    .gr-card { padding: 1.4rem; border-radius: 1.4rem; background: #fff; border: 1.5px dashed var(--c-line); }
    .gr-card h3 { font-size: 1.1rem; font-weight: 700; color: var(--c-main); margin-bottom: 1rem; }
    .gr-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(11rem, 1fr)); gap: 1rem; }
    .gr-stat { padding: 1.2rem; border-radius: 1.2rem; background: var(--c-peach); border: 1px solid var(--c-line); }
    .gr-stat b { display: block; font-size: 1.9rem; color: var(--c-main); }
    .gr-stat span { font-size: .82rem; color: #6b7280; }
    .gr-form { display: grid; gap: .8rem; }
    .gr-form.cols { grid-template-columns: repeat(auto-fit, minmax(13rem, 1fr)); align-items: end; }
    .gr-in { width: 100%; padding: .75rem .9rem; border-radius: .9rem; border: 1.5px solid var(--c-line); background: var(--c-peach); font: inherit; font-size: .92rem; }
    .gr-in:focus { outline: none; background: #fff; border-color: var(--c-main-2); box-shadow: 0 0 0 4px rgba(63,113,134,.15); }
    .gr-lbl { display: block; font-size: .8rem; font-weight: 700; color: var(--c-main); margin-bottom: .3rem; }
    .gr-btn { padding: .8rem 1.3rem; border-radius: .9rem; border: 0; cursor: pointer; font: inherit; font-weight: 700; color: #1f2937; background: linear-gradient(110deg, var(--c-gold-2), var(--c-gold)); }
    .gr-btn:hover { filter: brightness(.97); }
    .gr-del { padding: .4rem .8rem; border-radius: .7rem; border: 1px solid #fecaca; background: #fef2f2; color: #b91c1c; font: inherit; font-size: .8rem; font-weight: 600; cursor: pointer; }
    .gr-ok { padding: .8rem 1rem; border-radius: .9rem; background: #ecfdf5; border: 1px solid #a7f3d0; color: #047857; font-size: .9rem; }
    .gr-err { color: #dc2626; font-size: .82rem; margin-top: .3rem; }
    .gr-wrap { overflow-x: auto; }
    .gr table { width: 100%; border-collapse: collapse; font-size: .9rem; }
    .gr th { text-align: left; padding: .7rem .8rem; background: var(--c-main); color: #fff; font-size: .8rem; white-space: nowrap; }
    .gr th:first-child { border-radius: .8rem 0 0 .8rem; } .gr th:last-child { border-radius: 0 .8rem .8rem 0; }
    .gr td { padding: .7rem .8rem; border-bottom: 1px solid var(--c-line); vertical-align: middle; }
    .gr-empty { padding: 1.5rem; text-align: center; color: #9ca3af; }
    .gr-pill { display: inline-block; padding: .2rem .65rem; border-radius: 999px; font-weight: 700; font-size: .8rem; }
    .gr-hi { background: #d1fae5; color: #047857; } .gr-mid { background: #fef3c7; color: #b45309; } .gr-lo { background: #fee2e2; color: #b91c1c; }
</style>

<nav class="gr-tabs" aria-label="Menu guru">
    <a href="{{ route('guru.nilai') }}" class="{{ request()->routeIs('guru.nilai') ? 'on' : '' }}">Nilai Siswa</a>
    <a href="{{ route('guru.materi.index') }}" class="{{ request()->routeIs('guru.materi.*') ? 'on' : '' }}">Kelola Materi</a>
    <a href="{{ route('guru.kuis.index') }}" class="{{ request()->routeIs('guru.kuis.*') ? 'on' : '' }}">Kelola Kuis</a>
    <a href="{{ route('guru.video.index') }}" class="{{ request()->routeIs('guru.video.*') ? 'on' : '' }}">Kelola Video</a>
    <a href="{{ route('guru.siswa.index') }}" class="{{ request()->routeIs('guru.siswa.*') ? 'on' : '' }}">Akun Siswa</a>
</nav>

@if (session('ok'))
    <div class="gr-ok" role="status">{{ session('ok') }}</div>
@endif