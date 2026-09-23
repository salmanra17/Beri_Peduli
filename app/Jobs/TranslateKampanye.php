<?php

namespace App\Jobs;

use App\Models\Kampanye;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TranslateKampanye implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $backoff = 30;

    public function __construct(public readonly Kampanye $kampanye) {}

    public function handle(): void
    {
        $apiKey = config('services.gemini.api_key');

        if (! $apiKey) {
            Log::warning('TranslateKampanye: GEMINI_API_KEY not set, skipping translation.');

            return;
        }

        $judulEn = $this->translateWithGemini($this->kampanye->judul, $apiKey);
        $deskripsiEn = $this->translateWithGemini($this->kampanye->deskripsi, $apiKey);

        if ($judulEn || $deskripsiEn) {
            $this->kampanye->updateQuietly([
                'judul_en' => $judulEn ?? $this->kampanye->judul_en,
                'deskripsi_en' => $deskripsiEn ?? $this->kampanye->deskripsi_en,
            ]);
        }
    }

    /**
     * Translate Indonesian text to English using Gemini AI.
     */
    private function translateWithGemini(string $text, string $apiKey): ?string
    {
        if (empty(trim($text))) {
            return null;
        }

        $response = Http::withOptions(['timeout' => 30])
            ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-3.6-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => 'Translate the following Indonesian text to natural, fluent English. '
                                    ."Return ONLY the translated text, no explanations or extra formatting:\n\n{$text}",
                            ],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'temperature' => 0.2,
                    'maxOutputTokens' => 2048,
                ],
            ]);

        if (! $response->successful()) {
            Log::error('TranslateKampanye: Gemini API error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        }

        return data_get($response->json(), 'candidates.0.content.parts.0.text');
    }
}
