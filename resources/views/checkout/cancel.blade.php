@extends('layouts.app')

@section('title', 'Payment Canceled')

@section('content')
    <div class="text-center">
        <h2 class="text-danger">Payment Canceled</h2>

        <p class="mt-3">
            No charge was made.
        </p>

        <a href="{{ route('checkout.form') }}" class="btn btn-outline-secondary mt-3">
            Try again
        </a>
    </div>
@endsection
