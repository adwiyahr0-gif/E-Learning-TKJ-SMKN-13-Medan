<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AiTutorController;
use App\Http\Controllers\GuruController;
use App\Models\QuizResult;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route untuk menampilkan halaman materi routing
Route::get('/materi/routing', function () {
    return view('materi.routing');
})->middleware(['auth', 'verified'])->name('materi.routing');

// Route untuk menampilkan halaman Video Animasi
Route::get('/video/animasi', function () {
    return view('video.index');
})->middleware(['auth', 'verified'])->name('video.animasi');

// Route untuk menampilkan halaman kuis evaluasi
Route::get('/kuis/evaluasi', function () {
    return view('kuis.index');
})->middleware(['auth', 'verified'])->name('kuis.evaluasi');

// Route untuk memproses jawaban, menilai PG, dan AI menilai Essay (POST)
Route::post('/kuis/evaluasi', function (\Illuminate\Http\Request $request) {

    // 1. PENILAIAN PILIHAN GANDA
    $kunciJawaban = [
        'pg_1'  => 'B',
        'pg_2'  => 'C',
        'pg_3'  => 'C',
        'pg_4'  => 'C',
        'pg_5'  => 'B',
        'pg_6'  => 'B',
        'pg_7'  => 'C',
        'pg_8'  => 'D',
        'pg_9'  => 'C',
        'pg_10' => 'C'
    ];

    $skorPG = 0;
    $benar = 0;

    foreach ($kunciJawaban as $soal => $jawabanBenar) {
        if ($request->input($soal) === $jawabanBenar) {
            $skorPG += 10;
            $benar++;
        }
    }

    // 2. PENILAIAN ESSAY OLEH AI
    $apiKey = trim((string) env('GEMINI_API_KEY'));
    $model = env('GEMINI_MODEL', 'gemini-3.8-flash');
    $skorEssay = 0;
    $feedbackAi = "Ulasan otomatis sedang tidak tersedia saat ini. Silakan hubungi guru.";

    if (!empty($apiKey)) {
        $jawabanUser = "Soal 1: " . $request->input('essay_1', '-') . "\n" .
                       "Soal 2: " . $request->input('essay_2', '-') . "\n" .
                       "Soal 3: " . $request->input('essay_3', '-') . "\n" .
                       "Soal 4: " . $request->input('essay_4', '-') . "\n" .
                       "Soal 5: " . $request->input('essay_5', '-');

        $prompt = "Kamu adalah sistem penilai ujian Jaringan Komputer. Evaluasi 5 jawaban essay berikut. Total skor maksimal 100 (20 poin/soal). Balas HANYA dengan format JSON persis ini: {\"skor_essay\": angka_skor, \"feedback\": \"Ulasan singkat 2 kalimat memotivasi\"}\n\nJawaban Siswa:\n" . $jawabanUser;

        try {
            $response = Http::withoutVerifying()
                ->connectTimeout(30)
                ->timeout(90)
                ->withHeaders(['x-goog-api-key' => $apiKey])
                ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent", [
                    'contents' => [['parts' => [['text' => $prompt]]]]
                ]);

            if ($response->successful()) {
                $aiAnswer = $response->json('candidates.0.content.parts.0.text');
                $aiAnswer = str_replace(['```json', '```'], '', (string) $aiAnswer);
                $resultData = json_decode(trim($aiAnswer), true);

                if (isset($resultData['skor_essay'])) {
                    $skorEssay = max(0, min(100, (int) $resultData['skor_essay']));
                    $feedbackAi = $resultData['feedback'] ?? "Penilaian otomatis berhasil dilakukan.";
                }
            }
        } catch (\Exception $e) {
            $feedbackAi = "Gagal menghubungi AI Tutor. Silakan coba lagi nanti.";
        }
    }

    // 3. HITUNG NILAI AKHIR (Rata-rata PG dan Essay)
    $nilaiAkhir = ($skorPG + $skorEssay) / 2;

    // 4. SIMPAN HASIL KE DATABASE (hanya akun siswa) agar guru bisa melihat nilainya
    if ($request->user()->role === 'siswa') {
        QuizResult::create([
            'user_id' => $request->user()->id,
            'judul'   => 'Kuis Evaluasi',
            'skor'    => (int) round($nilaiAkhir),
        ]);
    }

    return back()->with([
        'success' => 'Kuis berhasil diselesaikan!',
        'skor' => $skorPG,
        'benar' => $benar,
        'skor_essay' => $skorEssay,
        'nilai_akhir' => $nilaiAkhir,
        'feedback_ai' => $feedbackAi
    ]);
})->middleware(['auth', 'verified'])->name('kuis.submit');

// ==========================================
// AI TUTOR
// ==========================================
Route::middleware(['auth'])->group(function () {
    Route::get('/ai-tutor', [AiTutorController::class, 'index'])->name('ai.tutor.index');
    Route::post('/ai-tutor/ask', [AiTutorController::class, 'askAi'])->name('ai.tutor.ask');
    Route::post('/ai-tutor/clear', [AiTutorController::class, 'clear'])->name('ai.tutor.clear');
});

// ==========================================
// PANEL GURU (khusus akun dengan role guru)
// ==========================================
Route::middleware(['auth', 'guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/nilai', [GuruController::class, 'nilai'])->name('nilai');

    Route::get('/siswa', [GuruController::class, 'siswaIndex'])->name('siswa.index');
    Route::post('/siswa', [GuruController::class, 'siswaStore'])->name('siswa.store');
    Route::delete('/siswa/{user}', [GuruController::class, 'siswaDestroy'])->name('siswa.destroy');

    Route::get('/materi', [GuruController::class, 'materiIndex'])->name('materi.index');
    Route::post('/materi', [GuruController::class, 'materiStore'])->name('materi.store');
    Route::delete('/materi/{materi}', [GuruController::class, 'materiDestroy'])->name('materi.destroy');

    // --- Kelola Kuis (soal) ---
    Route::get('/kuis', [GuruController::class, 'kuisIndex'])->name('kuis.index');
    Route::post('/kuis', [GuruController::class, 'kuisStore'])->name('kuis.store');
    Route::delete('/kuis/{soal}', [GuruController::class, 'kuisDestroy'])->name('kuis.destroy');

    // --- Kelola Video ---
    Route::get('/video', [GuruController::class, 'videoIndex'])->name('video.index');
    Route::post('/video', [GuruController::class, 'videoStore'])->name('video.store');
    Route::delete('/video/{video}', [GuruController::class, 'videoDestroy'])->name('video.destroy');
});

require __DIR__.'/auth.php';