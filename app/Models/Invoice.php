<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'customer_id',
        'invoice_no',
        'subtotal',
        'discount',
        'tax',
        'grand_total'
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
