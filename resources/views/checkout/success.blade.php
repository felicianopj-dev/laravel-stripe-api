@extends('layouts.app')

@section('title', 'Payment Successful')

@section('content')
    <div class="text-center">
        <h2 class="text-success">Payment Successful</h2>

        <p class="mt-3">
            Your payment is being confirmed. The final confirmation happens via webhook.
        </p>

        <a href="{{ route('checkout.form') }}" class="btn btn-outline-primary mt-3">
            Create another payment
        </a>
    </div>
@endsection
