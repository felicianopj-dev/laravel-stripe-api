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
## Environment Variables

```bash
STRIPE_SECRET="stripe-secret"
STRIPE_WEBHOOK_SECRET="stripe-webhook-secret"
STRIPE_CURRENCY="usd"

APP_DEMO_API_TOKEN="your-token"
```

## Demo API Authentication
For demonstration purposes, this project uses a pre-generated Laravel Sanctum personal access token to authenticate billing-related API requests.

The token is injected server-side into the Blade checkout view and sent as a Bearer token when calling protected API endpoints (e.g. /api/billing/checkout). This approach keeps the demo simple while still reflecting real-world access control for billing operations.

You can generate the demo API token locally by running:

```bash
php artisan db:seed --class=DemoUserSeeder
```

The generated token will be printed to the console and should be copied into the APP_DEMO_API_TOKEN environment variable.

> **Note**: This setup is intentionally simplified for portfolio/demo purposes. In a production environment, tokens would be issued dynamically via user authentication (login) and never exposed directly in frontend templates.

## Local Webhook Testing

For local development, Stripe CLI can be used to forward webhook events.

```bash
stripe listen --forward-to http://localhost:8000/stripe/webhook
```

## License

MIT