@extends('layouts.admin')

@section('title', 'المنتجات')

@section('header-button')
    <a href="{{ route('products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-full shadow-lg hover:scale-105 transition">
        <i class="fa fa-plus"></i> إضافة منتج
    </a>
@endsection

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gray-50 rounded-2xl shadow-lg p-6 flex justify-between items-center">
            <div>
                <h3 class="text-gray-500 text-sm">إجمالي المنتجات</h3>
                <p class="text-2xl font-bold">{{ $productsCount ?? 0 }}</p>
            </div>
            <i class="fa fa-box text-blue-600 text-4xl"></i>
        </div>
        <div class="bg-gray-50 rounded-2xl shadow-lg p-6 flex justify-between items-center">
            <div>
                <h3 class="text-gray-500 text-sm">منتجات متاحة</h3>
                <p class="text-2xl font-bold">{{ $availableProducts ?? 0 }}</p>
            </div>
            <i class="fa fa-check-circle text-green-600 text-4xl"></i>
        </div>
        <div class="bg-gray-50 rounded-2xl shadow-lg p-6 flex justify-between items-center">
            <div>
                <h3 class="text-gray-500 text-sm">منتجات منتهية</h3>
                <p class="text-2xl font-bold">{{ $expiredProducts ?? 0 }}</p>
            </div>
            <i class="fa fa-times-circle text-red-600 text-4xl"></i>
        </div>
    </div>

    <!-- جدول المنتجات -->
    <div class="overflow-x-auto bg-white rounded-3xl shadow-2xl p-6">
        <table class="w-full text-right table-auto">
            <thead class="bg-gray-200 text-gray-700 uppercase text-sm">
            <tr>
                <th class="p-4">#</th>
                <th class="p-4">اسم المنتج</th>
                <th class="p-4">السعر</th>
                <th class="p-4">الكمية</th>
                <th class="p-4">الحالة</th>
                <th class="p-4">الإجراءات</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="p-4">{{ $product->id }}</td>
                    <td class="p-4 font-semibold">{{ $product->name }}</td>
                    <td class="p-4">{{ $product->price }} $</td>
                    <td class="p-4">{{ $product->quantity }}</td>
                    <td class="p-4">
                        @if($product->quantity > 0)
                            <span class="text-green-600 font-semibold">متاح</span>
                        @else
                            <span class="text-red-600 font-semibold">منتهي</span>
                        @endif
                    </td>
                    <td class="p-4 flex gap-2">
                        <a href="{{ route('products.edit', $product->id) }}"
                           class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 transition">
                            <i class="fa fa-edit"></i> تعديل
                        </a>
                         <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                    class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition delete-button">
                                <i class="fa fa-trash"></i> حذف
                            </button>
                        </form>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
