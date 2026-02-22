@extends('layouts.admin')

@section('title', 'لوحة التحكم')

@section('content')
    <div class="space-y-8">

        <!-- فلترة حسب الشهر والسنة -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 flex gap-4 transition-colors duration-300">
            <form method="GET" class="flex gap-4 flex-wrap items-center">
                <div>
                    <label class="text-gray-700 dark:text-gray-200 text-sm">الشهر</label>
                    <select name="month" class="border rounded px-2 py-1 dark:bg-gray-700 dark:text-white">
                        <option value="">كل الأشهر</option>
                        @foreach(range(1,12) as $m)
                            <option value="{{ $m }}" @selected($month==$m)>{{ ['يناير','فبراير','مارس','أبريل','مايو','يونيو','يوليو','أغسطس','سبتمبر','أكتوبر','نوفمبر','ديسمبر'][$m-1] }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-gray-700 dark:text-gray-200 text-sm">السنة</label>
                    <select name="year" class="border rounded px-2 py-1 dark:bg-gray-700 dark:text-white">
                        <option value="">كل السنوات</option>
                        @foreach(range(date('Y'),2010) as $y)
                            <option value="{{ $y }}" @selected($year==$y)>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded-lg hover:bg-blue-700 transition">تطبيق</button>
            </form>
        </div>

        <!-- البطاقات الإجمالية -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- العملاء -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 flex items-center gap-4 hover:shadow-2xl transition-colors duration-300">
                <div class="bg-blue-500 dark:bg-blue-400 p-4 rounded-full text-white">
                    <i class="fa fa-users fa-lg"></i>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-300 text-sm">العملاء</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $totalUsers }}</p>
                </div>
            </div>
            <!-- المنتجات -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 flex items-center gap-4 hover:shadow-2xl transition-colors duration-300">
                <div class="bg-green-500 dark:bg-green-400 p-4 rounded-full text-white">
                    <i class="fa fa-box fa-lg"></i>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-300 text-sm">المنتجات</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $totalProducts }}</p>
                </div>
            </div>
            <!-- الفواتير -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 flex items-center gap-4 hover:shadow-2xl transition-colors duration-300">
                <div class="bg-yellow-500 dark:bg-yellow-400 p-4 rounded-full text-white">
                    <i class="fa fa-file-invoice fa-lg"></i>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-300 text-sm">الفواتير</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $totalInvoices }}</p>
                </div>
            </div>
            <!-- الإيرادات -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 flex items-center gap-4 hover:shadow-2xl transition-colors duration-300">
                <div class="bg-red-500 dark:bg-red-400 p-4 rounded-full text-white">
                    <i class="fa fa-dollar-sign fa-lg"></i>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-300 text-sm">الإيرادات</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">${{ number_format($totalRevenue,2) }}</p>
                </div>
            </div>
        </div>

        <!-- الرسم البياني للإيرادات -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 transition-colors duration-300">
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">الإيرادات الشهرية</h3>
            <canvas id="revenueChart" class="w-full h-64"></canvas>
        </div>

        <!-- آخر العملاء والفواتير -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- آخر العملاء -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 transition-colors duration-300">
                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">آخر العملاء</h3>
                <ul class="space-y-3">
                    @foreach($latestUsers as $user)
                        <li class="flex justify-between items-center text-gray-700 dark:text-gray-200">
                            <span>{{ $user->name }}</span>
                            <span class="text-gray-400 dark:text-gray-400 text-sm">{{ $user->created_at->diffForHumans() }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- آخر الفواتير -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 transition-colors duration-300">
                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">آخر الفواتير</h3>
                <ul class="space-y-3">
                    @foreach($latestInvoices as $invoice)
                        <li class="flex justify-between items-center text-gray-700 dark:text-gray-200">
                            <span>#INV-{{ $invoice->id }}</span>
                            <span class="text-green-500 dark:text-green-400 font-semibold">${{ number_format($invoice->total,2) }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- أكثر المنتجات مبيعًا -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 transition-colors duration-300 mt-6">
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">أكثر المنتجات مبيعًا</h3>
            <ul class="space-y-3">
                @foreach($topProducts as $product)
                    <li class="flex justify-between items-center text-gray-700 dark:text-gray-200">
                        <span>{{ $product->name }}</span>
                        <span class="text-blue-500 dark:text-blue-400 font-semibold">{{ $product->invoices_count }} فاتورة</span>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 transition-colors duration-300 mt-6">
        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">آخر العملاء</h3>
        <table class="datatable w-full text-gray-700 dark:text-gray-200">
            <thead>
            <tr class="bg-gray-100 dark:bg-gray-700">
                <th>#</th>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>تاريخ التسجيل</th>
            </tr>
            </thead>
            <tbody>
            @foreach($latestUsers as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 transition-colors duration-300 mt-6">
        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">آخر الفواتير</h3>
        <table class="datatable w-full text-gray-700 dark:text-gray-200">
            <thead>
            <tr class="bg-gray-100 dark:bg-gray-700">
                <th>#</th>
                <th>رقم الفاتورة</th>
                <th>العميل</th>
                <th>الإجمالي</th>
                <th>تاريخ الإنشاء</th>
            </tr>
            </thead>
            <tbody>
            @foreach($latestInvoices as $index => $invoice)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>#INV-{{ $invoice->id }}</td>
                    <td>{{ $invoice->user->name ?? 'مجهول' }}</td>
                    <td>${{ number_format($invoice->total, 2) }}</td>
                    <td>{{ $invoice->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 transition-colors duration-300 mt-6">
        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">أكثر المنتجات مبيعًا</h3>
        <table class="datatable w-full text-gray-700 dark:text-gray-200">
            <thead>
            <tr class="bg-gray-100 dark:bg-gray-700">
                <th>#</th>
                <th>المنتج</th>
                <th>عدد الفواتير</th>
            </tr>
            </thead>
            <tbody>
            @foreach($topProducts as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->invoices_count }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/dark/1.0.1/dark.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/dark/1.0.1/dataTables.dark.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.datatable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                responsive: true,
                autoWidth: false,
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueData = @json($monthlyRevenue->pluck('total'));
        const revenueLabels = @json($monthlyRevenueLabels);

        const revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: revenueLabels,
                datasets: [{
                    label: 'الإيرادات',
                    data: revenueData,
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true }, x: {} }
            }
        });
    </script>

@endsection
