<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    protected $fillable = ['name', 'address', 'email', 'phone', 'client_type'];

    protected $hidden = ['created_at', 'updated_at'];

    public function person()
    {
        return $this->hasOne(CustomerPerson::class);
    }

    public function company()
    {
        return $this->hasOne(CustomerCompany::class);
    }
}
