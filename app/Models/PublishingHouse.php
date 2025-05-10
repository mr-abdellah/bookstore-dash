<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class PublishingHouse extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'owner_id',
        'name',
        'email',
        'phone',
        'address',
        'website',
        'established_year',
        'logo',
        'description',
        'social_links',
        'status',
    ];

    protected $casts = [
        'social_links' => 'array',
        'established_year' => 'integer',
    ];

    // Relationships
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}
