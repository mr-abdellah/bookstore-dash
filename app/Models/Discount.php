<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'code',
        'percent',
        'starts_at',
        'ends_at',
        'active',
    ];

    protected $casts = [
        'percent'   => 'integer',
        'starts_at' => 'date',
        'ends_at'   => 'date',
        'active'    => 'boolean',
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
