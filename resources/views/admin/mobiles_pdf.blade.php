<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $brand->name }} - Mobile List</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #333; }
        .header p { margin: 5px 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f4f4f4; color: #333; }
        tr:nth-child(even) { background-color: #fafafa; }
        .footer { margin-top: 30px; text-align: center; font-size: 0.8rem; color: #999; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer; background: #007bff; color: white; border: none; border-radius: 5px;">Print / Save as PDF</button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer; background: #6c757d; color: white; border: none; border-radius: 5px; margin-left: 10px;">Close</button>
    </div>

    <div class="header">
        <h1>{{ $brand->name }} Mobiles</h1>
        <p>Generated on: {{ date('d M, Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Mobile Model Name</th>
                <th>Price (Rs.)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mobiles as $index => $mobile)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $mobile->name }}</td>
                <td>{{ number_format((float)str_replace(',', '', $mobile->price)) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        &copy; {{ date('Y') }} Alfa Mobiles Official. All rights reserved.
    </div>

    <script>
        // Auto trigger print dialog
        window.onload = function() {
            // window.print();
        }
    </script>
</body>
</html>
