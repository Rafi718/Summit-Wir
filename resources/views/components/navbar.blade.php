<nav id="navbar"class="fixed top-0 left-0 w-full z-50 transition-all duration-500
     {{ request()->routeIs('home') ? 'bg-transparent' : 'bg-white shadow-md' }}">

    <div class="container mx-auto flex items-center justify-between py-4 px-6">

        {{-- Logo kiri --}}
        <a href="{{ route('home') }}" class="flex items-center space-x-2 scroll-smooth">
            <img src="{{ asset('assets/img/logo-s.png') }}" alt="SummitWir Logo" class="h-10 w-auto object-contain">
            <span id="nav-brand" class="text-2xl font-bold text-gray-900">SummitWir</span>
        </a>

        {{-- Menu tengah --}}
        <ul class="hidden md:flex space-x-8 font-medium absolute left-1/2 transform -translate-x-1/2">
            <li><a href="{{ route('home') }}" class="nav-link transition{{ request()->routeIs('home') ? 'text-white hover:text-green-100' : 'text-gray-800 hover:text-green-950' }}">Home</a></li>
            <li><a href="{{ route('products') }}" class="nav-link transition{{ request()->routeIs('home') ? 'text-white hover:text-green-100' : 'text-gray-800 hover:text-green-950' }}">Products</a></li>  
            <li><a href="{{ route('guide') }}" class="nav-link transition{{ request()->routeIs('home') ? 'text-white hover:text-green-100' : 'text-gray-800 hover:text-green-950' }}">Guide</a></li>
        </ul>

        {{-- Bagian kanan: Keranjang & Account --}}
        <div class="hidden md:flex items-center space-x-3">
           
            {{-- Hover Keranjang --}}
            <div class="relative cart-hover-container">
                <a href="{{ route('cart') }}"
                    class="nav-icon relative p-2 rounded-full transition hover:text-green-950"
                        title="Keranjang">
                            <i class="fas fa-shopping-cart"></i>
                            @php
                                $cartCount = Auth::check()
                                    ? \App\Models\CartItem::where('user_id', Auth::id())->count()
                                    : 0;
                            @endphp
                            @if ($cartCount > 0)
                                <span
                                    class="absolute -top-2 -right-2 bg-red-500 text-white text-xs
                                        rounded-full h-5 w-5 flex items-center justify-center font-bold">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                {{-- Hover Dropdown --}}
                <div class="cart-hover-dropdown absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 opacity-0 invisible transition-all duration-300 transform translate-y-2">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2">Keranjang Belanja</h3>
                        
                        @php
                            // Ambil data cart dari database
                            $cartItems = Auth::check() 
                                ? \App\Models\CartItem::with('product')->where('user_id', Auth::id())->get() 
                                : collect();
                            
                            $total = 0;
                        @endphp

                        @if($cartItems->count() > 0)
                            <div class="max-h-64 overflow-y-auto space-y-3">
                                @foreach($cartItems as $item)
                                    @php
                                        $product = $item->product;
                                        $price = $product->price ?? 0;
                                        $quantity = $item->quantity ?? 1;
                                        $duration = $item->duration ?? 1;
                                        
                                        // Hitung subtotal (price * quantity * duration)
                                        $subtotal = $price * $quantity * $duration;
                                        $total += $subtotal;
                                        
                                        // Ambil gambar produk
                                        $image = $product->image ?? $product->photo ?? $product->gambar ?? asset('assets/img/default-product.png');
                                        
                                        // Jika image adalah path relatif, tambahkan asset()
                                        if (!str_starts_with($image, 'http')) {
                                            $image = asset('storage/' . $image);
                                        }
                                    @endphp
                                    <div class="flex items-center space-x-3 pb-3 border-b border-gray-100">
                                        <img src="{{ $image }}" 
                                             alt="{{ $product->name ?? 'Produk' }}" 
                                             class="w-14 h-14 object-cover rounded"
                                             onerror="this.src='{{ asset('assets/img/default-product.png') }}'">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-800 truncate">{{ $product->name ?? 'Produk' }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $quantity }} x Rp {{ number_format($price, 0, ',', '.') }}
                                                @if($duration > 1)
                                                    <span class="text-blue-500">x {{ $duration }} hari</span>
                                                @endif
                                            </p>
                                            <p class="text-sm font-semibold text-blue-600">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-4 pt-3 border-t border-gray-200">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-base font-semibold text-gray-800">Total:</span>
                                    <span class="text-lg font-bold text-blue-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <a href="{{ route('cart') }}" 
                                   class="block w-full bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                                    Lihat Keranjang
                                </a>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.293 2.707A1 1 0 007.618 17h8.764a1 1 0 00.911-1.293L17 13M10 21h.01M14 21h.01" />
                                </svg>
                                <p class="text-gray-500 text-sm">
                                    @auth
                                        Keranjang Anda kosong
                                    @else
                                        Login untuk melihat keranjang
                                    @endauth
                                </p>
                                @auth
                                    <a href="{{ route('products') }}" class="inline-block mt-3 text-blue-600 hover:text-blue-700 text-sm font-medium">
                                        Mulai Belanja
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="inline-block mt-3 text-blue-600 hover:text-blue-700 text-sm font-medium">
                                        Login Sekarang
                                    </a>
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Akun --}}
            @auth
                <a href="{{ route('profile.index') }}"
                    class="flex items-center gap-3 rounded-xl px-2 py-2 transition hover:bg-black/5"
                    title="Profil Saya">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-black/10">
                        <i class="fas fa-user nav-icon"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="nav-user-text truncate text-sm font-semibold {{ request()->routeIs('home') ? 'text-white' : 'text-gray-900' }}">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="nav-user-subtext truncate text-xs {{ request()->routeIs('home') ? 'text-white/75' : 'text-gray-500' }}">
                            {{ auth()->user()->email }}
                        </p>
                    </div>
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="nav-login-pill rounded-full px-5 py-2.5 text-sm font-semibold shadow-sm ring-1 transition
                    {{ request()->routeIs('home') ? 'bg-white/12 text-white ring-white/20 backdrop-blur-sm hover:bg-white/20' : 'bg-green-950 text-white ring-green-950/10 hover:bg-green-900' }}">
                    Login
                </a>
            @endauth

        </div>

        {{-- Tombol menu mobile --}}
        <div class="md:hidden">
            <button id="menu-toggle" class="focus:outline-none text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Menu mobile dropdown --}}
    <div id="mobile-menu"
        class="md:hidden bg-white/95 backdrop-blur-md border-t overflow-hidden max-h-0 transition-[max-height_opacity] duration-300 ease-in-out opacity-0">
        <ul class="flex flex-col space-y-2 p-4 text-gray-800 font-medium">
            <li><a href="{{ route('home') }}" class="block py-2 hover:text-blue-600 transition">Home</a></li>
            <li><a href="{{ route('products') }}" class="block py-2 hover:text-blue-600 transition">Products</a></li>
            <li><a href="{{ route('guide') }}" class="block py-2 hover:text-blue-600 transition">Guide</a></li>
            <li><a href="{{ route('cart') }}" class="block py-2 hover:text-blue-600 transition">Cart</a></li>
            <li><a href="{{ route('profile.index') }}" class="block py-2 hover:text-blue-600 transition">Profile</a>
            </li>
        </ul>
    </div>
