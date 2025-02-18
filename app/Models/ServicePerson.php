<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePerson extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'service_persons';

    public function created_by()
    {
        return $this->belongsTo(User::class, 'add_by_user_id', 'id');
    }
    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_user_id', 'id');
    }
}
