<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    // عرض صفحة التقارير
    public function index(Request $request)
    {
        $type = $request->type ?? 'invoices';
        $from = $request->from ?? null;
        $to = $request->to ?? null;
        $data = [];

        switch ($type) {
            case 'invoices':
                $query = Invoice::with('customer');
                if ($from) $query->whereDate('invoice_date', '>=', $from);
                if ($to) $query->whereDate('invoice_date', '<=', $to);
                $data = $query->get();
                break;

            case 'purchases':
                $query = Purchase::with('product');
                if ($from) $query->whereDate('purchase_date', '>=', $from);
                if ($to) $query->whereDate('purchase_date', '<=', $to);
                $data = $query->get();
                break;

            case 'stock':
                $data = Product::all();
                break;

            case 'customers':
                $data = Customer::withCount('invoices')->with('invoices')->get();
                break;
        }

        return view('admin.reports.index', compact('type', 'from', 'to', 'data'));
    }

    // تصدير PDF
    public function pdf(Request $request)
    {
        $type = $request->type ?? 'invoices';
        $from = $request->from ?? null;
        $to = $request->to ?? null;
        $data = [];

        switch ($type) {
            case 'invoices':
                $query = Invoice::with('customer');
                if ($from) $query->whereDate('invoice_date', '>=', $from);
                if ($to) $query->whereDate('invoice_date', '<=', $to);
                $data = $query->get();
                break;

            case 'purchases':
                $query = Purchase::with('product');
                if ($from) $query->whereDate('purchase_date', '>=', $from);
                if ($to) $query->whereDate('purchase_date', '<=', $to);
                $data = $query->get();
                break;

            case 'stock':
                $data = Product::all();
                break;

            case 'customers':
                $data = Customer::withCount('invoices')->with('invoices')->get();
                break;
        }

        $pdf = Pdf::loadView('admin.reports.pdf', compact('type', 'from', 'to', 'data'));
        return $pdf->download("report_{$type}.pdf");
    }
}
