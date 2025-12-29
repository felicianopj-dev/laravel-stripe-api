@extends('layouts.app')

@section('title', 'Checkout Test')

@section('content')
    @php
        use App\Models\Product;

        $products = Product::query()
            ->where('is_active', true)
            ->orderBy('amount_cents')
            ->get();
    @endphp
    <meta name="api-token" content="{{ $apiToken }}">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-3">Test Stripe Payment</h4>

                    <form method="POST" action="{{ route('checkout.create') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Product</label>
                            <select name="product_code" class="form-select" required>
                                @foreach ($products as $product)
                                    <option value="{{ $product->code }}">
                                        {{ $product->name }}
                                        — {{ number_format($product->amount_cents / 100, 2) }}
                                        {{ strtoupper($product->currency) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Pay with Stripe
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        document.getElementById('payBtn').addEventListener('click', async () => {
            const token = document
                .querySelector('meta[name="api-token"]')
                ?.getAttribute('content');

            if (!token) {
                alert('Missing API token - check .env');
                return;
            }

            const productCode = document.getElementById('product_code').value;

            if (!productCode) {
                alert('Please select a product.');
                return;
            }

            const res = await fetch('/api/billing/checkout', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    product_code: productCode
                })
            });

            if (!res.ok) {
                const err = await res.json().catch(() => ({}));
                alert(err.message || 'Checkout failed');
                return;
            }

            const data = await res.json();
            window.location.href = data.checkout_url;
        });
    </script>
@endsection
