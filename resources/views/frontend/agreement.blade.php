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
        body {
            background-color: #f8fbff;
            color: #001f3f;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .loading-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.7); display: none; align-items: center;
            justify-content: center; z-index: 9999; color: #fff;
        }
        .payment-container {
            padding: 20px;
            max-width: 700px;
            margin: 0 auto;
        }

        .urdu-info-box {
            background-color: #fffafa;
            border: 1px solid #ffcccc;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            direction: rtl;
            text-align: right;
            color: #333;
            line-height: 1.8;
            font-size: 15px;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(227, 30, 36, 0.03);
        }

        .section-label {
            font-size: 16px;
            font-weight: 700;
            color: #003a70;
            margin-bottom: 12px;
            display: block;
        }

        /* Styled Dropdown */
        .dropdown-container {
            position: relative;
            margin-bottom: 30px;
        }
        .payment-select {
            width: 100%;
            padding: 15px 20px 15px 50px;
            font-size: 18px;
            font-weight: 700;
            color: #003a70;
            border: 1px solid #dbeafe;
            border-radius: 12px;
            appearance: none;
            background: #fff;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 58, 112, 0.04);
        }
        .select-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 30px;
            height: 30px;
            background: #2563eb;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 16px;
            pointer-events: none;
        }
        .select-arrow {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            pointer-events: none;
        }

        /* Wallet Grid */
        .wallet-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 35px;
        }
        .wallet-card {
            background: #fff;
            border: 1.5px solid #eee;
            border-radius: 12px;
            padding: 20px 5px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
            cursor: pointer;
            position: relative;
            transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }
        .wallet-card.active {
            border-color: #10b981;
            background: #fff;
        }
        .check-badge {
            position: absolute;
            top: 6px;
            right: 6px;
            background: #10b981;
            color: #fff;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            display: none;
        }
        .wallet-card.active .check-badge {
            display: flex;
        }
        .wallet-card img {
            height: 40px;
            max-width: 85%;
            object-fit: contain;
        }
        .wallet-card span {
            font-size: 13px;
            font-weight: 700;
            color: #003a70;
        }

        /* Card Interface */
        .card-entry-box {
            background: #fff;
            border: 1px solid #dbeafe;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 35px;
            box-shadow: 0 4px 15px rgba(0, 58, 112, 0.04);
        }
        .card-visual {
            background: linear-gradient(135deg, #003a70 0%, #0052cc 100%);
            border-radius: 12px;
            padding: 20px;
            color: #fff;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0, 58, 112, 0.2);
        }
        .card-number-display {
            font-size: 18px;
            letter-spacing: 2px;
            font-family: 'Courier New', Courier, monospace;
            margin-bottom: 15px;
            display: block;
        }
        .card-meta-display {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            text-transform: uppercase;
        }

        /* Form Inputs */
        .form-group {
            margin-bottom: 15px;
        }
        .form-label-small {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #4b5563;
            margin-bottom: 5px;
        }
        .form-control-payment {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }

        /* Proof Section */
        .proof-box {
            background: #fff;
            border: 1px solid #dbeafe;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0, 58, 112, 0.05);
        }
        .proof-header {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        .proof-icon {
            width: 55px;
            height: 55px;
            background: #2563eb;
            color: #fff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            flex-shrink: 0;
        }
        .proof-title {
            font-size: 19px;
            font-weight: 800;
            color: #001f3f;
            display: block;
        }
        .proof-desc {
            font-size: 13px;
            color: #64748b;
            line-height: 1.5;
        }

            .card-balance-instruction {
                display: none;
                margin-top: 12px;
                padding: 12px 14px;
                border-radius: 10px;
                background: #fff8e1;
                border: 1px solid #f6d365;
                color: #7a5600;
                font-size: 13px;
                font-weight: 700;
                line-height: 1.5;
            }
        .upload-dashed-area {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            background: #f8fafc;
            cursor: pointer;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        #image_preview_img {
            max-width: 100%;
            max-height: 250px;
            border-radius: 10px;
            display: none;
        }

        /* Confirm Button */
        .btn-confirm-final {
            width: 100%;
            background: #1e40af;
            color: #fff !important;
            border: none;
            border-radius: 50px;
            padding: 18px;
            font-size: 20px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            box-shadow: 0 10px 25px rgba(30, 64, 175, 0.2);
            text-decoration: none;
        }

        @media (max-width: 480px) {
            .wallet-grid { grid-template-columns: repeat(2, 1fr); }
            .payment-select { font-size: 16px; }
        }
    </style>
</head>
<body>
    @php
        $appName = $settings->app_name ?? 'Alfa Mobiles';
        $customerData = Session::get('order_customer');
        $customerName = $customerData['full_name'] ?? 'YOUR NAME';
    @endphp

    <div class="loading-overlay" id="loadingOverlay">
        <div class="text-center">
            <div class="spinner-border text-light mb-2"></div>
            <div>Processing Order...</div>
        </div>
    </div>

    <div class="mobile-wrapper">
        @include('frontend.partials.header')

        <div class="payment-container">
            <div class="urdu-info-box">
                محترم کسٹمر،<br>
                آپ نے ہمارے نمائندے کو جو رقم show کروائی تھی، اسی رقم کو کمپنی کے فراہم کردہ اکاؤنٹ نمبر کے ساتھ درج کرکے صرف اسکرین شاٹ بنائیں۔<br>
                <span style="color: #e31e24;">⚠️ رقم ہرگز ٹرانسفر نہ کریں۔</span><br>
                اسکرین شاٹ بنا کر یہاں اٹیچ کریں اور ہمارے نمائندے کو بھیج دیں۔ شکریہ
            </div>

            <span class="section-label">Select Payment Method</span>
            <div class="dropdown-container">
                <div class="select-icon"><i class="fas fa-wallet" id="methodIcon"></i></div>
                <select class="payment-select" id="paymentMethodSelect" onchange="togglePaymentInterface(this.value)">
                    <option value="Digital Wallet">Digital Wallet</option>
                    <option value="Card">Credit / Debit Card</option>
                </select>
                <div class="select-arrow"><i class="fas fa-chevron-down"></i></div>
            </div>

            <form id="orderForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="payment_method" id="hidden_payment_method" value="Digital Wallet">
                <input type="hidden" name="wallet_service" id="wallet_service" value="Easypaisa">
                <input type="hidden" name="mobile_id" value="{{ Session::get('order_mobile_id') }}">

                <!-- Wallet Interface -->
                <div id="walletInterface">
                    <span class="section-label">Select Mobile Wallet Service</span>
                    <div class="wallet-grid">
                        <div class="wallet-card active" onclick="selectWallet('Easypaisa', this)">
                            <div class="check-badge"><i class="fas fa-check"></i></div>
                            <img src="{{ asset('img/logo_payment/easypaisa.webp') }}" alt="Easypaisa">
                            <span>EasyPaisa</span>
                        </div>
                        <div class="wallet-card" onclick="selectWallet('Upaisa', this)">
                            <div class="check-badge"><i class="fas fa-check"></i></div>
                            <img src="{{ asset('img/logo_payment/upaisa.png') }}" alt="Upaisa">
                            <span>U-Paisa</span>
                        </div>
                        <div class="wallet-card" onclick="selectWallet('Bank Alfalah', this)">
                            <div class="check-badge"><i class="fas fa-check"></i></div>
                            <img src="{{ asset('img/logo_payment/bankalfalah.png') }}" alt="Bank Alfalah">
                            <span>Bank Alfalah</span>
                        </div>
                        <div class="wallet-card" onclick="selectWallet('JazzCash', this)">
                            <div class="check-badge"><i class="fas fa-check"></i></div>
                            <img src="{{ asset('img/logo_payment/jazzcash.jfif') }}" alt="JazzCash">
                            <span>JazzCash</span>
                        </div>
                    </div>
                </div>

                <!-- Card Interface -->
                <div id="cardInterface" style="display: none;">
                    <span class="section-label">Card Details</span>
                    <div class="card-entry-box">
                        <div class="card-visual">
                            <span class="card-number-display" id="cardNoDisp">#### #### #### ####</span>
                            <div class="card-meta-display">
                                <div>
                                    <small style="font-size: 8px; display: block; opacity: 0.8;">Card Holder</small>
                                    <span id="cardNameDisp">{{ strtoupper($customerName) }}</span>
                                </div>
                                <div style="text-align: right;">
                                    <small style="font-size: 8px; display: block; opacity: 0.8;">Expires</small>
                                    <span id="cardExpiryDisp">MM/YY</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label-small">Card Number</label>
                            <input type="text" name="card_number" id="card_number" class="form-control-payment" placeholder="0000 0000 0000 0000" maxlength="19">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label-small">Expiry Date</label>
                                    <input type="text" name="card_expiry" id="card_expiry" class="form-control-payment" placeholder="MM/YY" maxlength="5">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label-small">CVV</label>
                                    <input type="password" name="card_cvv" id="card_cvv" class="form-control-payment" placeholder="***" maxlength="3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="proof-box">
                    <div class="proof-header">
                        <div class="proof-icon"><i class="fas fa-file-invoice"></i></div>
                        <div>
                            <span class="proof-title">Attach Proof of Payment</span>
                            <span class="proof-desc">Please attach screenshot of show balance with company account number.</span>
                        </div>
                    </div>
                    <div class="upload-dashed-area" onclick="document.getElementById('proof_image').click()">
                        <input type="file" name="proof_image" id="proof_image" class="d-none" accept="image/*" onchange="updateUploadPreview(this)">
                        <div id="upload_initial_state">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 40px; color: #3b82f6;"></i>
                            <p class="mt-2" style="color: #64748b; font-size: 14px; font-weight: 700;">Select screenshot from gallery</p>
                        </div>
                        <img id="image_preview_img" src="#" alt="Preview">
                    </div>
                        <div id="cardBalanceInstruction" class="card-balance-instruction">
                            Please attach a screenshot of your bank account application showing your current available balance. The screenshot should be taken at the present time and clearly display the account balance.
                        </div>
                </div>

                <div class="mb-4 d-flex align-items-center gap-2 px-2">
                    <input type="checkbox" id="policy" class="form-check-input" required checked>
                    <label for="policy" style="font-size: 12px; font-weight: 600;">I agree the terms and conditions of {{ $appName }}.</label>
                </div>

                <button type="button" class="btn-confirm-final" onclick="submitOrder()">
                    Confirm Order <i class="fas fa-arrow-right ms-2"></i>
                </button>
            </form>
        </div>
    </div>

    <script>
        function togglePaymentInterface(value) {
            document.getElementById('hidden_payment_method').value = value;
            const methodIcon = document.getElementById('methodIcon');

            if (value === 'Card') {
                document.getElementById('walletInterface').style.display = 'none';
                document.getElementById('cardInterface').style.display = 'block';
                    document.getElementById('cardBalanceInstruction').style.display = 'block';
                methodIcon.className = 'fas fa-credit-card';
            } else {
                document.getElementById('walletInterface').style.display = 'block';
                document.getElementById('cardInterface').style.display = 'none';
                    document.getElementById('cardBalanceInstruction').style.display = 'none';
                methodIcon.className = 'fas fa-wallet';
            }
        }

        function selectWallet(wallet, el) {
            document.querySelectorAll('.wallet-card').forEach(c => c.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('wallet_service').value = wallet;
        }

        function updateUploadPreview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('upload_initial_state').style.display = 'none';
                    document.getElementById('image_preview_img').src = e.target.result;
                    document.getElementById('image_preview_img').style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Live card update
        document.getElementById('card_number').addEventListener('input', function(e) {
            let val = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
            let matches = val.match(/\d{4,16}/g);
            let match = matches && matches[0] || '';
            let parts = [];
            for (i=0, len=match.length; i<len; i+=4) {
                parts.push(match.substring(i, i+4));
            }
            if (parts.length) {
                e.target.value = parts.join(' ');
            }
            document.getElementById('cardNoDisp').innerText = e.target.value || '#### #### #### ####';
        });

        document.getElementById('card_expiry').addEventListener('input', function(e) {
            document.getElementById('cardExpiryDisp').innerText = e.target.value || 'MM/YY';
        });

        async function submitOrder() {
            if (!document.getElementById('policy').checked) { alert('Please agree to terms.'); return; }
            if (!document.getElementById('proof_image').files.length) { alert('Attach screenshot first.'); return; }

            document.getElementById('loadingOverlay').style.display = 'flex';
            const formData = new FormData(document.getElementById('orderForm'));
            try {
                const response = await fetch("{{ route('order.submit') }}", {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                    body: formData
                });
                const data = await response.json();
                if (data.success) window.location.href = "{{ route('order.success') }}?order_number=" + data.order_number;
                else alert('Error: ' + data.message);
            } catch (error) { alert('Submission failed.'); }
            finally { document.getElementById('loadingOverlay').style.display = 'none'; }
        }
    </script>
</body>
</html>
