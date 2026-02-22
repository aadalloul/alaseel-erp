@extends('layouts.admin')

@section('title', 'لوحة التحكم')

@section('content')
    <div class="space-y-8">

        <!-- البطاقات السريعة -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- بطاقة العملاء -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 flex items-center gap-4 transition-colors duration-300 hover:shadow-2xl">
                <div class="bg-blue-500 dark:bg-blue-400 p-4 rounded-full text-white">
                    <i class="fa fa-users fa-lg"></i>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-300 text-sm">العملاء</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">125</p>
                </div>
            </div>

            <!-- بطاقة المنتجات -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 flex items-center gap-4 transition-colors duration-300 hover:shadow-2xl">
                <div class="bg-green-500 dark:bg-green-400 p-4 rounded-full text-white">
                    <i class="fa fa-box fa-lg"></i>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-300 text-sm">المنتجات</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">48</p>
                </div>
            </div>

            <!-- بطاقة الفواتير -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 flex items-center gap-4 transition-colors duration-300 hover:shadow-2xl">
                <div class="bg-yellow-500 dark:bg-yellow-400 p-4 rounded-full text-white">
                    <i class="fa fa-file-invoice fa-lg"></i>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-300 text-sm">الفواتير</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">72</p>
                </div>
            </div>

            <!-- بطاقة الإيرادات -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 flex items-center gap-4 transition-colors duration-300 hover:shadow-2xl">
                <div class="bg-red-500 dark:bg-red-400 p-4 rounded-full text-white">
                    <i class="fa fa-dollar-sign fa-lg"></i>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-300 text-sm">الإيرادات</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">$12,450</p>
                </div>
            </div>

        </div>

        <!-- قسم الرسوم البيانية -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 transition-colors duration-300">
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">الإيرادات الشهرية</h3>
            <canvas id="revenueChart" class="w-full h-64"></canvas>
        </div>

        <!-- الجداول المختصرة: آخر العملاء والفواتير -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- آخر العملاء -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 transition-colors duration-300">
                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">آخر العملاء</h3>
                <ul class="space-y-3">
                    <li class="flex justify-between items-center text-gray-700 dark:text-gray-200">
                        <span>محمد أحمد</span>
                        <span class="text-gray-400 dark:text-gray-400 text-sm">2 أيام مضت</span>
                    </li>
                    <li class="flex justify-between items-center text-gray-700 dark:text-gray-200">
                        <span>ليلى سمير</span>
                        <span class="text-gray-400 dark:text-gray-400 text-sm">4 أيام مضت</span>
                    </li>
                    <li class="flex justify-between items-center text-gray-700 dark:text-gray-200">
                        <span>أحمد علي</span>
                        <span class="text-gray-400 dark:text-gray-400 text-sm">5 أيام مضت</span>
                    </li>
                </ul>
            </div>

            <!-- آخر الفواتير -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 transition-colors duration-300">
                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">آخر الفواتير</h3>
                <ul class="space-y-3">
                    <li class="flex justify-between items-center text-gray-700 dark:text-gray-200">
                        <span>#INV-101</span>
                        <span class="text-green-500 dark:text-green-400 font-semibold">$450</span>
                    </li>
                    <li class="flex justify-between items-center text-gray-700 dark:text-gray-200">
                        <span>#INV-102</span>
                        <span class="text-green-500 dark:text-green-400 font-semibold">$120</span>
                    </li>
                    <li class="flex justify-between items-center text-gray-700 dark:text-gray-200">
                        <span>#INV-103</span>
                        <span class="text-green-500 dark:text-green-400 font-semibold">$700</span>
                    </li>
                </ul>
            </div>

        </div>
    </div>
    <!-- قسم أكثر المنتجات مبيعًا -->
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

    <!-- قسم أكثر العملاء نشاطًا -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 transition-colors duration-300 mt-6">
        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">أكثر العملاء نشاطًا</h3>
        <ul class="space-y-3">
            @foreach($topUsers as $user)
                <li class="flex justify-between items-center text-gray-700 dark:text-gray-200">
                    <span>{{ $user->name }}</span>
                    <span class="text-green-500 dark:text-green-400 font-semibold">{{ $user->invoices_count }} فاتورة</span>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['يناير','فبراير','مارس','أبريل','مايو','يونيو'],
                datasets: [{
                    label: 'الإيرادات',
                    data: [5000, 7000, 4500, 9000, 8000, 12000],
                    borderColor: '#3B82F6', // أزرق
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#ffffff' },
                        grid: { color: 'rgba(255,255,255,0.1)' }
                    },
                    x: {
                        ticks: { color: '#ffffff' },
                        grid: { color: 'rgba(255,255,255,0.1)' }
                    }
                }
            }
        });
    </script>
@endsection
