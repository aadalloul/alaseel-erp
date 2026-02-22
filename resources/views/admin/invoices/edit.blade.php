@extends('layouts.admin')

@section('title', 'تعديل فاتورة')

@section('content')

    {{-- رسائل النجاح والفشل --}}
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

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- اسم الشركة -->
        <div class="text-center mb-6">
            <h1 class="text-4xl font-bold text-gray-700">Tajj Mall</h1>
            <p class="text-lg text-gray-500">شركة التسوق الأفضل في المدينة</p>
        </div>

        <!-- العميل -->
        <div class="bg-white p-6 rounded-2xl shadow mb-4">
            <label>العميل</label>
            <select name="customer_id" class="border p-3 rounded w-full">
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ $invoice->customer_id == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- تاريخ الفاتورة -->
        <div class="bg-white p-6 rounded-2xl shadow mb-4">
            <label>تاريخ الفاتورة</label>
            <input type="date" name="date" class="border p-3 rounded w-full"
                   value="{{ old('date', $invoice->invoice_date->format('Y-m-d')) }}">
        </div>

        <!-- المنتجات -->
        <div class="bg-white p-6 rounded-2xl shadow">
            <h3 class="font-bold mb-4">المنتجات</h3>
            <div id="items" class="space-y-4">
                @foreach($invoice->products as $i => $item)
                    <div class="grid grid-cols-4 gap-4">
                        <select name="products[{{ $i }}][id]" class="border p-3 rounded" required>
                            <option value="">اختر المنتج</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}"
                                    {{ $item->id == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} - {{ $product->quantity }} متوفر
                                </option>
                            @endforeach
                        </select>

                        <input type="number" name="products[{{ $i }}][quantity]"
                               value="{{ old("products.$i.quantity", $item->pivot->quantity) }}"
                               min="1" class="border p-3 rounded" required>

                        @if($i == 0)
                            <button type="button" onclick="addRow()" class="bg-green-500 text-white rounded px-4">+</button>
                        @else
                            <button type="button" onclick="this.parentElement.remove()" class="bg-red-500 text-white rounded px-4">×</button>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- زر التحديث -->
        <div class="flex justify-end mt-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-full shadow-lg">
                تحديث الفاتورة
            </button>
        </div>
    </form>

    <script>
        let index = {{ $invoice->products->count() }};

        function addRow() {
            let html = `
            <div class="grid grid-cols-4 gap-4 mt-2">
                <select name="products[\${index}][id]" class="border p-3 rounded" required>
                    <option value="">اختر المنتج</option>
                    @foreach($products as $product)
            <option value="{{ $product->id }}">
                            {{ $product->name }} - {{ $product->quantity }} متوفر
                        </option>
                    @endforeach
            </select>

            <input type="number" name="products[\${index}][quantity]" value="1" min="1" class="border p-3 rounded" required>

            <button type="button" onclick="this.parentElement.remove()" class="bg-red-500 text-white rounded px-4">×</button>
        </div>`;
            document.getElementById('items').insertAdjacentHTML('beforeend', html);
            index++;
        }
    </script>

@endsection
