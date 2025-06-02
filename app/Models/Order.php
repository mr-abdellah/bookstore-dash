<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Traits\GeneratesOrderReference;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kossa\AlgerianCities\Commune;
use Kossa\AlgerianCities\Wilaya;

class Order extends Model
{
    use UuidTrait, HasFactory, GeneratesOrderReference;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $referencePrefix = 'BC';

    protected $fillable = [
        'user_id',
        'reference',
        'first_name',
        'last_name',
        'phone',
        'wilaya_id',
        'commune_id',
        'address',
        'order_status',
        'payment_status',
        'payment_method',
    ];

    protected $casts = [
        'order_status' => OrderStatus::class,
        'payment_status' => PaymentStatus::class,
        'payment_method' => PaymentMethod::class,
    ];

    public function wilaya()
    {
        return $this->belongsTo(Wilaya::class);
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

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
