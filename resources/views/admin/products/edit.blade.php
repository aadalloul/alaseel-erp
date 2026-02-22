@extends('layouts.admin')

@section('title', 'تعديل المنتج')

@section('header-button')
    <a href="{{ route('products.index') }}"
       class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-full shadow-lg hover:scale-105 transition">
        <i class="fa fa-arrow-left"></i> العودة للقائمة
    </a>
@endsection

@section('content')

    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-lg">

        <h2 class="text-2xl font-bold mb-6 text-center">تعديل المنتج</h2>

        {{-- رسائل النجاح --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- رسائل الخطأ --}}
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- عرض أخطاء الفاليديشن --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>يوجد أخطاء:</strong>
                <ul class="list-disc pl-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- اسم المنتج --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">اسم المنتج</label>
                <input type="text" name="name"
                       value="{{ old('name', $product->name) }}"
                       class="w-full px-4 py-3 border rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                       placeholder="أدخل اسم المنتج">
            </div>

            {{-- السعر --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">السعر ($)</label>
                <input type="number" name="price"
                       value="{{ old('price', $product->price) }}"
                       class="w-full px-4 py-3 border rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                       step="0.01" min="0" placeholder="أدخل سعر المنتج">
            </div>

            {{-- الكمية --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">الكمية المتاحة</label>
                <input type="number" name="quantity"
                       value="{{ old('quantity', $product->quantity) }}"
                       class="w-full px-4 py-3 border rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                       min="0" placeholder="أدخل كمية المنتج المتوفرة">
            </div>

            {{-- زر التحديث --}}
            <div class="flex justify-end">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-full shadow-lg transition">
                    تحديث المنتج
                </button>
            </div>
        </form>

    </div>

@endsection
