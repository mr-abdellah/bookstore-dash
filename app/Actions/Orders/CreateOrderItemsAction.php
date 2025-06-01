<?php

namespace App\Actions\Orders;

use App\Models\Book;
use App\Models\Order;
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
                'commission' => $this->calculateCommission($book, $itemData['quantity']),
                'profit_percentage' => $book->profit_percentage ?? 0,
                'status' => 'pending',
            ]);

            $orderItems->push($orderItem);
        }

        return $orderItems;
    }

    /**
     * Calculate commission for the order item.
     */
    protected function calculateCommission(Book $book, int $quantity): float
    {
        $baseCommission = $book->commission_rate ?? 0.10; // 10% default
        return ($book->price * $quantity) * $baseCommission;
    }
}
