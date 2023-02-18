<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $fillable=[
        'name',
        'account_number',
        'ifsc_code',
    ];
    public function bankIfsc(){
        return $this->belongsTo(IfscCode::class,'ifsc_code','ifsc_code');
    }
}
