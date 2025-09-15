<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'company_id',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relacionamentos
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}
