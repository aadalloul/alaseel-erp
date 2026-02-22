<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id', 'total', 'invoice_date'];
    protected $casts = [
                'invoice_date' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // علاقة Many-to-Many مع المنتجات
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity','price');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function items(){
        return $this->hasMany(InvoiceItem::class);
    }

}
