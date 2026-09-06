<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - {{ $settings->app_name ?? 'Alfa Mobiles' }}</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --bg-color: #0b0e14;
            --sidebar-bg: #0f131a;
            --card-bg: #161b22;
            --text-main: #ffffff;
            --text-secondary: #8b949e;
            --accent-blue: #007bff;
            --border-color: #30363d;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            height: 100vh;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            position: fixed;
            padding: 20px;
            display: flex;
            flex-direction: column;
            z-index: 1200;
            transition: transform 0.3s ease;
        }

        .brand-section {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
        }

        .brand-logo-img {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid var(--border-color);
        }

        .brand-name {
            font-size: 1.15rem;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .admin-badge {
            background: rgba(0, 123, 255, 0.1);
            color: var(--accent-blue);
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 4px;
            border: 1px solid var(--accent-blue);
            margin-left: auto;
        }

        .nav-link {
            color: var(--text-secondary);
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            text-decoration: none;
            cursor: pointer;
        }

        .nav-link i {
            width: 20px;
            margin-right: 12px;
            font-size: 1rem;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--text-main);
            background: rgba(255, 255, 255, 0.05);
        }

        .nav-link.active {
            background: rgba(0, 123, 255, 0.1);
            border: 1px solid rgba(0, 123, 255, 0.2);
            color: var(--accent-blue);
        }

        .logout-btn {
            margin-top: auto;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
            background: transparent;
            padding: 10px;
            border-radius: 8px;
            width: 100%;
            text-align: left;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background: rgba(220, 53, 69, 0.1);
            color: #ff4d4d;
            border-color: #ff4d4d;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            padding: 40px;
            transition: margin-left 0.3s ease;
        }

        .page-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .page-header p {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .header-app-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            object-fit: cover;
            border: 1px solid var(--border-color);
        }

        /* Tabs */
        .custom-tabs {
            display: flex;
            gap: 20px;
            margin: 30px 0;
            border-bottom: 1px solid var(--border-color);
            overflow-x: auto;
            white-space: nowrap;
        }

        .custom-tab-item {
            cursor: pointer;
            color: var(--text-secondary);
            padding: 10px 0;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            transition: 0.3s;
            position: relative;
            flex-shrink: 0;
        }

        .custom-tab-item.active {
            color: var(--accent-blue);
        }

        .custom-tab-item.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--accent-blue);
        }

        /* Content Card */
        .admin-card {
            background: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            padding: 30px;
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .section-desc {
            color: var(--text-secondary);
            font-size: 0.85rem;
            margin-bottom: 25px;
        }

        /* Forms & Inputs */
        .form-label { color: var(--text-secondary); margin-bottom: 8px; font-size: 0.9rem; }
        .form-control {
            background: #0d1117;
            border: 1px solid var(--border-color);
            color: white;
            padding: 12px;
            font-size: 0.95rem;
        }
        .form-control:focus {
            background: #0d1117;
            border-color: var(--accent-blue);
            color: white;
            box-shadow: none;
        }
        select.form-control { background-image: none; }

        .btn-primary-custom {
            background: var(--accent-blue);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: fit-content;
        }

        .btn-danger-custom {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* Table */
        .table-custom {
            width: 100%;
            border-collapse: collapse;
            color: var(--text-main);
        }
        .table-custom th {
            text-align: left;
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-secondary);
            font-weight: 500;
        }
        .table-custom td {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .preview-img-small {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            object-fit: contain;
            background: #0d1117;
            border: 1px solid var(--border-color);
        }

        .badge-status {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-pending { background: rgba(255, 193, 7, 0.1); color: #ffc107; border: 1px solid #ffc107; }
        .badge-completed { background: rgba(40, 167, 69, 0.1); color: #28a745; border: 1px solid #28a745; }

        .d-none { display: none !important; }

        /* Media Queries */
        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; padding: 20px; }
        }
    </style>
</head>
<body>

    <div class="sidebar" id="sidebar">
        <div class="brand-section">
            <img src="{{ $settings->app_icon ?? '' }}" alt="Logo" class="brand-logo-img">
            <span class="brand-name">{{ $settings->app_name ?? 'Alfa Mobiles' }}</span>
            <div class="admin-badge">Admin</div>
        </div>

        <nav class="nav flex-column">
            <a class="nav-link active" onclick="showSection('orders')"><i class="fas fa-shopping-cart"></i> Orders</a>
            <a class="nav-link" onclick="showSection('brands')"><i class="fas fa-tags"></i> Brands & Series</a>
            <a class="nav-link" onclick="showSection('mobiles')"><i class="fas fa-mobile-alt"></i> Mobiles</a>
            <a class="nav-link" onclick="showSection('settings')"><i class="fas fa-cog"></i> Website Settings</a>
            <a class="nav-link" onclick="showSection('security')"><i class="fas fa-lock"></i> Security</a>
        </nav>

        <form action="{{ route('admin.logout') }}" method="POST" class="mt-auto">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </button>
        </form>
    </div>

    <main class="main-content">
        <div class="page-header d-flex align-items-center gap-3 mb-4">
            <img src="{{ $settings->app_icon ?? '' }}" alt="App Icon" class="header-app-icon">
            <div>
                <h1 class="mb-0">Alfa Mobiles Control Panel</h1>
                <p class="mb-0">Manage your orders, mobile phones, and site configurations.</p>
            </div>
        </div>

        <div class="custom-tabs">
            <div class="custom-tab-item active" id="tab-orders" onclick="showSection('orders')">Orders</div>
            <div class="custom-tab-item" id="tab-brands" onclick="showSection('brands')">Brands & Series</div>
            <div class="custom-tab-item" id="tab-mobiles" onclick="showSection('mobiles')">Mobiles</div>
            <div class="custom-tab-item" id="tab-settings" onclick="showSection('settings')">Settings</div>
            <div class="custom-tab-item" id="tab-security" onclick="showSection('security')">Security</div>
        </div>

        <!-- Section: Orders -->
        <section id="ordersSection" class="dashboard-section">
            <div class="admin-card">
                <h5 class="section-title">Order Management</h5>
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Mobile</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->full_name }}<br><small class="text-secondary">{{ $order->mobile_number }}</small></td>
                                <td>{{ $order->mobile_id }} (EMI: {{ $order->monthly_emi }})</td>
                                <td><span class="badge-status badge-{{ strtolower($order->status) }}">{{ $order->status }}</span></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-info" onclick="viewOrder({{ $order->id }})"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-success" onclick="updateOrderStatus({{ $order->id }}, 'Completed')"><i class="fas fa-check"></i></button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteOrder({{ $order->id }})"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Section: Brands & Series -->
        <section id="brandsSection" class="dashboard-section d-none">
            <div class="row">
                <div class="col-md-6">
                    <div class="admin-card">
                        <h5 class="section-title">Add New Brand</h5>
                        <form id="addBrandForm" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3"><input type="text" name="name" class="form-control" placeholder="Brand Name" required></div>
                            <div class="mb-3"><input type="file" name="logo" class="form-control" accept="image/*"></div>
                            <button type="submit" class="btn-primary-custom w-100">Add Brand</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="admin-card">
                        <h5 class="section-title">Add New Series</h5>
                        <form id="addSeriesForm">
                            @csrf
                            <div class="mb-3">
                                <select name="brand_id" class="form-control" required>
                                    <option value="">Select Brand</option>
                                    @foreach($brands as $brand) <option value="{{ $brand->id }}">{{ $brand->name }}</option> @endforeach
                                </select>
                            </div>
                            <div class="mb-3"><input type="text" name="name" class="form-control" placeholder="Series Name (e.g. iPhone 15)" required></div>
                            <button type="submit" class="btn-primary-custom w-100">Add Series</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="admin-card">
                        <h5 class="section-title">Manage Brands</h5>
                        <table class="table-custom">
                            <thead><tr><th>Logo</th><th>Name</th><th>Action</th></tr></thead>
                            <tbody>
                                @foreach($brands as $brand)
                                <tr>
                                    <td><img src="{{ $brand->logo_url }}" class="preview-img-small"></td>
                                    <td>{{ $brand->name }}</td>
                                    <td><button class="btn btn-sm btn-danger" onclick="deleteBrand({{ $brand->id }})"><i class="fas fa-trash"></i></button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="admin-card">
                        <h5 class="section-title">Manage Series</h5>
                        <table class="table-custom">
                            <thead><tr><th>Brand</th><th>Series</th><th>Action</th></tr></thead>
                            <tbody>
                                @foreach($series as $s)
                                <tr>
                                    <td>{{ $s->brand_name }}</td>
                                    <td>{{ $s->name }}</td>
                                    <td><button class="btn btn-sm btn-danger" onclick="deleteSeries({{ $s->id }})"><i class="fas fa-trash"></i></button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section: Mobiles -->
        <section id="mobilesSection" class="dashboard-section d-none">
            <div class="admin-card">
                <h5 class="section-title">Add New Mobile</h5>
                <form id="addMobileForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Brand</label>
                            <select name="brand_id" id="brand_select" class="form-control" required onchange="updateSeriesDropdown()">
                                <option value="">Select Brand</option>
                                @foreach($brands as $brand) <option value="{{ $brand->id }}">{{ $brand->name }}</option> @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Series</label>
                            <select name="series_id" id="series_select" class="form-control">
                                <option value="">Select Series</option>
                                <!-- Dynamic options -->
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Model Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Model Name" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Price (Rs.)</label>
                            <input type="text" name="price" class="form-control" placeholder="Price" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Specs Summary</label>
                            <textarea name="specs" class="form-control" placeholder="Specs Summary"></textarea>
                        </div>
                        <div class="col-12"><button type="submit" class="btn-primary-custom">Save Mobile</button></div>
                    </div>
                </form>
            </div>
            <div class="admin-card">
                <h5 class="section-title">Mobile Inventory</h5>
                <table class="table-custom">
                    <thead><tr><th>Image</th><th>Name</th><th>Brand</th><th>Series</th><th>Price</th><th>Action</th></tr></thead>
                    <tbody>
                        @foreach($mobiles as $mobile)
                        <tr>
                            <td><img src="{{ $mobile->image_url }}" class="preview-img-small"></td>
                            <td>{{ $mobile->name }}</td>
                            <td>{{ $mobile->brand_name }}</td>
                            <td>{{ $mobile->series_name ?? '-' }}</td>
                            <td>{{ $mobile->price }}</td>
                            <td><button class="btn btn-sm btn-danger" onclick="deleteMobile({{ $mobile->id }})"><i class="fas fa-trash"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Section: Settings -->
        <section id="settingsSection" class="dashboard-section d-none">
            <form id="settingsForm" enctype="multipart/form-data">
                @csrf
                <div class="admin-card">
                    <h5 class="section-title">Visual Settings (Logo & Banner)</h5>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Website Logo</label>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $settings->app_icon }}" class="preview-img-small" id="logoPreview">
                                <input type="file" name="app_icon_file" class="form-control" onchange="previewImg(this, 'logoPreview')">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Home Page Banner</label>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $settings->banner_url }}" class="preview-img-small" id="bannerPreview">
                                <input type="file" name="banner_file" class="form-control" onchange="previewImg(this, 'bannerPreview')">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact_number" class="form-control" value="{{ $settings->contact_number }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contact Email</label>
                            <input type="text" name="contact_email" class="form-control" value="{{ $settings->contact_email }}">
                        </div>
                    </div>
                </div>

                <div class="admin-card">
                    <h5 class="section-title">Play Store Information (Optional)</h5>
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">App Name</label><input type="text" name="app_name" class="form-control" value="{{ $settings->app_name }}"></div>
                        <div class="col-md-6"><label class="form-label">Developer</label><input type="text" name="developer" class="form-control" value="{{ $settings->developer }}"></div>
                        <div class="col-md-4"><label class="form-label">Category</label><input type="text" name="category" class="form-control" value="{{ $settings->category }}"></div>
                        <div class="col-md-4"><label class="form-label">Rating</label><input type="text" name="rating_score" class="form-control" value="{{ $settings->rating_score }}"></div>
                        <div class="col-md-4"><label class="form-label">Downloads</label><input type="text" name="downloads_count" class="form-control" value="{{ $settings->downloads_count }}"></div>
                    </div>
                    <button type="submit" class="btn-primary-custom mt-4 w-100">Save All Settings</button>
                </div>
            </form>
        </section>

        <!-- Section: Security -->
        <section id="securitySection" class="dashboard-section d-none">
            <div class="admin-card">
                <h5 class="section-title">Change Password</h5>
                <form id="passwordForm">
                    @csrf
                    <div class="mb-3"><label class="form-label">Current Password</label><input type="password" name="current_password" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">New Password</label><input type="password" name="new_password" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Confirm New Password</label><input type="password" name="new_password_confirmation" class="form-control" required></div>
                    <button type="submit" class="btn-primary-custom">Update Password</button>
                </form>
            </div>
        </section>
    </main>

    <script>
        const allSeries = @json($series);

        function updateSeriesDropdown() {
            const brandId = document.getElementById('brand_select').value;
            const seriesSelect = document.getElementById('series_select');
            seriesSelect.innerHTML = '<option value="">Select Series</option>';

            const filteredSeries = allSeries.filter(s => s.brand_id == brandId);
            filteredSeries.forEach(s => {
                seriesSelect.innerHTML += `<option value="${s.id}">${s.name}</option>`;
            });
        }

        function showSection(sectionId) {
            document.querySelectorAll('.nav-link, .custom-tab-item').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.dashboard-section').forEach(el => el.classList.add('d-none'));

            document.getElementById(sectionId + 'Section').classList.remove('d-none');
            document.getElementById('tab-' + sectionId).classList.add('active');
        }

        function previewImg(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => document.getElementById(previewId).src = e.target.result;
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.getElementById('settingsForm').onsubmit = async (e) => {
            e.preventDefault();
            const res = await fetch("{{ route('admin.settings.update') }}", { method: 'POST', body: new FormData(e.target) });
            if (res.ok) alert("Settings updated!");
        };

        document.getElementById('addBrandForm').onsubmit = async (e) => {
            e.preventDefault();
            const res = await fetch("{{ route('admin.brands.add') }}", { method: 'POST', body: new FormData(e.target) });
            if (res.ok) location.reload();
        };

        async function deleteBrand(id) {
            if (confirm("Delete this brand?")) {
                const res = await fetch(`/admin/brands/delete/${id}`, { method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'} });
                if (res.ok) location.reload();
            }
        }

        document.getElementById('addSeriesForm').onsubmit = async (e) => {
            e.preventDefault();
            const res = await fetch("{{ route('admin.series.add') }}", { method: 'POST', body: new FormData(e.target) });
            if (res.ok) location.reload();
        };

        async function deleteSeries(id) {
            if (confirm("Delete this series?")) {
                const res = await fetch(`/admin/series/delete/${id}`, { method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'} });
                if (res.ok) location.reload();
            }
        }

        document.getElementById('addMobileForm').onsubmit = async (e) => {
            e.preventDefault();
            const res = await fetch("{{ route('admin.mobiles.add') }}", { method: 'POST', body: new FormData(e.target) });
            if (res.ok) location.reload();
        };

        async function deleteMobile(id) {
            if (confirm("Delete this mobile?")) {
                const res = await fetch(`/admin/mobiles/delete/${id}`, { method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'} });
                if (res.ok) location.reload();
            }
        }

        async function updateOrderStatus(id, status) {
            const res = await fetch("{{ route('admin.orders.update_status') }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'},
                body: JSON.stringify({ id, status })
            });
            if (res.ok) location.reload();
        }

        async function deleteOrder(id) {
            if (confirm("Delete order?")) {
                const res = await fetch(`/admin/orders/delete/${id}`, { method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'} });
                if (res.ok) location.reload();
            }
        }

        document.getElementById('passwordForm').onsubmit = async (e) => {
            e.preventDefault();
            const res = await fetch("{{ route('admin.password.update') }}", {
                method: 'POST',
                headers: {'Accept': 'application/json'},
                body: new FormData(e.target)
            });
            if (res.ok) alert("Password changed!");
            else { const err = await res.json(); alert(err.message); }
        };
    </script>
</body>
</html>
