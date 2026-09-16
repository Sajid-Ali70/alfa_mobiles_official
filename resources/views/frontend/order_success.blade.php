<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Placed Successfully - {{ $settings->app_name ?? 'Alfa Mobiles' }}</title>
    <link rel="icon" type="image/png" href="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .success-wrapper {
            padding: 20px;
            text-align: center;
            background: #fff;
        }
        .success-icon {
            width: 80px;
            height: 80px;
            background: #28a745;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin: 0 auto 20px;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);
        }
        .success-title {
            font-size: 26px;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 10px;
        }
        .success-subtitle {
            font-size: 15px;
            color: #666;
            line-height: 1.5;
            margin-bottom: 30px;
        }
        .success-subtitle strong {
            color: #333;
        }

        .order-id-box {
            border: 2px dashed #e31e24;
            border-radius: 15px;
            padding: 20px;
            background: #fffafa;
            margin-bottom: 30px;
            position: relative;
        }
        .order-id-label {
            font-size: 12px;
            font-weight: 800;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            display: block;
        }
        .order-id-value {
            font-size: 24px;
            font-weight: 800;
            color: #e31e24;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .btn-copy {
            background: #f0f0f0;
            border: none;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            color: #333;
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
        }

        .summary-card {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 20px;
            padding: 20px;
            text-align: left;
            margin-bottom: 40px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.02);
        }
        .product-info {
            display: flex;
            gap: 15px;
            align-items: center;
            padding-bottom: 15px;
            border-bottom: 1px solid #f5f5f5;
            margin-bottom: 15px;
        }
        .product-img {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }
        .product-name {
            font-size: 17px;
            font-weight: 800;
            color: #1a1a1a;
            margin: 0;
        }
        .product-meta {
            font-size: 13px;
            color: #888;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .info-item label {
            display: block;
            font-size: 12px;
            color: #999;
            margin-bottom: 4px;
        }
        .info-item span {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: #333;
        }
        .text-green { color: #28a745 !important; }

        .timeline-section {
            text-align: left;
            margin-bottom: 40px;
        }
        .timeline-title {
            font-size: 18px;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 20px;
        }
        .timeline {
            position: relative;
            padding-left: 45px;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 17px;
            top: 0;
            width: 2px;
            height: 100%;
            background: #eee;
            z-index: 1;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 25px;
        }
        .timeline-dot {
            position: absolute;
            left: -45px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 14px;
            color: #999;
            z-index: 2;
        }
        .timeline-item.active .timeline-dot {
            background: #e31e24;
            border-color: #e31e24;
            color: #fff;
        }
        .timeline-content h4 {
            font-size: 15px;
            font-weight: 800;
            margin: 0 0 5px;
            color: #333;
        }
        .timeline-content p {
            font-size: 13px;
            color: #777;
            margin: 0;
            line-height: 1.4;
        }

        .footer-support {
            background: #f9f9f9;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .support-title {
            font-size: 14px;
            font-weight: 800;
            color: #666;
            margin-bottom: 15px;
        }
        .support-links {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .support-link {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 700;
            color: #333;
            text-decoration: none;
        }
        .support-link.whatsapp { color: #25d366; }
        .support-link.email { color: #e31e24; }
    </style>
</head>
<body>
    <div class="mobile-wrapper">
        @include('frontend.partials.header')

        <div class="success-wrapper">
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>

            <h1 class="success-title">Order Placed Successfully!</h1>
            <p class="success-subtitle">
                Thank you, <strong>{{ $order->full_name }}</strong>. Your installment request is registered.
            </p>

            <div class="order-id-box">
                <span class="order-id-label">Your Official Order ID</span>
                <div class="order-id-value">
                    <span id="orderIdText">{{ $order->order_number }}</span>
                    <button class="btn-copy" onclick="copyOrderId()">
                        <i class="far fa-copy"></i> Copy
                    </button>
                </div>
            </div>

            <div class="summary-card">
                <div class="product-info">
                    <img src="{{ asset($mobile->image_url) }}" class="product-img" alt="{{ $mobile->name }}">
                    <div>
                        <h3 class="product-name">{{ $mobile->name }} {{ $order->storage }}</h3>
                        <span class="product-meta">Standard Storage • {{ $order->color }}</span>
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <label>Tenure Plan:</label>
                        <span>{{ $order->tenure }} Months</span>
                    </div>
                    <div class="info-item">
                        <label>Monthly EMI:</label>
                        <span class="text-green">Rs. {{ number_format(str_replace(',', '', str_replace('Rs. ', '', $order->monthly_emi))) }} / mo</span>
                    </div>
                    <div class="info-item">
                        <label>Delivery Option:</label>
                        <span>{{ $order->delivery_type == 'Open Parcel via TCS Rider (Recommended)' ? 'Open Parcel (TCS Rider)' : $order->delivery_type }}</span>
                    </div>
                    <div class="info-item">
                        <label>Payment Mode:</label>
                        <span>{{ strtoupper($order->payment_method) }}</span>
                    </div>
                </div>
            </div>

            <div class="timeline-section">
                <h3 class="timeline-title">Order Processing Timeline</h3>
                <div class="timeline">
                    <div class="timeline-item active">
                        <div class="timeline-dot">1</div>
                        <div class="timeline-content">
                            <h4>Waiting for Approval (~5 min)</h4>
                            <p>Our verification agent checks customer address and payment choices.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot">2</div>
                        <div class="timeline-content">
                            <h4>Order Placed (~10 min after approval)</h4>
                            <p>Parcel dispatched via TCS Courier with SMS & WhatsApp tracking code.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot">3</div>
                        <div class="timeline-content">
                            <h4>Delivered & Verified</h4>
                            <p>Open parcel, verify original device condition, complete payment.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-support">
                <h4 class="support-title">Have questions about your order?</h4>
                <div class="support-links">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->contact_number ?? '') }}" class="support-link whatsapp">
                        <i class="fab fa-whatsapp"></i> WhatsApp Support
                    </a>
                    <a href="mailto:{{ $settings->contact_email ?? '' }}" class="support-link email">
                        <i class="fas fa-envelope"></i> Email Us
                    </a>
                </div>
            </div>

            <a href="{{ url('/') }}" class="btn btn-outline-secondary w-100 py-3 rounded-pill fw-bold mb-5">
                Back to Home
            </a>
        </div>
    </div>

    <script>
        function copyOrderId() {
            const text = document.getElementById('orderIdText').innerText;
            navigator.clipboard.writeText(text).then(() => {
                const btn = document.querySelector('.btn-copy');
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check"></i> Copied';
                btn.style.color = '#28a745';
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.style.color = '#333';
                }, 2000);
            });
        }
    </script>
</body>
</html>
