<?php

namespace App\Observers;

use App\Models\OrderItem;
use App\Models\PublisherPayout;
use App\Enums\OrderStatus;
use Illuminate\Support\Facades\Log;

class OrderItemObserver
{
    public function updated(OrderItem $orderItem): void
    {
        // Create payout when status changes to SHIPPED
        if ($orderItem->status === OrderStatus::SHIPPED && $orderItem->getOriginal('status') !== OrderStatus::SHIPPED) {
            if (!PublisherPayout::where('order_item_id', $orderItem->id)->exists()) {
                $total = $orderItem->unit_price * $orderItem->quantity;
                $profit = $total * ($orderItem->profit_percentage / 100);
                $publisherAmount = $total - $profit;

                $publishingHouse = $orderItem->publishingHouse;

                if ($publishingHouse) {
                    PublisherPayout::create([
                        'order_item_id' => $orderItem->id,
                        'publishing_house_id' => $publishingHouse->id,
                        'amount' => $publisherAmount,
                        'status' => 'pending',
                    ]);
                } else {
                    // Optionally log or throw an error here
                    Log::warning("Missing publishing house for OrderItem {$orderItem->id}");
                }
            }
        }


        // Cancel payout if order is cancelled
        if ($orderItem->status === OrderStatus::CANCELLED && $orderItem->getOriginal('status') !== OrderStatus::CANCELLED) {
            PublisherPayout::where('order_item_id', $orderItem->id)
                ->where('status', 'pending')
                ->delete();
        }
    }
}