<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        "name",
        "description",
        "client",
        "start_date",
        "end_date",
        "budget",
        "manager"
    ];
    public function projectEmployeeMapping(){
        return $this->belongsToMany(ProjectEmployeeMapping::class, 'project_id', 'id');
    }
}
