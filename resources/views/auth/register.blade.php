@extends('layouts.auth')

@section('title', 'Register | SummitWir')

@section('content')
    <section class="px-4 py-6 sm:px-6 sm:py-8 lg:px-8 lg:py-10">
        <div class="mx-auto flex min-h-screen max-w-6xl items-center justify-center">
            <div class="grid w-full overflow-hidden rounded-[28px] border border-white/15 bg-white/94 shadow-[0_24px_80px_rgba(15,23,42,0.38)] backdrop-blur-xl lg:grid-cols-[0.95fr_1.05fr]">
                <div class="relative min-h-[260px] overflow-hidden bg-slate-950 lg:min-h-[760px]">
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
                                SummitWir Membership
                            </p>
                            <h1
                                class="max-w-sm text-3xl font-extrabold leading-tight sm:text-4xl"
                                style="font-family: 'Sora', sans-serif;"
                            >
                                Buat akun dan mulai rencanakan sewa peralatan dengan lebih cepat.
                            </h1>
                            <div class="mt-8 space-y-4 text-sm text-white/78">
                                <div class="flex items-center justify-between gap-4 border-b border-white/12 pb-3">
                                    <span>Booking lebih praktis</span>
                                    <span class="text-emerald-200">01</span>
                                </div>
                                <div class="flex items-center justify-between gap-4 border-b border-white/12 pb-3">
                                    <span>Riwayat pesanan tersimpan</span>
                                    <span class="text-emerald-200">02</span>
                                </div>
                                <div class="flex items-center justify-between gap-4 border-b border-white/12 pb-3">
                                    <span>Konfirmasi lebih mudah</span>
                                    <span class="text-emerald-200">03</span>
                                </div>
                                <div class="flex items-center justify-between gap-4 border-b border-white/12 pb-3">
                                    <span>Siap untuk trip berikutnya</span>
                                    <span class="text-emerald-200">04</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center bg-white/96">
                    <div class="w-full p-6 sm:p-8 lg:p-10 xl:px-12">
                        <div class="mx-auto max-w-lg">
                            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-900">
                                Create account
                            </p>
                            <h2
                                class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-[2rem]"
                                style="font-family: 'Sora', sans-serif;"
                            >
                                Join SummitWir
                            </h2>
                            <p class="mt-3 text-sm leading-7 text-slate-600 sm:text-base">
                                Lengkapi data di bawah untuk membuat akun baru.
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

                            @if (session('success'))
                                <div class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form class="mt-8 grid gap-5 sm:grid-cols-2" method="POST" action="{{ route('register.post') }}">
                                @csrf

                                <div class="space-y-2 sm:col-span-2">
                                    <label for="name" class="block text-sm font-semibold text-slate-700">Full name</label>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        value="{{ old('name') }}"
                                        required
                                        autocomplete="name"
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-600 focus:bg-white focus:ring-4 focus:ring-emerald-100"
                                        placeholder="Nama lengkap"
                                    >
                                </div>

                                <div class="space-y-2 sm:col-span-2">
                                    <label for="email" class="block text-sm font-semibold text-slate-700">Email address</label>
                                    <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        value="{{ old('email') }}"
                                        required
                                        autocomplete="email"
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-600 focus:bg-white focus:ring-4 focus:ring-emerald-100"
                                        placeholder="you@example.com"
                                    >
                                </div>

                                <div class="space-y-2 sm:col-span-2">
                                    <label for="phone" class="block text-sm font-semibold text-slate-700">Phone number</label>
                                    <input
                                        type="text"
                                        name="phone"
                                        id="phone"
                                        value="{{ old('phone') }}"
                                        required
                                        autocomplete="tel"
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-600 focus:bg-white focus:ring-4 focus:ring-emerald-100"
                                        placeholder="08xxxxxxxxxx"
                                    >
                                </div>

                                <div class="space-y-2">
                                    <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        required
                                        autocomplete="new-password"
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-600 focus:bg-white focus:ring-4 focus:ring-emerald-100"
                                        placeholder="Minimal 8 karakter"
                                    >
                                </div>

                                <div class="space-y-2">
                                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">Confirm password</label>
                                    <input
                                        type="password"
                                        name="password_confirmation"
                                        id="password_confirmation"
                                        required
                                        autocomplete="new-password"
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-600 focus:bg-white focus:ring-4 focus:ring-emerald-100"
                                        placeholder="Ulangi password"
                                    >
                                </div>

                                <div class="sm:col-span-2">
                                    <button
                                        type="submit"
                                        class="w-full rounded-xl bg-green-950 px-5 py-3.5 text-base font-bold text-white shadow-lg shadow-green-950/20 transition hover:bg-green-900 focus:outline-none focus:ring-4 focus:ring-emerald-200"
                                    >
                                        Create Account
                                    </button>
                                </div>
                            </form>

                            <p class="mt-8 text-center text-sm text-slate-600">
                                Sudah punya akun?
                                <a href="{{ route('login') }}" class="font-semibold text-slate-900 transition hover:text-slate-700">
                                    Sign in
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
