<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        "name",
        "dob",
        "phone_number",
        "email",
        "gender",
        "date_joined",
        "salary"
    ];
    public function projectEmployeeMapping(){
        return $this->belongsToMany(ProjectEmployeeMapping::class, 'employee_id', 'id');
    }
    public function employeeAttendance(){
        return $this->belongsToMany(EmployeeAttendance::class, 'employee_id', 'id');
    }
    
}
