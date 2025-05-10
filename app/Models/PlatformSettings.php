<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatformSettings extends Model
{
    use UuidTrait, HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'profit_percentage',
        'platform_name',
        'logo',
        'contact_email',
        'contact_phone',
    ];

    public static function getSettings(): self
    {
        return self::first() ?? new self(); // fallback to empty instance if not seeded
    }
}
