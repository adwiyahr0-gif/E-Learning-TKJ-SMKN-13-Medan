<x-sidebar-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">Panel Guru: Kelola Video</h2>
    </x-slot>

    <div class="gr">
        @include('guru._head')

        <div class="gr-card">
            <h3>Tambah video baru</h3>
            <form method="POST" action="{{ route('guru.video.store') }}" enctype="multipart/form-data" class="gr-form" id="form-video">
                @csrf

                <div>
                    <label class="gr-lbl" for="judul">Judul video</label>
                    <input id="judul" name="judul" class="gr-in" value="{{ old('judul') }}" required>
                    @error('judul') <p class="gr-err">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="gr-lbl" for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3" class="gr-in">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi') <p class="gr-err">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="gr-lbl" for="jenis">Sumber video</label>
                    <select id="jenis" name="jenis" class="gr-in">
                        <option value="youtube" @selected(old('jenis', 'youtube') === 'youtube')>Link YouTube</option>
                        <option value="upload" @selected(old('jenis') === 'upload')>Unggah file MP4</option>
                    </select>
                    @error('jenis') <p class="gr-err">{{ $message }}</p> @enderror
                </div>

                <div id="blok-youtube">
                    <label class="gr-lbl" for="url">Link YouTube</label>
                    <input id="url" name="url" type="url" class="gr-in" placeholder="https://www.youtube.com/watch?v=..." value="{{ old('url') }}">
                    @error('url') <p class="gr-err">{{ $message }}</p> @enderror
                </div>

                <div id="blok-upload" style="display:none">
                    <label class="gr-lbl" for="file">File video (MP4, maks. 50 MB)</label>
                    <input id="file" name="file" type="file" class="gr-in" accept=".mp4,video/mp4">
                    @error('file') <p class="gr-err">{{ $message }}</p> @enderror
                </div>

                <div><button type="submit" class="gr-btn">Simpan video</button></div>
            </form>
        </div>

        <div class="gr-card">
            <h3>Daftar video ({{ $video->total() }})</h3>
            <div class="gr-wrap">
                <table>
                    <thead><tr><th>Judul</th><th>Sumber</th><th>Video</th><th></th></tr></thead>
                    <tbody>
                    @forelse ($video as $v)
                        <tr>
                            <td><b>{{ $v->judul }}</b><br><small>{{ \Illuminate\Support\Str::limit($v->deskripsi, 70) }}</small></td>
                            <td>{{ $v->jenis === 'youtube' ? 'YouTube' : 'File MP4' }}</td>
                            <td>
                                @php($buka = $v->jenis === 'youtube' ? $v->url : $v->file_url)
                                @if ($buka)
                                    <a href="{{ $buka }}" target="_blank" rel="noopener" style="color:#3f7186;font-weight:600">Buka</a>
                                @else - @endif
                            </td>
                            <td>
                                <form method="POST" action="{{ route('guru.video.destroy', $v) }}" onsubmit="return confirm('Hapus video ini?')">
                                    @csrf @method('DELETE')
                                    <button class="gr-del">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="gr-empty">Belum ada video.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div style="margin-top:1rem">{{ $video->links() }}</div>
        </div>
    </div>

    <script>
        (function () {
            const jenis = document.getElementById('jenis');
            const yt = document.getElementById('blok-youtube');
            const up = document.getElementById('blok-upload');
            function atur() {
                const isYt = jenis.value === 'youtube';
                yt.style.display = isYt ? 'block' : 'none';
                up.style.display = isYt ? 'none' : 'block';
            }
            jenis.addEventListener('change', atur);
            atur();
        })();
    </script>
</x-sidebar-layout>