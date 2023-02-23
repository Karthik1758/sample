<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrutinyItem extends Model
{
    protected $fillable = [
        'description',
        'form_type_id'
    ];

    
}
