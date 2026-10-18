<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\QuizResult;
use App\Models\Soal;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class GuruController extends Controller
{
    /* ===== NILAI SISWA ===== */
    public function nilai()
    {
        $hasil = QuizResult::with('user')->latest()->paginate(15);

        return view('guru.nilai', [
            'hasil'      => $hasil,
            'totalSiswa' => User::where('role', 'siswa')->count(),
            'rataRata'   => round(QuizResult::avg('skor') ?? 0, 1),
        ]);
    }

    /* ===== AKUN SISWA ===== */
    public function siswaIndex()
    {
        return view('guru.siswa', [
            'siswa' => User::where('role', 'siswa')->latest()->paginate(15),
        ]);
    }

    public function siswaStore(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', Password::min(6)],
        ]);

        User::create($data + ['role' => 'siswa']);

        return back()->with('ok', 'Akun siswa ' . $data['name'] . ' berhasil dibuat.');
    }

    public function siswaDestroy(User $user)
    {
        abort_unless($user->role === 'siswa', 403);

        $user->delete();

        return back()->with('ok', 'Akun siswa dihapus.');
    }

    /* ===== MATERI ===== */
    public function materiIndex()
    {
        return view('guru.materi', [
            'materi' => Materi::latest()->paginate(15),
        ]);
    }

    public function materiStore(Request $request)
    {
        $data = $request->validate([
            'judul'     => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
            'file'      => ['nullable', 'file', 'mimes:pdf,doc,docx,ppt,pptx,mp4', 'max:20480'],
        ]);

        $path = $request->hasFile('file')
            ? $request->file('file')->store('materi', 'public')
            : null;

        Materi::create([
            'judul'     => $data['judul'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'file_path' => $path,
            'user_id'   => $request->user()->id,
        ]);

        return back()->with('ok', 'Materi berhasil ditambahkan.');
    }

    public function materiDestroy(Materi $materi)
    {
        if ($materi->file_path) {
            Storage::disk('public')->delete($materi->file_path);
        }
        $materi->delete();

        return back()->with('ok', 'Materi dihapus.');
    }

    /* ===== KUIS (SOAL) ===== */
    public function kuisIndex()
    {
        return view('guru.kuis', [
            'soal'        => Soal::orderBy('tipe')->orderBy('urutan')->orderBy('id')->paginate(20),
            'jumlahPg'    => Soal::where('tipe', 'pilihan_ganda')->count(),
            'jumlahEssay' => Soal::where('tipe', 'essay')->count(),
        ]);
    }

    public function kuisStore(Request $request)
    {
        $data = $request->validate([
            'tipe'          => ['required', 'in:pilihan_ganda,essay'],
            'pertanyaan'    => ['required', 'string', 'max:1000'],
            'opsi_a'        => ['required_if:tipe,pilihan_ganda', 'nullable', 'string', 'max:255'],
            'opsi_b'        => ['required_if:tipe,pilihan_ganda', 'nullable', 'string', 'max:255'],
            'opsi_c'        => ['required_if:tipe,pilihan_ganda', 'nullable', 'string', 'max:255'],
            'opsi_d'        => ['required_if:tipe,pilihan_ganda', 'nullable', 'string', 'max:255'],
            'jawaban_benar' => ['required_if:tipe,pilihan_ganda', 'nullable', 'in:A,B,C,D'],
            'kunci_essay'   => ['nullable', 'string', 'max:2000'],
        ], [
            'opsi_a.required_if'        => 'Opsi A wajib diisi.',
            'opsi_b.required_if'        => 'Opsi B wajib diisi.',
            'opsi_c.required_if'        => 'Opsi C wajib diisi.',
            'opsi_d.required_if'        => 'Opsi D wajib diisi.',
            'jawaban_benar.required_if' => 'Pilih jawaban yang benar.',
        ]);

        if ($data['tipe'] === 'essay') {
            // Soal essay tidak memakai opsi dan jawaban benar
            $data = array_merge($data, [
                'opsi_a' => null, 'opsi_b' => null, 'opsi_c' => null, 'opsi_d' => null,
                'jawaban_benar' => null,
            ]);
        } else {
            $data['kunci_essay'] = null;
        }

        $data['urutan']  = (Soal::where('tipe', $data['tipe'])->max('urutan') ?? 0) + 1;
        $data['user_id'] = $request->user()->id;

        Soal::create($data);

        return back()->with('ok', 'Soal berhasil ditambahkan.');
    }

    public function kuisDestroy(Soal $soal)
    {
        $soal->delete();

        return back()->with('ok', 'Soal dihapus.');
    }

    /* ===== VIDEO ===== */
    public function videoIndex()
    {
        return view('guru.video', [
            'video' => Video::latest()->paginate(15),
        ]);
    }

    public function videoStore(Request $request)
    {
        $data = $request->validate([
            'judul'     => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
            'jenis'     => ['required', 'in:youtube,upload'],
            'url'       => [
                'required_if:jenis,youtube', 'nullable', 'url', 'max:500',
                'regex:~(youtu\.be/|youtube\.com/(watch\?v=|embed/|shorts/))[A-Za-z0-9_-]{11}~',
            ],
            'file'      => ['required_if:jenis,upload', 'nullable', 'file', 'mimes:mp4', 'max:51200'],
        ], [
            'url.required_if'  => 'Tempel link YouTube-nya.',
            'url.regex'        => 'Link harus berupa link video YouTube yang valid.',
            'file.required_if' => 'Pilih file video MP4.',
            'file.mimes'       => 'File harus berformat MP4.',
            'file.max'         => 'Ukuran video maksimal 50 MB.',
        ]);

        $path = null;
        if ($data['jenis'] === 'upload' && $request->hasFile('file')) {
            $path = $request->file('file')->store('video', 'public');
        }

        Video::create([
            'judul'     => $data['judul'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'jenis'     => $data['jenis'],
            'url'       => $data['jenis'] === 'youtube' ? $data['url'] : null,
            'file_path' => $path,
            'user_id'   => $request->user()->id,
        ]);

        return back()->with('ok', 'Video berhasil ditambahkan.');
    }

    public function videoDestroy(Video $video)
    {
        if ($video->file_path) {
            Storage::disk('public')->delete($video->file_path);
        }
        $video->delete();

        return back()->with('ok', 'Video dihapus.');
    }
}