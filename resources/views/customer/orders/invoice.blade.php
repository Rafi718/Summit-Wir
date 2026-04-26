@extends('layouts.customer')

@section('title', 'Struk Penyewaan | SummitWirr')

@section('content')
@php
    $orderNumber = 'ORD' . str_pad($order->id, 5, '0', STR_PAD_LEFT);
    $dp = (int) round($order->total_price * 0.5);
    $remaining = max((int) $order->total_price - $dp, 0);
    $statusLabel = match ($order->display_status) {
        \App\Models\Order::STATUS_PENDING => 'Menunggu Pembayaran',
        \App\Models\Order::STATUS_PAID => 'Sudah Dibayar',
        \App\Models\Order::STATUS_ON_RENT => 'Sedang Disewa',
        \App\Models\Order::STATUS_OVERDUE => 'Terlambat',
        \App\Models\Order::STATUS_COMPLETED => 'Selesai',
        \App\Models\Order::STATUS_CANCELLED => 'Dibatalkan',
        \App\Models\Order::STATUS_FAILED => 'Gagal',
        \App\Models\Order::STATUS_EXPIRED => 'Kadaluarsa',
        default => ucfirst((string) $order->display_status),
    };
@endphp

<style>
    @media print {
        nav,
        footer,
        .invoice-actions,
        .h-16,
        [data-flash-toast] {
            display: none !important;
        }

        body {
            background: #ffffff !important;
        }

        .invoice-sheet {
            box-shadow: none !important;
            border: 1px solid #111827 !important;
            margin: 0 !important;
        }
    }
</style>

<section class="bg-slate-100 min-h-screen py-8 md:py-12">
    <div class="max-w-5xl mx-auto px-4">
        <div class="invoice-actions flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mb-5">
            <a href="{{ url()->previous() }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-950">
                <span>&larr;</span>
                Kembali
            </a>

            <button type="button" onclick="window.print()"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-950 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800 transition">
                <i class="fas fa-print"></i>
                Cetak Struk
            </button>
        </div>

        <article class="invoice-sheet bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-slate-950 text-white px-6 md:px-10 py-8">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6">
                    <div>
                        <p class="text-xs uppercase tracking-[0.28em] text-slate-300 mb-3">STRUK PENYEWAAN</p>
                        <h1 class="text-3xl md:text-4xl font-black leading-tight">SummitWir</h1>
                        <p class="text-slate-300 mt-2 max-w-xl">
                            Bukti pembayaran DP dan ringkasan penyewaan perlengkapan camping.
                        </p>
                    </div>

                    <div class="md:text-right">
                        <p class="text-sm text-slate-300">Nomor Pesanan</p>
                        <p class="text-2xl font-bold">{{ $orderNumber }}</p>
                        <span class="inline-flex mt-3 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold">
                            {{ $statusLabel }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="px-6 md:px-10 py-8 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="rounded-xl border border-slate-200 p-4">
                        <p class="text-xs uppercase tracking-widest text-slate-500 mb-2">Penyewa</p>
                        <p class="font-bold text-slate-950">{{ $order->user->name }}</p>
                        <p class="text-sm text-slate-600">{{ $order->user->email }}</p>
                        <p class="text-sm text-slate-600">{{ $order->user->no_hp ?? '-' }}</p>
                    </div>

                    <div class="rounded-xl border border-slate-200 p-4">
                        <p class="text-xs uppercase tracking-widest text-slate-500 mb-2">Jadwal</p>
                        <p class="text-sm text-slate-600">Mulai</p>
                        <p class="font-semibold text-slate-950">
                            {{ $order->loan_date ? $order->loan_date->format('d M Y') : 'Belum mulai' }}
                        </p>
                        <p class="text-sm text-slate-600 mt-2">Kembali</p>
                        <p class="font-semibold text-slate-950">
                            {{ $order->return_date ? $order->return_date->format('d M Y') : 'Belum ditentukan' }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-slate-200 p-4">
                        <p class="text-xs uppercase tracking-widest text-slate-500 mb-2">Pengambilan</p>
                        <p class="font-semibold text-slate-950">Kantor Summit Wirr</p>
                        <p class="text-sm text-slate-600">Telkom University Purwokerto</p>
                        <p class="text-sm text-slate-600 mt-2">Durasi: {{ $order->duration }} hari</p>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between gap-3 mb-4">
                        <h2 class="text-lg font-bold text-slate-950">Daftar Barang</h2>
                        <p class="text-sm text-slate-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>

                    <div class="overflow-hidden rounded-xl border border-slate-200">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-100 text-slate-600">
                                <tr>
                                    <th class="text-left px-4 py-3">Barang</th>
                                    <th class="text-center px-4 py-3">Qty</th>
                                    <th class="text-right px-4 py-3">Harga / Hari</th>
                                    <th class="text-right px-4 py-3">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @foreach ($order->orderDetails as $detail)
                                    @php
                                        $itemSubtotal = $detail->product->price * $detail->quantity * $order->duration;
                                    @endphp
                                    <tr>
                                        <td class="px-4 py-4">
                                            <div class="flex items-center gap-3">
                                                <img src="{{ asset('storage/' . $detail->product->image) }}"
                                                    alt="{{ $detail->product->name }}"
                                                    class="w-12 h-12 rounded-lg object-cover">
                                                <div>
                                                    <p class="font-semibold text-slate-950">{{ $detail->product->name }}</p>
                                                    <p class="text-xs text-slate-500">{{ $order->duration }} hari sewa</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-center text-slate-700">{{ $detail->quantity }}</td>
                                        <td class="px-4 py-4 text-right text-slate-700">
                                            Rp{{ number_format($detail->product->price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-4 text-right font-semibold text-slate-950">
                                            Rp{{ number_format($itemSubtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 items-start">
                    <div class="lg:col-span-3 rounded-xl bg-slate-50 border border-slate-200 p-5">
                        <h3 class="font-bold text-slate-950 mb-2">Catatan Penyewaan</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Struk ini menjadi bukti DP penyewaan. Sisa pembayaran dilunasi saat pengambilan barang.
                            Harap kembalikan barang sesuai tanggal yang tertera untuk menghindari denda keterlambatan.
                        </p>
                    </div>

                    <div class="lg:col-span-2 rounded-xl border border-slate-200 p-5 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600">Total Sewa</span>
                            <span class="font-semibold text-slate-950">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600">DP Dibayar</span>
                            <span class="font-semibold text-green-700">Rp{{ number_format($dp, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600">Denda</span>
                            <span class="font-semibold text-slate-950">Rp{{ number_format($order->total_fine ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t border-slate-200 pt-3 flex justify-between">
                            <span class="font-bold text-slate-950">Sisa Bayar</span>
                            <span class="font-black text-slate-950">Rp{{ number_format($remaining, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>
@endsection
