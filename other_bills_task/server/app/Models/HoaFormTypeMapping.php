<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoaFormTypeMapping extends Model
{
    protected $fillable=[
        'hoa',
        'form_type_id'
    ];
}
