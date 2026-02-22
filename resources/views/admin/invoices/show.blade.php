@extends('layouts.admin')

@section('title', 'عرض الفاتورة')

@section('header-button')
    <a href="{{ route('invoices.index') }}"
       class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-full shadow-lg transition">
        <i class="fa fa-arrow-right"></i> رجوع
    </a>
    <button onclick="window.print()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-full shadow-lg transition ml-2">
        <i class="fa fa-print"></i> طباعة
    </button>
@endsection

@section('content')

    <div class="bg-white p-6 rounded-2xl shadow">

        <!-- اسم الشركة -->
        <div class="text-center mb-6">
            <h1 class="text-4xl font-bold text-gray-700">Tajj Mall</h1>
            <p class="text-lg text-gray-500">شركة التسوق الأفضل في المدينة</p>
        </div>

        <!-- معلومات الفاتورة -->
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="font-bold">اسم العميل:</h3>
                <p>{{ $invoice->customer->name }}</p>
            </div>
            <div>
                <h3 class="font-bold">تاريخ الفاتورة:</h3>
                <p>{{ $invoice->invoice_date->format('Y-m-d') }}</p>
            </div>
        </div>

        <!-- جدول المنتجات -->
        <table class="w-full border-collapse border border-gray-300 mb-6">
            <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 p-3 text-left">المنتج</th>
                <th class="border border-gray-300 p-3 text-center">الكمية</th>
                <th class="border border-gray-300 p-3 text-right">السعر للوحدة (₪)</th>
                <th class="border border-gray-300 p-3 text-right">المجموع (₪)</th>
            </tr>
            </thead>
            <tbody>
            @php $total = 0; @endphp
            @foreach($invoice->products as $product)
                @php $subtotal = $product->pivot->quantity * $product->price; @endphp
                <tr>
                    <td class="border border-gray-300 p-3">{{ $product->name }}</td>
                    <td class="border border-gray-300 p-3 text-center">{{ $product->pivot->quantity }}</td>
                    <td class="border border-gray-300 p-3 text-right">{{ number_format($product->price, 2) }}</td>
                    <td class="border border-gray-300 p-3 text-right">{{ number_format($subtotal, 2) }}</td>
                </tr>
                @php $total += $subtotal; @endphp
            @endforeach
            </tbody>
            <tfoot>
            <tr class="bg-gray-100">
                <th colspan="3" class="border border-gray-300 p-3 text-right">المجموع الكلي</th>
                <th class="border border-gray-300 p-3 text-right">{{ number_format($total, 2) }} ₪</th>
            </tr>
            </tfoot>
        </table>

    </div>

@endsection
