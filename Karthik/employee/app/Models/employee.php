<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    protected $fillable = [
        "full_name",
        "dob",
        "phone_number",
        "email",
        "gender"
    ];

    public function leave()
    {
        return $this->hasMany(Leave::class);
    }
}
