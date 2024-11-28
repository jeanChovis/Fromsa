<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_Entry extends Model
{
    protected $table = 'product_entry';

    protected $fillable = ['amount','date','product_id','supplier_id'];

    protected $hidden = ['created_at','updated_at'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
