@extends('layouts.auth')

@section('title', 'Login | SummitWir')

@section('content')
    <section class="px-4 py-6 sm:px-6 sm:py-8 lg:px-8 lg:py-10">
        <div class="mx-auto flex min-h-screen max-w-6xl items-center justify-center">
            <div class="grid w-full overflow-hidden rounded-[28px] border border-white/15 bg-white/92 shadow-[0_24px_80px_rgba(15,23,42,0.38)] backdrop-blur-xl lg:grid-cols-[1.02fr_0.98fr]">
                <div class="relative min-h-[260px] overflow-hidden bg-slate-950 lg:min-h-[680px]">
                    <img
                        src="{{ asset('img/tenda.jpg') }}"
                        alt="Camping at night"
                        class="absolute inset-0 h-full w-full object-cover"
                    >
                    <div class="absolute inset-0 bg-gradient-to-br from-slate-950/80 via-slate-900/45 to-emerald-900/40"></div>
                    <div class="relative flex h-full flex-col justify-between p-6 text-white sm:p-8 lg:p-10">
                        <a
                            href="{{ route('home') }}"
                            class="inline-flex w-fit items-center gap-2 rounded-xl border border-white/20 bg-white/10 px-4 py-2 text-sm font-semibold text-white/90 backdrop-blur-sm transition hover:bg-white/18"
                        >
                            <span aria-hidden="true">&larr;</span>
                            Kembali ke beranda
                        </a>

                        <div class="max-w-md">
                            <p class="mb-3 text-xs font-semibold uppercase tracking-[0.28em] text-emerald-200/85">
                                SummitWir Outdoor Gear
                            </p>
                            <h1
                                class="max-w-sm text-3xl font-extrabold leading-tight sm:text-4xl"
                                style="font-family: 'Sora', sans-serif;"
                            >
                                Masuk dan siapkan perjalanan berikutnya.
                            </h1>
                            <p class="mt-4 max-w-md text-sm leading-7 text-white/80 sm:text-base">
                                Akses katalog sewa, pantau pesanan, dan atur kebutuhan pendakian Anda dari satu tempat.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center bg-white/96">
                    <div class="w-full p-6 sm:p-8 lg:p-10 xl:px-12">
                        <div class="mx-auto max-w-md">
                            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-900">
                                Welcome back
                            </p>
                            <h2
                                class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-[2rem]"
                                style="font-family: 'Sora', sans-serif;"
                            >
                                Sign in to your account
                            </h2>
                            <p class="mt-3 text-sm leading-7 text-slate-600 sm:text-base">
                                Gunakan email dan password Anda untuk melanjutkan.
                            </p>

                            @if ($errors->any())
                                <div class="mt-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                                    <p class="font-semibold">Ada beberapa input yang perlu diperbaiki.</p>
                                    <ul class="mt-2 list-disc space-y-1 pl-5">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session('status'))
                                <div class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form class="mt-8 space-y-5" method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="space-y-2">
                                    <label for="email" class="block text-sm font-semibold text-slate-700">Email address</label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        required
                                        autocomplete="email"
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-600 focus:bg-white focus:ring-4 focus:ring-emerald-100"
                                        placeholder="you@example.com"
                                    />
                                </div>

                                <div class="space-y-2">
                                    <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        required
                                        autocomplete="current-password"
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-600 focus:bg-white focus:ring-4 focus:ring-emerald-100"
                                        placeholder="Masukkan password"
                                    />
                                </div>

                                <div class="flex flex-col gap-3 text-sm text-slate-600 sm:flex-row sm:items-center sm:justify-between">
                                    <label class="inline-flex items-center gap-3">
                                        <input
                                            type="checkbox"
                                            name="remember"
                                            class="h-4 w-4 rounded border-slate-300 text-emerald-700 focus:ring-emerald-200"
                                        />
                                        <span>Remember me</span>
                                    </label>
                                    <a href="{{ route('password.request') }}" class="font-semibold text-slate-900 transition hover:text-slate-700">
                                        Forgot password?
                                    </a>
                                </div>

                                <button
                                    type="submit"
                                    class="w-full rounded-xl bg-green-950 px-5 py-3.5 text-base font-bold text-white shadow-lg shadow-green-950/20 transition hover:bg-green-900 focus:outline-none focus:ring-4 focus:ring-emerald-200"
                                >
                                    Sign In
                                </button>
                            </form>

                            <p class="mt-8 text-center text-sm text-slate-600">
                                Belum punya akun?
                                <a href="{{ route('register') }}" class="font-semibold text-slate-900 transition hover:text-slate-700">
                                    Sign up
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
