<x-sidebar-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">Panel Guru: Nilai Siswa</h2>
    </x-slot>

    <div class="gr">
        @include('guru._head')

        <div class="gr-stats">
            <div class="gr-stat"><b>{{ $totalSiswa }}</b><span>Total siswa</span></div>
            <div class="gr-stat"><b>{{ $hasil->total() }}</b><span>Hasil kuis tercatat</span></div>
            <div class="gr-stat"><b>{{ $rataRata }}</b><span>Rata-rata nilai</span></div>
        </div>

        <div class="gr-card">
            <h3>Daftar nilai kuis</h3>
            <div class="gr-wrap">
                <table>
                    <thead><tr><th>Siswa</th><th>Email</th><th>Kuis</th><th>Nilai</th><th>Tanggal</th></tr></thead>
                    <tbody>
                    @forelse ($hasil as $h)
                        <tr>
                            <td>{{ $h->user->name ?? '-' }}</td>
                            <td>{{ $h->user->email ?? '-' }}</td>
                            <td>{{ $h->judul }}</td>
                            <td><span class="gr-pill {{ $h->skor >= 75 ? 'gr-hi' : ($h->skor >= 60 ? 'gr-mid' : 'gr-lo') }}">{{ $h->skor }}</span></td>
                            <td>{{ $h->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="gr-empty">Belum ada hasil kuis.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div style="margin-top:1rem">{{ $hasil->links() }}</div>
        </div>
    </div>
</x-sidebar-layout>