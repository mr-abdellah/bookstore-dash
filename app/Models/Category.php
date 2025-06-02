<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use UuidTrait, HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name_en',
        'name_fr',
        'name_ar',
        'slug',
        'publishing_house_id'
    ];

    protected static function booted(): void
    {
        static::creating(function ($category) {
            $category->slug = str($category->name_en)->slug();
        });

        static::updating(function ($category) {
            $category->slug = str($category->name_en)->slug();
        });
    }


    public function publishingHouse()
    {
        return $this->belongsTo(PublishingHouse::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
