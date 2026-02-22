@extends('layouts.admin')

@section('title', 'الفواتير')

@section('header-button')
    <a href="{{ url('/invoices/create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-full shadow-lg hover:scale-105 transition">
        <i class="fa fa-plus"></i> فاتورة جديدة
    </a>
@endsection

@section('content')

    {{-- Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gray-50 rounded-2xl shadow-lg p-6 flex justify-between items-center">
            <div>
                <h3 class="text-gray-500 text-sm">عدد الفواتير</h3>
                <p class="text-2xl font-bold">{{ $invoices->count() }}</p>
            </div>
            <i class="fa fa-file-invoice text-blue-600 text-4xl"></i>
        </div>

        <div class="bg-gray-50 rounded-2xl shadow-lg p-6 flex justify-between items-center">
            <div>
                <h3 class="text-gray-500 text-sm">إجمالي المبيعات</h3>
                <p class="text-2xl font-bold">{{ number_format($invoices->sum('total'),2) }} ₪</p>
            </div>
            <i class="fa fa-coins text-green-600 text-4xl"></i>
        </div>

        <div class="bg-gray-50 rounded-2xl shadow-lg p-6 flex justify-between items-center">
            <div>
                <h3 class="text-gray-500 text-sm">متوسط الفاتورة</h3>
                <p class="text-2xl font-bold">
                    {{ $invoices->count() ? number_format($invoices->avg('total'),2) : 0 }} ₪
                </p>
            </div>
            <i class="fa fa-chart-line text-purple-600 text-4xl"></i>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto bg-white rounded-3xl shadow-2xl p-6">
        <table class="w-full text-right table-auto">
            <thead class="bg-gray-200 text-gray-700 uppercase text-sm">
            <tr>
                <th class="p-4">#</th>
                <th class="p-4">العميل</th>
                <th class="p-4">الإجمالي</th>
                <th class="p-4">التاريخ</th>
                <th class="p-4">الإجراءات</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($invoices as $invoice)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="p-4">{{ $invoice->id }}</td>
                    <td class="p-4 font-semibold">{{ $invoice->customer->name }}</td>
                    <td class="p-4">{{ number_format($invoice->total,2) }} ₪</td>
                    <td class="p-4">{{ date('d/m/Y', strtotime($invoice->date)) }}</td>
                    <td class="p-4 flex gap-2">

                        <a href="{{ url('/invoices/'.$invoice->id) }}"
                           class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                            <i class="fa fa-eye"></i> عرض
                        </a>
                        <a href="{{ url('/invoices/'.$invoice->id.'/edit') }}"
                           class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 transition">
                            <i class="fa fa-edit"></i> تعديل
                        </a>
                        <form action="{{ url('/invoices/'.$invoice->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                    data-id="{{ $invoice->id }}"
                                    class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition delete-button">
                                <i class="fa fa-trash"></i> حذف
                            </button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500">
                        لا توجد فواتير
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

@endsection
