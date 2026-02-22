@extends('layouts.admin')

@section('title', 'إضافة عميل جديد')

@section('header-button')
    <a href="{{ route('customers.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-full shadow-lg hover:scale-105 transition">
        <i class="fa fa-arrow-left"></i> العودة للقائمة
    </a>
@endsection

@section('content')

    <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl p-8 max-w-3xl mx-auto -translate-y-2">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">إضافة عميل جديد</h2>

        <form action="{{ route('customers.store') }}" method="POST" class="space-y-6" novalidate>
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- الاسم -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">الاسم الكامل *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3 border rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 transition"
                           placeholder="أدخل الاسم الكامل">
                    @error('name') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- رقم الهاتف -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">الهاتف</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required
                           maxlength="9"
                           pattern="[0-9]{9}"
                           title="رقم الهاتف يجب أن يكون 9 أرقام فقط"
                           class="w-full px-4 py-3 border rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                           placeholder="أدخل رقم الهاتف"
                           oninput="this.value = this.value.replace(/\D/g,'')"
                           onpaste="event.preventDefault();"
                    >
                    @error('phone')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>



                <!-- البريد الإلكتروني -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">البريد الإلكتروني *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-3 border rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 transition"
                           placeholder="example@email.com">
                    @error('email') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- العنوان -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">العنوان</label>
                    <input type="text" name="address" value="{{ old('address') }}"
                           class="w-full px-4 py-3 border rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 transition"
                           placeholder="أدخل العنوان">
                    @error('address') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-4">
                <button type="reset" class="px-6 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-full shadow-lg transition">
                    إلغاء
                </button>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-lg hover:scale-105 transition">
                    إضافة العميل
                </button>
            </div>
        </form>
    </div>

@endsection
