<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'customers';

    public function created_by()
    {
        return $this->belongsTo(User::class, 'add_by_user_id', 'id');
    }
    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_user_id', 'id');
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'customerId', 'id');
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'customer_packages', 'customer_id', 'package_id')->withPivot('usable_number', 'id');
    }
}
