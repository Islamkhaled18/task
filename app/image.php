<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    protected $guarded=[];
    protected $table ="images";

    public function setPhotoAttribute($value)
    {
        $this->attributes['photo'] = json_encode($value);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
