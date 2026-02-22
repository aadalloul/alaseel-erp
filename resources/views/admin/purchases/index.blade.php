@extends('layouts.admin')

@section('content')

    <!-- رسائل نجاح وفشل العمليات -->
    <!-- Toast Notifications تحت التوب بار مباشرة -->
    <div class="mt-4 ml-4 space-y-2">
        @if(session('success'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 2000)"
                x-show="show"
                x-transition:enter="transition transform ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition transform ease-in duration-300"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2"
                class="bg-green-500 text-white px-4 py-2 rounded-lg shadow flex items-center gap-2 min-w-[200px]"
            >
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 2000)"
                x-show="show"
                x-transition:enter="transition transform ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition transform ease-in duration-300"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2"
                class="bg-red-500 text-white px-4 py-2 rounded-lg shadow flex items-center gap-2 min-w-[200px]"
            >
                ❌ {{ session('error') }}
            </div>
        @endif
    </div>


    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">المشتريات</h1>
        <!-- زر إضافة مشتريات -->
        <a href="{{ route('purchases.create') }}"
           class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md shadow text-sm">
            إضافة مشتريات
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

        @foreach($purchases as $purchase)
            <div class="border rounded-lg p-4 shadow relative">

                <h3 class="font-bold text-lg mb-2">{{ $purchase->supplier }} - {{ $purchase->purchase_date }}</h3>
                <p class="mb-2">الحالة:
                    <span class="{{ $purchase->status == 'completed' ? 'text-green-600' : 'text-yellow-600' }}">
                {{ ucfirst($purchase->status) }}
            </span>
                </p>

                <!-- قائمة المنتجات -->
                <ul class="mb-2 space-y-1">
                    @foreach($purchase->products as $product)
                        <li class="flex justify-between items-center bg-gray-50 p-2 rounded">
                            <span>{{ $product->name }}</span>
                            <span>{{ $product->pivot->quantity }} × {{ number_format($product->pivot->price,2) }} ₪</span>

                            <!-- زر حذف المنتج -->
                            <form action="{{ route('purchases.removeProduct', [$purchase->id, $product->id]) }}" method="POST" class="ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                                    حذف
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>

                <!-- زر لإظهار/إخفاء نموذج إضافة منتج -->
                <div x-data="{ open: false }" class="mb-2">
                    <button @click="open = !open"
                            class="text-white bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded-md shadow text-sm mb-2">
                        إضافة منتج
                    </button>

                    <div x-show="open" x-transition class="mt-2 p-2 border rounded-md bg-gray-50 space-y-2">
                        <form action="{{ route('purchases.addProduct', $purchase->id) }}" method="POST" class="flex gap-2 items-center">
                            @csrf

                            <select name="product_id" class="border rounded-md p-1 text-sm w-32">
                                @foreach($products as $productOption)
                                    <option value="{{ $productOption->id }}">{{ $productOption->name }}</option>
                                @endforeach
                            </select>

                            <input type="number" name="quantity" placeholder="الكمية" class="border rounded-md p-1 text-sm w-16">
                            <input type="number" step="0.01" name="price" placeholder="السعر" class="border rounded-md p-1 text-sm w-20">

                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm">
                                حفظ
                            </button>
                        </form>
                    </div>
                </div>

                <!-- أزرار تعديل وحذف المشتريات -->
                <div class="flex gap-2 mt-4">
                    <a href="{{ route('purchases.edit', $purchase->id) }}"
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                        تعديل
                    </a>
                    <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                            حذف
                        </button>
                    </form>
                </div>

            </div>
        @endforeach

    </div>

@endsection
