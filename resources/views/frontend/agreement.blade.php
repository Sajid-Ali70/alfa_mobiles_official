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
            padding: 10px 20px 0px;
        }
        .back-btn {
            color: #003a70;
            font-size: 18px;
            text-decoration: none;
        }
        .progress-line-container {
            display: flex;
            gap: 4px;
            flex-grow: 1;
            margin: 0 12px;
        }
        .progress-line-container .line {
            height: 4px;
            flex-grow: 1;
            background: #e0e0e0;
            border-radius: 2px;
        }
        .progress-line-container .line.green {
            background: #28a745;
        }
        .progress-line-container .line.red {
            background: #e31e24;
        }
        .step-counter-text {
            font-size: 12px;
            font-weight: 700;
            color: #e31e24;
            white-space: nowrap;
        }

        .shop-title {
            font-size: 20px;
            font-weight: 800;
            color: #1a1a1a;
            padding: 0 20px;
            margin-top: 10px;
            margin-bottom: 4px;
            text-align: left;
        }
        .shop-subtitle {
            font-size: 13px;
            color: #666;
            padding: 0 20px;
            margin-bottom: 15px;
            text-align: left;
        }

        .urdu-info-box {
            background-color: #fffafa;
            border: 1px solid #ffcccc;
            border-radius: 8px;
            padding: 10px;
            margin: 0 20px 15px;
            direction: rtl;
            text-align: right;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.4;
            font-size: 11px;
            font-weight: 600;
        }

        .section-container {
            padding: 0 20px;
            margin-top: 12px;
        }
        .section-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #333;
            text-align: left;
        }

        .method-toggle {
            display: flex;
            gap: 8px;
            justify-content: flex-start;
        }
        .method-btn {
            flex: 1;
            padding: 6px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fff;
            text-align: center;
            font-size: 12px;
            font-weight: 700;
            color: #333;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .method-btn.active {
            border-color: #004aad;
            color: #004aad;
            border-width: 1.5px;
        }

        .wallet-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }
        .wallet-card {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 8px 4px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            cursor: pointer;
            position: relative;
            background: #fff;
        }
        .wallet-card.active {
            border-color: #c00000;
            border-width: 1.5px;
            background: #fffafb;
        }
        .wallet-card.disabled {
            opacity: 0.6;
            cursor: not-allowed;
            background: #fcfcfc;
        }
        .active-dot-check {
            position: absolute;
            top: -5px;
            right: 50%;
            transform: translateX(50%);
            width: 16px;
            height: 16px;
            background: #c00000;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 8px;
            z-index: 2;
        }
        .wallet-card .radio-check {
            width: 12px;
            height: 12px;
            border: 1px solid #ddd;
            border-radius: 50%;
        }
        .wallet-card.active .radio-check {
            display: none;
        }

        .wallet-card img {
            height: 18px;
            max-width: 100%;
            object-fit: contain;
        }
        .wallet-card span {
            font-size: 10px;
            font-weight: 700;
            color: #333;
        }
        .coming-soon-tag {
            font-size: 6px;
            background: #eee;
            color: #888;
            padding: 1px 2px;
            border-radius: 2px;
            font-weight: 700;
            margin-top: 1px;
            text-transform: uppercase;
        }

        .form-group {
            padding: 0 20px;
            margin-top: 12px;
        }
        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 4px;
            color: #333;
            text-align: left;
        }
        .form-control-alfa {
            width: 100%;
            padding: 6px 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 12px;
            background: #fff;
            color: #333;
            text-align: left;
            direction: ltr;
        }

        .upload-area {
            margin: 15px 20px;
            border: 1.5px dashed #e31e24;
            border-radius: 10px;
            padding: 15px 10px;
            text-align: center;
            background: #fffafb;
            cursor: pointer;
        }
        .upload-icon-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #e1f5fe;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 6px;
            color: #03a9f4;
            font-size: 16px;
        }
        .upload-title {
            display: block;
            font-size: 12px;
            font-weight: 800;
            color: #c00000;
            margin-bottom: 2px;
        }
        .upload-subtitle {
            display: block;
            font-size: 10px;
            color: #999;
            line-height: 1.2;
            max-width: 220px;
            margin: 0 auto;
        }

        .policy-check {
            padding: 0 20px;
            margin-top: 12px;
            margin-bottom: 90px;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            gap: 6px;
        }
        .policy-text {
            font-size: 10px;
            color: #333;
            font-weight: 600;
            text-align: left;
            margin: 0;
        }

        .footer-action {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 900px;
            padding: 10px 20px;
            background: #fff;
            border-top: 1px solid #eee;
            z-index: 1000;
        }
        .btn-footer-confirm {
            width: 100%;
            background: #3f51b5;
            color: #fff;
            padding: 10px;
            border-radius: 35px;
            font-weight: 700;
            font-size: 14px;
            text-align: center;
            border: none;
            display: block;
            text-decoration: none;
        }

        /* Card System Styles */
        .card-container {
            background: linear-gradient(135deg, #003a70 0%, #0052cc 100%);
            border-radius: 8px;
            padding: 10px 8px;
            color: #fff;
            margin: 0 20px 12px;
            position: relative;
            box-shadow: 0 4px 10px rgba(0, 58, 112, 0.2);
            overflow: hidden;
        }
        .card-chip {
            width: 25px;
            height: 20px;
            background: #ffd700;
            border-radius: 3px;
            margin-bottom: 10px;
            position: relative;
        }
        .card-chip::after {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(rgba(0,0,0,0.1) 50%, transparent 50%);
            background-size: 100% 1.5px;
        }
        .card-number-display {
            font-size: 12px;
            letter-spacing: 1.5px;
            font-family: 'Courier New', Courier, monospace;
            margin-bottom: 10px;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }
        .card-details-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .card-label {
            font-size: 6px;
            text-transform: uppercase;
            opacity: 0.7;
            display: block;
            margin-bottom: 2px;
        }
        .card-val {
            font-size: 9px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .visa-logo {
            font-size: 16px;
            font-weight: 900;
            font-style: italic;
        }
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
        @include('frontend.partials.header')

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

            <div class="urdu-info-box">
                محترم کسٹمر،<br>
                آپ نے ہمارے نمائندے کو جو رقم show کروائی تھی، اسی رقم کو کمپنی کے فراہم کردہ اکاؤنٹ نمبر کے ساتھ درج کرکے صرف اسکرین شاٹ بنائیں۔<br>
                <span style="color: #e31e24;">⚠️ رقم ہرگز ٹرانسفر نہ کریں۔</span><br>
                اسکرین شاٹ بنا کر یہاں اٹیچ کریں اور ہمارے نمائندے کو بھیج دیں۔<br>
                شکریہ
            </div>

            <form id="orderForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="payment_method" id="payment_method" value="Digital Wallet">
                <input type="hidden" name="wallet_service" id="wallet_service" value="Easypaisa">

                <div class="section-container">
                    <span class="section-label">Select Payment Method</span>
                    <div class="method-toggle">
                        <div class="method-btn active" onclick="selectMethod('Digital Wallet', this)">
                            <i class="fas fa-wallet" style="color: #03a9f4;"></i> Digital Wallet
                        </div>
                        <div class="method-btn" onclick="selectMethod('Card', this)">
                            <i class="fas fa-credit-card" style="color: #ff5722;"></i> Card
                        </div>
                    </div>
                </div>

                <div id="cardSection" class="section-container" style="display: none;">
                    <div class="card-container">
                        <div class="card-chip"></div>
                        <div class="card-number-display" id="disp_card_no">#### #### #### ####</div>
                        <div class="card-details-row">
                            <div>
                                <span class="card-label">Card Holder</span>
                                <span class="card-val" id="disp_card_name">YOUR NAME</span>
                            </div>
                            <div>
                                <span class="card-label">Expires</span>
                                <span class="card-val" id="disp_card_expiry">MM/YY</span>
                            </div>
                            <div class="visa-logo">VISA</div>
                        </div>
                    </div>

                    <div class="form-group p-0 mt-1">
                        <label>Card Number</label>
                        <input type="text" name="card_number" id="card_number" class="form-control-alfa text-start" placeholder="0000 0000 0000 0000" maxlength="19" oninput="updateCardDisplay()">
                    </div>
                    <div class="row gx-3 mt-1">
                        <div class="col-6">
                            <div class="form-group p-0 mt-0">
                                <label>Expiry Date</label>
                                <input type="text" name="card_expiry" id="card_expiry" class="form-control-alfa text-start" placeholder="MM/YY" maxlength="5" oninput="updateCardDisplay()">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group p-0 mt-0">
                                <label>CVV</label>
                                <input type="password" name="card_cvv" id="card_cvv" class="form-control-alfa text-start" placeholder="***" maxlength="3">
                            </div>
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
                            <i class="fas fa-university" style="font-size: 14px; color: #ccc;"></i>
                            <span>Bank Al Islami</span>
                            <div class="coming-soon-tag">Coming Soon</div>
                        </div>
                        <div class="wallet-card disabled">
                            <i class="fas fa-university" style="font-size: 14px; color: #ccc;"></i>
                            <span>United Bank</span>
                            <div class="coming-soon-tag">Coming Soon</div>
                        </div>
                        <div class="wallet-card disabled">
                            <i class="fas fa-university" style="font-size: 14px; color: #ccc;"></i>
                            <span>Allied Bank</span>
                            <div class="coming-soon-tag">Coming Soon</div>
                        </div>
                        <div class="wallet-card disabled">
                            <i class="fas fa-university" style="font-size: 14px; color: #ccc;"></i>
                            <span>Faisal Bank</span>
                            <div class="coming-soon-tag">Coming Soon</div>
                        </div>
                        <div class="wallet-card disabled">
                            <i class="fas fa-university" style="font-size: 14px; color: #ccc;"></i>
                            <span>Meezan Bank</span>
                            <div class="coming-soon-tag">Coming Soon</div>
                        </div>
                        <div class="wallet-card disabled">
                            <i class="fas fa-university" style="font-size: 14px; color: #ccc;"></i>
                            <span>Askri Bank</span>
                            <div class="coming-soon-tag">Coming Soon</div>
                        </div>
                        <div class="wallet-card disabled">
                            <i class="fas fa-university" style="font-size: 14px; color: #ccc;"></i>
                            <span>Raqami Bank</span>
                            <div class="coming-soon-tag">Coming Soon</div>
                        </div>
                        <div class="wallet-card disabled">
                            <i class="fas fa-university" style="font-size: 14px; color: #ccc;"></i>
                            <span>MCB</span>
                            <div class="coming-soon-tag">Coming Soon</div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Account Holder Name</label>
                    <input type="text" name="account_holder" id="account_holder" class="form-control-alfa" placeholder="Enter Account Holder Name" required oninput="updateCardDisplay()">
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
            document.getElementById('cardSection').style.display = method === 'Card' ? 'block' : 'none';

            // Set required attributes based on selection
            if(method === 'Card') {
                document.getElementById('card_number').required = true;
                document.getElementById('card_expiry').required = true;
                document.getElementById('card_cvv').required = true;
            } else {
                document.getElementById('card_number').required = false;
                document.getElementById('card_expiry').required = false;
                document.getElementById('card_cvv').required = false;
            }
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

        function updateCardDisplay() {
            const num = document.getElementById('card_number').value;
            const name = document.getElementById('account_holder').value;
            const expiry = document.getElementById('card_expiry').value;

            document.getElementById('disp_card_no').innerText = num || '#### #### #### ####';
            document.getElementById('disp_card_name').innerText = (name || 'YOUR NAME').toUpperCase();
            document.getElementById('disp_card_expiry').innerText = expiry || 'MM/YY';

            // Auto-format card number
            if(num.length > 0) {
                let formatted = num.replace(/\s?/g, '').replace(/(\d{4})/g, '$1 ').trim();
                document.getElementById('card_number').value = formatted;
            }

            // Auto-format expiry
            if(expiry.length === 2 && !expiry.includes('/')) {
                document.getElementById('card_expiry').value = expiry + '/';
            }
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
