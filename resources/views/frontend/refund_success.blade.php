<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund Request Success - {{ $settings->app_name ?? 'Alfa Mobiles' }}</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .success-content {
            padding: 40px 20px;
            text-align: center;
        }
        .success-circle {
            width: 80px;
            height: 80px;
            background-color: #e8f5e9;
            color: #2e7d32;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin: 0 auto 20px;
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.1);
        }
        .success-title {
            font-size: 28px;
            font-weight: 800;
            color: #002d72;
            margin-bottom: 5px;
        }
        .success-subtitle {
            font-size: 28px;
            font-weight: 800;
            color: #2e7d32;
            margin-bottom: 15px;
        }
        .success-desc {
            font-size: 15px;
            color: #666;
            font-weight: 600;
            line-height: 1.4;
            margin-bottom: 30px;
        }
        .id-card-box {
            border: 1px dashed #eee;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            position: relative;
        }
        .id-card-icon {
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            padding: 0 10px;
            color: #004aad;
            font-size: 20px;
        }
        .id-label {
            font-size: 14px;
            font-weight: 800;
            color: #333;
            margin-bottom: 8px;
        }
        .id-value {
            font-size: 22px;
            font-weight: 900;
            color: #004aad;
            margin-bottom: 15px;
        }
        .id-divider {
            border-top: 1px dashed #eee;
            margin: 15px 0;
        }
        .dt-label {
            font-size: 11px;
            font-weight: 700;
            color: #999;
            margin-bottom: 5px;
        }
        .dt-value {
            font-size: 14px;
            font-weight: 800;
            color: #333;
        }

        .info-card {
            background-color: #f8fbff;
            border-radius: 20px;
            padding: 20px;
            text-align: left;
            margin-bottom: 30px;
        }
        .info-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            color: #002d72;
        }
        .info-header i { font-size: 20px; }
        .info-header h3 { font-size: 18px; font-weight: 800; margin: 0; }

        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .info-item {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        .info-item i {
            color: #004aad;
            font-size: 16px;
            margin-top: 3px;
            width: 20px;
            text-align: center;
        }
        .info-item p {
            margin: 0;
            font-size: 13px;
            font-weight: 700;
            color: #333;
            line-height: 1.4;
        }
        .info-item p span {
            color: #004aad;
            text-decoration: underline;
        }

        .action-btns {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 15px;
            padding: 0 15px 40px;
        }
        .btn-back-success {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 15px;
            color: #333;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-home-success {
            background: #002d72;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 15px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="mobile-wrapper">
        <!-- Reusable Header -->
        @include('frontend.partials.header')

        <div class="success-content">
            <div class="success-circle">
                <i class="fas fa-check"></i>
            </div>

            <h1 class="success-title">Refund Request</h1>
            <h2 class="success-subtitle">Successfully Received!</h2>

            <p class="success-desc">
                Your refund request has been received and<br>
                is now being reviewed.
            </p>

            <div class="id-card-box">
                <div class="id-card-icon"><i class="far fa-file-alt"></i></div>
                <div class="id-label">Your Refund Request ID</div>
                <div class="id-value">{{ $refund->refund_id ?? 'RRF-20260821-897462' }}</div>

                <div class="id-divider"></div>

                <div class="dt-label">Date & Time</div>
                <div class="dt-value">{{ \Carbon\Carbon::parse($refund->created_at ?? now())->format('d M Y | h:i A') }}</div>
            </div>

            <div class="info-card">
                <div class="info-header">
                    <i class="fas fa-info-circle"></i>
                    <h3>Important Information</h3>
                </div>

                <ul class="info-list">
                    <li class="info-item">
                        <i class="far fa-clock"></i>
                        <p>Your refund request is important to us. It will be processed within approximately <span>6 hours</span>.</p>
                    </li>
                    <li class="info-item">
                        <i class="fas fa-headset"></i>
                        <p>Please stay in touch with our agent or supervisor during this time.</p>
                    </li>
                    <li class="info-item">
                        <i class="fas fa-phone-alt"></i>
                        <p>Please keep your mobile phone on and accessible. You may receive a call, email or WhatsApp message regarding your refund.</p>
                    </li>
                    <li class="info-item">
                        <i class="fas fa-shield-alt"></i>
                        <p>Do not contact any bank helpline during this process. Doing so may delay your refund.</p>
                    </li>
                    <li class="info-item">
                        <i class="fas fa-check-circle"></i>
                        <p>Once your refund is completed, the amount will be returned to your original account.</p>
                    </li>
                    <li class="info-item">
                        <i class="fas fa-heart"></i>
                        <p>Thank you for your patience and cooperation. We value your trust in {{ $settings->app_name ?? 'Alfa Mobiles' }} Mart.</p>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-btns">
            <a href="{{ route('refund') }}" class="btn-back-success">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <a href="{{ route('home') }}" class="btn-home-success">
                <i class="fas fa-home"></i> Go to Home
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
