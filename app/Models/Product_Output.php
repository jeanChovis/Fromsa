<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_Output extends Model
{
    protected $table = 'product_output';

    protected $fillable = ['date','total','customer_id','product_id'];

    protected $hidden = ['created_at','updated_at'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
