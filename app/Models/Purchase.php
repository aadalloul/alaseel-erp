<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'supplier',

         'purchase_date',
        'status',
    ];

    // هذا يحوّل العمود purchase_date إلى كائن Carbon تلقائيًا
    protected $casts = [
        'purchase_date' => 'datetime',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'purchase_product')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}
