<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobRole extends Model
{
    protected $fillable = [
        "name"
    ];
    public function employee()
    {
        return $this->hasMany(Employee::class,'role_id','id');
    }
}
