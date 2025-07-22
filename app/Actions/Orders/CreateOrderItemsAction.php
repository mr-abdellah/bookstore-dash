<?php

namespace App\Actions\Orders;

use App\Models\Book;
use App\Models\Order;
use App\Models\PlatformSettings;
use Illuminate\Support\Collection;

class CreateOrderItemsAction
{
    public function execute(Order $order, array $items): Collection
    {
        $orderItems = collect();

        foreach ($items as $itemData) {
            $book = Book::findOrFail($itemData['book_id']);

            $orderItem = $order->items()->create([
                'book_id' => $book->id,
                'publishing_house_id' => $book->publishing_house_id,
                'quantity' => $itemData['quantity'],
                'unit_price' => $itemData['unit_price'] ?? $book->price,
                'profit_percentage' => PlatformSettings::getSettings()->profit_percentage ?: 0,
                'status' => 'pending',
            ]);

            $orderItems->push($orderItem);
        }

        return $orderItems;
    }
}
