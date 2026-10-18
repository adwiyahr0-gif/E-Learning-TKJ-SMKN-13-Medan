<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiTutorController extends Controller
{
    private const MAX_MESSAGES = 20; // 10 tanya-jawab terakhir yang diingat

    public function index()
    {
        return view('ai-tutor.index', [
            'history' => session('ai_history', []),
        ]);
    }

    public function clear()
    {
        session()->forget('ai_history');

        return redirect()->route('ai.tutor.index');
    }

    public function askAi(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:1000',
        ]);

        $userQuestion = $request->input('question');
        $apiKey = trim(env('GEMINI_API_KEY'));

        $models = array_filter([
            env('GEMINI_MODEL', 'gemini-3.8-flash'),
            env('GEMINI_FALLBACK_MODEL'),
        ]);

        // Ambil riwayat sebelumnya, lalu tambahkan pertanyaan baru
        $history = session('ai_history', []);

        $contents = [];
        foreach ($history as $msg) {
            $contents[] = [
                'role'  => $msg['role'], // 'user' atau 'model'
                'parts' => [['text' => $msg['text']]],
            ];
        }
        $contents[] = [
            'role'  => 'user',
            'parts' => [['text' => $userQuestion]],
        ];

        $payload = [
            'system_instruction' => [
                'parts' => [[
                    'text' => 'Kamu adalah guru mata pelajaran Jaringan Komputer yang ramah dan profesional. '
                            . 'Jawab dengan penjelasan yang terstruktur, padat, dan mudah dipahami. '
                            . 'Gunakan konteks percakapan sebelumnya: jika siswa bertanya singkat '
                            . '(misalnya "kalau yang itu?" atau "contohnya?"), anggap pertanyaan itu '
                            . 'masih berkaitan dengan topik sebelumnya.',
                ]],
            ],
            'contents' => $contents,
        ];

        try {
            $response = null;

            foreach ($models as $model) {
                for ($attempt = 1; $attempt <= 3; $attempt++) {
                    $response = Http::withoutVerifying()
                        ->timeout(60)
                        ->withHeaders(['x-goog-api-key' => $apiKey])
                        ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent", $payload);

                    if (!in_array($response->status(), [429, 503])) {
                        break 2;
                    }

                    sleep(2);
                }
            }

            if ($response->successful()) {
                $aiAnswer = $response->json('candidates.0.content.parts.0.text');

                if (blank($aiAnswer)) {
                    return redirect()->route('ai.tutor.index')
                        ->with('ai_error', 'AI tidak memberikan jawaban untuk pertanyaan ini. Coba tulis ulang dengan kalimat lain.');
                }

                // Simpan tanya-jawab ke riwayat, batasi jumlahnya
                $history[] = ['role' => 'user',  'text' => $userQuestion];
                $history[] = ['role' => 'model', 'text' => $aiAnswer];
                $history = array_slice($history, -self::MAX_MESSAGES);

                session(['ai_history' => $history]);

                return redirect()->route('ai.tutor.index');
            }

            $googleError = in_array($response->status(), [429, 503])
                ? 'AI sedang sibuk. Silakan coba lagi dalam beberapa saat.'
                : ($response->json('error.message') ?? 'Terjadi kesalahan dari server Google.');

            return redirect()->route('ai.tutor.index')
                ->with('ai_question', $userQuestion)
                ->with('ai_error', 'Gagal: ' . $googleError);

        } catch (\Exception $e) {
            return redirect()->route('ai.tutor.index')
                ->with('ai_question', $userQuestion)
                ->with('ai_error', 'Error Sistem: ' . $e->getMessage());
        }
    }
}