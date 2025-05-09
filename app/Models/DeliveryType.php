<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class DeliveryType extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'logo_url',
        'api_code',
        'estimated_delay',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
