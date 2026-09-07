<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installment Calculator - {{ $settings->app_name ?? 'Alfa Mobiles' }}</title>
    <link rel="icon" type="image/png" href="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .calc-content { padding: 40px 30px; flex-grow: 1; }
        .form-group { margin-bottom: 30px; }
        .form-group label {
            display: block;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #333;
        }
        .form-select-alfa {
            width: 100%;
            padding: 16px 20px;
            border: 1px solid #ddd;
            border-radius: 12px;
            font-size: 18px;
            color: #333;
            background-color: #fff;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 18px 14px;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);
        }

        .btn-calculate {
            width: 100%;
            padding: 22px;
            background-color: #003a70;
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 22px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 6px 20px rgba(0, 58, 112, 0.2);
            transition: all 0.2s;
            margin-top: 15px;
        }
        .btn-calculate:active { transform: scale(0.97); background-color: #002d5a; }

        .result-box {
            display: none;
            margin-top: 40px;
            padding: 0;
            background: #fff;
            border-radius: 25px;
            overflow: hidden;
            border: 1px solid #eef2f7;
            animation: slideUp 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
            box-shadow: 0 20px 50px rgba(0,0,0,0.1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .result-header {
            background: #f8fbff;
            padding: 25px;
            border-bottom: 1px solid #f0f4f8;
            text-align: center;
        }
        .result-header h3 {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
            color: #003a70;
            text-transform: uppercase;
        }

        .result-body { padding: 35px 30px; }

        .res-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
        }
        .res-row:last-of-type { border-bottom: none; }
        .res-lbl { font-size: 16px; color: #666; font-weight: 600; min-width: 120px; }
        .res-val { font-size: 18px; font-weight: 700; color: #333; text-align: right; }

        .description-box {
            background: #fdfdfd;
            border: 1px solid #f0f0f0;
            border-radius: 12px;
            padding: 20px;
            margin-top: 8px;
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }

        .emi-premium-card {
            background: linear-gradient(135deg, #003a70 0%, #0052cc 100%);
            color: white;
            padding: 40px 25px;
            border-radius: 20px;
            text-align: center;
            margin-bottom: 35px;
            position: relative;
            box-shadow: 0 10px 25px rgba(0, 58, 112, 0.3);
        }
        .emi-premium-card .emi-amt {
            display: block;
            font-size: 60px;
            font-weight: 900;
            line-height: 1;
        }
        .emi-premium-card .emi-lbl {
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            opacity: 0.9;
            margin-bottom: 8px;
            display: block;
        }
        .emi-premium-card .emi-note {
            font-size: 15px;
            margin-top: 12px;
            opacity: 0.8;
            display: block;
            font-weight: 600;
        }

        .btn-book-special {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 20px;
            background-color: #e31e24;
            color: white !important;
            text-decoration: none !important;
            border-radius: 15px;
            font-size: 22px;
            font-weight: 800;
            gap: 12px;
            transition: transform 0.2s;
            margin-top: 30px;
        }
        .btn-book-special:active { transform: scale(0.98); }

        .product-preview-img {
            width: 160px;
            height: 160px;
            object-fit: contain;
            margin: 0 auto 30px;
            display: block;
        }

        .back-btn {
            font-size: 24px;
            color: #003a70;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="mobile-wrapper">
        <!-- Reusable Header -->
        @include('frontend.partials.header')

        <div class="calc-content">
            <div class="d-flex align-items-center mb-5">
                <a href="{{ url('/') }}" class="back-btn me-4"><i class="fas fa-arrow-left"></i></a>
                <h1 class="shop-title mb-0" style="font-size: 32px;">Installment Calculator</h1>
            </div>

            <div class="calculator-form">
                <div class="form-group">
                    <label><i class="fas fa-tag me-2 text-primary"></i> 1. Select Brand</label>
                    <select id="brand_id" class="form-select-alfa" onchange="loadModels(this.value)">
                        <option value="">Choose Brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-layer-group me-2 text-primary"></i> 2. Select Series</label>
                            <select id="series_filter" class="form-select-alfa" disabled onchange="applyFilters()">
                                <option value="all">All Series</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-hdd me-2 text-primary"></i> 3. Select Storage</label>
                            <select id="storage_filter" class="form-select-alfa" disabled onchange="applyFilters()">
                                <option value="all">All Storages</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-mobile-alt me-2 text-primary"></i> 4. Select Model</label>
                    <select id="mobile_id" class="form-select-alfa" disabled onchange="updateColorOptions()">
                        <option value="">Choose Model</option>
                    </select>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-palette me-2 text-primary"></i> 5. Select Color</label>
                    <select id="color" class="form-select-alfa" disabled>
                        <option value="">Choose Color</option>
                    </select>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-calendar-check me-2 text-primary"></i> 6. Select EMI Tenure</label>
                    <select id="tenure" class="form-select-alfa">
                        <option value="3">3 Months Plan (0% Markup)</option>
                        <option value="6">6 Months Plan (0% Markup)</option>
                        <option value="12">12 Months Plan</option>
                        <option value="18">18 Months Plan</option>
                        <option value="24">24 Months Plan</option>
                    </select>
                </div>

                <button type="button" class="btn-calculate" onclick="calculate()">
                    CALCULATE NOW <i class="fas fa-calculator ms-2"></i>
                </button>
            </div>

            <div id="resultBox" class="result-box">
                <div class="result-header">
                    <h3>Your Installment Plan</h3>
                </div>

                <div class="result-body">
                    <img id="res_image" src="" alt="Mobile" class="product-preview-img" style="display:none;">

                    <div class="emi-premium-card">
                        <span class="emi-lbl">Monthly Installment</span>
                        <span class="emi-amt" id="res_emi">Rs. 0</span>
                        <span class="emi-note">Zero Down Payment Required*</span>
                    </div>

                    <div class="res-row">
                        <span class="res-lbl">Model</span>
                        <span class="res-val" id="res_model">-</span>
                    </div>
                    <div class="res-row">
                        <span class="res-lbl">Series</span>
                        <span class="res-val" id="res_series">-</span>
                    </div>
                    <div class="res-row">
                        <span class="res-lbl">Storage</span>
                        <span class="res-val" id="res_storage">-</span>
                    </div>
                    <div class="res-row">
                        <span class="res-lbl">Color</span>
                        <span class="res-val" id="res_color">-</span>
                    </div>
                    <div class="res-row">
                        <span class="res-lbl">Device Price</span>
                        <span class="res-val" id="res_total">Rs. 0</span>
                    </div>
                    <div class="res-row">
                        <span class="res-lbl">Tenure</span>
                        <span class="res-val" id="res_tenure">0 Months</span>
                    </div>

                    <div class="mt-5">
                        <span class="res-lbl d-block mb-3">Mobile Description & Specs</span>
                        <div class="description-box" id="res_description">
                            -
                        </div>
                    </div>

                    <p class="text-center text-muted mt-5 mb-4" style="font-size: 14px;">
                        * Approval depends on bank verification and credit score.
                        Prices are inclusive of all taxes.
                    </p>

                    <a id="btn_book" href="{{ route('shop') }}" class="btn-book-special">
                        BOOK THIS MOBILE <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        let mobileData = [];

        async function loadModels(brandId) {
            const modelSelect = document.getElementById('mobile_id');
            const seriesFilter = document.getElementById('series_filter');
            const storageFilter = document.getElementById('storage_filter');
            const colorSelect = document.getElementById('color');

            modelSelect.innerHTML = '<option value="">Loading...</option>';
            modelSelect.disabled = true;
            seriesFilter.innerHTML = '<option value="all">All Series</option>';
            seriesFilter.disabled = true;
            storageFilter.innerHTML = '<option value="all">All Storages</option>';
            storageFilter.disabled = true;
            colorSelect.innerHTML = '<option value="">Choose Color</option>';
            colorSelect.disabled = true;

            if (!brandId) {
                modelSelect.innerHTML = '<option value="">Choose Model</option>';
                return;
            }

            try {
                const response = await fetch(`/get-models/${brandId}`);
                mobileData = await response.json();

                // Populate Series
                const uniqueSeries = [];
                const seriesMap = new Map();
                mobileData.forEach(m => {
                    if (m.series_id && !seriesMap.has(m.series_id)) {
                        seriesMap.set(m.series_id, m.series_name);
                        uniqueSeries.push({id: m.series_id, name: m.series_name});
                    }
                });
                uniqueSeries.forEach(s => {
                    seriesFilter.innerHTML += `<option value="${s.id}">${s.name}</option>`;
                });
                if (uniqueSeries.length > 0) seriesFilter.disabled = false;

                // Populate Storages
                const uniqueStorages = [...new Set(mobileData.map(m => m.storage_name).filter(s => s))];
                uniqueStorages.forEach(s => {
                    storageFilter.innerHTML += `<option value="${s}">${s}</option>`;
                });
                if (uniqueStorages.length > 0) storageFilter.disabled = false;

                applyFilters();
            } catch (error) {
                console.error('Error fetching models:', error);
                modelSelect.innerHTML = '<option value="">Error loading</option>';
            }
        }

        function applyFilters() {
            const seriesVal = document.getElementById('series_filter').value;
            const storageVal = document.getElementById('storage_filter').value;
            const modelSelect = document.getElementById('mobile_id');

            modelSelect.innerHTML = '<option value="">Choose Model</option>';

            const filtered = mobileData.filter(m => {
                const matchSeries = seriesVal === 'all' || m.series_id == seriesVal;
                const matchStorage = storageVal === 'all' || m.storage_name === storageVal;
                return matchSeries && matchStorage;
            });

            filtered.forEach(mobile => {
                let displayName = mobile.name;
                // Add storage hint if not filtering by storage
                if (storageVal === 'all' && mobile.storage_name) {
                    displayName += ` (${mobile.storage_name})`;
                }
                modelSelect.innerHTML += `<option value="${mobile.id}">${displayName}</option>`;
            });

            modelSelect.disabled = false;
            updateColorOptions();
        }

        function updateColorOptions() {
            const mobileId = document.getElementById('mobile_id').value;
            const colorSelect = document.getElementById('color');
            const selectedMobile = mobileData.find(m => m.id == mobileId);

            colorSelect.innerHTML = '<option value="">Choose Color</option>';
            if (selectedMobile && selectedMobile.colors) {
                const colors = selectedMobile.colors.split(',');
                colors.forEach(c => {
                    colorSelect.innerHTML += `<option value="${c.trim()}">${c.trim()}</option>`;
                });
                colorSelect.disabled = false;
            } else {
                colorSelect.disabled = true;
            }
        }

        function calculate() {
            const mobileId = document.getElementById('mobile_id').value;
            const color = document.getElementById('color').value;
            const tenure = document.getElementById('tenure').value;
            const resultBox = document.getElementById('resultBox');

            if (!mobileId) {
                alert('Please select a mobile model.');
                return;
            }
            if (!color) {
                alert('Please select a color.');
                return;
            }

            const selectedMobile = mobileData.find(m => m.id == mobileId);
            const price = parseInt(selectedMobile.price.toString().replace(/,/g, ''));
            const emi = Math.round(price / tenure);

            // Populate Result
            document.getElementById('res_model').innerText = selectedMobile.name;
            document.getElementById('res_series').innerText = selectedMobile.series_name || 'N/A';
            document.getElementById('res_storage').innerText = selectedMobile.storage_name || 'Standard';
            document.getElementById('res_color').innerText = color;
            document.getElementById('res_total').innerText = 'Rs. ' + price.toLocaleString();
            document.getElementById('res_tenure').innerText = tenure + ' Months';
            document.getElementById('res_description').innerText = selectedMobile.specs || 'Standard high-performance device with official warranty.';
            document.getElementById('res_emi').innerText = 'Rs. ' + emi.toLocaleString();

            // Update Book Now link
            document.getElementById('btn_book').href = "{{ route('plan') }}?id=" + selectedMobile.id;

            if(selectedMobile.image_url) {
                document.getElementById('res_image').src = selectedMobile.image_url;
                document.getElementById('res_image').style.display = 'block';
            } else {
                document.getElementById('res_image').style.display = 'none';
            }

            resultBox.style.display = 'block';

            setTimeout(() => {
                resultBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }, 100);
        }
    </script>
</body>
</html>
