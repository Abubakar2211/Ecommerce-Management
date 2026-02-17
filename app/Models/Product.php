<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['name','description','price','stock','vendor_id','image','category','subcategory','brand','description'];

    public function order(){
        return $this->hasMany(Order::class);
    }
}
