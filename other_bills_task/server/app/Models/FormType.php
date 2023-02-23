<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormType extends Model
{
    
    protected $fillable=[
        'form_type',
        'form_number_id'
    ];
    public function formHoaTypeMapping(){
        return $this->belongsToMany(Hoa::class,'hoa_form_type_mappings', 'form_type_id', 'hoa', 'id', 'hoa');
    }

    public function scrutinyItems(){
        return $this->hasMany(ScrutinyItem::class);
    }
    
    public function formNumber(){
        return $this->hasOne(Form::class,'id','form_number_id');
    }


}