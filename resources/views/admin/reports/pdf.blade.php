<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تقرير {{ ucfirst($type) }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            direction: rtl;
            text-align: center;
            font-size: 14px;
        }
        h1, h3 {
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #4A90E2;
            color: white;
            padding: 8px;
            border: 1px solid #ccc;
        }
        td {
            border: 1px solid #ccc;
            padding: 6px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .header {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>تقرير {{ ucfirst($type) }}</h1>
    @if($from && $to)
        <h3>من {{ $from }} إلى {{ $to }}</h3>
    @elseif($from)
        <h3>من {{ $from }}</h3>
    @elseif($to)
        <h3>حتى {{ $to }}</h3>
    @endif
</div>

<table>
    <thead>
    <tr>
        @if($type=='invoices')
            <th>#</th>
            <th>العميل</th>
            <th>المجموع</th>
            <th>تاريخ الفاتورة</th>
        @elseif($type=='purchases')
            <th>المنتج</th>
            <th>المورد</th>
            <th>الكمية</th>
            <th>السعر</th>
            <th>تاريخ الشراء</th>
        @elseif($type=='stock')
            <th>المنتج</th>
            <th>الكمية المتوفرة</th>
            <th>السعر</th>
        @elseif($type=='customers')
            <th>اسم العميل</th>
            <th>عدد الفواتير</th>
            <th>آخر فاتورة</th>
        @endif
    </tr>
    </thead>
    <tbody>
    @foreach($data as $item)
        <tr>
            @if($type=='invoices')
                <td>{{ $item->id }}</td>
                <td>{{ $item->customer->name ?? '-' }}</td>
                <td>{{ $item->total }}</td>
                <td>{{ $item->invoice_date }}</td>
            @elseif($type=='purchases')
                <td>{{ $item->product->name ?? '-' }}</td>
                <td>{{ $item->supplier }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->purchase_date }}</td>
            @elseif($type=='stock')
                <td>{{ $item->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->price }}</td>
            @elseif($type=='customers')
                <td>{{ $item->name }}</td>
                <td>{{ $item->invoices_count }}</td>
                <td>{{ optional($item->invoices->last())->invoice_date ?? '-' }}</td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
