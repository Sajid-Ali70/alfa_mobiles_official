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
        body { background-color: #f8fbff; }
        .success-wrapper {
            padding: 30px 20px;
            text-align: center;
            background: #fff;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 20px;
            margin-top: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .success-title { font-size: 24px; font-weight: 800; color: #002d5a; margin-top: 15px; }

        /* Summary Card */
        .summary-card {
            background: #fff;
            border: 1px solid #eef2f7;
            border-radius: 15px;
            padding: 20px;
            text-align: left;
            margin: 25px 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px; margin-bottom: 15px; }
        .info-grid:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
        .info-item label { display: block; font-size: 11px; color: #888; font-weight: 700; text-transform: uppercase; margin-bottom: 2px; }
        .info-item span { display: block; font-size: 14px; font-weight: 800; color: #002d5a; }
        .text-green { color: #00a65a !important; }

        /* Timeline Styling */
        .order-timeline-container { text-align: left; margin-top: 30px; }
        .timeline-header { font-size: 22px; font-weight: 800; color: #002d5a; margin-bottom: 25px; }

        .timeline-v { position: relative; padding-left: 50px; }
        .timeline-v::before {
            content: '';
            position: absolute;
            left: 20px; top: 0; bottom: 0;
            width: 2px; background: #e0e6ed;
            z-index: 1;
        }

        .t-step { position: relative; margin-bottom: 35px; min-height: 50px; }
        .t-num {
            position: absolute; left: -50px;
            width: 42px; height: 42px;
            background: #fff; border: 2px solid #e0e6ed;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; color: #888; z-index: 2;
        }

        /* Active/Completed states */
        .t-step.active .t-num { background: #00a65a; border-color: #00a65a; color: #fff; }
        .t-step.active .t-content {
            background-color: #f0fff4;
            border-radius: 12px;
            padding: 15px;
            border: 1px solid #dcfce7;
        }
        .t-step.active .t-title { color: #00a65a; display: flex; align-items: center; gap: 8px; }
        .t-step.active .t-title::after {
            content: '\f058'; font-family: 'Font Awesome 5 Free'; font-weight: 900;
            font-size: 14px;
        }

        .t-title { font-size: 16px; font-weight: 800; color: #002d5a; margin-bottom: 4px; }
        .t-desc { font-size: 13px; color: #64748b; line-height: 1.5; margin: 0; }

        .support-box {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            margin: 30px 0;
        }
        .support-links { display: flex; justify-content: center; gap: 30px; }
        .support-link { text-decoration: none; font-weight: 700; font-size: 14px; display: flex; align-items: center; gap: 8px; }

        .btn-home {
            width: 100%; border: 2px solid #002d5a; color: #002d5a;
            border-radius: 30px; padding: 14px; font-weight: 800;
            background: transparent; transition: all 0.2s;
            text-decoration: none; display: block;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
    <div class="mobile-wrapper">
        @include('frontend.partials.header')

        <div class="success-wrapper">
            <h1 class="success-title">Order Placed Successfully!</h1>
            <p style="color: #64748b;">Thank you, <strong>{{ $order->full_name }}</strong>. Your request is registered.</p>

            <div class="summary-card">
                <div class="info-grid">
                    <div class="info-item">
                        <label>Tenure Plan</label>
                        <span>{{ str_replace('Months Months', 'Months', $order->tenure . ' Months') }}</span>
                    </div>
                    <div class="info-item">
                        <label>Monthly EMI:</label>
                        <span class="text-green">{{ $order->monthly_emi }}</span>
                    </div>
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Delivery Option:</label>
                        <span>Open Parcel (TCS Rider)</span>
                    </div>
                    <div class="info-item">
                        <label>Payment Mode:</label>
                        <span>{{ strtoupper($order->payment_method) }}</span>
                    </div>
                </div>
            </div>

            <div class="order-timeline-container">
                <h2 class="timeline-header">Order Processing Timeline</h2>
                <div class="timeline-v">
                    <!-- Step 1 -->
                    <div class="t-step active">
                        <div class="t-num">1</div>
                        <div class="t-content">
                            <h4 class="t-title">Waiting for Approval</h4>
                            <p class="t-desc">Your order is under review and waiting for approval.</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="t-step">
                        <div class="t-num">2</div>
                        <div class="t-content">
                            <h4 class="t-title">Order Approved</h4>
                            <p class="t-desc">Your order has been approved successfully.</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="t-step">
                        <div class="t-num">3</div>
                        <div class="t-content">
                            <h4 class="t-title">Mobile Dispatched</h4>
                            <p class="t-desc">Your mobile has been dispatched and will be delivered to you within 1 to 2 days. You will also receive the TCS rider's name and mobile number via email.</p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="t-step">
                        <div class="t-num">4</div>
                        <div class="t-content">
                            <h4 class="t-title">Parcel Delivered Successfully</h4>
                            <p class="t-desc">Your parcel has been delivered successfully.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="support-box">
                <p style="font-size: 14px; font-weight: 800; color: #002d5a; margin-bottom: 15px;">Need help with your order?</p>
                <div class="support-links">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', env('SUPPORT_WHATSAPP', '923277949105')) }}" class="support-link" style="color: #25d366;">
                        <i class="fab fa-whatsapp" style="font-size: 20px;"></i> WhatsApp Support
                    </a>
                    <a href="mailto:{{ env('SUPPORT_EMAIL', 'sajid40830@gmail.com') }}" class="support-link" style="color: #e31e24;">
                        <i class="fas fa-envelope" style="font-size: 18px;"></i> Email Us
                    </a>
                </div>
            </div>

            <a href="{{ url('/') }}" class="btn-home">Back to Home</a>
        </div>
    </div>
</body>
</html>
