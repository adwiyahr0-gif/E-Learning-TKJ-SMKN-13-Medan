<x-sidebar-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">Panel Guru: Kelola Materi</h2>
    </x-slot>

    <div class="gr">
        @include('guru._head')

        <div class="gr-card">
            <h3>Tambah materi baru</h3>
            <form method="POST" action="{{ route('guru.materi.store') }}" enctype="multipart/form-data" class="gr-form">
                @csrf
                <div>
                    <label class="gr-lbl" for="judul">Judul materi</label>
                    <input id="judul" name="judul" class="gr-in" value="{{ old('judul') }}" required>
                    @error('judul') <p class="gr-err">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="gr-lbl" for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4" class="gr-in">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi') <p class="gr-err">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="gr-lbl" for="file">File (PDF, Word, PowerPoint, MP4; maks. 20 MB)</label>
                    <input id="file" name="file" type="file" class="gr-in" accept=".pdf,.doc,.docx,.ppt,.pptx,.mp4">
                    @error('file') <p class="gr-err">{{ $message }}</p> @enderror
                </div>
                <div><button type="submit" class="gr-btn">Simpan materi</button></div>
            </form>
        </div>

        <div class="gr-card">
            <h3>Daftar materi ({{ $materi->total() }})</h3>
            <div class="gr-wrap">
                <table>
                    <thead><tr><th>Judul</th><th>Deskripsi</th><th>File</th><th></th></tr></thead>
                    <tbody>
                    @forelse ($materi as $m)
                        <tr>
                            <td><b>{{ $m->judul }}</b></td>
                            <td>{{ \Illuminate\Support\Str::limit($m->deskripsi, 80) }}</td>
                            <td>
                                @if ($m->file_path)
                                    <a href="{{ asset('storage/' . $m->file_path) }}" target="_blank" style="color:#3f7186;font-weight:600">Buka</a>
                                @else - @endif
                            </td>
                            <td>
                                <form method="POST" action="{{ route('guru.materi.destroy', $m) }}" onsubmit="return confirm('Hapus materi ini?')">
                                    @csrf @method('DELETE')
                                    <button class="gr-del">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="gr-empty">Belum ada materi.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div style="margin-top:1rem">{{ $materi->links() }}</div>
        </div>
    </div>
</x-sidebar-layout>