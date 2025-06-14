<?php

namespace App\Models;

use App\Enums\PublisherPayoutStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PublisherPayout extends Model
{
    protected $fillable = [
        'order_item_id',
        'publishing_house_id',
        'amount',
        'status',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function publishingHouse(): BelongsTo
    {
        return $this->belongsTo(PublishingHouse::class, 'publishing_house_id');
    }
}