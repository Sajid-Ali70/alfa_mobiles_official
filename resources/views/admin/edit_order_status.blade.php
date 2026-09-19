<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order Status - {{ $settings->app_name ?? 'Alfa Mobiles' }}</title>
    <link rel="icon" type="image/png" href="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --bg-color: #0b0e14;
            --card-bg: #161b22;
            --text-main: #ffffff;
            --text-secondary: #8b949e;
            --accent-blue: #007bff;
            --border-color: #30363d;
        }
        body { background-color: var(--bg-color); color: var(--text-main); font-family: 'Segoe UI', sans-serif; padding: 40px 20px; }
        .container-box { max-width: 800px; margin: 0 auto; background: var(--card-bg); padding: 30px; border-radius: 12px; border: 1px solid var(--border-color); }
        .form-label { color: var(--text-secondary); font-weight: 600; margin-bottom: 8px; }
        .form-control, .form-select { background: #0d1117; border: 1px solid var(--border-color); color: white; padding: 12px; }
        .form-control:focus, .form-select:focus { background: #0d1117; border-color: var(--accent-blue); color: white; box-shadow: none; }
        .btn-update { background: var(--accent-blue); color: white; border: none; padding: 12px 30px; border-radius: 8px; font-weight: 700; width: 100%; }
        .back-link { color: var(--text-secondary); text-decoration: none; display: flex; align-items: center; gap: 8px; margin-bottom: 20px; font-weight: 500; }
        .back-link:hover { color: white; }
        .order-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; padding: 20px; background: rgba(255,255,255,0.02); border-radius: 8px; }
        .info-item label { display: block; font-size: 0.75rem; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 4px; }
        .info-item span { font-weight: 600; font-size: 1rem; }
        .alert-success { background: rgba(40, 167, 69, 0.1); border: 1px solid #28a745; color: #28a745; border-radius: 8px; }
        #riderInfoFields { display: none; margin-top: 20px; padding: 20px; border: 1px solid var(--border-color); border-radius: 8px; background: rgba(255,255,255,0.01); }
    </style>
</head>
<body>

    <div class="container-box">
        <a href="{{ route('admin.dashboard') }}" class="back-link"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>

        <h2 class="mb-4">Update Order Status</h2>

        @if(session('success'))
            <div class="alert alert-success mb-4">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="order-info-grid">
            <div class="info-item"><label>Order Number</label><span>#{{ $order->order_number }}</span></div>
            <div class="info-item"><label>Customer Name</label><span>{{ $order->full_name }}</span></div>
            <div class="info-item"><label>Mobile Phone</label><span>{{ $mobile->name ?? 'N/A' }}</span></div>
            <div class="info-item"><label>Customer Email</label><span class="text-info">{{ $order->email }}</span></div>
        </div>

        <form action="{{ route('admin.orders.submit_status', $order->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="form-label">Current Status: <span class="badge bg-primary ms-2">{{ $order->status }}</span></label>
                <select name="status" id="statusSelect" class="form-select mt-2" required>
                    @php
                        $statuses = [
                            "Waiting for Approval",
                            "Initial Verification",
                            "Verification Completed",
                            "Order Approved",
                            "Mobile Dispatched",
                            "Parcel in Transit",
                            "Parcel Delivered Successfully",
                            "First Installment Due",
                            "Cancelled - Wrong Screenshot Attached",
                            "Cancelled - Verification Not Completed"
                        ];
                    @endphp
                    @foreach($statuses as $index => $statusValue)
                        <option value="{{ $statusValue }}" {{ $order->status == $statusValue ? 'selected' : '' }}>
                            {{ $index < 8 ? ($index + 1) . ". " : "" }}{{ $statusValue }}
                        </option>
                    @endforeach

                    @if(!in_array($order->status, $statuses))
                        <option value="{{ $order->status }}" selected>{{ $order->status }} (Current)</option>
                    @endif
                </select>
            </div>

            <!-- Rider Info Fields -->
            <div id="riderInfoFields">
                <h5 class="mb-3 text-info"><i class="fas fa-truck me-2"></i> Rider Information</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Rider Name</label>
                        <input type="text" name="rider_name" class="form-control" value="{{ $order->rider_name ?? '' }}" placeholder="Enter Rider Name">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Rider Phone Number</label>
                        <input type="text" name="rider_phone" class="form-control" value="{{ $order->rider_phone ?? '' }}" placeholder="Enter Rider Phone">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-update mt-3">
                Update Status & Send Email Notification
            </button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('statusSelect');
            const riderFields = document.getElementById('riderInfoFields');

            function toggleRiderFields() {
                if (statusSelect.value === 'Mobile Dispatched') {
                    riderFields.style.display = 'block';
                } else {
                    riderFields.style.display = 'none';
                }
            }

            statusSelect.addEventListener('change', toggleRiderFields);
            toggleRiderFields(); // Initial check
        });
    </script>

</body>
</html>
