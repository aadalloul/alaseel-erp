<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


class PurchaseController extends Controller
{
    // صفحة عرض المشتريات
    public function index()
    {
        $purchases = Purchase::with('products')->get();
        $products = Product::all(); // مهم

        return view('admin.purchases.index', compact('purchases', 'products'));
    }



    // صفحة إضافة مشتريات
    public function create()
    {
        $products = Product::all();
        return view('admin.purchases.create', compact('products'));
    }

    // حفظ عملية شراء
// حفظ عملية شراء
    public function store(Request $request)
    {
        $request->validate([
            'supplier' => 'required|string|max:255',
            'purchase_date' => 'nullable|date',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0.01',
        ]);

        $purchase = Purchase::create([
            'supplier' => $request->supplier,
            'purchase_date' => $request->purchase_date ?? now()->format('Y-m-d'),
            'status' => 'pending',
        ]);

        // تأكد أن المنتجات موجودة قبل عمل foreach
        if ($request->has('products') && is_array($request->products)) {
            foreach ($request->products as $item) {
                if(isset($item['product_id'])) { // تحقق من وجود product_id
                    $purchase->products()->attach($item['product_id'], [
                        'quantity' => $item['quantity'] ?? 1,
                        'price' => $item['price'] ?? 0,
                    ]);

                    // تحديث المخزون
                    $product = Product::find($item['product_id']);
                    if ($product) {
                        $product->quantity += $item['quantity'] ?? 1;
                        $product->save();
                    }
                }
            }
        }

        return redirect()->route('purchases.index')
            ->with('success', 'تمت إضافة عملية الشراء بنجاح');
    }


    // صفحة تعديل مشتريات
    public function edit(Purchase $purchase)
    {
        $products = Product::all();
        $purchase->load('products'); // جلب المنتجات المرتبطة
        return view('admin.purchases.edit', compact('purchase', 'products'));
    }

    // تحديث عملية شراء
    public function update(Request $request, $id)
    {
        $purchase = Purchase::findOrFail($id);

        $validated = $request->validate([
            'supplier' => 'required|string|max:255',
            'purchase_date' => 'nullable|date',
            'status' => 'required|in:pending,completed',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        // إعادة المخزون للمنتجات القديمة قبل التحديث
        foreach ($purchase->products as $product) {
            $product->quantity -= $product->pivot->quantity;
            $product->save();
        }

        // إذا لم يُدخل المستخدم تاريخ → ضع اليوم تلقائيًا
        $purchaseDate = $validated['purchase_date'] ?? Carbon::today()->format('Y-m-d');

        // تحديث بيانات المشتريات الأساسية
        $purchase->update([
            'supplier' => $validated['supplier'],
            'purchase_date' => $purchaseDate,
            'status' => $validated['status'],
        ]);

        // تحديث المنتجات المرتبطة والمخزون الجديد
        $syncData = [];
        if (isset($validated['products']) && is_array($validated['products'])) {
            foreach ($validated['products'] as $item) {
                $syncData[$item['product_id']] = [
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ];

                $product = Product::find($item['product_id']);
                $product->quantity += $item['quantity'];
                $product->save();
            }
        }

        $purchase->products()->sync($syncData);

        return redirect()->route('purchases.index')
            ->with('success', 'تم تحديث عملية الشراء بنجاح');
    }


    // حذف عملية شراء
    public function destroy(Purchase $purchase)
    {
        try {
            // استرجاع المخزون قبل الحذف
            foreach ($purchase->products as $product) {
                $product->quantity -= $product->pivot->quantity;
                $product->save();
            }

            $purchase->products()->detach(); // إزالة المنتجات المرتبطة
            $purchase->delete();

            return redirect()->back()->with('success', 'تم حذف عملية الشراء بنجاح!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف عملية الشراء.');
        }
    }

    public function addProduct(Request $request, Purchase $purchase)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'price'      => 'required|numeric|min:0.01',
        ]);

        try {
            $purchase->products()->attach($request->product_id, [
                'quantity' => $request->quantity,
                'price'    => $request->price,
            ]);

            // تحديث المخزون
            $product = Product::find($request->product_id);
            $product->quantity += $request->quantity;
            $product->save();

            return redirect()->back()->with('success', 'تمت إضافة المنتج بنجاح!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة المنتج.');
        }
    }

    public function removeProduct(Request $request, $purchaseId, $productId)
    {
        $purchase = Purchase::findOrFail($purchaseId);
        $product = Product::findOrFail($productId);

        // إعادة المخزون للمنتج قبل الحذف
        $product->quantity -= $purchase->products()->where('product_id', $productId)->first()->pivot->quantity;
        $product->save();

        // إزالة المنتج من علاقة many-to-many
        $purchase->products()->detach($productId);

        return redirect()->back()->with('success', 'تمت إزالة المنتج بنجاح');
    }

}
