<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table ="products";
    protected $guarded=[];

    public function images(){
        return $this->hasMany(Image::class , 'product_id');
    }


    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

}
