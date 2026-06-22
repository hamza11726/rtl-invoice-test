<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'DejaVu Sans';
            direction: rtl;
            text-align: right;
        }

        .header {
            width: 100%;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 10px;
            text-align: center;
        }

        .total-box {
            margin-top: 20px;
            width: 300px;
            float: left;
        }

        .total-box td {
            border: none;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>
            نظام الفواتير
        </h2>
        <h3>
            فاتورة رقم:
            {{ $invoice->invoice_no }}
        </h3>
        <p>
            العميل:
            {{ $invoice->customer->name }}
        </p>
        <p>
            التاريخ:
            {{ $invoice->created_at->format('Y-m-d') }}
        </p>
    </div>
    <table>
        <thead>
            <tr>
                <th>
                    الصنف
                </th>
                <th>
                    الكمية
                </th>
                <th>
                    السعر
                </th>
                <th>
                    الخصم
                </th>
                <th>
                    الضريبة
                </th>
                <th>
                    الإجمالي
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $item)
                <tr>
                    <td>
                        {{ $item->item_name }}
                    </td>
                    <td>
                        {{ $item->qty }}
                    </td>
                    <td>
                        {{ $item->unit_price }}
                    </td>
                    <td>
                        {{ $item->discount }}
                    </td>
                    <td>
                        {{ $item->tax }}
                    </td>
                    <td>
                        {{ $item->total }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="total-box">
        <tr>
            <td>
                المجموع الفرعي
            </td>
            <td>
                {{ $invoice->subtotal }}
            </td>
        </tr>
        <tr>
            <td>
                الخصم
            </td>
            <td>
                {{ $invoice->discount }}
            </td>
        </tr>
        <tr>
            <td>
                الضريبة
            </td>
            <td>
                {{ $invoice->tax }}
            </td>
        </tr>
        <tr>
            <td>
                الإجمالي النهائي
            </td>
            <td>
                {{ $invoice->grand_total }}
            </td>
        </tr>
    </table>
</body>

</html>
