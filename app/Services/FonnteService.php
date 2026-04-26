<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    public function sendMessage(string $target, string $message): bool
    {
        $token = config('services.fonnte.token');

        if (blank($token)) {
            Log::warning('Fonnte token is not configured.');

            return false;
        }

        try {
            $response = Http::asForm()
                ->withHeaders([
                    'Authorization' => $token,
                ])
                ->timeout((int) config('services.fonnte.timeout', 15))
                ->post(config('services.fonnte.endpoint', 'https://api.fonnte.com/send'), [
                    'target' => $target,
                    'message' => $message,
                    'countryCode' => config('services.fonnte.country_code', '62'),
                ])
                ->throw()
                ->json();

            return (bool) ($response['status'] ?? false);
        } catch (RequestException $exception) {
            Log::error('Failed to send Fonnte WhatsApp message.', [
                'target' => $target,
                'status' => $exception->response?->status(),
                'response' => $exception->response?->json(),
            ]);
        } catch (\Throwable $exception) {
            Log::error('Failed to send Fonnte WhatsApp message.', [
                'target' => $target,
                'error' => $exception->getMessage(),
            ]);
        }

        return false;
    }
}
