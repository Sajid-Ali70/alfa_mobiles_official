<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Information - {{ $settings->app_name ?? 'Alfa Mobiles' }}</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @php
        $appName = $settings->app_name ?? 'Alfa Mobiles';
    @endphp

    <div class="mobile-wrapper">
        <!-- Header -->
        <header>
            <div class="logo">
                <a href="{{ url('/') }}">
                    <img src="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}" alt="{{ $appName }}">
                </a>
            </div>
            <div class="header-right">
                <a href="{{ route('track') }}" class="btn-track">
                    <i class="fas fa-truck-moving"></i> Track
                </a>
                <div class="contact-icons">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->contact_number ?? '') }}" class="contact-circle bg-whatsapp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="mailto:{{ $settings->contact_email ?? 'info@alfamobiles.com' }}" class="contact-circle bg-mail">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </div>
        </header>

        <div class="shop-content">
            <!-- Step Indicator -->
            <div class="step-indicator-wrapper">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <a href="{{ route('plan') }}" class="back-btn"><i class="fas fa-arrow-left"></i></a>
                    <div class="progress-line-container">
                        <div class="line active"></div>
                        <div class="line active"></div>
                        <div class="line active"></div>
                        <div class="line current"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </div>
                    <div class="step-counter-text">03/03 — Customer info</div>
                </div>
            </div>

            <h1 class="shop-title">Customer Information</h1>
            <p class="shop-subtitle">Provide your delivery details and choose your payment preference.</p>

            <form id="customerForm" action="{{ route('agreement') }}" method="GET">
                <input type="hidden" name="delivery_type" id="selectedDelivery" value="Open Parcel via TCS Rider (Recommended)">

                <!-- Full Name -->
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="full_name" class="form-control-alfa" placeholder="e.g. Muhammad Ali Shah" required>
                </div>

                <!-- CNIC -->
                <div class="form-group">
                    <label>CNIC *</label>
                    <input type="text" name="cnic" class="form-control-alfa" placeholder="XXXXX-XXXXXXX-X" required>
                </div>

                <!-- Mobile Number -->
                <div class="form-group">
                    <label>Mobile Number * (WhatsApp active)</label>
                    <input type="text" name="mobile_number" class="form-control-alfa" placeholder="XXXXX-XXXXXXX" required>
                </div>

                <!-- Delivery Address -->
                <div class="form-group">
                    <label>Delivery Address *</label>
                    <textarea name="address" class="form-control-alfa" rows="3" placeholder="House #, Street, Sector / Area, City (e.g. Gulberg III, Lahore)" required></textarea>
                </div>

                <!-- Delivery Type -->
                <div class="section-container">
                    <span class="section-label">Delivery Type</span>
                    <div class="choice-box-list">
                        <div class="choice-box active" onclick="selectDelivery('Open Parcel via TCS Rider (Recommended)', this)">
                            <div class="radio-circle"></div>
                            <i class="fas fa-box-open choice-icon"></i>
                            <div class="choice-text-wrap">
                                <span class="choice-title">Open Parcel via TCS Rider (Recommended)</span>
                                <span class="choice-desc">Open parcel and verify phone condition in front of TCS rider before completing payment.</span>
                            </div>
                        </div>
                        <div class="choice-box" onclick="selectDelivery('Standard Courier Delivery', this)">
                            <div class="radio-circle"></div>
                            <div class="choice-text-wrap">
                                <span class="choice-title">Standard Courier Delivery</span>
                                <span class="choice-desc">Direct sealed package delivery via TCS standard dispatch.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Note Box -->
                <div class="note-box mb-4">
                    <i class="fas fa-shield-alt"></i>
                    <div class="note-text">
                        <span>No Advance Payment Required:</span> Your parcel is packed and dispatched under official guarantee. Payment/verification happens when the rider brings your package.
                    </div>
                </div>
            </form>
        </div>

        <!-- Footer Action -->
        <div class="footer-action">
            <button type="submit" form="customerForm" class="btn-shop-now border-0 w-100">
                Next → Proceed to Payment Agreement
            </button>
        </div>
    </div>

    <script>
        function selectDelivery(type, el) {
            document.querySelectorAll('.choice-box').forEach(b => b.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('selectedDelivery').value = type;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
