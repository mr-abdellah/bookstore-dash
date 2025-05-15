<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use UuidTrait, HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name', 'bio', 'avatar', 'publishing_house_id'];

    public function publishingHouse()
    {
        return $this->belongsTo(PublishingHouse::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
