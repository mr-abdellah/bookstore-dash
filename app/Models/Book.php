<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use UuidTrait, HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'author_id',
        'category_id',
        'publishing_house_id',
        'discount_id',
        'title',
        'description',
        'price',
        'language',
        'dimensions',
        'pages_count',
        'images',
        'cover',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'images' => 'array',
    ];


    public function getImagesAttribute($value)
    {
        return collect(json_decode($value, true))->map(fn($img) => url('storage/' . $img))->all();
    }

    public function getCoverAttribute($value)
    {
        return $value ? url('storage/' . $value) : null;
    }


    // Relationships

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function publishingHouse()
    {
        return $this->belongsTo(PublishingHouse::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
