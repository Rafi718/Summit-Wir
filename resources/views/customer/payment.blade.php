@extends('layouts.customer')

@section('title', 'Pembayaran | SummitWirr')

@section('content')
    <section class="max-w-3xl mx-auto px-6 py-12 text-center">
        <h1 class="text-2xl font-bold mb-6">Pembayaran Pesanan #{{ $order->id }}</h1>
        <p class="text-lg mb-4">Total: <strong>Rp {{ number_format($order->total_price * 0.5, 0, ',', '.') }}</strong></p>

        <button id="pay-button" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            Bayar Sekarang
        </button>

        <form id="payment-form" action="{{ route('checkout.process', ['order' => $order->id]) }}" method="POST"
            style="display: none;">
            @csrf
        </form>
    </section>

    <script src="/assets/js/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        const syncPaymentStatus = async (result) => {
            const response = await fetch("{{ route('payment.sync', $order, false) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                body: JSON.stringify({
                    transaction_status: result.transaction_status || 'pending',
                }),
            });

            return response.json();
        };

        const goToPaymentStatus = () => {
            window.location.href = "{{ route('payment.status', ['order' => $order->id], false) }}";
        };

        document.getElementById('pay-button').addEventListener('click', function() {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: async function(result) {
                    const payment = await syncPaymentStatus(result);
                    window.location.href = payment.redirect_url || "{{ route('profile.orders.renting', absolute: false) }}";
                },
                onPending: async function(result) {
                    await syncPaymentStatus(result);
                    goToPaymentStatus();
                },
                onError: async function(result) {
                    await syncPaymentStatus(result);
                    goToPaymentStatus();
                },
                onClose: function() {
                    //
                }
            });
        });
    </script>
@endsection
