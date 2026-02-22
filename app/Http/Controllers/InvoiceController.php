<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    // عرض كل الفواتير
    public function index()
    {
        $invoices = Invoice::with('customer')->get();
        return view('admin.invoices.index', compact('invoices'));
    }

    // صفحة إنشاء فاتورة
    public function create()
    {
        $products = Product::all();

        // جلب أو إنشاء العميل الافتراضي
        $defaultCustomer = Customer::firstOrCreate(
            ['name' => 'عميل مول'],
            ['email' => 'cash@mall.com']
        );

        return view('admin.invoices.create', compact('products', 'defaultCustomer'));
    }

    // حفظ فاتورة جديدة
    public function store(Request $request)
    {
        $request->validate([
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {

            $defaultCustomer = Customer::firstOrCreate(
                ['name' => 'عميل مول'],
                ['email' => 'cash@mall.com']
            );

            $invoice = Invoice::create([
                'customer_id' => $defaultCustomer->id,
                'invoice_date' => now(),
                'status' => 'pending',
                'total' => 0,
            ]);

            $syncData = [];
            $total = 0;

            foreach ($request->products as $p) {

                $product = Product::lockForUpdate()->findOrFail($p['id']);
                $available = $product->quantity;
                $qty = $p['quantity'];

                if ($qty > $available) {
                    DB::rollBack();
                    return back()->withInput()
                        ->with('error', "الكمية المطلوبة من {$product->name} غير متوفرة. المتبقي حالياً: {$available}");
                }

                $syncData[$product->id] = [
                    'quantity' => $qty,
                    'price'    => $product->price
                ];

                $total += $product->price * $qty;

                // خصم من المخزون
                $product->quantity -= $qty;
                $product->save();
            }


            $invoice->products()->sync($syncData);
            $invoice->update(['total' => $total]);

            DB::commit();

            return redirect()->route('invoices.index')
                ->with('success', 'تم إنشاء الفاتورة وخصم المخزون بنجاح');

        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }


    // تعديل فاتورة

    public function edit($id)
    {
        $invoice = Invoice::with('products')->findOrFail($id);
        $customers = Customer::all();
        $products = Product::all();

        return view('admin.invoices.edit', compact('invoice', 'customers', 'products'));
    }




    public function update(Request $request, $id)
    {


        $invoice = Invoice::with('products')->findOrFail($id);

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'date' => 'required',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:1',
        ]);


        DB::beginTransaction();

        try {

            // أولاً: رجّع الكميات القديمة للمخزون
            foreach ($invoice->products as $oldProduct) {
                $oldProduct->quantity += $oldProduct->pivot->quantity;
                $oldProduct->save();
            }

            $syncData = [];
            $total = 0;

            foreach ($request->products as $p) {

                $product = Product::lockForUpdate()->findOrFail($p['id']);
                $available = $product->quantity;
                $qty = $p['quantity'];

                if ($qty > $available) {
                    DB::rollBack();
                    return back()->withInput()
                        ->with('error', "الكمية المطلوبة من {$product->name} غير متوفرة. المتبقي حالياً: {$available}");
                }

                $syncData[$product->id] = [
                    'quantity' => $qty,
                    'price' => $product->price
                ];

                $total += $product->price * $qty;

                $product->quantity -= $qty;
                $product->save();
            }

            $invoice->update([
                'customer_id' => $request->customer_id,
                'invoice_date' => $request->date,
                'total' => $total
            ]);

            $invoice->products()->sync($syncData);

            DB::commit();

            return redirect()->route('invoices.index')
                ->with('success', 'تم تحديث الفاتورة بنجاح');

        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }


    // حذف فاتورة
    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $invoice = Invoice::with('products')->findOrFail($id);

            // إرجاع الكميات للمخزون
            foreach ($invoice->products as $product) {
                $product->quantity += $product->pivot->quantity;
                $product->save();
            }

            $invoice->products()->detach();
            $invoice->delete();

            DB::commit();

            return redirect()->route('invoices.index')
                ->with('success', 'تم حذف الفاتورة وإرجاع المخزون بنجاح');

        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }


    // عرض فاتورة واحدة
    public function show($id)
    {
        $invoice = Invoice::with('customer', 'products')->findOrFail($id);
        return view('admin.invoices.show', compact('invoice'));
    }
}
