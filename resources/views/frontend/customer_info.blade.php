<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Information - {{ $settings->app_name ?? 'Alfa Mobiles' }}</title>
    <link rel="icon" type="image/png" href="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
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

        .shop-title {
            font-size: 28px;
            font-weight: 800;
            color: #1a1a1a;
            padding: 0 20px;
            margin-top: 15px;
            margin-bottom: 8px;
        }
        .shop-subtitle {
            font-size: 16px;
            color: #666;
            padding: 0 20px;
            margin-bottom: 30px;
        }

        .form-group {
            padding: 0 20px;
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #333;
        }
        .form-control-alfa {
            width: 100%;
            padding: 12px 18px;
            border: 1px solid #ddd;
            border-radius: 12px;
            font-size: 15px;
            background: #fff;
            color: #333;
        }
        .form-control-alfa::placeholder {
            color: #bbb;
        }
        .form-control-alfa:focus {
            outline: none;
            border-color: #e31e24;
        }

        .section-container {
            padding: 0 20px;
            margin-top: 30px;
        }
        .section-label {
            display: block;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #333;
        }

        .choice-box-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .choice-box {
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 15px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            cursor: pointer;
            position: relative;
            background: #fff;
            transition: all 0.2s;
        }
        .choice-box.active {
            border-color: #e31e24;
            background: #fffcfc;
        }
        .radio-circle {
            width: 20px;
            height: 20px;
            border: 2px solid #ddd;
            border-radius: 50%;
            flex-shrink: 0;
            margin-top: 2px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .choice-box.active .radio-circle {
            border-color: #e31e24;
        }
        .choice-box.active .radio-circle::after {
            content: '';
            width: 10px;
            height: 10px;
            background: #e31e24;
            border-radius: 50%;
        }

        .choice-text-wrap {
            display: flex;
            flex-direction: column;
            flex: 1;
        }
        .choice-title {
            font-size: 15px;
            font-weight: 700;
            color: #333;
        }
        .choice-desc {
            font-size: 13px;
            color: #777;
            margin-top: 2px;
            line-height: 1.4;
        }

        .note-box {
            margin: 30px 20px 140px;
            background: #fff9e6;
            border: 1px solid #ffeeba;
            border-radius: 12px;
            padding: 15px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }
        .note-box i {
            color: #856404;
            font-size: 18px;
            margin-top: 2px;
        }
        .note-text {
            font-size: 14px;
            color: #856404;
            line-height: 1.5;
        }

        .footer-action {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 900px;
            padding: 20px;
            background: #fff;
            border-top: 1px solid #eee;
            z-index: 1000;
        }
        .btn-footer-next {
            width: 100%;
            background: #e31e24;
            color: #fff;
            padding: 16px;
            border-radius: 35px;
            font-weight: 700;
            font-size: 17px;
            text-align: center;
            border: none;
            display: block;
        }
    </style>
</head>
<body>
    @php $appName = $settings->app_name ?? 'Alfa Mobiles'; @endphp

    <div class="mobile-wrapper">
        @include('frontend.partials.header')

        <div class="shop-content">
            <div class="step-indicator-wrapper">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="{{ url()->previous() }}" class="back-btn"><i class="fas fa-arrow-left"></i></a>
                    <div class="progress-line-container">
                        <div class="line completed"></div>
                        <div class="line completed"></div>
                        <div class="line active"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </div>
                    <div class="step-counter-text">02/05 — Customer info</div>
                </div>
            </div>

            <h1 class="shop-title">Customer Information</h1>
            <p class="shop-subtitle">Provide your delivery details and choose your payment preference.</p>

            <form id="customerForm" action="{{ route('agreement') }}" method="GET">
                <input type="hidden" name="delivery_type" id="selectedDelivery" value="Open Parcel via TCS Rider (Recommended)">
                <input type="hidden" name="payment_method_group" id="selectedMethodGroup" value="Digital Wallet">

                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="full_name" class="form-control-alfa" placeholder="e.g. Muhammad Ali Shah" required>
                </div>

                <div class="form-group">
                    <label>CNIC * (13 digits)</label>
                    <input type="text" name="cnic" class="form-control-alfa" placeholder="e.g. 4210112345678" required maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                </div>

                <div class="form-group">
                    <label>Mobile Number * (11 digits)</label>
                    <input type="text" name="mobile_number" class="form-control-alfa" placeholder="e.g. 03001234567" required maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                </div>

                <div class="form-group">
                    <label>Delivery Address *</label>
                    <textarea name="address" class="form-control-alfa" rows="3" placeholder="House #, Street, Sector / Area, City (e.g. Gulberg III, Lahore)" required></textarea>
                </div>

                <div class="section-container">
                    <span class="section-label">Delivery Type</span>
                    <div class="choice-box-list">
                        <div class="choice-box active" onclick="selectChoice(this, 'selectedDelivery', 'Open Parcel via TCS Rider (Recommended)')">
                            <div class="radio-circle"></div>
                            <div class="d-flex gap-3 w-100">
                                <i class="fas fa-box-open text-danger" style="font-size: 20px; margin-top: 2px;"></i>
                                <div class="choice-text-wrap">
                                    <span class="choice-title">Open Parcel via TCS Rider (Recommended)</span>
                                    <span class="choice-desc">Open parcel and verify phone condition in front of TCS rider.</span>
                                </div>
                            </div>
                        </div>
                        <div class="choice-box" onclick="selectChoice(this, 'selectedDelivery', 'Standard Courier Delivery')">
                            <div class="radio-circle"></div>
                            <div class="choice-text-wrap">
                                <span class="choice-title">Standard Courier Delivery</span>
                                <span class="choice-desc">Direct sealed package delivery via TCS dispatch.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-container">
                    <span class="section-label">Payment Method</span>
                    <div class="choice-box-list">
                        <div class="choice-box" onclick="selectChoice(this, 'selectedMethodGroup', 'Card')">
                            <div class="radio-circle"></div>
                            <div class="d-flex gap-3 w-100">
                                <i class="fas fa-credit-card" style="font-size: 20px; margin-top: 2px; color: #ff5722;"></i>
                                <div class="choice-text-wrap">
                                    <span class="choice-title">Card (0% EMI)</span>
                                    <span class="choice-desc">Visa / Mastercard bank installment support.</span>
                                </div>
                            </div>
                        </div>
                        <div class="choice-box active" onclick="selectChoice(this, 'selectedMethodGroup', 'Digital Wallet')">
                            <div class="radio-circle"></div>
                            <div class="d-flex gap-3 w-100">
                                <i class="fas fa-wallet" style="font-size: 20px; margin-top: 2px; color: #03a9f4;"></i>
                                <div class="choice-text-wrap">
                                    <span class="choice-title">Digital Wallet (Easypaisa / Upaisa / Alfalah)</span>
                                    <span class="choice-desc">Instant digital wallet verification.</span>
                                </div>
                            </div>
                        </div>
                        <div class="choice-box" onclick="selectChoice(this, 'selectedMethodGroup', 'Cash on Delivery')">
                            <div class="radio-circle"></div>
                            <div class="d-flex gap-3 w-100">
                                <i class="fas fa-money-bill-wave" style="font-size: 20px; margin-top: 2px; color: #4caf50;"></i>
                                <div class="choice-text-wrap">
                                    <span class="choice-title">Full Payment via Cash on Delivery</span>
                                    <span class="choice-desc">Pay full cash after opening parcel.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="note-box">
                    <i class="fas fa-shield-alt"></i>
                    <div class="note-text">
                        <span class="fw-bold">No Advance Payment Required:</span> Your parcel is packed and dispatched under official guarantee.
                    </div>
                </div>
            </form>
        </div>

        <div class="footer-action">
            <button type="submit" form="customerForm" class="btn-footer-next">
                Next → Proceed to Payment Agreement
            </button>
        </div>
    </div>

    <script>
        function selectChoice(el, hiddenId, value) {
            el.parentElement.querySelectorAll('.choice-box').forEach(b => b.classList.remove('active'));
            el.classList.add('active');
            document.getElementById(hiddenId).value = value;
        }
    </script>
</body>
</html>
