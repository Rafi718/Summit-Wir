<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'SummitWirr')</title>
    
    
    <link rel="icon" href="{{ asset('assets/img/logo-f.png') }}" type="image/png">

    {{-- Vite (Tailwind + JS otomatis dari Laravel) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Reusable Animations --}}
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">

    {{-- Brand Marquee CSS --}}
    <link rel="stylesheet" href="{{ asset('css/brand-marquee.css') }}">
    @stack('styles')

    {{-- Font Inter --}}
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap">

    <style>
        html {
            scroll-behavior: smooth;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            color: #1f2937;
        }
    </style>
    
</head>

<body class="min-h-screen flex flex-col">

    {{-- Navbar --}}
    @includeIf('components.navbar')

    <div class="fixed top-24 right-4 z-[60] space-y-3 pointer-events-none">
        @if (session('success'))
            <div
                class="flash-toast pointer-events-auto flex w-full max-w-sm items-start gap-3 rounded-xl border border-gray-200 bg-white px-4 py-3 shadow-lg transition-all duration-300"
                role="status"
                data-flash-toast
            >
                <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gray-100 text-gray-700">
                    <i class="fas fa-check"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-gray-900">Berhasil</p>
                    <p class="text-sm text-gray-600">{{ session('success') }}</p>
                </div>
                <button
                    type="button"
                    class="rounded-md p-1 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600"
                    aria-label="Tutup notifikasi"
                    data-flash-toast-close
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div
                class="flash-toast pointer-events-auto flex w-full max-w-sm items-start gap-3 rounded-xl border border-red-200 bg-white px-4 py-3 shadow-lg transition-all duration-300"
                role="alert"
                data-flash-toast
            >
                <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600">
                    <i class="fas fa-circle-exclamation"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-gray-900">Perhatian</p>
                    <p class="text-sm text-gray-600">{{ session('error') }}</p>
                </div>
                <button
                    type="button"
                    class="rounded-md p-1 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600"
                    aria-label="Tutup notifikasi"
                    data-flash-toast-close
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif
    </div>

    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- Footer --}}
    @includeIf('components.footer')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    {{-- Script efek transparan navbar --}}
    <script>
        const navbar = document.querySelector('.navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar?.classList.add(
                    'backdrop-blur-md', 
                    'bg-white/70', 
                    'shadow-md'
                );
            } else {
                navbar?.classList.remove(
                    'backdrop-blur-md', 
                    'bg-white/70', 
                    'shadow-md'
                );
            }
        });
    </script>

    <script>
        document.querySelectorAll('[data-flash-toast]').forEach((toast) => {
            const closeButton = toast.querySelector('[data-flash-toast-close]');
            const hideToast = () => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            };

            closeButton?.addEventListener('click', hideToast);
            setTimeout(hideToast, 3000);
        });
    </script>

    {{-- Animations Script --}}
        <script src="{{ asset('js/scroll-animations.js') }}"></script>
</body>
</html>
