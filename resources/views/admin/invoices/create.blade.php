@extends('layouts.admin')

@section('title', 'إنشاء فاتورة')

@section('content')

    <!-- رسائل النجاح والخطأ -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('invoices.store') }}" method="POST">
    @csrf

    <!-- اسم الشركة -->
        <div class="text-center mb-6">
            <h1 class="text-4xl font-bold text-gray-700">Tajj Mall</h1>
            <p class="text-lg text-gray-500">شركة التسوق الأفضل في المدينة</p>
        </div>

        <!-- العميل الافتراضي وتاريخ الفاتورة -->
        <input type="hidden" name="customer_id" value="{{ $defaultCustomer->id }}">
        <input type="hidden" name="date" value="{{ date('Y-m-d') }}">

        <!-- المنتجات -->
        <div class="bg-white p-6 rounded-2xl shadow">
            <h3 class="font-bold mb-4">المنتجات</h3>
            <div id="items" class="space-y-4">
                <div class="grid grid-cols-4 gap-4">
                    <select name="products[0][id]" class="border p-3 rounded" required>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} - {{ $product->price }} ₪</option>
                        @endforeach
                    </select>
                    <input type="number" name="products[0][quantity]" value="1" min="1" class="border p-3 rounded">
                    <button type="button" onclick="addRow()" class="bg-green-500 text-white rounded px-4">+</button>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-full shadow-lg">
                حفظ الفاتورة
            </button>
        </div>
    </form>

    <script>
        let index = 1;
        function addRow(){
            let html = `
        <div class="grid grid-cols-4 gap-4 mt-2">
            <select name="products[${index}][id]" class="border p-3 rounded" required>
                @foreach($products as $product)
            <option value="{{ $product->id }}">{{ $product->name }} - {{ $product->price }} ₪</option>
                @endforeach
            </select>
            <input type="number" name="products[${index}][quantity]" value="1" min="1" class="border p-3 rounded">
            <button type="button" onclick="this.parentElement.remove()" class="bg-red-500 text-white rounded px-4">×</button>
        </div>
        `;
            document.getElementById('items').insertAdjacentHTML('beforeend', html);
            index++;
        }
    </script>

@endsection
