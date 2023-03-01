<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillMultipleParty extends Model
{
    use HasFactory;
    public function ifscCode(){
        return $this->hasOne(IfscCode::class,'ifsc_code','ifsc_code');
    }
}
