<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <title>Payment Receipt</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .receipt-container {
            width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .logo img {
            width: 90px;
        }

        .company {
            font-size: 14px;
        }

        .company h2 {
            margin: 0;
            color: #222;
        }

        .receipt-info {
            text-align: right;
            font-size: 14px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section h4 {
            margin-bottom: 8px;
            border-bottom: 1px solid #eee;
            padding-bottom: 4px;
        }

        .customer p {
            margin: 3px 0;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #f3f3f3;
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .total-row td {
            font-weight: bold;
            font-size: 16px;
            background: #fafafa;
        }

        .footer {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
        }

        @media print {

            body {
                margin: 0;
            }

            .receipt-container {
                border: none;
            }

        }
    </style>

</head>

<body onload="window.print()">

    <div class="receipt-container">

        <!-- Header -->
        <div class="header">

            <div class="logo">

                <img src="{{ asset('assets/logo/renew_1.png') }}">

            </div>

            <div class="company">

                <h2>Renew Plus Hair & Skin Care</h2>

                <p>{{ $payment->branch_location }}, {{ $payment->branch_name }}, India</p>

                <p>📞 +91 {{ $payment->branch_phone }}</p>

                <p>✉ {{ $payment->branch_email }}</p>

            </div>

            <div class="receipt-info">

                <strong>PAYMENT RECEIPT</strong>

                <p>Receipt No : {{ $payment->receipt_no }}</p>

                <p>Date : {{ $payment->payment_date }}</p>

            </div>

        </div>

        <!-- Customer Info -->
        <div class="section customer">

            <h4>Billed To</h4>

            <p><strong>Name:</strong> {{ $payment->customer_first_name }}</p>

            <p><strong>Phone:</strong> {{ $payment->customer_phone }}</p>

            <p><strong>Email:</strong> {{ $payment->customer_email }}</p>

            <p><strong>Address:</strong> {{ $payment->customer_address }}</p>

        </div>

        <!-- Service Table -->
        <div class="section">

            <table>

                <thead>

                    <tr>
                        <th>#</th>
                        <th>Service / Treatment</th>
                        <th>Amount</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach ($treatments as $key => $t)
                        <tr>

                            <td>{{ $key + 1 }}</td>

                            <td>{{ $t->treatment_name }}</td>

                            <td>₹{{ number_format($payment->amount, 2) }}</td>

                        </tr>
                    @endforeach

                </tbody>

                <tfoot>

                    <tr class="total-row">

                        <td colspan="2" align="right">Total</td>

                        <td>₹{{ number_format($payment->amount, 2) }}</td>

                    </tr>

                </tfoot>

            </table>

        </div>

        <!-- Footer -->
        <div class="footer">

            <p>Thank you for choosing <strong>Renew Plus Hair & Skin Care</strong></p>

            <p>This is a computer generated receipt</p>

        </div>

    </div>

</body>

</html>
