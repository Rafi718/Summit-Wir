<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Auth | SummitWir')</title>

    {{-- Vite (Tailwind + JS dari Laravel) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap">
</head>

<body class="antialiased text-slate-900" style="font-family: 'Manrope', sans-serif;">
    <main
        class="relative min-h-screen overflow-hidden bg-slate-950"
        style="background-image:
            linear-gradient(135deg, rgba(6, 78, 59, 0.78), rgba(15, 23, 42, 0.9)),
            url('{{ asset('img/TEST.jpg') }}');
            background-size: cover;
            background-position: center;">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(255,255,255,0.14),_transparent_38%)]"></div>
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="relative">
            @yield('content')
        </div>
    </main>
</body>
</html>
