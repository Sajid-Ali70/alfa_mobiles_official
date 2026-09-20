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

        .edit-mobile-dialog {
            max-width: 1140px;
        }

        .edit-mobile-modal {
            background: #0c2137;
            border: 1px solid #3c6084 !important;
            border-radius: 10px !important;
            box-shadow: 0 24px 70px rgba(0, 0, 0, 0.45);
        }

        .edit-mobile-modal .modal-header,
        .edit-mobile-modal .modal-footer {
            border-color: #2d4d6c !important;
            padding: 15px 22px;
        }

        .edit-mobile-modal .modal-title {
            font-size: 1.45rem;
            font-weight: 700;
        }

        .edit-mobile-modal .modal-body {
            padding: 22px;
        }

        .edit-mobile-modal .form-label {
            color: #e0e9f3;
            font-size: 0.92rem;
            font-weight: 600;
        }

        .edit-mobile-modal .form-control,
        .edit-mobile-modal .form-select {
            min-height: 44px;
            background-color: #0a1a2c;
            border-color: #3a5c7f;
            border-radius: 6px;
            color: #f4f8fc;
        }

        .edit-mobile-modal .form-control:focus,
        .edit-mobile-modal .form-select:focus {
            background-color: #0a1a2c;
            border-color: #2d8cff;
            color: #fff;
            box-shadow: 0 0 0 2px rgba(45, 140, 255, 0.18);
        }

        .edit-mobile-modal .form-select option {
            background: #0c2137;
        }

        .edit-status-panel {
            display: grid;
            grid-template-columns: 1.15fr 1.4fr;
            border: 1px solid #315372;
            border-radius: 7px;
            overflow: hidden;
            background: rgba(6, 22, 38, 0.35);
        }

        .edit-status-panel > div {
            min-height: 92px;
            padding: 14px 18px;
            border-right: 1px solid #315372;
        }

        .edit-status-panel > div:last-child { border-right: 0; }

        .edit-status-title {
            color: #dfe9f3;
            font-size: 0.92rem;
            font-weight: 700;
            margin-bottom: 14px;
        }

        .status-pill {
            display: inline-block;
            min-width: 76px;
            padding: 5px 14px;
            border-radius: 20px;
            color: #fff;
            font-size: 0.83rem;
            font-weight: 700;
            text-align: center;
        }

        .status-pill-pta { background: #0ab866; }
        .status-pill-non-pta { background: #f5a900; }
        .status-pill-jv { background: #f23b64; }

        .edit-price-heading {
            display: flex;
            justify-content: space-around;
            gap: 10px;
            margin: -3px 0 12px;
        }

        .edit-price-heading .status-pill {
            min-width: 92px;
        }

        .edit-mobile-modal textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }
        .edit-mobile-image-preview {
            display: block;
            width: 108px;
            height: 78px;
            margin-top: 8px;
            border: 1px solid #3a5c7f;
            border-radius: 6px;
            object-fit: contain;
            background: #081625;
        }

        .edit-mobile-modal .modal-footer .btn {
            min-width: 130px;
            min-height: 44px;
            font-weight: 600;
        }

        @media (max-width: 767px) {
            .edit-mobile-dialog { margin: 10px; }
            .edit-status-panel { grid-template-columns: 1fr; }
            .edit-status-panel > div { border-right: 0; border-bottom: 1px solid #315372; }
            .edit-status-panel > div:last-child { border-bottom: 0; }
        }

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

        .btn-secondary-custom {
            background: #30363d;
            color: white;
            border: 1px solid #484f58;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: fit-content;
            text-decoration: none;
        }
        .btn-secondary-custom:hover {
            background: #484f58;
            color: white;
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
            white-space: nowrap;
        }
        .badge-pending { background: rgba(255, 193, 7, 0.1); color: #ffc107; border: 1px solid #ffc107; }
        .badge-completed { background: rgba(40, 167, 69, 0.1); color: #28a745; border: 1px solid #28a745; }
        .badge-status.badge-delivered { background: rgba(13, 202, 240, 0.1); color: #0dcaf0; border: 1px solid #0dcaf0; }
        .badge-status.badge-cancelled { background: rgba(220, 53, 69, 0.1); color: #dc3545; border: 1px solid #dc3545; }

        .status-select-sm {
            padding: 5px 10px;
            font-size: 0.85rem;
            background: #0d1117;
            border: 1px solid var(--border-color);
            color: white;
            border-radius: 6px;
            outline: none;
            cursor: pointer;
        }
        .status-select-sm:focus {
            border-color: var(--accent-blue);
        }

        .d-none { display: none !important; }

        /* Media Queries */
        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; padding: 20px; }
        }

        /* Order Details Modal Styling */
        .modal-label { font-size: 0.75rem; text-transform: uppercase; color: var(--text-secondary); font-weight: 700; margin-bottom: 2px; }
        .modal-value { font-size: 1rem; color: white; font-weight: 600; margin-bottom: 15px; }
        .proof-img-container { background: #000; border-radius: 12px; overflow: hidden; border: 1px solid var(--border-color); }
    </style>
</head>
<body>

    <div class="sidebar" id="sidebar">
        <div class="brand-section">
            <img src="{{ $settings->app_icon ?? '' }}" alt="Logo" class="brand-logo-img">
            <span class="brand-name">{{ $settings->app_icon ? '' : ($settings->app_name ?? 'Alfa Mobiles') }}</span>
            <div class="admin-badge">Admin</div>
        </div>

        <nav class="nav flex-column">
            <a class="nav-link active" onclick="showSection('orders')"><i class="fas fa-shopping-cart"></i> Orders</a>
            <a class="nav-link" onclick="showSection('refunds')"><i class="fas fa-undo"></i> Refund Requests</a>
            <a class="nav-link" onclick="showSection('brands')"><i class="fas fa-tags"></i> Brands, Series & Storage</a>
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
            <div class="custom-tab-item" id="tab-refunds" onclick="showSection('refunds')">Refund Requests</div>
            <div class="custom-tab-item" id="tab-brands" onclick="showSection('brands')">Brands, Series & Storage</div>
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
                                <th>Status Update</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->full_name }}<br><small class="text-secondary">{{ $order->mobile_number }}</small></td>
                                <td>ID: {{ $order->mobile_id }}<br><small class="text-info">EMI: {{ $order->monthly_emi }}</small></td>
                                <td>
                                    <span class="badge-status badge-pending">{{ $order->status }}</span>
                                    <a href="{{ route('admin.orders.edit_status', $order->id) }}" class="btn btn-sm btn-outline-info ms-2">
                                        <i class="fas fa-edit"></i> Edit Status
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-info" onclick="viewOrder({{ json_encode($order) }})"><i class="fas fa-eye"></i></button>
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

        <!-- Section: Refunds -->
        <section id="refundsSection" class="dashboard-section d-none">
            <div class="admin-card">
                <h5 class="section-title">Refund Requests</h5>
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>Refund ID</th>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($refunds as $refund)
                            <tr>
                                <td>{{ $refund->refund_id }}</td>
                                <td>{{ $refund->order_id }}</td>
                                <td>{{ $refund->customer_name }}</td>
                                <td>Rs. {{ number_format($refund->refund_amount) }}</td>
                                <td><span class="badge-status badge-{{ strtolower($refund->status) }}">{{ $refund->status }}</span></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-info" onclick="viewRefund({{ json_encode($refund) }})"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-success" onclick="updateRefundStatus({{ $refund->id }}, 'Completed')"><i class="fas fa-check"></i></button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteRefund({{ $refund->id }})"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Section: Brands & Series & Storage -->
        <section id="brandsSection" class="dashboard-section d-none">
            <div class="row">
                <div class="col-md-4">
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
                <div class="col-md-4">
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
                <div class="col-md-4">
                    <div class="admin-card">
                        <h5 class="section-title">Add New Storage</h5>
                        <form id="addStorageForm">
                            @csrf
                            <div class="mb-3"><input type="text" name="name" class="form-control" placeholder="Storage Name (e.g. 128GB)" required></div>
                            <button type="submit" class="btn-primary-custom w-100">Add Storage</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
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
                <div class="col-md-4">
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
                <div class="col-md-4">
                    <div class="admin-card">
                        <h5 class="section-title">Manage Storage</h5>
                        <table class="table-custom">
                            <thead><tr><th>Name</th><th>Action</th></tr></thead>
                            <tbody>
                                @foreach($storages as $st)
                                <tr>
                                    <td>{{ $st->name }}</td>
                                    <td><button class="btn btn-sm btn-danger" onclick="deleteStorage({{ $st->id }})"><i class="fas fa-trash"></i></button></td>
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
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                    <h5 class="section-title mb-0">Add New Mobile</h5>
                </div>
                <form id="addMobileForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Brand</label>
                            <select name="brand_id" id="brand_select" class="form-control" required onchange="updateSeriesDropdown()">
                                <option value="">Select Brand</option>
                                @foreach($brands as $brand) <option value="{{ $brand->id }}">{{ $brand->name }}</option> @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Series</label>
                            <select name="series_id" id="series_select" class="form-control">
                                <option value="">Select Series</option>
                                <!-- Dynamic options -->
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Model Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Model Name" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Available Colors (Comma separated)</label>
                            <input type="text" name="colors" class="form-control" placeholder="Black, Silver, Blue">
                        </div>
                            <div class="col-12">
                                <label class="form-label">Storage, Price & Status Variants</label>
                                <div id="add_mobile_variants"></div>
                                <button type="button" class="btn btn-outline-info btn-sm" onclick="addMobileVariant('add_mobile_variants')"><i class="fas fa-plus me-1"></i>Add Storage Variant</button>
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
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead><tr><th>Image</th><th>Name</th><th>Brand</th><th>Series</th><th>Storage / Variants</th><th>Price</th><th>Colors</th><th>Status</th><th>Action</th></tr></thead>
                        <tbody>
                            @foreach($mobiles as $mobile)
                            <tr>
                                <td><img src="{{ $mobile->image_url }}" class="preview-img-small"></td>
                                <td>{{ $mobile->name }}</td>
                                <td>{{ $mobile->brand_name }}</td>
                                <td>{{ $mobile->series_name ?? '-' }}</td>
                                <td>
                                    @forelse($mobile->variants as $variant)
                                        <div>{{ $variant->storage_name }} / {{ strtoupper($variant->status ?? 'standard') }}</div>
                                    @empty
                                        {{ $mobile->storage_name ?? '-' }}
                                    @endforelse
                                </td>
                                <td>
                                    @forelse($mobile->variants as $variant)
                                        <div>Rs. {{ number_format((int)$variant->price) }}</div>
                                    @empty
                                        Rs. {{ number_format((int)$mobile->price) }}
                                    @endforelse
                                </td>
                                <td>{{ $mobile->colors ?? 'N/A' }}</td>
                                <td>{{ $mobile->status ? strtoupper($mobile->status) : '-' }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-warning text-white" onclick="openEditMobileModal({{ json_encode($mobile) }})"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteMobile({{ $mobile->id }})"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
                    <h5 class="section-title">Telegram Bot Integration</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Telegram Bot Token</label>
                            <input type="text" name="telegram_token" class="form-control" value="{{ $settings->telegram_token ?? '' }}" placeholder="Enter Token">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Telegram Chat ID</label>
                            <input type="text" name="telegram_chat_id" class="form-control" value="{{ $settings->telegram_chat_id ?? '' }}" placeholder="Enter Chat ID">
                        </div>
                    </div>
                </div>

                <div class="admin-card">
                    <h5 class="section-title">General Settings</h5>
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">App/Website Name</label><input type="text" name="app_name" class="form-control" value="{{ $settings->app_name }}"></div>
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

    <!-- Modals for Viewing Details -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-dark text-white border-secondary rounded-4">
                <div class="modal-header border-secondary px-4 py-3">
                    <h5 class="modal-title" id="modalTitle">Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 py-4" id="modalBody">
                    <!-- Content dynamic -->
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Mobile Modal -->
    <div class="modal fade" id="editMobileModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl edit-mobile-dialog">
            <div class="modal-content edit-mobile-modal text-white">
                <div class="modal-header border-secondary px-4 py-3">
                    <h5 class="modal-title"><i class="fas fa-pencil-alt text-warning me-2"></i>Edit Mobile Phone</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editMobileForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="edit_mobile_id">
                    <div class="modal-body px-4 py-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Brand</label>
                                <select name="brand_id" id="edit_brand_select" class="form-control" required onchange="updateEditSeriesDropdown()">
                                    @foreach($brands as $brand) <option value="{{ $brand->id }}">{{ $brand->name }}</option> @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Series</label>
                                <select name="series_id" id="edit_series_select" class="form-control">
                                    <option value="">Select Series</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Model Name</label>
                                <input type="text" name="name" id="edit_mobile_name" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Storage, Price & Status Variants</label>
                                <div id="edit_mobile_variants"></div>
                                <button type="button" class="btn btn-outline-info btn-sm" onclick="addMobileVariant('edit_mobile_variants')"><i class="fas fa-plus me-1"></i>Add Storage Variant</button>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Update Image (Choose File)</label>
                                <input type="file" name="image" id="edit_mobile_image" class="form-control" accept="image/*" onchange="previewEditMobileImage(this)">
                                <img id="edit_mobile_image_preview" class="edit-mobile-image-preview d-none" alt="Mobile preview">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Available Colors (Comma separated)</label>
                                <input type="text" name="colors" id="edit_mobile_colors" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Specs Summary</label>
                                <textarea name="specs" id="edit_mobile_specs" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-secondary px-4 py-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Mobile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const allSeries = @json($series);
        const allStorages = @json($storages);
        const baseUrl = "{{ url('/') }}";

        function addMobileVariant(containerId, variant = {}) {
            const container = document.getElementById(containerId);
            const index = container.querySelectorAll('.mobile-variant-row').length;
            const storageOptions = allStorages.map(storage => `<option value="${storage.id}" ${storage.id == (variant.storage_id || '') ? 'selected' : ''}>${storage.name}</option>`).join('');
            const row = document.createElement('div');
            row.className = 'mobile-variant-row row g-2 align-items-end mb-2';
            row.innerHTML = `
                <div class="col-md-4">
                    <label class="form-label small">Storage</label>
                    <select name="variants[${index}][storage_id]" class="form-control" required>
                        <option value="">Select Storage</option>${storageOptions}
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Status</label>
                    <select name="variants[${index}][status]" class="form-control">
                        <option value="" ${!variant.status ? 'selected' : ''}>Standard</option>
                        <option value="pta" ${variant.status === 'pta' ? 'selected' : ''}>PTA</option>
                        <option value="non-pta" ${variant.status === 'non-pta' ? 'selected' : ''}>Non-PTA</option>
                        <option value="jv" ${variant.status === 'jv' ? 'selected' : ''}>JV</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Price (Rs.)</label>
                    <input type="text" name="variants[${index}][price]" class="form-control" value="${variant.price || ''}" placeholder="Price" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.mobile-variant-row').remove()"><i class="fas fa-trash"></i></button>
                </div>`;
            container.appendChild(row);
        }

        function populateMobileVariants(containerId, variants, mobile) {
            const container = document.getElementById(containerId);
            container.innerHTML = '';
            if (variants.length) {
                variants.forEach(variant => addMobileVariant(containerId, variant));
            } else if (mobile && (mobile.storage_id || mobile.price)) {
                addMobileVariant(containerId, {storage_id: mobile.storage_id, price: mobile.price, status: mobile.status});
            }
        }

        function updateSeriesDropdown() {
            const brandId = document.getElementById('brand_select').value;
            const seriesSelect = document.getElementById('series_select');
            seriesSelect.innerHTML = '<option value="">Select Series</option>';
            const filteredSeries = allSeries.filter(s => s.brand_id == brandId);
            filteredSeries.forEach(s => {
                seriesSelect.innerHTML += `<option value="${s.id}">${s.name}</option>`;
            });
        }

        function updateEditSeriesDropdown(selectedSeriesId = null) {
            const brandId = document.getElementById('edit_brand_select').value;
            const seriesSelect = document.getElementById('edit_series_select');
            seriesSelect.innerHTML = '<option value="">Select Series</option>';
            const filteredSeries = allSeries.filter(s => s.brand_id == brandId);
            filteredSeries.forEach(s => {
                const selected = s.id == selectedSeriesId ? 'selected' : '';
                seriesSelect.innerHTML += `<option value="${s.id}" ${selected}>${s.name}</option>`;
            });
        }

        function openEditMobileModal(mobile) {
            document.getElementById('edit_mobile_id').value = mobile.id;
            document.getElementById('edit_brand_select').value = mobile.brand_id;
            document.getElementById('edit_mobile_name').value = mobile.name;
            document.getElementById('edit_mobile_colors').value = mobile.colors || '';
            document.getElementById('edit_mobile_specs').value = mobile.specs || '';
            populateMobileVariants('edit_mobile_variants', mobile.variants || [], mobile);
            const imagePreview = document.getElementById('edit_mobile_image_preview');
            imagePreview.src = mobile.image_url || '';
            imagePreview.classList.toggle('d-none', !mobile.image_url);

            updateEditSeriesDropdown(mobile.series_id);

            const editModal = new bootstrap.Modal(document.getElementById('editMobileModal'));
            editModal.show();
        }

        function previewEditMobileImage(input) {
            const preview = document.getElementById('edit_mobile_image_preview');
            if (input.files && input.files[0]) {
                preview.src = URL.createObjectURL(input.files[0]);
                preview.classList.remove('d-none');
            }
        }

        addMobileVariant('add_mobile_variants');

        document.getElementById('editMobileForm').onsubmit = async (e) => {
            e.preventDefault();
            const res = await fetch(`${baseUrl}/admin/mobiles/update`, {
                method: 'POST',
                headers: {'Accept': 'application/json'},
                body: new FormData(e.target)
            });
            if (res.ok) {
                location.reload();
            } else {
                const err = await res.json();
                alert("Error updating mobile: " + (err.message || "Internal Server Error"));
            }
        };

        function showSection(sectionId) {
            document.querySelectorAll('.nav-link, .custom-tab-item').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.dashboard-section').forEach(el => el.classList.add('d-none'));

            document.getElementById(sectionId + 'Section').classList.remove('d-none');
            const tabEl = document.getElementById('tab-' + sectionId);
            if(tabEl) tabEl.classList.add('active');
        }

        function previewImg(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => document.getElementById(previewId).src = e.target.result;
                reader.readAsDataURL(input.files[0]);
            }
        }

        function viewOrder(order) {
            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            document.getElementById('modalTitle').innerText = "📋 Order ID: " + order.order_number;

            let statusBadgeClass = 'badge-pending';
            if (order.status.includes('Delivered')) statusBadgeClass = 'badge-completed';
            if (order.status.includes('Approved')) statusBadgeClass = 'badge-completed';

            document.getElementById('modalBody').innerHTML = `
                <div class="row g-4">
                    <div class="col-md-12 mb-2">
                        <span class="badge-status ${statusBadgeClass} fs-6 px-3 py-2">Current Status: ${order.status}</span>
                    </div>
                    <div class="col-md-6">
                        <div class="modal-label">Customer Name</div>
                        <div class="modal-value">${order.full_name}</div>

                        <div class="modal-label">Email Address</div>
                        <div class="modal-value text-info">${order.email || 'N/A'}</div>

                        <div class="modal-label">Mobile Number</div>
                        <div class="modal-value">${order.mobile_number}</div>

                        <div class="modal-label">CNIC Number</div>
                        <div class="modal-value">${order.cnic}</div>

                        <div class="modal-label">Delivery Address</div>
                        <div class="modal-value text-secondary">${order.address}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="modal-label">Payment Mode</div>
                        <div class="modal-value">${order.payment_method} (${order.wallet_service})</div>

                        <div class="modal-label">Tenure Plan</div>
                        <div class="modal-value">${order.tenure} Months</div>

                        <div class="modal-label">Monthly EMI</div>
                        <div class="modal-value text-success">${order.monthly_emi}</div>

                        <div class="modal-label">Total Amount</div>
                        <div class="modal-value text-info">${order.total_price}</div>
                    </div>
                    <div class="col-12 mt-4 pt-3 border-top border-secondary">
                        <div class="modal-label mb-3">Verification Screenshot (Show Balance)</div>
                        <div class="proof-img-container">
                            <img src="${order.proof_image}" class="w-100 d-block shadow-lg">
                        </div>
                    </div>
                </div>
            `;
            modal.show();
        }

        function viewRefund(refund) {
            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            document.getElementById('modalTitle').innerText = "Refund Request: " + refund.refund_id;
            document.getElementById('modalBody').innerHTML = `
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="modal-label">Customer Name</div>
                        <div class="modal-value">${refund.customer_name}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="modal-label">Refund Amount</div>
                        <div class="modal-value text-danger">Rs. ${refund.refund_amount}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="modal-label">Order Number</div>
                        <div class="modal-value">${refund.order_id}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="modal-label">Wallet/Bank Method</div>
                        <div class="modal-value">${refund.payment_method}</div>
                    </div>
                    <div class="col-12 mt-3 pt-3 border-top border-secondary">
                        <div class="modal-label mb-2">Attached Proof</div>
                        <div class="proof-img-container">
                            <img src="${refund.proof_image}" class="w-100 d-block">
                        </div>
                    </div>
                </div>
            `;
            modal.show();
        }

        document.getElementById('settingsForm').onsubmit = async (e) => {
            e.preventDefault();
            const res = await fetch(`${baseUrl}/admin/settings/update`, { method: 'POST', body: new FormData(e.target) });
            if (res.ok) alert("Settings updated!");
        };

        document.getElementById('addBrandForm').onsubmit = async (e) => {
            e.preventDefault();
            const res = await fetch(`${baseUrl}/admin/brands/add`, { method: 'POST', body: new FormData(e.target) });
            if (res.ok) location.reload();
        };

        async function deleteBrand(id) {
            if (confirm("Delete this brand?")) {
                const res = await fetch(`${baseUrl}/admin/brands/delete/${id}`, { method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'} });
                if (res.ok) location.reload();
            }
        }

        document.getElementById('addSeriesForm').onsubmit = async (e) => {
            e.preventDefault();
            const res = await fetch(`${baseUrl}/admin/series/add`, { method: 'POST', body: new FormData(e.target) });
            if (res.ok) location.reload();
        };

        async function deleteSeries(id) {
            if (confirm("Delete this series?")) {
                const res = await fetch(`${baseUrl}/admin/series/delete/${id}`, { method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'} });
                if (res.ok) location.reload();
            }
        }

        document.getElementById('addStorageForm').onsubmit = async (e) => {
            e.preventDefault();
            const res = await fetch(`${baseUrl}/admin/storages/add`, { method: 'POST', body: new FormData(e.target) });
            if (res.ok) location.reload();
        };

        async function deleteStorage(id) {
            if (confirm("Delete this storage?")) {
                const res = await fetch(`${baseUrl}/admin/storages/delete/${id}`, { method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'} });
                if (res.ok) location.reload();
            }
        }

        document.getElementById('addMobileForm').onsubmit = async (e) => {
            e.preventDefault();
            const res = await fetch(`${baseUrl}/admin/mobiles/add`, {
                method: 'POST',
                headers: {'Accept': 'application/json'},
                body: new FormData(e.target)
            });
            if (res.ok) location.reload();
            else {
                const err = await res.json();
                alert("Error adding mobile: " + (err.message || "Internal Server Error"));
            }
        };

        async function deleteMobile(id) {
            if (confirm("Delete this mobile?")) {
                const res = await fetch(`${baseUrl}/admin/mobiles/delete/${id}`, { method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'} });
                if (res.ok) location.reload();
            }
        }

        async function deleteOrder(id) {
            if (confirm("Delete order?")) {
                const res = await fetch(`${baseUrl}/admin/orders/delete/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                if (res.ok) {
                    location.reload();
                } else {
                    const err = await res.json();
                    alert("Error deleting order: " + (err.message || "Internal Server Error"));
                }
            }
        }

        async function updateRefundStatus(id, status) {
            const res = await fetch(`${baseUrl}/admin/refunds/update-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ id, status })
            });
            if (res.ok) location.reload();
        }

        async function deleteRefund(id) {
            if (confirm("Delete refund request?")) {
                const res = await fetch(`${baseUrl}/admin/refunds/delete/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                if (res.ok) location.reload();
            }
        }

        document.getElementById('passwordForm').onsubmit = async (e) => {
            e.preventDefault();
            const res = await fetch(`${baseUrl}/admin/password/update`, {
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
