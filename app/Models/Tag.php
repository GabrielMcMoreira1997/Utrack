<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'company_id', 'user_id'];

    public function links()
    {
        return $this->belongsToMany(Link::class);
    }
}
