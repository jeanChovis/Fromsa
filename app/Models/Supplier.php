<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model {
	protected $table = 'supplier';
	protected $fillable = ['ruc', 'company_name', 'address', 'email', 'phone'];

	protected $hidden = ['created_at', 'updated_at'];
}
