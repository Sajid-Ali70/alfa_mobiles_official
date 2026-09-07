<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Agreement - {{ $settings->app_name ?? 'Alfa Mobiles' }}</title>
    <link rel="icon" type="image/png" href="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .loading-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.7); display: none; align-items: center;
            justify-content: center; z-index: 9999; color: #fff;
        }
        .step-indicator-wrapper {
            padding: 20px 20px 10px;
        }
        .back-btn {
            color: #003a70;
            font-size: 22px;
            text-decoration: none;
        }
        .progress-line-container {
            display: flex;
            gap: 6px;
            flex-grow: 1;
            margin: 0 20px;
        }
        .progress-line-container .line {
            height: 6px;
            flex-grow: 1;
            background: #e0e0e0;
            border-radius: 3px;
        }
        .progress-line-container .line.green {
            background: #28a745;
        }
        .progress-line-container .line.red {
            background: #e31e24;
        }
        .step-counter-text {
            font-size: 14px;
            font-weight: 700;
            color: #e31e24;
            white-space: nowrap;
        }

        .shop-title {
            font-size: 28px;
            font-weight: 800;
            color: #1a1a1a;
            padding: 0 20px;
            margin-top: 20px;
            margin-bottom: 8px;
            text-align: right;
        }
        .shop-subtitle {
            font-size: 16px;
            color: #666;
            padding: 0 20px;
            margin-bottom: 30px;
            text-align: right;
        }

        .urdu-notice-box {
            background-color: #fffafa;
            border: 1px solid #ffcccc;
            border-radius: 15px;
            padding: 25px;
            margin: 0 20px 30px;
            direction: rtl;
            text-align: right;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 2;
            font-size: 18px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(227, 30, 36, 0.05);
        }
        .urdu-notice-box p {
            margin: 0;
            text-align: right;
        }

        .section-container {
            padding: 0 20px;
            margin-top: 30px;
        }
        .section-label {
            display: block;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #333;
            text-align: right;
        }

        .method-toggle {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
        }
        .method-btn {
            flex: 1;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 12px;
            background: #fff;
            text-align: center;
            font-size: 16px;
            font-weight: 700;
            color: #333;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .method-btn.active {
            border-color: #004aad;
            color: #004aad;
            border-width: 2px;
        }

        .wallet-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .wallet-card {
            border: 1px solid #eee;
            border-radius: 15px;
            padding: 25px 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
            cursor: pointer;
            position: relative;
            background: #fff;
        }
        .wallet-card.active {
            border-color: #c00000;
            border-width: 2px;
            background: #fffafb;
        }
        .wallet-card.disabled {
            opacity: 0.7;
            cursor: not-allowed;
            background: #fcfcfc;
        }
        .active-dot-check {
            position: absolute;
            top: -10px;
            right: 50%;
            transform: translateX(50%);
            width: 24px;
            height: 24px;
            background: #c00000;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 12px;
            z-index: 2;
        }
        .wallet-card .radio-check {
            width: 20px;
            height: 20px;
            border: 1px solid #ddd;
            border-radius: 50%;
            margin-bottom: 5px;
        }
        .wallet-card.active .radio-check {
            display: none;
        }

        .wallet-card img {
            height: 40px;
            max-width: 100%;
            object-fit: contain;
        }
        .wallet-card span {
            font-size: 15px;
            font-weight: 700;
            color: #333;
        }
        .coming-soon-tag {
            font-size: 9px;
            background: #eee;
            color: #888;
            padding: 2px 5px;
            border-radius: 4px;
            font-weight: 700;
            margin-top: 5px;
            text-transform: uppercase;
        }

        .form-group {
            padding: 0 20px;
            margin-top: 35px;
        }
        .form-group label {
            display: block;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #333;
            text-align: right;
        }
        .form-control-alfa {
            width: 100%;
            padding: 15px 20px;
            border: 1px solid #ddd;
            border-radius: 12px;
            font-size: 16px;
            background: #fff;
            color: #333;
            text-align: right;
            direction: rtl;
        }

        .upload-area {
            margin: 35px 20px;
            border: 2px dashed #e31e24;
            border-radius: 20px;
            padding: 45px 25px;
            text-align: center;
            background: #fffafb;
            cursor: pointer;
        }
        .upload-icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #e1f5fe;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: #03a9f4;
            font-size: 30px;
        }
        .upload-title {
            display: block;
            font-size: 18px;
            font-weight: 800;
            color: #c00000;
            margin-bottom: 10px;
        }
        .upload-subtitle {
            display: block;
            font-size: 14px;
            color: #999;
            line-height: 1.4;
            max-width: 350px;
            margin: 0 auto;
        }

        .policy-check {
            padding: 0 20px;
            margin-top: 30px;
            margin-bottom: 140px;
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-start;
            align-items: center;
            gap: 12px;
        }
        .policy-text {
            font-size: 14px;
            color: #333;
            font-weight: 600;
            text-align: right;
            margin: 0;
        }

        .footer-action {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 900px;
            padding: 25px 20px;
            background: #fff;
            border-top: 1px solid #eee;
            z-index: 1000;
        }
        .btn-footer-confirm {
            width: 100%;
            background: #3f51b5;
            color: #fff;
            padding: 18px;
            border-radius: 35px;
            font-weight: 700;
            font-size: 18px;
            text-align: center;
            border: none;
            display: block;
            text-decoration: none;
        }

        header {
            background: #fff;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f0f0f0;
        }
        .btn-track {
            background: #001f3f;
            color: #fff;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .contact-us-box {
            text-align: right;
        }
        .contact-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-decoration: none;
            font-size: 20px;
        }
        .bg-whatsapp { background-color: #25d366; }
        .bg-mail { background-color: #e31e24; }
        .contact-label { font-size: 12px; font-weight: 800; color: #333; display: block; text-align: right; margin-bottom: 4px; }
    </style>
</head>
<body>
    @php $appName = $settings->app_name ?? 'Alfa Mobiles'; @endphp

    <div class="loading-overlay" id="loadingOverlay">
        <div class="text-center">
            <div class="spinner-border text-light mb-2"></div>
            <div>Processing Order...</div>
        </div>
    </div>

    <div class="mobile-wrapper">
        <header>
            <div class="logo">
                <a href="{{ url('/') }}"><img src="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}" alt="{{ $appName }}" style="height: 50px;"></a>
            </div>
            <div class="header-right d-flex align-items-center gap-3">
                <a href="{{ route('track') }}" class="btn-track">
                    <i class="fas fa-truck-moving"></i> Track
                </a>
                <div class="contact-us-box">
                    <span class="contact-label">CONTACT US</span>
                    <div class="contact-icons d-flex gap-2">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->contact_number ?? '') }}" class="contact-circle bg-whatsapp"><i class="fab fa-whatsapp"></i></a>
                        <a href="mailto:{{ $settings->contact_email ?? 'info@alfamobiles.com' }}" class="contact-circle bg-mail" target="_blank"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </header>

        <div class="shop-content">
            <div class="step-indicator-wrapper">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="{{ url()->previous() }}" class="back-btn"><i class="fas fa-arrow-left"></i></a>
                    <div class="progress-line-container">
                        <div class="line green"></div>
                        <div class="line green"></div>
                        <div class="line green"></div>
                        <div class="line red"></div>
                        <div class="line"></div>
                    </div>
                    <div class="step-counter-text">04/05 — Payment Agreement</div>
                </div>
            </div>

            <h1 class="shop-title">Payment Agreement</h1>
            <p class="shop-subtitle">Put details for just agreement, don't send money.</p>

            <div class="urdu-notice-box">
                <p>
                    محترم کسٹمر! اس مرحلہ پر ادائیگی درکار نہیں تھی، اس لئے اگر آپ نے غلطی سے رقم منتقل کر دی ہے تو ہمیں اس پر افسوس ہے۔ برائے کرم درج ذیل معلومات ارسال کریں تاکہ تصدیق کے بعد آپ کی رقم واپس کی جا سکے۔ تمام معلومات کی تصدیق کے بعد آپ کی رقم جلد از جلد اسی اکاؤنٹ میں واپس کر دی جائے گی۔ شکریہ۔
                </p>
            </div>

            <form id="orderForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="payment_method" id="payment_method" value="Digital Wallet">
                <input type="hidden" name="wallet_service" id="wallet_service" value="Easypaisa">

                <div class="section-container">
                    <span class="section-label">Select Payment Method</span>
                    <div class="method-toggle">
                        <div class="method-btn" onclick="selectMethod('Card', this)">
                            <i class="fas fa-credit-card" style="color: #ff5722;"></i> Card
                        </div>
                        <div class="method-btn active" onclick="selectMethod('Digital Wallet', this)">
                            <i class="fas fa-wallet" style="color: #03a9f4;"></i> Digital Wallet
                        </div>
                    </div>
                </div>

                <div id="walletSection" class="section-container">
                    <span class="section-label">Select Mobile Wallet Service</span>
                    <div class="wallet-grid">
                        <div class="wallet-card active" onclick="selectWallet('Easypaisa', this)">
                            <div class="active-dot-check"><i class="fas fa-check"></i></div>
                            <img src="{{ asset('img/logo_payment/easypaisa.webp') }}" alt="Easypaisa">
                            <span>Easypaisa</span>
                        </div>
                        <div class="wallet-card" onclick="selectWallet('Upaisa', this)">
                            <div class="radio-check"></div>
                            <img src="{{ asset('img/logo_payment/upaisa.png') }}" alt="Upaisa">
                            <span>Upaisa</span>
                        </div>
                        <div class="wallet-card" onclick="selectWallet('UBL', this)">
                            <div class="radio-check"></div>
                            <img src="{{ asset('img/logo_payment/ubl.jfif') }}" alt="UBL" onerror="this.src='{{ asset('img/logo_payment/upaisa.png') }}'">
                            <span>UBL</span>
                        </div>
                        <div class="wallet-card" onclick="selectWallet('Alfalah', this)">
                            <div class="radio-check"></div>
                            <img src="{{ asset('img/logo_payment/bankalfalah.png') }}" alt="Alfalah">
                            <span>Alfalah</span>
                        </div>

                        <!-- Coming Soon Banks -->
                        <div class="wallet-card disabled">
                            <i class="fas fa-university" style="font-size: 24px; color: #ccc;"></i>
                            <span>Bank Al Islami</span>
                            <div class="coming-soon-tag">Coming Soon</div>
                        </div>
                        <div class="wallet-card disabled">
                            <i class="fas fa-university" style="font-size: 24px; color: #ccc;"></i>
                            <span>United Bank</span>
                            <div class="coming-soon-tag">Coming Soon</div>
                        </div>
                        <div class="wallet-card disabled">
                            <i class="fas fa-university" style="font-size: 24px; color: #ccc;"></i>
                            <span>Allied Bank</span>
                            <div class="coming-soon-tag">Coming Soon</div>
                        </div>
                        <div class="wallet-card disabled">
                            <i class="fas fa-university" style="font-size: 24px; color: #ccc;"></i>
                            <span>Faisal Bank</span>
                            <div class="coming-soon-tag">Coming Soon</div>
                        </div>
                        <div class="wallet-card disabled">
                            <i class="fas fa-university" style="font-size: 24px; color: #ccc;"></i>
                            <span>Meezan Bank</span>
                            <div class="coming-soon-tag">Coming Soon</div>
                        </div>
                        <div class="wallet-card disabled">
                            <i class="fas fa-university" style="font-size: 24px; color: #ccc;"></i>
                            <span>Askri Bank</span>
                            <div class="coming-soon-tag">Coming Soon</div>
                        </div>
                        <div class="wallet-card disabled">
                            <i class="fas fa-university" style="font-size: 24px; color: #ccc;"></i>
                            <span>Raqami Bank</span>
                            <div class="coming-soon-tag">Coming Soon</div>
                        </div>
                        <div class="wallet-card disabled">
                            <i class="fas fa-university" style="font-size: 24px; color: #ccc;"></i>
                            <span>MCB</span>
                            <div class="coming-soon-tag">Coming Soon</div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Account Holder Name</label>
                    <input type="text" name="account_holder" class="form-control-alfa" placeholder="Enter Account Holder Name" required>
                </div>

                <div class="upload-area" onclick="document.getElementById('proof_image').click()">
                    <input type="file" name="proof_image" id="proof_image" class="d-none" accept="image/*" onchange="updateUploadPreview(this)">
                    <div id="uploadPreview">
                        <div class="upload-icon-circle">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <span class="upload-title">Attach Proof of Payment</span>
                        <span class="upload-subtitle" id="uploadText">Show balance screenshot of given number with verification of our agent</span>
                    </div>
                </div>

                <div class="policy-check">
                    <input type="checkbox" id="policy" class="form-check-input" required>
                    <label for="policy" class="policy-text">I Agree the terms and conditions of {{ $appName }} policy.</label>
                </div>
            </form>
        </div>

        <div class="footer-action">
            <button type="button" class="btn-footer-confirm" onclick="submitOrder()">
                Confirm Order →
            </button>
        </div>
    </div>

    <script>
        function selectMethod(method, el) {
            document.querySelectorAll('.method-btn').forEach(b => b.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('payment_method').value = method;
            document.getElementById('walletSection').style.display = method === 'Digital Wallet' ? 'block' : 'none';
        }

        function selectWallet(wallet, el) {
            if (el.classList.contains('disabled')) return;
            document.querySelectorAll('.wallet-card').forEach(c => {
                c.classList.remove('active');
                const check = c.querySelector('.active-dot-check');
                if (check) check.remove();
                if (!c.querySelector('.radio-check') && !c.classList.contains('disabled')) {
                    c.insertAdjacentHTML('afterbegin', '<div class="radio-check"></div>');
                }
            });
            el.classList.add('active');
            const radio = el.querySelector('.radio-check');
            if (radio) radio.remove();
            el.insertAdjacentHTML('afterbegin', '<div class="active-dot-check"><i class="fas fa-check"></i></div>');
            document.getElementById('wallet_service').value = wallet;
        }

        function updateUploadPreview(input) {
            if (input.files && input.files[0]) {
                document.getElementById('uploadText').innerText = "Selected: " + input.files[0].name;
                document.getElementById('uploadText').style.color = "#28a745";
            }
        }

        async function submitOrder() {
            const form = document.getElementById('orderForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            document.getElementById('loadingOverlay').style.display = 'flex';

            const formData = new FormData(form);
            try {
                const response = await fetch("{{ route('order.submit') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: formData
                });

                const data = await response.json();
                if (data.success) {
                    window.location.href = "{{ route('track') }}?order_id=" + data.order_number;
                } else {
                    alert('Error: ' + (data.message || 'Something went wrong'));
                }
            } catch (error) {
                console.error(error);
                alert('An error occurred during submission.');
            } finally {
                document.getElementById('loadingOverlay').style.display = 'none';
            }
        }
    </script>
</body>
</html>
