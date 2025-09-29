<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['name','price','stock','image','description'];

    public function order(){
        return $this->hasMany(Order::class);
    }
}
