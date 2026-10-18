<x-sidebar-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">Panel Guru: Akun Siswa</h2>
    </x-slot>

    <div class="gr">
        @include('guru._head')

        <div class="gr-card">
            <h3>Daftarkan akun siswa baru</h3>
            <form method="POST" action="{{ route('guru.siswa.store') }}" class="gr-form cols">
                @csrf
                <div>
                    <label class="gr-lbl" for="name">Nama lengkap</label>
                    <input id="name" name="name" class="gr-in" value="{{ old('name') }}" required>
                    @error('name') <p class="gr-err">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="gr-lbl" for="email">Email</label>
                    <input id="email" name="email" type="email" class="gr-in" value="{{ old('email') }}" required>
                    @error('email') <p class="gr-err">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="gr-lbl" for="password">Kata sandi (min. 6 karakter)</label>
                    <input id="password" name="password" type="text" class="gr-in" required autocomplete="off">
                    @error('password') <p class="gr-err">{{ $message }}</p> @enderror
                </div>
                <div><button type="submit" class="gr-btn">Buat akun</button></div>
            </form>
        </div>

        <div class="gr-card">
            <h3>Daftar siswa ({{ $siswa->total() }})</h3>
            <div class="gr-wrap">
                <table>
                    <thead><tr><th>Nama</th><th>Email</th><th>Dibuat</th><th></th></tr></thead>
                    <tbody>
                    @forelse ($siswa as $s)
                        <tr>
                            <td>{{ $s->name }}</td>
                            <td>{{ $s->email }}</td>
                            <td>{{ $s->created_at->format('d M Y') }}</td>
                            <td>
                                <form method="POST" action="{{ route('guru.siswa.destroy', $s) }}" onsubmit="return confirm('Hapus akun {{ $s->name }}? Nilainya ikut terhapus.')">
                                    @csrf @method('DELETE')
                                    <button class="gr-del">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="gr-empty">Belum ada akun siswa.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div style="margin-top:1rem">{{ $siswa->links() }}</div>
        </div>
    </div>
</x-sidebar-layout>