<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublishingHouse extends Model
{
    use UuidTrait, HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'owner_id',
        'name',
        'email',
        'phone',
        'address',
        'website',
        'established_year',
        'logo',
        'description',
        'social_links',
        'status',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];

    // Relationships
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Optional method to fetch related orders
    public function getRelatedOrders()
    {
        return Order::whereHas('items', function ($query) {
            $query->where('publishing_house_id', $this->id);
        })->with([
                    'items' => function ($query) {
                        $query->where('publishing_house_id', $this->id);
                    }
                ])->get();
    }
}
