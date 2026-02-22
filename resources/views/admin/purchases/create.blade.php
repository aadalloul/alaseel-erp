@extends('layouts.admin')

@section('title','إضافة عملية شراء')

@section('content')

    @if(session('success'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 2000)"
            x-show="show"
            class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow z-50"
        >
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 2000)"
            x-show="show"
            class="fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded shadow z-50"
        >
            {{ session('error') }}
        </div>
    @endif

    <div class="max-w-3xl mx-auto p-4 bg-white rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">إضافة عملية شراء</h2>

        <form action="{{ route('purchases.store') }}" method="POST">
        @csrf

        <!-- بيانات عملية الشراء -->
            <div class="mb-4 flex gap-4">
                <input type="text" name="supplier" placeholder="المورد"
                       class="border rounded p-2 w-1/2" value="{{ old('supplier') }}">
                <input type="date" name="purchase_date"
                       class="border rounded p-2 w-1/2"
                       value="{{ old('purchase_date', date('Y-m-d')) }}">
            </div>

            <!-- المنتجات -->
            <div id="products-container" class="space-y-2">
                <template id="product-template">
                    <div class="flex gap-2 items-center">
                        <select name="products[__INDEX__][product_id]" class="border rounded p-1 w-32 product-select">
                            <option value="" selected disabled>اختر المنتج</option> <!-- الخيار الافتراضي -->
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                        <input type="number" name="products[__INDEX__][quantity]" placeholder="الكمية"
                               class="border rounded p-1 w-16" value="1">
                        <!-- السعر readonly -->
                        <input type="number" step="0.01" name="products[__INDEX__][price]" placeholder="السعر"
                               class="border rounded p-1 w-20 price-input" value="0" readonly>
                        <button type="button" class="remove-product bg-red-500 text-white px-2 py-1 rounded">حذف</button>
                    </div>
                </template>
            </div>

            <button type="button" id="add-product" class="bg-blue-500 text-white px-3 py-1 rounded mb-4">
                إضافة منتج
            </button>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
                حفظ العملية
            </button>
        </form>
    </div>

    <script>
        let index = 0;
        document.getElementById('add-product').addEventListener('click', function() {
            const template = document.getElementById('product-template').innerHTML;
            const html = template.replace(/__INDEX__/g, index);
            const container = document.getElementById('products-container');
            container.insertAdjacentHTML('beforeend', html);
            index++;
        });

        // حذف أي منتج
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-product')) {
                e.target.parentElement.remove();
            }
        });

        // تعبئة السعر تلقائيًا عند اختيار المنتج
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('product-select')) {
                const price = e.target.selectedOptions[0].dataset.price;
                const row = e.target.closest('div');
                const priceInput = row.querySelector('.price-input');
                if(priceInput) priceInput.value = price;
            }
        });
    </script>

@endsection
