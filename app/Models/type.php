<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class type extends Model
{
    use HasFactory;
    //Товары данного типа
    public function products(){
        return $this->hasMany(\App\Models\product::class, 'type_id','id');
    }
    public function genres(){
        return $this->belongsToMany(\App\Models\genre::class,'genre_type','type_id','genre_id');
    }
}
