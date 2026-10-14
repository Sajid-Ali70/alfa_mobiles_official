<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matching Orders - {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body { background: #f8fbff; color: #001f3f; font-family: 'Segoe UI', sans-serif; }
        .results-wrapper { width: 100%; max-width: 700px; min-height: 100vh; margin: 0 auto; padding: 20px; background: #fff; }
        .order-card { margin-top: 16px; padding: 18px; border: 1px solid #eef2f7; border-radius: 14px; }
        .order-card h2 { margin: 0; font-size: 18px; font-weight: 800; color: #002d5a; }
        .order-card p { margin: 8px 0 14px; color: #64748b; }
        .status { font-weight: 700; color: #004aad; }
        .btn-view-order { display: inline-block; padding: 10px 16px; border-radius: 24px; background: #004aad; color: #fff; font-weight: 700; text-decoration: none; }
        .btn-back { display: inline-block; margin-top: 20px; color: #004aad; font-weight: 700; text-decoration: none; }
    </style>
</head>
<body>
    <main class="results-wrapper">
        @include('frontend.partials.header')

        <h1 class="mt-4" style="font-size: 24px; font-weight: 900;">Your Orders</h1>
        <p>We found {{ $orders->count() }} orders matching your details. Select an order to view its tracking status.</p>

        @foreach($orders as $order)
            <article class="order-card">
                <h2>{{ $order->order_number }}</h2>
                <p>{{ $order->mobile_name }} &middot; {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</p>
                <p class="status mb-3">Status: {{ $order->status }}</p>
                <form action="{{ route('track.status') }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->order_number }}">
                    <button type="submit" class="btn-view-order">View Tracking</button>
                </form>
            </article>
        @endforeach

        <a href="{{ route('track') }}" class="btn-back">&larr; Search again</a>
    </main>
</body>
</html>
