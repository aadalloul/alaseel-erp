@extends('layouts.admin')

@section('title', 'المشتريات')

@section('header-button')
    <a href="{{ route('purchases.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full shadow-lg hover:scale-105 transition">
        <i class="fa fa-plus"></i> إضافة مشتريات
    </a>
@endsection

@section('content')
    <!-- كروت إحصائية -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-gray-50 rounded-2xl shadow-lg p-6 flex justify-between items-center">
            <div>
                <h3 class="text-gray-500 text-sm">إجمالي المشتريات</h3>
                <p class="text-2xl font-bold">{{ $purchasesCount ?? 0 }}</p>
            </div>
            <i class="fa fa-cart-plus text-blue-600 text-4xl"></i>
        </div>
        <div class="bg-gray-50 rounded-2xl shadow-lg p-6 flex justify-between items-center">
            <div>
                <h3 class="text-gray-500 text-sm">مشتريات مكتملة</h3>
                <p class="text-2xl font-bold">{{ $completedPurchases ?? 0 }}</p>
            </div>
            <i class="fa fa-check-circle text-green-600 text-4xl"></i>
        </div>
        <div class="bg-gray-50 rounded-2xl shadow-lg p-6 flex justify-between items-center">
            <div>
                <h3 class="text-gray-500 text-sm">مشتريات معلقة</h3>
                <p class="text-2xl font-bold">{{ $pendingPurchases ?? 0 }}</p>
            </div>
            <i class="fa fa-hourglass-half text-yellow-600 text-4xl"></i>
        </div>
    </div>

    <!-- جدول المشتريات -->
    <div class="overflow-x-auto">
        <table class="w-full text-right table-auto bg-white rounded-xl shadow-lg">
            <thead class="bg-gray-200 text-gray-700 uppercase text-sm">
            <tr>
                <th class="p-4">#</th>
                <th class="p-4">اسم المنتج</th>
                <th class="p-4">المورد</th>
                <th class="p-4">الكمية</th>
                <th class="p-4">التاريخ</th>
                <th class="p-4">الإجراءات</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($purchases as $purchase)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="p-4">{{ $purchase->id }}</td>
                    <td class="p-4">{{ $purchase->product->name ?? '' }}</td>
                    <td class="p-4">{{ $purchase->supplier ?? '' }}</td>
                    <td class="p-4">{{ $purchase->quantity }}</td>
                    <td class="p-4">{{ $purchase->created_at->format('d/m/Y') }}</td>
                    <td class="p-4 flex gap-2">
                        <a href="{{ route('purchases.edit', $purchase->id) }}"
                           class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 transition">
                            <i class="fa fa-edit"></i> تعديل
                        </a>
                        <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">
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
