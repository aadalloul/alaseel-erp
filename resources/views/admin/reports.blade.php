@extends('layouts.admin')

@section('title', 'التقارير')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-gray-50 rounded-2xl shadow-lg p-6">
            <h3 class="text-gray-500 text-sm mb-2">إجمالي العملاء</h3>
            <p class="text-2xl font-bold">{{ $customersCount ?? 0 }}</p>
        </div>
        <div class="bg-gray-50 rounded-2xl shadow-lg p-6">
            <h3 class="text-gray-500 text-sm mb-2">إجمالي المنتجات</h3>
            <p class="text-2xl font-bold">{{ $productsCount ?? 0 }}</p>
        </div>
        <div class="bg-gray-50 rounded-2xl shadow-lg p-6">
            <h3 class="text-gray-500 text-sm mb-2">إجمالي الفواتير</h3>
            <p class="text-2xl font-bold">{{ $invoicesCount ?? 0 }}</p>
        </div>
    </div>

    <!-- مثال على رسم بياني -->
    <div class="bg-white rounded-3xl shadow-2xl p-6">
        <h3 class="text-gray-700 font-bold mb-4">مبيعات آخر شهر</h3>
        <div id="chart" class="h-64">
            <!-- يمكنك إضافة مكتبة Chart.js هنا -->
        </div>
    </div>
@endsection
