@extends('layouts.customer')

@section('title', 'Pembayaran Berhasil | SummitWirr')

@section('content')
    <section class="max-w-4xl mx-auto px-6 py-12">
        <div class="bg-white rounded-2xl shadow-md p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-green-950 mb-4">Pembayaran Berhasil</h1>
                <p class="text-lg mb-2">Pesanan #{{ $order->id }} telah dibayar.</p>
                <p class="text-gray-600">
                    Silakan ambil barang sewaan Anda di lokasi berikut.
                </p>
            </div>

            <div class="bg-gray-100 p-4 rounded-xl mb-6">
                <p><strong>Tempat Pengambilan:</strong> Kantor Summit Wirr, Telkom University Purwokerto</p>
                <p><strong>Durasi Sewa:</strong> {{ $order->duration }} hari</p>
                <p><strong>Sisa Pembayaran:</strong> Rp{{ number_format($order->total_price * 0.5, 0, ',', '.') }}</p>
            </div>

            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Barang yang Disewa</h2>
                <div class="space-y-3">
                    @foreach ($order->orderDetails as $detail)
                        <div class="flex items-center justify-between gap-4 rounded-xl border border-gray-200 p-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('storage/' . $detail->product->image) }}"
                                    alt="{{ $detail->product->name }}"
                                    class="w-14 h-14 object-cover rounded-lg">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $detail->product->name }}</p>
                                    <p class="text-sm text-gray-500">Qty: {{ $detail->quantity }}</p>
                                </div>
                            </div>
                            <p class="font-semibold text-gray-900">
                                Rp{{ number_format($detail->product->price * $detail->quantity * $order->duration, 0, ',', '.') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('profile.index') }}"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-center">
                    Lihat Profil
                </a>
                <a href="{{ route('products') }}"
                    class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-center">
                    Sewa Lagi
                </a>
            </div>
        </div>
    </section>
@endsection
