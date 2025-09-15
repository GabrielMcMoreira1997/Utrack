<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'user_id',
        'original_url',
        'short_code',
        'custom_slug',
        'description',
        'password',
        'expires_at',
        'clicks'
    ];

    protected $dates = ['expires_at'];

    // Relacionamentos
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Getter para pegar a URL final curta
    public function getShortUrlAttribute()
    {
        return "https://{$this->company->domain}/" . ($this->custom_slug ?: $this->short_code);
    }

    // Validade do link
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
