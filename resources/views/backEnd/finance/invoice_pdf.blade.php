<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student Invoice</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            font-family: 'dejavu sans', sans-serif;
        }

        .container {
            width: 100%;
            padding: 30px;
            background: #fff;
        }

        .text-start {
            text-align: left;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .main-title {
            font-size: 14px;
            color: #3c4e7a;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 12px;
            color: #333;
        }

        .table th {
            background: #f5f5f5;
        }

        .invoice-header {
            width: 100%;
            margin-bottom: 20px;
        }

        .invoice-header td {
            padding: 5px 0;
        }

        .water-mark {
            position: absolute;
            bottom: 50px;
            opacity: 0.1;
            transform: rotate(15deg);
            width: 100%;
        }

        .water-mark img {
            width: 100%;
        }

        .summary-table {
            width: 100%;
            margin-top: 20px;
        }

        .summary-table td {
            padding: 8px;
        }

        .summary-table .text-end {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="">
        <div class="water-mark">
            <img src="{{ asset('/uploads/settings/logo.png') }}" alt="logo">
        </div>

        <!-- Invoice Header -->
        <table class="invoice-header">
            <tr>
                <td class="text-start">
                    <img src="{{ asset('/uploads/settings/logo.png') }}" width="150" alt="logo">
                </td>
                <td class="text-end">
                    <h4 class="mb-0 text-uppercase">Invoice NO.</h4>
                    <p class="mb-0">{{ $finance_invoice->invoice_number }}</p>
                </td>
            </tr>
        </table>

        <hr>

        <!-- Invoice Details -->
        <table class="invoice-header">
            <tr>
                <td class="text-start"><strong class="main-title">Date:</strong> {{ $finance_invoice->created_at->format('Y-m-d') }}</td>
                <td class="text-end"><strong class="main-title">Invoice No:</strong> {{ $finance_invoice->invoice_number }}</td>
            </tr>
        </table>

        <hr>

        <!-- Billing Information -->
        <table class="invoice-header">
            <tr>
                <td class="text-start">
                    <strong class="main-title">Invoiced To:</strong>
                    <address>
                        Full Name: {{ $finance_invoice->student->full_name }}<br>
                        Email: {{ $finance_invoice->student->email }}<br>
                        Phone: {{ $finance_invoice->student->mobile }}<br>
                        Address: {{ $finance_invoice->student->current_address }}<br>
                    </address>
                </td>
                <td class="text-end">
                    <strong class="main-title">Refund Policy:</strong>
                    <address>
                    
                        - Full refund if cancellation is made 7 days before the course start date.<br>
                        - 50% refund if within the first 7 days of the course.<br>
                        - No refund after the first week of the course.<br>
                        - Non-refundable registration, administrative, and material fees.<br>
                    </address>
                </td>
            </tr>
        </table>

        <!-- Invoice Table -->
        <table class="table">
            <thead>
                <tr>
                    <th class="text-start">Course Name</th>
                    <th class="text-end">Levels</th>
                    <th class="text-end">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-start">{{ $finance_invoice->staff_scheduled->course_name_en }}</td>
                    <td class="text-end">{{ $finance_invoice->levels_id }}</td>
                    <td class="text-end">
                        {{ $finance_invoice->staff_scheduled->trackType->track_pricing_plans[0]->price }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Summary Section -->
        @php
            $total_price = $finance_invoice->staff_scheduled->trackType->track_pricing_plans[0]->price;
            $total_tax_amount = ($total_price * 14) / 100;
            $total_price_after_tax = $total_price + $total_tax_amount;
        @endphp

        <table class="summary-table">
            <tr>
                <td><strong class="main-title">Sub Total:</strong></td>
                <td class="text-end">{{ $total_price }}</td>
            </tr>
            <tr>
                <td><strong class="main-title">Tax (14%):</strong></td>
                <td class="text-end">{{ $total_tax_amount }}</td>
            </tr>
            <tr>
                <td><strong class="main-title">Total:</strong></td>
                <td class="text-end">{{ $total_price_after_tax }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
