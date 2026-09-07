<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund Payment - {{ $settings->app_name ?? 'Alfa Mobiles' }}</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .refund-alert-box {
            background-color: #fffafa;
            border: 1px solid #ffcccc;
            border-radius: 20px;
            padding: 30px;
            margin: 30px 20px;
            display: flex;
            gap: 20px;
        }
        .refund-alert-icon {
            color: #e31e24;
            font-size: 32px;
            margin-top: 8px;
        }
        .urdu-text {
            direction: rtl;
            text-align: right;
            flex-grow: 1;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.8;
        }
        .urdu-text h3 {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 15px;
        }
        .urdu-text p {
            margin-bottom: 0;
            font-size: 20px;
            font-weight: 600;
        }
        .section-header {
            padding: 0 30px;
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
            color: #002d72;
        }
        .section-header i { font-size: 28px; }
        .section-header h2 { font-size: 24px; font-weight: 800; margin: 0; }

        .refund-form-container {
            padding: 0 20px;
        }
        .input-group-custom {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 15px;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        }
        .input-group-custom i {
            color: #333;
            font-size: 24px;
            width: 35px;
            text-align: center;
        }
        .input-field-wrap {
            flex-grow: 1;
        }
        .input-field-wrap label {
            display: block;
            font-size: 16px;
            font-weight: 700;
            color: #333;
            margin-bottom: 4px;
        }
        .input-field-wrap input {
            width: 100%;
            border: none;
            padding: 0;
            font-size: 18px;
            font-weight: 600;
            color: #666;
            outline: none;
        }
        .input-field-wrap input::placeholder { color: #ccc; font-weight: 500; }

        .info-blue-box {
            background-color: #eef4ff;
            border-radius: 15px;
            padding: 18px 22px;
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 15px 0 40px;
        }
        .info-blue-box i { color: #004aad; font-size: 22px; }
        .info-blue-box span { font-size: 16px; color: #004aad; font-weight: 700; }

        .bottom-actions {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 20px;
            padding: 30px 20px 60px;
        }
        .btn-back-refund {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 15px;
            padding: 20px;
            color: #333;
            font-weight: 700;
            text-decoration: none;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 18px;
        }
        .btn-next-refund {
            background: #004aad;
            color: #fff;
            border: none;
            border-radius: 15px;
            padding: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            width: 100%;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="mobile-wrapper">
        <!-- Reusable Header -->
        @include('frontend.partials.header')

        <!-- Urdu Alert Box -->
        <div class="refund-alert-box">
            <div class="refund-alert-icon"><i class="fas fa-exclamation-circle"></i></div>
            <div class="urdu-text">
                <h3>محترم کسٹمر!</h3>
                <p>
                    اس مرحلہ پر ادائیگی درکار نہیں تھی،<br>
                    اس لئے اگر آپ نے غلطی سے رقم منتقل کر دی ہے تو<br>
                    ہمیں اس پر افسوس ہے۔<br>
                    برائے کرم درج ذیل معلومات ارسال کریں تاکہ<br>
                    تصدیق کے بعد آپ کی رقم واپس کی جا سکے۔<br>
                    تمام معلومات کی تصدیق کے بعد آپ کی رقم<br>
                    جلد از جلد اسی اکاؤنٹ میں واپس کر دی جائے گی۔<br>
                    شکریہ۔
                </p>
            </div>
        </div>

        <!-- Customer Details Section -->
        <div class="section-header">
            <i class="fas fa-user-edit"></i>
            <h2>Customer Details</h2>
        </div>

        <form action="{{ route('refund.agreement') }}" method="POST">
            @csrf
            <div class="refund-form-container">
                <div class="input-group-custom">
                    <i class="far fa-user"></i>
                    <div class="input-field-wrap">
                        <label>Customer Name</label>
                        <input type="text" name="customer_name" placeholder="Enter your full name" required>
                    </div>
                </div>

                <div class="input-group-custom">
                    <i class="far fa-list-alt"></i>
                    <div class="input-field-wrap">
                        <label>Order ID / Order Number</label>
                        <input type="text" name="order_id" placeholder="Enter your order ID or order number" required>
                    </div>
                </div>

                <div class="input-group-custom">
                    <i class="fas fa-dollar-sign"></i>
                    <div class="input-field-wrap">
                        <label>Refund Amount (PKR)</label>
                        <input type="number" name="refund_amount" placeholder="Enter refund amount" required>
                    </div>
                </div>

                <div class="info-blue-box">
                    <i class="fas fa-info-circle"></i>
                    <span>Please enter the exact amount you want to refund.</span>
                </div>
            </div>

            <!-- Bottom Actions -->
            <div class="bottom-actions">
                <a href="{{ url('/') }}" class="btn-back-refund">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <button type="submit" class="btn-next-refund">
                    Next <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
