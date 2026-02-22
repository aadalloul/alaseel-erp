<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Invoice;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // فلترة حسب الشهر والسنة (اختياري)
        $month = $request->month ?? null;
        $year = $request->year ?? null;

        $invoicesQuery = Invoice::query();

        if ($month) $invoicesQuery->whereMonth('created_at', $month);
        if ($year) $invoicesQuery->whereYear('created_at', $year);

        // بطاقات
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalInvoices = $invoicesQuery->count();
        $totalRevenue = $invoicesQuery->sum('total');

        // آخر العملاء والفواتير
        $latestUsers = User::orderBy('created_at','desc')->take(5)->get();
        $latestInvoices = $invoicesQuery->orderBy('created_at','desc')->take(5)->get();

        // الإيرادات الشهرية
        $monthlyRevenue = Invoice::selectRaw('MONTH(created_at) as month, SUM(total) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyRevenueLabels = $monthlyRevenue->pluck('month')->map(function($m){
            $months = ['يناير','فبراير','مارس','أبريل','مايو','يونيو','يوليو','أغسطس','سبتمبر','أكتوبر','نوفمبر','ديسمبر'];
            return $months[$m-1];
        });

        // أكثر المنتجات مبيعًا
        $topProducts = Product::withCount('invoices')
            ->orderBy('invoices_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers','totalProducts','totalInvoices','totalRevenue',
            'latestUsers','latestInvoices','monthlyRevenue','monthlyRevenueLabels',
            'topProducts','month','year'
        ));
    }
}
