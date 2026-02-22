@extends('layouts.admin')

@section('title', 'الفواتير')

@section('header-button')
    <a href="{{ route('invoices.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full shadow-lg hover:scale-105 transition">
        <i class="fa fa-plus"></i> إضافة فاتورة
    </a>
@endsection

@section('content')
    <!-- كروت إحصائية -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-gray-50 rounded-2xl shadow-lg p-6 flex justify-between items-center">
            <div>
                <h3 class="text-gray-500 text-sm">إجمالي الفواتير</h3>
                <p class="text-2xl font-bold">{{ $invoicesCount ?? 0 }}</p>
            </div>
            <i class="fa fa-file-invoice text-blue-600 text-4xl"></i>
        </div>
        <div class="bg-gray-50 rounded-2xl shadow-lg p-6 flex justify-between items-center">
            <div>
                <h3 class="text-gray-500 text-sm">فواتير مدفوعة</h3>
                <p class="text-2xl font-bold">{{ $paidInvoices ?? 0 }}</p>
            </div>
            <i class="fa fa-check-circle text-green-600 text-4xl"></i>
        </div>
        <div class="bg-gray-50 rounded-2xl shadow-lg p-6 flex justify-between items-center">
            <div>
                <h3 class="text-gray-500 text-sm">فواتير غير مدفوعة</h3>
                <p class="text-2xl font-bold">{{ $unpaidInvoices ?? 0 }}</p>
            </div>
            <i class="fa fa-times-circle text-red-600 text-4xl"></i>
        </div>
    </div>

    <!-- جدول الفواتير -->
    <div class="overflow-x-auto">
        <table class="w-full text-right table-auto bg-white rounded-xl shadow-lg">
            <thead class="bg-gray-200 text-gray-700 uppercase text-sm">
            <tr>
                <th class="p-4">#</th>
                <th class="p-4">رقم الفاتورة</th>
                <th class="p-4">العميل</th>
                <th class="p-4">المبلغ</th>
                <th class="p-4">الحالة</th>
                <th class="p-4">تاريخ الإنشاء</th>
                <th class="p-4">الإجراءات</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($invoices as $invoice)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="p-4">{{ $invoice->id }}</td>
                    <td class="p-4 font-semibold">{{ $invoice->invoice_number }}</td>
                    <td class="p-4">{{ $invoice->customer->name ?? '' }}</td>
                    <td class="p-4">{{ $invoice->amount }} $</td>
                    <td class="p-4">
                        @if($invoice->status == 'paid')
                            <span class="text-green-600 font-semibold">مدفوعة</span>
                        @else
                            <span class="text-red-600 font-semibold">غير مدفوعة</span>
                        @endif
                    </td>
                    <td class="p-4">{{ $invoice->created_at->format('d/m/Y') }}</td>
                    <td class="p-4 flex gap-2">
                        <a href="{{ route('invoices.edit', $invoice->id) }}"
                           class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 transition">
                            <i class="fa fa-edit"></i> تعديل
                        </a>
                        <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST">
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
