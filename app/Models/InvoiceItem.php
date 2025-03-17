<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $table = "invoice_items";
    protected $guarded = [];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
    public function customer()
    {
        return $this->hasOneThrough(Customer::class, Invoice::class, 'id', 'id', 'invoice_id', 'customerId');
    }
    public function payment()
    {
        return $this->hasOneThrough(Payment::class, Invoice::class, 'id', 'id', 'invoice_id', 'paymentTypeId');
    }

    public function user()
    {
        return $this->hasOneThrough(User::class, Invoice::class, 'id', 'id', 'invoice_id', 'userId');
    }

    public function updated_by()
    {
        return $this->hasOneThrough(User::class, Invoice::class, 'id', 'id', 'invoice_id', 'updated_user_id');
    }

    public function product()
    {
        return $this->belongsTo(Book::class, 'product_id', 'id');
    }
    public function service()
    {
        return $this->belongsTo(Service::class, 'product_id', 'id');
    }
    public function package()
    {
        return $this->belongsTo(Package::class, 'product_id', 'id');
    }
}
