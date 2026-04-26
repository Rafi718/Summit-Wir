<footer class="bg-green-950 text-white pt-16 pb-10">
    <div class="container mx-auto px-6 md:px-12 lg:px-20">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

            <!-- LOGO + ALAMAT -->
            <div class="space-y-6">
                <img src="{{ asset('img/logo12.png') }}" 
                     alt="SummitWir" 
                     class="max-w-[220px] object-contain">
  
                <div class="space-y-4 text-white text-base leading-relaxed">

                    <!-- Alamat -->
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-location-dot text-lg mt-1 text-emerald-200"></i>
                        <p>
                            Jl. DI Panjaitan No.128, Karangreja, Purwokerto Kidul, Kec. Purwokerto Sel., Kabupaten Banyumas, Jawa Tengah 53147
                        </p>
                    </div>

                    <!-- Jam Operasional -->
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-clock text-lg mt-1 text-emerald-200"></i>
                        <p>Setiap hari, 09:00 - 20:00 WIB</p>
                    </div>

                    <!-- Email -->
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-envelope text-lg mt-1 text-emerald-200"></i>
                        <p>summitwir@gmail.com</p>
                    </div>
                </div>
            </div>

            <!-- Informasi -->
            <div class="space-y-4">
                <h3 class="font-semibold text-xl mb-4">Informasi</h3>
                <ul class="space-y-3 text-white">
                    <li><a href="{{ route('guide') }}" class="transition hover:text-emerald-200">Cara sewa</a></li>
                </ul>
            </div>

            <!-- Tentang -->
            <div class="space-y-4">
                <h3 class="font-semibold text-xl mb-4">Tentang SummitWir</h3>
                <ul class="space-y-3 text-white">
                    <li><a href="#" class="transition hover:text-emerald-200">Tentang Kami</a></li>
                </ul>
            </div>

            <!-- Layanan Bantuan -->
            <div class="space-y-4">
                <h3 class="font-semibold text-xl mb-4">Layanan Bantuan</h3>

                <p class="text-white">WhatsApp Kami</p>

                <div class="flex items-center gap-3">
                    <i class="fa-brands fa-whatsapp text-2xl text-emerald-200"></i>
                    <p class="text-white text-lg font-semibold">0878 1200 0155</p>
                </div>
            </div>

        </div>

        <!-- Garis -->
        <div class="border-t border-green-800/80 mt-14 pt-6"></div>

        <!-- Bottom -->
        <div class="flex flex-col md:flex-row justify-between items-center text-white">

            <p>&copy; 2025 SummitWir. All rights reserved</p>

            <div class="flex items-center gap-6 mt-4 md:mt-0">
                <span>Follow us</span>
                <i class="fa-brands fa-instagram text-xl transition hover:text-emerald-200 cursor-pointer"></i>
                <i class="fa-brands fa-facebook text-xl transition hover:text-emerald-200 cursor-pointer"></i>
                <i class="fa-brands fa-x-twitter text-xl transition hover:text-emerald-200 cursor-pointer"></i>
            </div>

            
        </div>

    </div>
</footer>
