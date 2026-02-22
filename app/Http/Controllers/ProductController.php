<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // عرض كل المنتجات
    public function index()
    {
        $products = Product::all();
        $productsCount = $products->count();
        $availableProducts = Product::where('quantity', '>', 0)->count();
        $expiredProducts = Product::where('quantity', '<=', 0)->count();

        return view('admin.products.index', compact('products', 'productsCount', 'availableProducts', 'expiredProducts'));
    }

    // صفحة إضافة منتج جديد
    public function create()
    {
        return view('admin.products.create');
    }

    // تخزين المنتج الجديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:products,name',
            'price' => 'required|numeric|min:0.01',
            'quantity' => 'required|integer|min:0',
        ], [
            'name.required' => 'اسم المنتج مطلوب',
            'name.unique' => 'اسم المنتج موجود بالفعل',
            'price.required' => 'السعر مطلوب',
            'price.numeric' => 'السعر يجب أن يكون رقم',
            'price.min' => 'السعر لا يمكن أن يكون أقل من 0.01',
            'quantity.required' => 'الكمية مطلوبة',
            'quantity.integer' => 'الكمية يجب أن تكون رقم صحيح',
            'quantity.min' => 'الكمية لا يمكن أن تكون أقل من 0',
        ]);

        // حفظ المنتج
        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'تمت إضافة المنتج بنجاح');

    }

    // صفحة تعديل منتج موجود
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    // تحديث المنتج
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('products.index')->with('success', 'تم تحديث المنتج بنجاح');
    }

    // حذف منتج
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'تم حذف المنتج بنجاح');
    }
}
