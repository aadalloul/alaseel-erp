<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin_or_permission:customers.create')->only(['create', 'store']);
        $this->middleware('is_admin_or_permission:customers.edit')->only(['edit', 'update']);
        $this->middleware('is_admin_or_permission:customers.delete')->only(['destroy']);
    }

    public function index()
    {
        $customers = Customer::all();
        $customersCount = $customers->count();
        $newCustomers = Customer::whereDate('created_at', today())->count();
        $activeCustomers = Customer::where('status', 'active')->count();

        return view('admin.customers.index', compact(
            'customers', 'customersCount', 'newCustomers', 'activeCustomers'
        ));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|digits:9|unique:customers,phone',
            'address' => 'nullable|string|max:500',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')
            ->with('success', 'تم إضافة العميل بنجاح');
    }

    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'required|digits:9|numeric|unique:customers,phone,'.$customer->id,
            'email' => 'nullable|email',
            'address' => 'nullable|string|max:500',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')
            ->with('success', 'تم تحديث العميل');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'تم حذف العميل');
    }
}
