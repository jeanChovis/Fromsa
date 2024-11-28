<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerPerson extends Model
{
    protected $table = 'customer_person';
    protected $fillable = [
        'dni',
        'date_birth', 
        'gender', 
        'customer_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
