<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IfscCode extends Model
{
    protected $fillable=[
        'ifsc_code',
        'bank_name',
        'state',
        'branch'
    ];
}
