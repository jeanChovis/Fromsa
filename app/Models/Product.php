<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $fillable = ['category_id','name','stock','image','price'];

    protected $hidden = ['created_at','updated_at'];

    /*protected $casts = [
        'price' => 'decimal:2', // Esto asegura que el precio se trate como decimal con 2 decimales
    ];*/
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
