<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name_en',
        'name_fr',
        'name_ar',
        'slug',
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
