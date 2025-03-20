<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjustmentItem extends Model
{
    use HasFactory;
    protected $table = 'adjustment_items';
    protected $guarded = [];
    public function product()
    {
        return $this->belongsTo(Book::class, 'product_id', 'id');
    }
    public function adjustment()
    {
        return $this->belongsTo(Adjustment::class, 'adjustment_id', 'id');
    }
    public function user()
    {
        return $this->hasOneThrough(User::class, Adjustment::class, 'id', 'id', 'adjustment_id', 'user_id');
    }
    public function updatedBy()
    {
        return $this->hasOneThrough(User::class, Adjustment::class, 'id', 'id', 'adjustment_id', 'updated_user_id');
    }

}
