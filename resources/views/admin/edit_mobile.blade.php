<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mobile - {{ $settings->app_name ?? 'Alfa Mobiles' }}</title>
    <link rel="icon" type="image/png" href="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --bg: #0b0e14; --panel: #161b22; --input: #0d1117; --border: #30363d; --muted: #8b949e; --blue: #007bff; }
        body { min-height: 100vh; margin: 0; background: var(--bg); color: #fff; font-family: 'Segoe UI', Tahoma, sans-serif; }
        .sidebar { width: 260px; height: 100vh; box-sizing: border-box; background: #0f131a; border-right: 1px solid var(--border); position: fixed; inset: 0 auto 0 0; padding: 20px; display: flex; flex-direction: column; z-index: 10; }
        .brand-section { display: flex; align-items: center; gap: 12px; margin-bottom: 40px; }
        .brand-logo-img { width: 35px; height: 35px; border-radius: 8px; object-fit: cover; border: 1px solid var(--border); }
        .brand-name { font-size: 1.15rem; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .admin-badge { margin-left: auto; padding: 2px 8px; border: 1px solid var(--blue); border-radius: 4px; color: var(--blue); background: rgba(0,123,255,.1); font-size: .7rem; }
        .nav-link { display: flex; align-items: center; gap: 12px; margin-bottom: 5px; padding: 12px 15px; border-radius: 8px; color: var(--muted); text-decoration: none; }
        .nav-link i { width: 20px; }
        .nav-link:hover, .nav-link.active { color: #fff; background: rgba(255,255,255,.05); }
        .nav-link.active { color: var(--blue); background: rgba(0,123,255,.1); border: 1px solid rgba(0,123,255,.2); }
        .logout-btn { margin-top: auto; width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; background: transparent; color: var(--muted); text-align: left; }
        .logout-btn:hover { color: #ff4d4d; border-color: #ff4d4d; background: rgba(220,53,69,.1); }
        .edit-main { margin-left: 260px; padding: 35px 40px; }
        .edit-page { max-width: 1050px; margin: 0 auto; }
        .page-top { display: flex; align-items: center; justify-content: space-between; gap: 20px; margin-bottom: 25px; }
        .page-title { margin: 0; font-size: 1.6rem; font-weight: 700; }
        .edit-card { padding: 28px; background: var(--panel); border: 1px solid var(--border); border-radius: 12px; }
        .form-label { color: #c9d1d9; font-size: .9rem; font-weight: 600; }
        .form-control, .form-select { background: var(--input); border: 1px solid var(--border); color: #fff; min-height: 44px; }
        .form-control:focus, .form-select:focus { background: var(--input); color: #fff; border-color: var(--blue); box-shadow: none; }
        .form-select option { background: var(--input); }
        .variant-row { padding: 15px; margin-bottom: 12px; border: 1px solid #315372; border-radius: 8px; background: #102438; }
        .mobile-preview { width: 110px; height: 85px; margin-top: 8px; border: 1px solid #315372; border-radius: 6px; object-fit: contain; background: #081625; }
        .btn-primary { background: var(--blue); border: 0; }
        @media (max-width: 767px) { .sidebar { width: 220px; transform: translateX(-100%); } .edit-main { margin-left: 0; padding: 20px 12px; } .edit-card { padding: 18px; } .page-top { align-items: flex-start; flex-direction: column; } }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="brand-section">
            <img src="{{ $settings->app_icon ?? '' }}" alt="Logo" class="brand-logo-img">
            <span class="brand-name">{{ $settings->app_icon ? '' : ($settings->app_name ?? 'Alfa Mobiles') }}</span>
            <span class="admin-badge">Admin</span>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-shopping-cart"></i> Orders</a>
            <a class="nav-link" href="{{ route('admin.dashboard') }}#refunds"><i class="fas fa-undo"></i> Refund Requests</a>
            <a class="nav-link" href="{{ route('admin.dashboard') }}#brands"><i class="fas fa-tags"></i> Brands, Series & Storage</a>
            <a class="nav-link active" href="{{ route('admin.dashboard') }}#mobiles"><i class="fas fa-mobile-alt"></i> Mobiles</a>
            <a class="nav-link" href="{{ route('admin.dashboard') }}#settings"><i class="fas fa-cog"></i> Website Settings</a>
            <a class="nav-link" href="{{ route('admin.dashboard') }}#security"><i class="fas fa-lock"></i> Security</a>
        </nav>
        <form action="{{ route('admin.logout') }}" method="POST" class="mt-auto">
            @csrf
            <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
        </form>
    </aside>
    <main class="edit-main">
      <div class="edit-page">
        <div class="page-top">
            <h1 class="page-title"><i class="fas fa-pencil-alt text-warning me-2"></i>Edit Mobile Phone</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light"><i class="fas fa-arrow-left me-2"></i>Back to Dashboard</a>
        </div>

        <div class="edit-card">
            <form action="{{ route('admin.mobiles.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $mobile->id }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Brand</label>
                        <select name="brand_id" id="brand_select" class="form-select" required>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ $mobile->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Series</label>
                        <select name="series_id" id="series_select" class="form-select">
                            <option value="">Select Series</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Model Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $mobile->name }}" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Storage, Price & Status Variants</label>
                        <div id="variants"></div>
                        <button type="button" class="btn btn-outline-info btn-sm" onclick="addVariant()"><i class="fas fa-plus me-1"></i>Add Storage Variant</button>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Update Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this)">
                        <img id="imagePreview" class="mobile-preview {{ $mobile->image_url ? '' : 'd-none' }}" src="{{ $mobile->image_url ?? '' }}" alt="Mobile preview">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Available Colors</label>
                        <input type="text" name="colors" class="form-control" value="{{ $mobile->colors ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Specs Summary</label>
                        <textarea name="specs" class="form-control" rows="3">{{ $mobile->specs ?? '' }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-2"></i>Update Mobile</button>
                </div>
            </form>
        </div>
            </div>
        </main>

    <script>
        const allSeries = @json($series);
        const allStorages = @json($storages);
        const existingVariants = @json($variants);
        const selectedSeriesId = @json($mobile->series_id);

        function updateSeries() {
            const selectedBrand = document.getElementById('brand_select').value;
            const seriesSelect = document.getElementById('series_select');
            seriesSelect.innerHTML = '<option value="">Select Series</option>';
            allSeries.filter(series => series.brand_id == selectedBrand).forEach(series => {
                seriesSelect.innerHTML += `<option value="${series.id}" ${series.id == selectedSeriesId ? 'selected' : ''}>${series.name}</option>`;
            });
        }

        function addVariant(variant = {}) {
            const container = document.getElementById('variants');
            const index = container.querySelectorAll('.variant-row').length;
            const storageOptions = allStorages.map(storage => `<option value="${storage.id}" ${storage.id == (variant.storage_id || '') ? 'selected' : ''}>${storage.name}</option>`).join('');
            const row = document.createElement('div');
            row.className = 'variant-row row g-2 align-items-end';
            row.innerHTML = `
                <div class="col-md-4"><label class="form-label small">Storage</label><select name="variants[${index}][storage_id]" class="form-select" required><option value="">Select Storage</option>${storageOptions}</select></div>
                <div class="col-md-3"><label class="form-label small">Status</label><select name="variants[${index}][status]" class="form-select"><option value="" ${!variant.status ? 'selected' : ''}>Standard</option><option value="pta" ${variant.status === 'pta' ? 'selected' : ''}>PTA</option><option value="non-pta" ${variant.status === 'non-pta' ? 'selected' : ''}>Non-PTA</option><option value="jv" ${variant.status === 'jv' ? 'selected' : ''}>JV</option></select></div>
                <div class="col-md-3"><label class="form-label small">Price (Rs.)</label><input type="text" name="variants[${index}][price]" class="form-control" value="${variant.price || ''}" required></div>
                <div class="col-md-2"><button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.variant-row').remove()"><i class="fas fa-trash"></i></button></div>`;
            container.appendChild(row);
        }

        function previewImage(input) {
            if (!input.files || !input.files[0]) return;
            const preview = document.getElementById('imagePreview');
            preview.src = URL.createObjectURL(input.files[0]);
            preview.classList.remove('d-none');
        }

        updateSeries();
        if (existingVariants.length) existingVariants.forEach(addVariant);
        else addVariant({storage_id: @json($mobile->storage_id), price: @json($mobile->price), status: @json($mobile->status)});
        document.getElementById('brand_select').addEventListener('change', updateSeries);
    </script>
</body>
</html>
