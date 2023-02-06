<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class employee extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'employees';
    protected $fillable = [
        "full_name",
        "dob",
        "phone_number",
        "email",
        "gender"
    ];
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];
    public function leave()
    {
        return $this->hasMany(Leave::class);
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}