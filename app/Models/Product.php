<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // هذه الأعمدة مسموح بإنشائها وتحديثها عبر create أو update
    protected $fillable = [
        'name',
        'price',
        'quantity',
        'stock',
    ];

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'invoice_product')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
    public function purchases()
    {
        return $this->belongsToMany(Purchase::class, 'purchase_product')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }



}
