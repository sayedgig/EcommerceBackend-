<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table="orders";
    protected $fillable = [
        'firstname', 
    'lastname', 
    'phone', 
    'email', 
    'address', 
    'city', 
    'state', 
    'zipcode'
    ];
    public function orderitem(){
        return $this->hasMany(Orderitems::class,'order_id','id');
    }
}
