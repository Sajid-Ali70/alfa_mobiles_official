<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order - {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body { background-color: #f8fbff; color: #001f3f; font-family: 'Segoe UI', sans-serif; }
        .track-wrapper { padding: 20px; max-width: 600px; margin: 0 auto; background: #fff; min-height: 100vh; }

        /* Summary Card */
        .summary-card {
            border: 1px solid #eef2f7; border-radius: 15px; padding: 0;
            margin-bottom: 30px; text-align: left; overflow: hidden;
        }
        .info-row { display: grid; grid-template-columns: 1fr 1fr; border-bottom: 1px solid #f1f5f9; }
        .info-row:last-child { border-bottom: none; }
        .info-item { padding: 12px 15px; }
        .info-item:first-child { border-right: 1px solid #f1f5f9; }
        .info-item label { display: block; font-size: 11px; color: #8ba2ad; font-weight: 700; margin-bottom: 2px; }
        .info-item span { display: block; font-size: 14px; font-weight: 800; color: #002d5a; }
        .text-green { color: #00a65a !important; }

        /* Timeline Styling */
        .timeline-header { font-size: 24px; font-weight: 900; color: #002d5a; margin-bottom: 30px; text-align: left; }
        .timeline-container { position: relative; padding-left: 50px; text-align: left; }
        .timeline-container::before {
            content: ''; position: absolute; left: 20px; top: 5px; bottom: 0;
            width: 2px; background: #e0e6ed; z-index: 1;
        }

        .t-step { position: relative; margin-bottom: 35px; }
        .t-num {
            position: absolute; left: -50px; width: 42px; height: 42px;
            background: #fff; border: 2px solid #e0e6ed; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; color: #888; z-index: 2;
        }

        /* Active State */
        .t-step.active .t-num { background: #00a65a; border-color: #00a65a; color: #fff; box-shadow: 0 0 0 5px rgba(0, 166, 90, 0.1); }
        .t-step.active .t-content {
            background-color: #f0fff4; border-radius: 12px; padding: 15px;
            border: 1px solid #dcfce7; position: relative;
        }
        .t-step.active .t-title { color: #00a65a; display: flex; align-items: center; gap: 8px; }
        .t-step.active .t-title::after { content: '\f058'; font-family: 'Font Awesome 5 Free'; font-weight: 900; font-size: 16px; }

        /* Cancelled State */
        .t-step.cancelled .t-num { background: #e31e24; border-color: #e31e24; color: #fff; }
        .t-step.cancelled .t-content {
            background-color: #fff5f5; border-radius: 12px; padding: 15px;
            border: 1px solid #fed7d7; position: relative;
        }
        .t-step.cancelled .t-title { color: #e31e24; font-weight: 800; }
        .cancel-msg-box {
            background: #fff5f5; border: 1px solid #fed7d7; color: #c53030;
            padding: 12px; border-radius: 8px; font-size: 13px; margin-top: 10px;
            line-height: 1.5; font-weight: 600;
        }

        /* Completed State */
        .t-step.completed .t-num { background: #00a65a; border-color: #00a65a; color: #fff; }

        .t-title { font-size: 17px; font-weight: 800; color: #002d5a; margin-bottom: 4px; }
        .t-desc { font-size: 13px; color: #64748b; line-height: 1.5; margin: 0; }

        /* Support Box */
        .support-box { background: #f8fafc; border-radius: 15px; padding: 20px; margin: 30px 0; text-align: center; }
        .support-links { display: flex; justify-content: center; gap: 30px; }
        .support-link { text-decoration: none; font-weight: 700; font-size: 14px; display: flex; align-items: center; gap: 8px; }

        .btn-home {
            width: 100%; border: 2px solid #002d5a; color: #002d5a;
            border-radius: 35px; padding: 12px; font-weight: 800;
            background: transparent; text-decoration: none; display: block;
        }

        .final-footer { margin-top: 30px; text-align: center; padding-bottom: 20px; }
        .footer-branding { font-size: 13px; font-weight: 700; color: #8ba2ad; display: flex; align-items: center; justify-content: center; gap: 10px; }
        .footer-branding::before, .footer-branding::after { content: ''; height: 1px; width: 40px; background: #e2e8f0; }

        /* Rider Badge */
        .rider-details {
            background: #f0f7ff; border: 1px dashed #007bff;
            padding: 10px; border-radius: 8px; margin-top: 10px; font-size: 12px;
        }
    </style>
</head>
<body>
    @php
        $status = $order->status;
        $isCancelled = in_array($status, ['Cancelled', 'Cancelled - Wrong Screenshot Attached', 'Cancelled - Verification Not Completed']);

        $step1_done = in_array($status, ['Initial Verification', 'Verification Completed', 'Order Approved', 'Mobile Dispatched', 'Parcel in Transit', 'Parcel Delivered Successfully', 'First Installment Due', 'Completed']);
        $step1_active = in_array($status, ['Waiting for Approval', 'Pending']) && !$isCancelled;

        $step2_done = in_array($status, ['Mobile Dispatched', 'Parcel in Transit', 'Parcel Delivered Successfully', 'First Installment Due', 'Completed']);
        $step2_active = in_array($status, ['Order Approved', 'Approved', 'Verification Completed']) && !$isCancelled;

        $step3_done = in_array($status, ['Parcel Delivered Successfully', 'First Installment Due', 'Completed']);
        $step3_active = in_array($status, ['Mobile Dispatched', 'Parcel in Transit']) && !$isCancelled;
    @endphp

    <div class="track-wrapper">
        @include('frontend.partials.header')

        <div class="summary-card">
            <div class="info-row">
                <div class="info-item"><label>Order ID</label><span>{{ $order->order_number }}</span></div>
                <div class="info-item"><label>Order Date</label><span>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</span></div>
            </div>
            <div class="info-row">
                <div class="info-item"><label>Tenure Plan</label><span>{{ str_replace('Months Months', 'Months', $order->tenure . ' Months') }}</span></div>
                <div class="info-item"><label>Monthly EMI:</label><span class="text-green">{{ $order->monthly_emi }}</span></div>
            </div>
            <div class="info-row">
                <div class="info-item"><label>Delivery Option:</label><span>Open Parcel (TCS Rider)</span></div>
                <div class="info-item"><label>Payment Mode</label><span>{{ strtoupper($order->payment_method) }}</span></div>
            </div>
        </div>

        <div class="timeline-section">
            <h2 class="timeline-header">Order Processing Timeline</h2>
            <div class="timeline-container">

                <!-- Step 1 -->
                <div class="t-step {{ $step1_done ? 'completed' : '' }} {{ $step1_active ? 'active' : '' }}">
                    <div class="t-num">1</div>
                    <div class="t-content">
                        <h4 class="t-title">Waiting for Approval</h4>
                        <p class="t-desc">Your order is under review and waiting for approval.</p>
                    </div>
                </div>

                @if($isCancelled)
                <div class="t-step cancelled">
                    <div class="t-num">2</div>
                    <div class="t-content">
                        <h4 class="t-title">{{ $status }}</h4>
                        <div class="cancel-msg-box">
                            @if($status == 'Cancelled - Wrong Screenshot Attached')
                                Your order has been cancelled because the screenshot provided was incorrect or invalid. Please contact our support to resolve this.
                            @else
                                Your order has been cancelled because the verification process was not completed. Please contact our supervisor and ensure your connection is stable.
                            @endif
                        </div>
                    </div>
                </div>
                @else
                <!-- Step 2 -->
                <div class="t-step {{ $step2_done ? 'completed' : '' }} {{ $step2_active ? 'active' : '' }}">
                    <div class="t-num">2</div>
                    <div class="t-content">
                        <h4 class="t-title">Order Approved</h4>
                        <p class="t-desc">Your order has been approved successfully.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="t-step {{ $step3_done ? 'completed' : '' }} {{ $step3_active ? 'active' : '' }}">
                    <div class="t-num">3</div>
                    <div class="t-content">
                        <h4 class="t-title">Mobile Dispatched</h4>
                        <p class="t-desc">Your mobile has been dispatched and will be delivered to you within 1 to 2 days.</p>
                        @if($order->rider_name)
                        <div class="rider-details">
                            <i class="fas fa-truck-loading me-1"></i> <strong>Rider:</strong> {{ $order->rider_name }} |
                            <i class="fas fa-phone-alt ms-2 me-1"></i> <strong>Phone:</strong> {{ $order->rider_phone }}
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="t-step {{ $status == 'Parcel Delivered Successfully' || $status == 'Completed' ? 'completed' : '' }}">
                    <div class="t-num">4</div>
                    <div class="t-content">
                        <h4 class="t-title">Parcel Delivered Successfully</h4>
                        <p class="t-desc">Your parcel has been delivered successfully.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="support-box">
            <p style="font-size: 13px; font-weight: 700; color: #002d5a; margin-bottom: 15px;">Need help with your order?</p>
            <div class="support-links">
                <a href="https://wa.me/{{ env('SUPPORT_WHATSAPP', '923277949105') }}" class="support-link" style="color: #25d366;">
                    <i class="fab fa-whatsapp"></i> WhatsApp Support
                </a>
                <a href="mailto:{{ env('SUPPORT_EMAIL', 'sajid40830@gmail.com') }}" class="support-link" style="color: #e31e24;">
                    <i class="fas fa-envelope"></i> Email Us
                </a>
            </div>
        </div>

        <a href="{{ url('/') }}" class="btn-home text-center">Back to Home</a>

        <div class="final-footer">
            <div class="footer-branding">
                {{ env('FOOTER_BRANDING', 'Alfa Mobiles Mart | Safe • Secure • Trusted') }}
            </div>
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
