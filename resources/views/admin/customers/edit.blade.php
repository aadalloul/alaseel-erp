@extends('layouts.admin')

@section('title', 'تعديل بيانات العميل')

@section('header-button')
    <a href="{{ route('customers.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-full shadow-lg hover:scale-105 transition">
        <i class="fa fa-arrow-left"></i> العودة للقائمة
    </a>
@endsection

@section('content')

    <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-3xl mx-auto -translate-y-2">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">تعديل بيانات العميل</h2>

        <form action="{{ route('customers.update', $customer->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">الاسم الكامل</label>
                    <input type="text" name="name" value="{{ old('name', $customer->name) }}"
                           class="w-full px-4 py-3 border rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                           placeholder="أدخل الاسم الكامل">
                    @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">الهاتف</label>
                    <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}"
                           class="w-full px-4 py-3 border rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                           placeholder="أدخل رقم الهاتف">
                    @error('phone') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                           class="w-full px-4 py-3 border rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                           placeholder="example@email.com">
                    @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">العنوان</label>
                    <input type="text" name="address" value="{{ old('address', $customer->address) }}"
                           class="w-full px-4 py-3 border rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                           placeholder="أدخل العنوان">
                    @error('address') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-4">
                <button type="reset" class="px-6 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-full shadow-lg transition">
                    إلغاء
                </button>
                <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-full shadow-lg hover:scale-105 transition">
                    حفظ التعديلات
                </button>
            </div>
        </form>
    </div>

@endsection
