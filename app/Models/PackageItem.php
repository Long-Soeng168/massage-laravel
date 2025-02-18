<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageItem extends Model
{
    use HasFactory;
    protected $table = 'package_items';
    protected $guarded = [];
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
}
