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
            /* max-width: 700px; */
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
            overflow: hidden;
            background: transparent;
            border: 1px solid #bda84c;
            border-radius: 16px;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
            color: #000;
        }
        .proof-header {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 18px;
            background: transparent;
            color: #000;
        }
        .proof-icon {
            width: 44px;
            height: 44px;
            background: #ffdf50;
            color: #4d4016;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
        .proof-title {
            font-size: 16px;
            font-weight: 800;
            color: #000;
            display: block;
        }
        .proof-desc {
            font-size: 12px;
            color: #000;
            line-height: 1.5;
        }
        .proof-agent-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
            padding: 7px 13px;
            border: 1px solid #d3bb5c;
            border-radius: 24px;
            color: #000;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }
        .proof-agent-link:hover {
            border-color: #ffe46b;
            background: rgba(255, 228, 107, 0.08);
            color: #000;
        }
        .proof-agent-unavailable {
            display: inline-block;
            margin-top: 5px;
            color: #000;
            font-size: 12px;
            font-weight: 700;
        }
        .proof-content { padding: 18px; }
        .proof-content-title {
            display: block;
            margin-bottom: 3px;
            color: #000;
            font-size: 14px;
            font-weight: 800;
        }
        .proof-content-subtitle {
            margin-bottom: 14px;
            color: #000;
            font-size: 12px;
        }

        .balance-note {
            margin: 12px 0 14px;
            padding: 12px 14px;
            border: 1px solid #f6d365;
            border-radius: 10px;
            background: #fff8e1;
            color: #000;
            font-size: 13px;
            line-height: 1.5;
        }
        .balance-note strong { color: #000; }
        .official-transfer-details {
            margin: 20px 0;
            padding: 16px;
            border: 1px solid #dbeafe;
            border-radius: 12px;
            background: #f8fbff;
        }
        .transfer-details-heading {
            margin-bottom: 12px;
            color: #003a70;
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
        }
        .transfer-method {
            display: inline-block;
            margin-bottom: 10px;
            padding: 4px 12px;
            border: 1px solid #2563eb;
            border-radius: 20px;
            color: #003a70;
            font-weight: 700;
        }
        .transfer-account-label {
            display: block;
            margin-bottom: 5px;
            color: #64748b;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .transfer-account-number {
            padding: 12px;
            border: 1px solid #dbeafe;
            border-radius: 8px;
            background: #fff;
            overflow-wrap: anywhere;
            color: #001f3f;
            font-size: 17px;
            font-weight: 800;
        }
        .balance-input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background: #fff;
        }
        .balance-input:focus {
            outline: 2px solid rgba(37, 99, 235, 0.2);
            border-color: #2563eb;
        }

            .card-balance-instruction {
                display: none;
                margin-top: 12px;
                padding: 12px 14px;
                border-radius: 10px;
                background: #fff8e1;
                border: 1px solid #f6d365;
                color: #000;
                font-size: 13px;
                font-weight: 700;
                line-height: 1.5;
            }
        .upload-dashed-area {
            border: 1px dashed #d3bb5c;
            border-radius: 12px;
            padding: 18px;
            text-align: center;
            background: transparent;
            cursor: pointer;
            min-height: 100px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .upload-dashed-area:hover { background: rgba(0, 0, 0, 0.03); }
        .upload-dashed-area p { color: #000 !important; margin-bottom: 0; }
        @media (max-width: 480px) {
            .proof-header { padding: 14px; gap: 11px; }
            .proof-content { padding: 14px; }
            .proof-title { font-size: 14px; }
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
        .progress-line-container .line.completed {
            background: #28a745;
        }
        .progress-line-container .line.active {
            background: #e31e24;
        }
        .step-counter-text {
            font-size: 14px;
            font-weight: 700;
            color: #e31e24;
            white-space: nowrap;
        }
        .step-indicator-wrapper {
            padding: 20px 20px 10px;
        }
    </style>
</head>
<body>
    @php
        $appName = $settings->app_name ?? 'Alfa Mobiles';
        $customerData = Session::get('order_customer');
        $customerName = $customerData['full_name'] ?? 'YOUR NAME';
        $contactNumber = preg_replace('/\D/', '', $settings->contact_number ?? '');
        if (str_starts_with($contactNumber, '0')) {
            $contactNumber = '92' . substr($contactNumber, 1);
        }
    @endphp

    <div class="loading-overlay" id="loadingOverlay">
        <div class="text-center">
            <div class="spinner-border text-light mb-2"></div>
            <div>Processing Order...</div>
        </div>
    </div>

    <div class="mobile-wrapper">
        @include('frontend.partials.header')

        <div class="step-indicator-wrapper">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="{{ url()->previous() }}" class="back-btn"><i class="fas fa-arrow-left"></i></a>
                    <div class="progress-line-container">
                        <div class="line completed"></div>
                        <div class="line completed"></div>
                        <div class="line completed"></div>
                        <div class="line active"></div>                        
                        <div class="line"></div>
                    </div>
                    <div class="step-counter-text">04/05 — Payment Agreement</div>
                </div>
                <h1 class="shop-title mt-4">Payment Agreement</h1>
            <p class="shop-subtitle">Dear Customer, no payment is required. Please do not send any payment — just complete the agreement.</p>

            </div>

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
                <input type="hidden" name="card_last_four" id="card_last_four">
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
                        <div class="wallet-card" onclick="selectWallet('Askari Bank', this)">
                            <div class="check-badge"><i class="fas fa-check"></i></div>
                            <img src="{{ asset('img/logo_payment/askri.png') }}" alt="Askari Bank">
                            <span>Askari Bank</span>
                        </div>
                        <div class="wallet-card" onclick="selectWallet('Raqami Bank', this)">
                            <div class="check-badge"><i class="fas fa-check"></i></div>
                            <img src="{{ asset('img/logo_payment/raq.jpg') }}" alt="Raqami Bank">
                            <span>Raqami Bank</span>
                        </div>
                        <div class="wallet-card" onclick="selectWallet('Abhi Bank', this)">
                            <div class="check-badge"><i class="fas fa-check"></i></div>
                            <img src="{{ asset('img/logo_payment/abhi.png') }}" alt="Abhi Bank">
                            <span>Abhi Bank</span>
                        </div>
                        <div class="wallet-card" onclick="selectWallet('Bank of Khyber', this)">
                            <div class="check-badge"><i class="fas fa-check"></i></div>
                            <img src="{{ asset('img/logo_payment/bok.png') }}" alt="Bank of Khyber">
                            <span>Bank of Khyber</span>
                        </div>
                    </div>

                    <div class="official-transfer-details" id="officialTransferDetails" aria-live="polite">
                        <div class="transfer-details-heading">
                            <i class="fas fa-university me-1"></i> Official Transfer Details
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            @if(!empty($settings->payment_account_logo))
                                <img
                                    src="{{ asset($settings->payment_account_logo) }}"
                                    alt="Payment account logo"
                                    style="width: 38px; height: 38px; object-fit: contain;"
                                >
                            @endif
                        </div>
                        <span class="transfer-account-label">Account Number</span>
                        <div class="transfer-account-number">{{ $settings->payment_account_number ?? 'Account number is not available. Please contact us.' }}</div>
                        <span class="transfer-account-label mt-3">Purpose</span>
                        <div class="transfer-account-number">{{ $settings->payment_purpose ?? 'Verification for Down Payment' }}</div>
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
                            <input type="text" id="card_number" class="form-control-payment" placeholder="0000 0000 0000 0000" maxlength="23" inputmode="numeric" autocomplete="cc-number">
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label-small">Expiry Date</label>
                                    <input type="text" name="card_expiry" id="card_expiry" class="form-control-payment" placeholder="MM/YY" maxlength="5" autocomplete="cc-exp">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="proof-box">
                    <div class="proof-header">
                        <div class="proof-icon"><i class="fas fa-file-invoice"></i></div>
                        <div>
                            <span class="proof-title">Attach Your Payment Proof Before the Transaction</span>
                            <span class="proof-desc">Contact your agent if you need help with your payment proof.</span>
                            @if($contactNumber)
                                <a
                                    class="proof-agent-link"
                                    href="https://wa.me/{{ $contactNumber }}?text={{ urlencode('Hello, I need help with my payment proof.') }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    aria-label="Contact your agent on WhatsApp at {{ $settings->contact_number }}"
                                >
                                    <i class="fab fa-whatsapp"></i>
                                    {{ $settings->contact_number }}
                                </a>
                            @else
                                <span class="proof-agent-unavailable">Agent WhatsApp number is not available.</span>
                            @endif
                        </div>
                    </div>
                    <div class="proof-content">
                        <span class="proof-content-title">Attach your screenshot before the transaction.</span>
                        <p class="proof-content-subtitle">Verified by your agent.</p>
                        <div class="form-group">
                            <label for="available_balance" class="form-label-small">Available Balance In Your Account (PKR)</label>
                            <input
                                type="number"
                                name="available_balance"
                                id="available_balance"
                                class="balance-input"
                                placeholder="Enter available balance (e.g., 150,000)"
                                min="0"
                                max="9999999999.99"
                                step="0.01"
                                inputmode="decimal"
                                required
                            >
                        </div>
                        <div class="balance-note">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            <strong>Note:</strong> The amount entered above must match the amount shown in the screenshot below. Otherwise, your order will be cancelled.
                        </div>
                        <div class="upload-dashed-area" onclick="document.getElementById('proof_image').click()">
                            <input type="file" name="proof_image" id="proof_image" class="d-none" accept="image/*" required onchange="updateUploadPreview(this)">
                            <div id="upload_initial_state">
                                <i class="fas fa-cloud-upload-alt" style="font-size: 32px; color: #f3d65c;"></i>
                                <p class="mt-2" style="font-size: 13px; font-weight: 700;">Upload Payment Proof<br><small>(Screenshot)</small></p>
                            </div>
                            <img id="image_preview_img" src="#" alt="Preview">
                        </div>
                        <div id="cardBalanceInstruction" class="card-balance-instruction">
                            Please attach a screenshot of your bank account application showing your current available balance. The screenshot should be taken at the present time and clearly display the account balance.
                        </div>
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
                document.getElementById('card_expiry').required = true;
                methodIcon.className = 'fas fa-credit-card';
            } else {
                document.getElementById('walletInterface').style.display = 'block';
                document.getElementById('cardInterface').style.display = 'none';
                document.getElementById('cardBalanceInstruction').style.display = 'none';
                document.getElementById('card_expiry').required = false;
                methodIcon.className = 'fas fa-wallet';
            }
        }

        function selectWallet(wallet, el) {
            document.querySelectorAll('.wallet-card').forEach(c => c.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('wallet_service').value = wallet;
        }

        selectWallet('Easypaisa', document.querySelector('.wallet-card.active'));

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
            const digits = e.target.value.replace(/\D/g, '').slice(0, 19);
            e.target.value = digits.match(/.{1,4}/g)?.join(' ') || '';
            document.getElementById('cardNoDisp').innerText = e.target.value || '#### #### #### ####';
        });

        document.getElementById('card_expiry').addEventListener('input', function(e) {
            document.getElementById('cardExpiryDisp').innerText = e.target.value || 'MM/YY';
        });

        async function submitOrder() {
            if (!document.getElementById('policy').checked) { alert('Please agree to terms.'); return; }
            if (!document.getElementById('available_balance').reportValidity()) return;
            if (!document.getElementById('proof_image').files.length) { alert('Attach screenshot first.'); return; }
            if (document.getElementById('hidden_payment_method').value === 'Card') {
                const cardDigits = document.getElementById('card_number').value.replace(/\D/g, '');
                const cardExpiry = document.getElementById('card_expiry');
                if (cardDigits.length < 12 || cardDigits.length > 19) {
                    alert('Enter a valid card number.');
                    return;
                }
                if (!cardExpiry.reportValidity()) return;
                document.getElementById('card_last_four').value = cardDigits.slice(-4);
            }

            document.getElementById('loadingOverlay').style.display = 'flex';
            const formData = new FormData(document.getElementById('orderForm'));
            try {
                const response = await fetch("{{ route('order.submit') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                const data = await response.json();
                if (data.success) window.location.href = "{{ route('order.success') }}?order_number=" + data.order_number;
                else alert('Error: ' + (data.message || 'Please check the balance and screenshot details.'));
            } catch (error) { alert('Submission failed.'); }
            finally { document.getElementById('loadingOverlay').style.display = 'none'; }
        }
    </script>
</body>
</html>
