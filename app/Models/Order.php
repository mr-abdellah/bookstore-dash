<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use UuidTrait, HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'wilaya',
        'commune',
        'address',
        'delivery_type_id',
        'order_status',
        'payment_status',
        'payment_method',
    ];

    protected $casts = [
        'order_status' => OrderStatus::class,
        'payment_status' => PaymentStatus::class,
        'payment_method' => PaymentMethod::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Dynamic subtotal (books only)
    public function getSubtotalAttribute()
    {
        return $this->items->sum(fn($item) => $item->unit_price * $item->quantity);
    }

    // Dynamic total commission
    public function getTotalCommissionAttribute()
    {
        return $this->items->sum('commission');
    }

    // Dynamic total (subtotal + delivery)
    public function getTotalAttribute()
    {
        $deliveryCost = $this->deliveryType->cost ?? 0; // Assumes DeliveryType relation
        return $this->subtotal + $deliveryCost;
    }
}