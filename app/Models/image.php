<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    //Ссылка на конкретный товар
    public function product(){
        $this->belongsTo(product::class);
    }
}
