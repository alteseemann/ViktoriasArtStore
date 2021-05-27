<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class genre extends Model
{
    use HasFactory;

    public function types(){
        return $this->belongsToMany(\App\Models\type::class,'genre_type','genre_id','type_id');
    }
}
