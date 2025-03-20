<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCredit extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'customer_credits';
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'paymentTypeId', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'add_by_user_id', 'id');
    }
    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_user_id', 'id');
    }

}
