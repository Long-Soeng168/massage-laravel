<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPackage extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'customer_packages';

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }
}
