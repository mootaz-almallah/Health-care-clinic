{{-- OrderController --}}


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 14px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #0d6efd;
            margin-bottom: 10px;
        }
        .invoice-details {
            margin-bottom: 30px;
        }
        .invoice-details table {
            width: 100%;
        }
        .invoice-details td {
            padding: 5px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th, .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .items-table th {
            background-color: #f8f9fa;
        }
        .total-section {
            text-align: right;
            margin-top: 20px;
        }
        .total-section table {
            width: 300px;
            margin-left: auto;
        }
        .total-section td {
            padding: 5px;
        }
        .total-section .total-row {
            font-weight: bold;
            border-top: 2px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Health Pulse</h1>
        <h2>Invoice #{{ $order->id }}</h2>
    </div>

    <div class="invoice-details">
        <table>
            <tr>
                <td><strong>Date:</strong> {{ $date }}</td>
                <td><strong>Order ID:</strong> #{{ $order->id }}</td>
            </tr>
            <tr>
                <td><strong>Customer:</strong> {{ $user->name }}</td>
                <td><strong>Status:</strong> {{ ucfirst($order->status) }}</td>
            </tr>
            <tr>
                <td><strong>Email:</strong> {{ $user->email }}</td>
                <td><strong>Payment Method:</strong> {{ $order->payment_method ?? 'Cash on Delivery' }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Address:</strong> {{ $user->address }}</td>
            </tr>
        </table>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $item->pharma->name }}</td>
                <td>${{ number_format($item->price, 2) }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <table>
            <tr>
                <td>Subtotal:</td>
                <td>${{ number_format($order->total_amount - 5, 2) }}</td>
            </tr>
            <tr>
                <td>Shipping Fee:</td>
                <td>$5.00</td>
            </tr>
            <tr class="total-row">
                <td>Total:</td>
                <td>${{ number_format($order->total_amount, 2) }}</td>
            </tr>
        </table>
    </div>

    <div style="margin-top: 50px; text-align: center; font-size: 12px; color: #666;">
        <p>Thank you for your purchase!</p>
        <p>This is a computer-generated invoice, no signature required.</p>
    </div>
</body>
</html> 