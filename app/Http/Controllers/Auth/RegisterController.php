<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Services\FonnteService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct(private readonly FonnteService $fonnteService)
    {
    }

    public function register()
    {
        return view('auth.register');
    }

    public function handleRegister(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'no_hp' => $credentials['phone'],
            'password' => Hash::make($credentials['password']),
            'whatsapp_otp' => $this->generateOtp(),
            'whatsapp_otp_expires_at' => now()->addMinutes(10),
        ]);

        $this->sendWhatsappOtp($user);

        Auth::login($user);

        return redirect()->route('whatsapp.verification.notice');
    }

    public function verification()
    {
        return view('auth.verify-whatsapp');
    }

    public function verifyWhatsapp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $user = $request->user();

        if (!$user->whatsapp_otp || !$user->whatsapp_otp_expires_at || $user->whatsapp_otp_expires_at->isPast()) {
            return back()->withErrors([
                'otp' => 'Kode OTP sudah kedaluwarsa. Silakan kirim ulang kode.',
            ]);
        }

        if (!hash_equals($user->whatsapp_otp, $request->otp)) {
            return back()->withErrors([
                'otp' => 'Kode OTP tidak sesuai.',
            ]);
        }

        $user->forceFill([
            'email_verified_at' => now(),
            'whatsapp_otp' => null,
            'whatsapp_otp_expires_at' => null,
        ])->save();

        return redirect()->route('home');
    }

    public function resendVerification(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        $user->forceFill([
            'whatsapp_otp' => $this->generateOtp(),
            'whatsapp_otp_expires_at' => now()->addMinutes(10),
        ])->save();

        $this->sendWhatsappOtp($user);

        return back()->with('message', 'Kode OTP WhatsApp berhasil dikirim ulang.');
    }

    private function generateOtp(): string
    {
        return (string) random_int(100000, 999999);
    }

    private function sendWhatsappOtp(User $user): void
    {
        $message = "Halo {$user->name}, kode verifikasi Summit Wir Anda adalah {$user->whatsapp_otp}. Kode berlaku 10 menit.";

        $this->fonnteService->sendMessage($user->no_hp, $message);
    }
}
