# Laravel + Stripe Checkout Integration

A clean and production-oriented integration between Laravel and the Stripe API, demonstrating a complete payment flow using Stripe Checkout and webhooks.

## Tech Stack

- Laravel 11
- PHP 8.2+
- Stripe API
- Blade
- Bootstrap

## Typical Payment Flow

- Create Checkout Session
- Redirect customer to Stripe Checkout
- Receive and validate webhook events
- Persist payment data and status

## Setup
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## Local Webhook Testing

For local development, Stripe CLI can be used to forward webhook events.

```bash
stripe listen --forward-to http://localhost:8000/stripe/webhook
```

## License

MIT