<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCompany extends Model
{
    protected $table = 'customer_company';
    protected $fillable = [
        'ruc',
        'customer_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
