@extends('layouts.admin')

@section('title', 'إضافة منتج جديد')

@section('header-button')
    <a href="{{ route('products.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-full shadow-lg hover:scale-105 transition">
        <i class="fa fa-arrow-left"></i> العودة للقائمة
    </a>
@endsection

@section('content')

    <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-3xl mx-auto -translate-y-2">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">إضافة منتج جديد</h2>

        <form action="{{ route('products.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">اسم المنتج</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full px-4 py-3 border rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                           placeholder="أدخل اسم المنتج">
                    @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">السعر ($)</label>
                    <input type="number" name="price" value="{{ old('price') }}"
                           class="w-full px-4 py-3 border rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                           placeholder="أدخل السعر">
                    @error('price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">الكمية</label>
                    <input type="number" name="quantity" value="{{ old('quantity') }}"
                           class="w-full px-4 py-3 border rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                           placeholder="أدخل الكمية">
                    @error('quantity') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-4">
                <button type="reset" class="px-6 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-full shadow-lg transition">
                    إلغاء
                </button>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-lg hover:scale-105 transition">
                    إضافة المنتج
                </button>
            </div>
        </form>
    </div>

@endsection
