@extends('layouts.admin')

@section('title', 'تعديل عملية شراء')

@section('content')
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold mb-6">تعديل عملية شراء #{{ $purchase->id }}</h2>

        <form action="{{ route('purchases.update', $purchase->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- بيانات أساسية --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block mb-1 font-semibold">المورد</label>
                    <input type="text" name="supplier" value="{{ old('supplier', $purchase->supplier) }}"
                           class="border rounded-lg w-full p-2">
                    @error('supplier') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-1 font-semibold">تاريخ الشراء</label>
                    <input type="date" name="purchase_date"
                           class="border rounded p-2 w-1/2"
                           value="{{ old('purchase_date', $purchase->purchase_date ?? date('Y-m-d')) }}">
                    @error('purchase_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-1 font-semibold">الحالة</label>
                    <select name="status" class="border rounded-lg w-full p-2">
                        <option value="pending" {{ old('status', $purchase->status)=='pending' ? 'selected' : '' }}>معلقة</option>
                        <option value="completed" {{ old('status', $purchase->status)=='completed' ? 'selected' : '' }}>مكتملة</option>
                    </select>
                    @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- جدول المنتجات --}}
            <div class="overflow-x-auto mb-4">
                <table class="w-full text-center border-collapse">
                    <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 border">المنتج</th>
                        <th class="p-3 border">الكمية</th>
                        <th class="p-3 border">السعر</th>
                        <th class="p-3 border">إجراء</th>
                    </tr>
                    </thead>
                    <tbody id="products-table">
                    @foreach(old('products', $purchase->products->map(function($p){
                        return [
                            'product_id' => $p->id,
                            'quantity' => $p->pivot->quantity ?? 1,
                            'price' => $p->pivot->price ?? 0
                        ];
                    })) as $index => $item)
                        <tr class="border-b">
                            <td class="p-2">
                                <select name="products[{{ $index }}][product_id]" class="border rounded-lg w-full p-2 product-select">
                                    <option value="" selected disabled>اختر المنتج</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                            {{ (isset($item['product_id']) && $product->id == $item['product_id']) ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-2">
                                <input type="number" name="products[{{ $index }}][quantity]" min="1"
                                       value="{{ old("products.$index.quantity", $item['quantity'] ?? 1) }}"
                                       class="border rounded-lg w-full p-2">
                            </td>
                            <td class="p-2">
                                <input type="number" step="0.01" name="products[{{ $index }}][price]"
                                       value="{{ old("products.$index.price", $item['price'] ?? 0) }}"
                                       class="border rounded-lg w-full p-2 price-input" readonly>
                            </td>
                            <td class="p-2 text-center">
                                <button type="button" class="remove-product bg-red-500 text-white px-2 py-1 rounded">حذف</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <button type="button" id="add-product"
                    class="mb-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-lg">
                إضافة منتج
            </button>

            <div class="mt-4">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg shadow-lg">
                    تحديث عملية الشراء
                </button>
            </div>
        </form>
    </div>

    {{-- سكربت لإضافة وحذف الصفوف وتحديث السعر تلقائي --}}
    <script>
        let productIndex = {{ count(old('products', $purchase->products)) }};

        document.getElementById('add-product').addEventListener('click', function() {
            const table = document.getElementById('products-table');
            const row = document.createElement('tr');
            row.classList.add('border-b');
            row.innerHTML = `
            <td class="p-2">
                <select name="products[${productIndex}][product_id]" class="border rounded-lg w-full p-2 product-select">
                    <option value="" selected disabled>اختر المنتج</option>
                    @foreach($products as $product)
            <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                    @endforeach
            </select>
        </td>
        <td class="p-2">
            <input type="number" name="products[${productIndex}][quantity]" value="1" min="1" class="border rounded-lg w-full p-2">
            </td>
            <td class="p-2">
                <input type="number" step="0.01" name="products[${productIndex}][price]" value="0" class="border rounded-lg w-full p-2 price-input" readonly>
            </td>
            <td class="p-2 text-center">
                <button type="button" class="remove-product bg-red-500 text-white px-2 py-1 rounded">حذف</button>
            </td>
        `;
            table.appendChild(row);
            productIndex++;
        });

        // حذف صف
        document.addEventListener('click', function(e) {
            if(e.target && e.target.classList.contains('remove-product')){
                e.target.closest('tr').remove();
            }
        });

        // تحديث السعر تلقائي عند اختيار المنتج
        document.addEventListener('change', function(e){
            if(e.target && e.target.classList.contains('product-select')){
                const selected = e.target.selectedOptions[0];
                const priceInput = e.target.closest('tr').querySelector('.price-input');
                if(selected && selected.dataset.price){
                    priceInput.value = selected.dataset.price;
                } else {
                    priceInput.value = 0;
                }
            }
        });
    </script>
@endsection
