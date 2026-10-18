<x-sidebar-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">Panel Guru: Kelola Kuis</h2>
    </x-slot>

    <div class="gr">
        @include('guru._head')

        <div class="gr-card">
            <h3>Tambah soal baru</h3>
            <form method="POST" action="{{ route('guru.kuis.store') }}" class="gr-form" id="form-soal">
                @csrf

                <div>
                    <label class="gr-lbl" for="tipe">Jenis soal</label>
                    <select id="tipe" name="tipe" class="gr-in">
                        <option value="pilihan_ganda" @selected(old('tipe', 'pilihan_ganda') === 'pilihan_ganda')>Pilihan ganda</option>
                        <option value="essay" @selected(old('tipe') === 'essay')>Essay (dinilai AI)</option>
                    </select>
                    @error('tipe') <p class="gr-err">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="gr-lbl" for="pertanyaan">Pertanyaan</label>
                    <textarea id="pertanyaan" name="pertanyaan" rows="3" class="gr-in" required>{{ old('pertanyaan') }}</textarea>
                    @error('pertanyaan') <p class="gr-err">{{ $message }}</p> @enderror
                </div>

                {{-- Khusus pilihan ganda --}}
                <div id="blok-pg" style="display:grid;gap:1rem">
                    @foreach (['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D'] as $k => $huruf)
                        <div>
                            <label class="gr-lbl" for="opsi_{{ $k }}">Opsi {{ $huruf }}</label>
                            <input id="opsi_{{ $k }}" name="opsi_{{ $k }}" class="gr-in" value="{{ old('opsi_' . $k) }}">
                            @error('opsi_' . $k) <p class="gr-err">{{ $message }}</p> @enderror
                        </div>
                    @endforeach

                    <div>
                        <label class="gr-lbl" for="jawaban_benar">Jawaban yang benar</label>
                        <select id="jawaban_benar" name="jawaban_benar" class="gr-in">
                            <option value="">Pilih jawaban benar</option>
                            @foreach (['A', 'B', 'C', 'D'] as $h)
                                <option value="{{ $h }}" @selected(old('jawaban_benar') === $h)>{{ $h }}</option>
                            @endforeach
                        </select>
                        @error('jawaban_benar') <p class="gr-err">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Khusus essay --}}
                <div id="blok-essay" style="display:none">
                    <label class="gr-lbl" for="kunci_essay">Kunci jawaban / acuan penilaian AI (opsional)</label>
                    <textarea id="kunci_essay" name="kunci_essay" rows="3" class="gr-in" placeholder="Poin-poin yang harus ada dalam jawaban siswa">{{ old('kunci_essay') }}</textarea>
                    @error('kunci_essay') <p class="gr-err">{{ $message }}</p> @enderror
                </div>

                <div><button type="submit" class="gr-btn">Simpan soal</button></div>
            </form>
        </div>

        <div class="gr-card">
            <h3>Daftar soal ({{ $jumlahPg }} pilihan ganda, {{ $jumlahEssay }} essay)</h3>
            <div class="gr-wrap">
                <table>
                    <thead><tr><th>Jenis</th><th>Pertanyaan</th><th>Jawaban benar</th><th></th></tr></thead>
                    <tbody>
                    @forelse ($soal as $s)
                        <tr>
                            <td>{{ $s->isPilihanGanda() ? 'Pilihan ganda' : 'Essay' }}</td>
                            <td><b>{{ \Illuminate\Support\Str::limit($s->pertanyaan, 90) }}</b></td>
                            <td>
                                @if ($s->isPilihanGanda())
                                    {{ $s->jawaban_benar }}. {{ $s->{'opsi_' . strtolower($s->jawaban_benar)} }}
                                @else
                                    {{ $s->kunci_essay ? \Illuminate\Support\Str::limit($s->kunci_essay, 50) : '-' }}
                                @endif
                            </td>
                            <td>
                                <form method="POST" action="{{ route('guru.kuis.destroy', $s) }}" onsubmit="return confirm('Hapus soal ini?')">
                                    @csrf @method('DELETE')
                                    <button class="gr-del">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="gr-empty">Belum ada soal.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div style="margin-top:1rem">{{ $soal->links() }}</div>
        </div>
    </div>

    <script>
        (function () {
            const tipe = document.getElementById('tipe');
            const pg = document.getElementById('blok-pg');
            const essay = document.getElementById('blok-essay');
            function atur() {
                const isPg = tipe.value === 'pilihan_ganda';
                pg.style.display = isPg ? 'grid' : 'none';
                essay.style.display = isPg ? 'none' : 'block';
            }
            tipe.addEventListener('change', atur);
            atur();
        })();
    </script>
</x-sidebar-layout>