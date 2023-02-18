<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable=[
        'form_number'
    ];
    public function formTypes(){
        return $this->belongsTo(FormType::class,'form_number_id','id');
    }
}
