<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Agreement - {{ $settings->app_name ?? 'Alfa Mobiles' }}</title>
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

    <div class="loading-overlay" id="loadingOverlay">
        <div class="text-center">
            <div class="spinner-border text-light mb-2"></div>
            <div>Processing Order...</div>
        </div>
    </div>

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
                    <i class="fas fa-truck-moving"></i> <span>Track</span>
                </a>
                <div class="contact-icons">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->contact_number ?? '') }}" class="contact-circle bg-whatsapp" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="mailto:{{ $settings->contact_email ?? 'info@alfamobiles.com' }}" class="contact-circle bg-mail" target="_blank">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </div>
        </header>

        <div class="shop-content">
            <!-- Step Indicator -->
            <div class="step-indicator-wrapper">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <a href="{{ route('customer_info') }}" class="back-btn"><i class="fas fa-arrow-left"></i></a>
                    <div class="progress-line-container">
                        <div class="line active"></div>
                        <div class="line active"></div>
                        <div class="line active"></div>
                        <div class="line current"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </div>
                    <div class="step-counter-text">04/03 — Payment Agreement</div>
                </div>
            </div>

            <h1 class="shop-title">Payment Agreement</h1>
            <p class="shop-subtitle">Put details for just agreement, don't send money.</p>

            <form id="orderForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="payment_method" id="payment_method" value="Digital Wallet">
                <input type="hidden" name="wallet_service" id="wallet_service" value="Easypaisa">

                <!-- Select Payment Method -->
                <div class="section-container">
                    <span class="section-label">Select Payment Method</span>
                    <div class="method-toggle">
                        <div class="method-btn" onclick="selectMethod('Card', this)">
                            <i class="fas fa-credit-card"></i> Card
                        </div>
                        <div class="method-btn active" onclick="selectMethod('Digital Wallet', this)">
                            <i class="fas fa-wallet"></i> Digital Wallet
                        </div>
                    </div>
                </div>

                <!-- Select Mobile Wallet Service -->
                <div id="walletSection" class="section-container">
                    <span class="section-label">Select Mobile Wallet Service</span>
                    <div class="wallet-grid">
                        <div class="wallet-card active" onclick="selectWallet('Easypaisa', this)">
                            <div class="active-dot-check"><i class="fas fa-check"></i></div>
                            <img src="{{ asset('img/logo_payment/easypaisa.webp') }}" alt="Easypaisa">
                            <span>Easypaisa</span>
                        </div>
                        <div class="wallet-card" onclick="selectWallet('Upaisa', this)">
                            <img src="{{ asset('img/logo_payment/upaisa.png') }}" alt="Upaisa">
                            <span>Upaisa</span>
                        </div>
                        <div class="wallet-card" onclick="selectWallet('JazzCash', this)">
                            <img src="{{ asset('img/logo_payment/jazzcash.jfif') }}" alt="JazzCash" onerror="this.src='{{ asset('img/logo_payment/upaisa.png') }}'">
                            <span>JazzCash</span>
                        </div>
                        <div class="wallet-card" onclick="selectWallet('Alfalah', this)">
                            <img src="{{ asset('img/logo_payment/bankalfalah.png') }}" alt="Alfalah">
                            <span>Alfalah</span>
                        </div>
                    </div>
                </div>

                <!-- Account Holder Name -->
                <div class="form-group">
                    <label>Account Holder Name</label>
                    <input type="text" name="account_holder" class="form-control-alfa" placeholder="Enter Account Holder Name" required>
                </div>

                <!-- Upload Box -->
                <div class="upload-area" onclick="document.getElementById('proof_image').click()">
                    <input type="file" name="proof_image" id="proof_image" class="d-none" accept="image/*" onchange="updateUploadPreview(this)">
                    <div id="uploadPreview" class="w-100 h-100">
                        <div class="upload-icon-circle">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <span class="upload-title">Attach Proof of Payment</span>
                        <span class="upload-subtitle" id="uploadText">Show balance screenshot of given number with verification of our agent</span>
                    </div>
                </div>

                <!-- Policy Checkbox -->
                <div class="policy-check">
                    <input type="checkbox" id="policy" class="form-check-input" required>
                    <label for="policy" class="policy-text">I Agree the terms and conditions of {{ $appName }} policy.</label>
                </div>
            </form>
        </div>

        <!-- Footer Action -->
        <div class="footer-action">
            <button type="button" class="btn-confirm-order w-100 border-0" onclick="submitOrder()">
                Confirm Order —>
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function selectMethod(method, el) {
            document.querySelectorAll('.method-btn').forEach(b => b.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('payment_method').value = method;

            const walletSection = document.getElementById('walletSection');
            if (method === 'Digital Wallet') {
                walletSection.style.display = 'block';
            } else {
                walletSection.style.display = 'none';
            }
        }

        function selectWallet(wallet, el) {
            document.querySelectorAll('.wallet-card').forEach(c => {
                c.classList.remove('active');
                const check = c.querySelector('.active-dot-check');
                if (check) check.remove();
            });
            el.classList.add('active');
            el.insertAdjacentHTML('afterbegin', '<div class="active-dot-check"><i class="fas fa-check"></i></div>');
            document.getElementById('wallet_service').value = wallet;
        }

        function updateUploadPreview(input) {
            if (input.files && input.files[0]) {
                document.getElementById('uploadText').innerText = "Selected: " + input.files[0].name;
                document.getElementById('uploadText').classList.add('text-success');
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
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
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
