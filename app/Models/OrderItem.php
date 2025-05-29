<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use UuidTrait, HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'order_id',
        'book_id',
        'quantity',
        'unit_price',
        'commission',
        'publishing_house_id',
        'profit_percentage',
        'status',
        'confirmed_by',
        'confirmed_at',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'commission' => 'decimal:2',
        'profit_percentage' => 'decimal:2',
        'status' => OrderStatus::class,
        'confirmed_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function publishingHouse()
    {
        return $this->belongsTo(PublishingHouse::class);
    }

    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }
}