</nav>

{{-- CSS untuk hover effect --}}
<style>
    .cart-hover-container:hover .cart-hover-dropdown {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .cart-hover-dropdown:hover {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
</style>

{{-- Script scroll & mobile menu --}}
@if (request()->routeIs('home'))
<script>
    const navbar   = document.getElementById('navbar');
    const navLinks = document.querySelectorAll('.nav-link');
    const navBrand = document.getElementById('nav-brand');
    const navIcons = document.querySelectorAll('.nav-icon');
    const navUserTexts = document.querySelectorAll('.nav-user-text');
    const navUserSubtexts = document.querySelectorAll('.nav-user-subtext');
    const navLoginPills = document.querySelectorAll('.nav-login-pill');

    function handleNavbar() {
        if (window.scrollY > 50) {
            navbar.classList.remove('bg-transparent');
            navbar.classList.add('bg-white/90', 'backdrop-blur-md', 'shadow-md');
            navLinks.forEach(link => {
                link.classList.remove('text-white', 'hover:text-green-100');
                link.classList.add('text-gray-800', 'hover:text-green-950');
            });
            navIcons.forEach(icon => {
                icon.classList.remove('text-white');
                icon.classList.add('text-gray-700');
            });
            navUserTexts.forEach(text => {
                text.classList.remove('text-white');
                text.classList.add('text-gray-900');
            });
            navUserSubtexts.forEach(text => {
                text.classList.remove('text-white/75');
                text.classList.add('text-gray-500');
            });
            navBrand.classList.remove('text-white');
            navBrand.classList.add('text-gray-900');
            navLoginPills.forEach(button => {
                button.classList.remove('bg-white/12', 'text-white', 'ring-white/20', 'backdrop-blur-sm', 'hover:bg-white/20');
                button.classList.add('bg-green-950', 'text-white', 'ring-green-950/10', 'hover:bg-green-900', 'shadow-sm');
            });
        } else {
            navbar.classList.add('bg-transparent');
            navbar.classList.remove('bg-white/90', 'backdrop-blur-md', 'shadow-md');
            navLinks.forEach(link => {
                link.classList.add('text-white', 'hover:text-green-100');
                link.classList.remove('text-gray-800', 'hover:text-green-950');
            });
            navIcons.forEach(icon => {
                icon.classList.add('text-white');
                icon.classList.remove('text-gray-700');
            });
            navUserTexts.forEach(text => {
                text.classList.add('text-white');
                text.classList.remove('text-gray-900');
            });
            navUserSubtexts.forEach(text => {
                text.classList.add('text-white/75');
                text.classList.remove('text-gray-500');
            });
            navBrand.classList.add('text-white');
            navBrand.classList.remove('text-gray-900');
            navLoginPills.forEach(button => {
                button.classList.add('bg-white/12', 'text-white', 'ring-white/20', 'backdrop-blur-sm', 'hover:bg-white/20', 'shadow-sm');
                button.classList.remove('bg-green-950', 'ring-green-950/10', 'hover:bg-green-900');
            });
        }
    }


    // 🔑 PENTING: set kondisi awal saat page load
    handleNavbar();

    // Jalankan saat scroll
    window.addEventListener('scroll', handleNavbar);
</script>
@endif


<script>
    // Mobile menu toggle
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    menuToggle.addEventListener('click', () => {
        if (mobileMenu.classList.contains('max-h-0')) {
            mobileMenu.classList.remove('max-h-0', 'opacity-0');
            mobileMenu.classList.add('max-h-96', 'opacity-100');
        } else {
            mobileMenu.classList.add('max-h-0', 'opacity-0');
            mobileMenu.classList.remove('max-h-96', 'opacity-100');
        }
    });
</script>

@if (!request()->is('customer/home') && !request()->is('home'))
    <div class="h-16"></div>
@endif
