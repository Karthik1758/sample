<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hoa extends Model
{
    protected $fillable = [
        'mjh',
        'mjh_desc',
        'smjh',
        'smjh_desc',
        'mih',
        'mih_desc',
        'gsh',
        'gsh_desc',
        'sh',
        'sh_desc',
        'dh',
        'dh_desc',
        'sdh',
        'sdh_desc',
        'hoa',
        'hoa_tier'
    ];
}