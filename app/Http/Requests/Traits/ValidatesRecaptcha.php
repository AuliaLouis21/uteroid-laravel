<?php

namespace App\Http\Requests\Traits;

use Closure;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Validator;

trait ValidatesRecaptcha
{
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $secret = config('recaptcha.secret_key') ?: Setting::where('key', 'recaptcha_secret_key')->value('value') ?? '';

            if (empty($secret)) {
                return;
            }

            $token = $this->input('g-recaptcha-response');

            if (empty($token)) {
                $validator->errors()->add('g-recaptcha-response', 'Silakan verifikasi bahwa Anda bukan robot.');
                return;
            }

            try {
                $response = Http::asForm()->timeout(10)->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => $secret,
                    'response' => $token,
                    'remoteip' => $this->ip(),
                ]);

                $result = $response->json();

                if (!($result['success'] ?? false)) {
                    $validator->errors()->add('g-recaptcha-response', 'Verifikasi gagal. Silakan coba lagi.');
                }

                if (($result['score'] ?? 0) < 0.5) {
                    $validator->errors()->add('g-recaptcha-response', 'Verifikasi gagal. Silakan coba lagi.');
                }
            } catch (\Exception $e) {
                $validator->errors()->add('g-recaptcha-response', 'Verifikasi gagal. Silakan coba lagi.');
            }
        });
    }
}
