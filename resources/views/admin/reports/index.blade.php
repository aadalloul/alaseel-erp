@extends('layouts.admin')

@section('title','التقارير')

@section('content')

    <!-- نموذج اختيار التقرير -->
    <form action="{{ route('reports.index') }}" method="GET" class="flex gap-4 mb-6 flex-wrap justify-center items-center">
        <select name="type" class="border rounded px-4 py-2">
            <option value="invoices" {{ ($type ?? '')=='invoices' ? 'selected' : '' }}>الفواتير</option>
            <option value="purchases" {{ ($type ?? '')=='purchases' ? 'selected' : '' }}>المشتريات</option>
            <option value="stock" {{ ($type ?? '')=='stock' ? 'selected' : '' }}>المخزون</option>
            <option value="customers" {{ ($type ?? '')=='customers' ? 'selected' : '' }}>العملاء</option>
        </select>

        <input type="date" name="from" value="{{ $from ?? '' }}" class="border rounded px-4 py-2">
        <input type="date" name="to" value="{{ $to ?? '' }}" class="border rounded px-4 py-2">

        <!-- أزرار التحكم -->
        <div class="flex flex-wrap gap-4 justify-center w-full mt-2">
            <!-- تحميل PDF -->
            <a href="{{ route('reports.pdf', ['type'=>$type ?? 'invoices', 'from'=>$from ?? '', 'to'=>$to ?? '']) }}"
               class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold px-6 py-3 rounded-lg shadow-lg border border-red-800 transition-all duration-200">
                تحميل PDF
            </a>

            <!-- عرض التقرير -->
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-lg shadow-lg border border-blue-800 transition-all duration-200">
                عرض التقرير
            </button>

            <!-- طباعة التقرير -->
            <button type="button" onclick="window.print()"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-3 rounded-lg shadow-lg border border-green-800 transition-all duration-200">
                طباعة التقرير
            </button>
        </div>
    </form>

    <!-- جدول النتائج -->
    <div class="overflow-x-auto bg-white rounded-xl shadow-lg p-4 print:shadow-none print:p-0">
        <table class="w-full text-center border-collapse print:border print:border-black">
            <thead class="bg-blue-200 text-gray-700 uppercase print:bg-gray-200">
            <tr>
                @if(($type ?? '')=='invoices')
                    <th class="p-3 border">رقم الفاتورة</th>
                    <th class="p-3 border">اسم العميل</th>
                    <th class="p-3 border">المجموع</th>
                    <th class="p-3 border">تاريخ الفاتورة</th>
                    <th class="p-3 border">الإجراءات</th>
                @elseif(($type ?? '')=='purchases')
                    <th class="p-3 border">المنتج</th>
                    <th class="p-3 border">المورد</th>
                    <th class="p-3 border">الكمية</th>
                    <th class="p-3 border">السعر</th>
                    <th class="p-3 border">تاريخ الشراء</th>
                    <th class="p-3 border">الإجراءات</th>
                @elseif(($type ?? '')=='stock')
                    <th class="p-3 border">المنتج</th>
                    <th class="p-3 border">الكمية المتوفرة</th>
                    <th class="p-3 border">السعر</th>
                @elseif(($type ?? '')=='customers')
                    <th class="p-3 border">اسم العميل</th>
                    <th class="p-3 border">عدد الفواتير</th>
                    <th class="p-3 border">آخر فاتورة</th>
                @endif
            </tr>
            </thead>

            <tbody>
            @foreach($data ?? [] as $item)
                <tr class="hover:bg-gray-50 print:bg-white">
                    @if(($type ?? '')=='invoices')
                        <td class="p-3 border">{{ $item->id }}</td>
                        <td class="p-3 border">{{ $item->customer->name ?? '-' }}</td>
                        <td class="p-3 border">{{ $item->total }}</td>
                        <td class="p-3 border">{{ $item->invoice_date }}</td>
                        <td class="p-3 border flex justify-center gap-2">
                            <a href="{{ url('/invoices/'.$item->id) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded transition">
                                عرض
                            </a>
                            <form action="{{ url('/invoices/'.$item->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="delete-button bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded transition">
                                    حذف
                                </button>
                            </form>
                        </td>
                    @elseif(($type ?? '')=='purchases')
                        <td class="p-3 border">{{ $item->product->name ?? '-' }}</td>
                        <td class="p-3 border">{{ $item->supplier }}</td>
                        <td class="p-3 border">{{ $item->quantity }}</td>
                        <td class="p-3 border">{{ $item->price }}</td>
                        <td class="p-3 border">{{ $item->purchase_date }}</td>
                        <td class="p-3 border flex justify-center gap-2">
                            <form action="{{ route('purchases.destroy', $item->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="delete-button bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded transition">
                                    حذف
                                </button>
                            </form>
                        </td>
                    @elseif(($type ?? '')=='stock')
                        <td class="p-3 border">{{ $item->name }}</td>
                        <td class="p-3 border">{{ $item->quantity }}</td>
                        <td class="p-3 border">{{ $item->price }}</td>
                    @elseif(($type ?? '')=='customers')
                        <td class="p-3 border">{{ $item->name }}</td>
                        <td class="p-3 border">{{ $item->invoices_count }}</td>
                        <td class="p-3 border">{{ $item->invoices->last()?->invoice_date ?? '-' }}</td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-button').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('.delete-form');
                    Swal.fire({
                        title: 'هل أنت متأكد؟',
                        text: "لن تستطيع التراجع عن هذا الإجراء!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'نعم، احذف!',
                        cancelButtonText: 'إلغاء'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
