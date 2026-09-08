<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund Agreement - {{ $settings->app_name ?? 'Alfa Mobiles' }}</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .refund-agreement-header {
            padding: 20px 15px 10px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #002d72;
        }
        .refund-agreement-header i { font-size: 24px; color: #7030a0; }
        .refund-agreement-header h2 { font-size: 20px; font-weight: 800; margin: 0; }

        .urdu-info-box {
            background-color: #fffafa;
            border: 1px solid #ffcccc;
            border-radius: 15px;
            padding: 20px;
            margin: 0 15px 20px;
            direction: rtl;
            text-align: right;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.8;
            font-size: 14px;
            font-weight: 600;
        }

        .payment-method-section {
            padding: 0 15px 20px;
        }
        .payment-method-section label {
            display: block;
            font-size: 14px;
            font-weight: 800;
            margin-bottom: 15px;
            color: #333;
        }
        .method-choice {
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 12px 15px;
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .method-choice.active {
            border-color: #004aad;
            background-color: #f8fbff;
        }
        .method-choice.disabled {
            opacity: 0.6;
            cursor: not-allowed;
            background-color: #f9f9f9;
        }
        .checkbox-custom {
            width: 20px;
            height: 20px;
            border: 2px solid #ddd;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .method-choice.active .checkbox-custom {
            background-color: #004aad;
            border-color: #004aad;
        }
        .checkbox-custom i { color: #fff; font-size: 12px; display: none; }
        .method-choice.active .checkbox-custom i { display: block; }

        .method-img { height: 20px; width: 60px; object-fit: contain; }
        .method-name { font-size: 14px; font-weight: 700; color: #333; flex-grow: 1; }
        .coming-soon-badge {
            font-size: 10px;
            background: #eee;
            color: #777;
            padding: 2px 8px;
            border-radius: 10px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .upload-verification-box {
            background-color: #f6fff6;
            border: 1px solid #e0f2e0;
            border-radius: 15px;
            padding: 20px;
            margin: 0 15px 20px;
        }
        .upload-verification-box label {
            font-size: 13px;
            font-weight: 800;
            color: #333;
            margin-bottom: 15px;
            display: block;
            line-height: 1.4;
        }
        .upload-verification-box label span { color: #e31e24; }

        .drop-zone {
            border: 2px dashed #b5e7b5;
            border-radius: 12px;
            padding: 30px 20px;
            text-align: center;
            cursor: pointer;
            background: #fff;
        }
        .drop-zone i { font-size: 32px; color: #ccc; margin-bottom: 10px; }
        .drop-zone h4 { font-size: 15px; font-weight: 800; margin-bottom: 5px; color: #333; }
        .drop-zone p { font-size: 11px; color: #999; margin-bottom: 10px; font-weight: 600; }
        .drop-zone .file-info { font-size: 10px; color: #bbb; font-weight: 500; }

        .refund-note-box {
            background-color: #eef4ff;
            border-radius: 12px;
            padding: 12px 15px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0 15px 30px;
        }
        .refund-note-box i { color: #004aad; font-size: 18px; }
        .refund-note-box span { font-size: 11px; color: #004aad; font-weight: 700; line-height: 1.4; }

        .agreement-actions {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 15px;
            padding: 0 15px 40px;
        }
        .btn-back {
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
        .btn-submit-refund {
            background: #002d72;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 15px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .loading-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); display: none; align-items: center;
            justify-content: center; z-index: 9999; color: white;
            backdrop-filter: blur(3px);
        }

        @media (max-width: 480px) {
            .btn-track-main, .contact-label-main {
                display: none !important;
            }
            .contact-box-header {
                border: none !important;
                padding: 0 !important;
            }
        }
    </style>
</head>
<body>
    <div class="loading-overlay" id="loadingOverlay">
        <div class="text-center">
            <div class="spinner-border text-light mb-2"></div>
            <div>Submitting Refund Request...</div>
        </div>
    </div>

    <div class="mobile-wrapper">
        <!-- Reusable Header -->
        @include('frontend.partials.header')

        <div class="refund-agreement-header">
            <i class="fas fa-check-shield"></i>
            <h2>Refund Agreement</h2>
        </div>

        <div class="urdu-info-box">
            محترم کسٹمر جتنی اماؤنٹ آپ سے غلطی سے ٹرانسفر ہوئی ہے اتنی ہی رقم کا آپ کو دوبارہ دیے گئے اکاؤنٹ نمبر کے ساتھ سکرین شاٹ بنانا ہوگا لیکن یاد رہے کہ رقم ٹرانسفر ہرگز ہرگز نہ کریں۔<br>
            نوٹ: یہ سکرین شاٹ صرف اس لیے لیا جاتا ہے کہ کسٹمر پہلے کمپنی کے پورٹل پر رجسٹر ہوگا پھر رقم واپس ہوگی شکریہ
        </div>

        <form id="refundSubmitForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="payment_method" id="selected_method" value="EasyPaisa">

            <div class="payment-method-section">
                <label>Select Payment Method (For Refund Verification)</label>

                <div class="method-choice active" onclick="selectRefundMethod('EasyPaisa', this)">
                    <div class="checkbox-custom"><i class="fas fa-check"></i></div>
                    <img src="{{ asset('img/logo_payment/easypaisa.webp') }}" class="method-img" alt="EasyPaisa">
                    <span class="method-name">EasyPaisa</span>
                </div>

                <div class="method-choice" onclick="selectRefundMethod('U Paisa', this)">
                    <div class="checkbox-custom"><i class="fas fa-check"></i></div>
                    <img src="{{ asset('img/logo_payment/upaisa.png') }}" class="method-img" alt="U Paisa">
                    <span class="method-name">U Paisa</span>
                </div>

                <div class="method-choice" onclick="selectRefundMethod('UBL Bank', this)">
                    <div class="checkbox-custom"><i class="fas fa-check"></i></div>
                    <img src="{{ asset('img/logo_payment/ubl.jfif') }}" class="method-img" alt="UBL Bank">
                    <span class="method-name">UBL Bank</span>
                </div>

                <div class="method-choice" onclick="selectRefundMethod('Alfalah Bank', this)">
                    <div class="checkbox-custom"><i class="fas fa-check"></i></div>
                    <img src="{{ asset('img/logo_payment/bankalfalah.png') }}" class="method-img" alt="Alfalah Bank">
                    <span class="method-name">Alfalah Bank</span>
                </div>

                <!-- Coming Soon Banks -->
                <div class="method-choice disabled">
                    <div class="checkbox-custom"></div>
                    <i class="fas fa-university text-secondary"></i>
                    <span class="method-name">Bank Al Islami</span>
                    <span class="coming-soon-badge">Coming Soon</span>
                </div>

                <div class="method-choice disabled">
                    <div class="checkbox-custom"></div>
                    <i class="fas fa-university text-secondary"></i>
                    <span class="method-name">United Bank</span>
                    <span class="coming-soon-badge">Coming Soon</span>
                </div>

                <div class="method-choice disabled">
                    <div class="checkbox-custom"></div>
                    <i class="fas fa-university text-secondary"></i>
                    <span class="method-name">Allied Bank</span>
                    <span class="coming-soon-badge">Coming Soon</span>
                </div>

                <div class="method-choice disabled">
                    <div class="checkbox-custom"></div>
                    <i class="fas fa-university text-secondary"></i>
                    <span class="method-name">Faisal Bank</span>
                    <span class="coming-soon-badge">Coming Soon</span>
                </div>

                <div class="method-choice disabled">
                    <div class="checkbox-custom"></div>
                    <i class="fas fa-university text-secondary"></i>
                    <span class="method-name">Meezan Bank</span>
                    <span class="coming-soon-badge">Coming Soon</span>
                </div>

                <div class="method-choice disabled">
                    <div class="checkbox-custom"></div>
                    <i class="fas fa-university text-secondary"></i>
                    <span class="method-name">Askri Bank</span>
                    <span class="coming-soon-badge">Coming Soon</span>
                </div>

                <div class="method-choice disabled">
                    <div class="checkbox-custom"></div>
                    <i class="fas fa-university text-secondary"></i>
                    <span class="method-name">Raqami Bank</span>
                    <span class="coming-soon-badge">Coming Soon</span>
                </div>

                <div class="method-choice disabled">
                    <div class="checkbox-custom"></div>
                    <i class="fas fa-university text-secondary"></i>
                    <span class="method-name">MCB</span>
                    <span class="coming-soon-badge">Coming Soon</span>
                </div>
            </div>

            <div class="upload-verification-box">
                <label>Upload Verification Screenshot Of Show Balance With Company Account Number Or Given Account Number By Agent. <span>*</span></label>

                <div class="drop-zone" onclick="document.getElementById('proof_image').click()">
                    <input type="file" name="proof_image" id="proof_image" class="d-none" accept="image/*" onchange="previewFile(this)">
                    <i class="fas fa-cloud-upload-alt" id="uploadIcon"></i>
                    <h4 id="uploadTitle">Browse Files</h4>
                    <p id="uploadSub">Drag and drop files here or click to browse</p>
                    <div class="file-info">JPG, PNG or PDF (Max. 5MB)</div>
                </div>
            </div>

            <div class="refund-note-box">
                <i class="fas fa-info-circle"></i>
                <span>Please don't send money to any account number, just upload a verification show balance screenshot and also send it to agent.</span>
            </div>

            <div class="agreement-actions">
                <a href="{{ route('refund') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <button type="button" class="btn-submit-refund" onclick="submitRefundForm()">
                    Submit Refund Request
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function selectRefundMethod(method, el) {
            if (el.classList.contains('disabled')) return;
            document.querySelectorAll('.method-choice').forEach(c => c.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('selected_method').value = method;
        }

        function previewFile(input) {
            if (input.files && input.files[0]) {
                document.getElementById('uploadTitle').innerText = input.files[0].name;
                document.getElementById('uploadSub').innerText = "File selected successfully";
                document.getElementById('uploadIcon').style.color = "#25d366";
            }
        }

        async function submitRefundForm() {
            const form = document.getElementById('refundSubmitForm');
            const fileInput = document.getElementById('proof_image');

            if (!fileInput.files || !fileInput.files[0]) {
                alert("Please upload the verification screenshot.");
                return;
            }

            document.getElementById('loadingOverlay').style.display = 'flex';

            const formData = new FormData(form);
            try {
                const response = await fetch("{{ route('refund.submit') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                });

                const data = await response.json();
                if (data.success) {
                    window.location.href = "{{ route('refund.success') }}?refund_id=" + data.refund_id;
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
