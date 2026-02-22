@extends('layouts.admin')

@section('title', 'العملاء')

@section('header-button')
    <a href="{{route('customers.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-full shadow-lg hover:scale-105 transition">
        <i class="fa fa-plus"></i>إضافة عميل
    </a>


@endsection

@section('content')

    <!-- كروت إحصائية -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-gray-50 rounded-2xl shadow-lg p-6 flex justify-between items-center">
            <div>
                <h3 class="text-gray-500 text-sm">إجمالي العملاء</h3>
                <p class="text-2xl font-bold">{{ $customersCount ?? 0 }}</p>
            </div>
            <i class="fa fa-users text-blue-600 text-4xl"></i>
        </div>
        <div class="bg-gray-50 rounded-2xl shadow-lg p-6 flex justify-between items-center">
            <div>
                <h3 class="text-gray-500 text-sm">عملاء جدد</h3>
                <p class="text-2xl font-bold">{{ $newCustomers ?? 0 }}</p>
            </div>
            <i class="fa fa-user-plus text-green-600 text-4xl"></i>
        </div>
        <div class="bg-gray-50 rounded-2xl shadow-lg p-6 flex justify-between items-center">
            <div>
                <h3 class="text-gray-500 text-sm">عملاء نشطون</h3>
                <p class="text-2xl font-bold">{{ $activeCustomers ?? 0 }}</p>
            </div>
            <i class="fa fa-check-circle text-purple-600 text-4xl"></i>
        </div>
    </div>

    <!-- جدول العملاء -->
    <div class="overflow-x-auto">
        <table class="w-full text-right table-auto bg-white rounded-xl shadow-lg">
            <thead class="bg-gray-200 text-gray-700 uppercase text-sm">
            <tr>
                <th class="p-4">#</th>
                <th class="p-4">الاسم</th>
                <th class="p-4">الهاتف</th>
                <th class="p-4">البريد الإلكتروني</th>
                <th class="p-4">العنوان</th>
                <th class="p-4">الإجراءات</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($customers as $customer)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="p-4">{{ $customer->id }}</td>
                    <td class="p-4 font-semibold">{{ $customer->name }}</td>
                    <td class="p-4">{{ $customer->phone }}</td>
                    <td class="p-4">{{ $customer->email }}</td>
                    <td class="p-4">{{ $customer->address }}</td>
                    <td class="p-4 flex gap-2">
                        <a href="{{ route('customers.edit', $customer->id) }}"
                           class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 transition">
                            <i class="fa fa-edit"></i> تعديل
                        </a>
                         <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="delete-form">
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
