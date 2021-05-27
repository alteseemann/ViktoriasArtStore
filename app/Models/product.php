<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\This;

class product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    //Пользователь
    public function user(){
        return $this->belongsTo(User::class);
    }
    //Тип товара
    public function type(){
        return $this->belongsTo(\App\Models\type::class);
    }
    //Связанные изображения
    public function images()
    {
        return $this->hasMany(\App\Models\image::class, 'product_id','id');
    }
}
