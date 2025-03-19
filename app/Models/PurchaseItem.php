<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;
    protected $table = 'purchase_items';
    protected $guarded = [];
    public function product()
    {
        return $this->belongsTo(Book::class, 'product_id', 'id');
    }
    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'id');
    }
    public function supplier()
    {
        return $this->hasOneThrough(Supplier::class, Purchase::class, 'id', 'id', 'purchase_id', 'supplier_id');
    }

    public function user()
    {
        return $this->hasOneThrough(User::class, Purchase::class, 'id', 'id', 'purchase_id', 'user_id');
    }
}
