@extends('layouts.customer')

@section('title', 'Verifikasi WhatsApp | SummitWir')

@section('content')
    <section class="w-11/12 md:w-1/2 mx-auto flex items-center justify-center px-6 py-20">
        <div class="bg-white shadow-lg rounded-2xl p-8 max-w-md w-full text-center">
            <div class="flex justify-center mb-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-green-950/10 text-green-950">
                    <i class="fa-brands fa-whatsapp text-3xl"></i>
                </div>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-2">
                Verifikasi WhatsApp Anda
            </h2>

            <p class="text-gray-600 text-sm leading-relaxed mb-6">
                Kami sudah mengirim kode OTP ke nomor WhatsApp
                <span class="font-semibold text-gray-800">{{ auth()->user()->no_hp }}</span>.
                Masukkan kode tersebut untuk mengaktifkan akun Anda.
            </p>

            @if (session('message'))
                <div class="mb-4 rounded-lg border border-green-950/10 bg-green-950/5 p-3 text-sm text-green-950">
                    {{ session('message') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 text-sm rounded-lg text-left">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('whatsapp.verification.verify') }}" class="mb-3 space-y-4">
                @csrf
                <input
                    type="text"
                    inputmode="numeric"
                    name="otp"
                    maxlength="6"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-center text-xl font-semibold tracking-widest focus:border-green-950 focus:outline-none focus:ring-2 focus:ring-green-950/10"
                    placeholder="123456"
                >
                <button type="submit"
                    class="w-full rounded-lg bg-green-950 py-3 font-medium text-white shadow transition hover:bg-green-900">
                    Verifikasi Akun
                </button>
            </form>

            <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
                @csrf
                <button type="submit"
                    class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 py-3 rounded-lg font-medium transition">
                    Kirim Ulang OTP
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full text-gray-500 hover:text-gray-700 py-2 rounded-lg font-medium transition">
                    Logout
                </button>
            </form>
        </div>
    </section>
@endsection
