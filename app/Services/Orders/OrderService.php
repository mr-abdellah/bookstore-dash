<?php

namespace App\Services\Orders;

use App\Actions\Orders\CalculateOrderTotalAction;
use App\Actions\Orders\CreateOrderItemsAction;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    public function __construct(
        protected CreateOrderItemsAction $createOrderItemsAction,
        protected CalculateOrderTotalAction $calculateOrderTotalAction
    ) {}

    /**
     * Get paginated orders for a user.
     */
    public function getUserOrders(User $user, int $perPage = 15): LengthAwarePaginator
    {
        return $user->orders()
            ->with(['items.book', 'items.publishingHouse'])
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get detailed order information.
     */
    public function getOrderDetails(Order $order): Order
    {
        return $order->load([
            'items.book',
            'items.publishingHouse',
            'user:id,first_name,last_name,email'
        ]);
    }

    /**
     * Create a new order with items.
     */
    public function createOrder(User $user, array $data): Order
    {
        $order = $user->orders()->create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'wilaya' => $data['wilaya'],
            'commune' => $data['commune'],
            'address' => $data['address'],
            'order_status' => $data['order_status'] ?? OrderStatus::PENDING,
            'payment_status' => $data['payment_status'] ?? PaymentStatus::PENDING,
            'payment_method' => $data['payment_method'] ?? PaymentMethod::OFFLINE,
        ]);

        $this->createOrderItemsAction->execute($order, $data['items']);

        return $order->fresh(['items.book', 'items.publishingHouse']);
    }


    /**
     * Update an existing order.
     */
    public function updateOrder(Order $order, array $data): Order
    {
        $order->update([
            'status' => $data['status'] ?? $order->status,
            'payment_status' => $data['payment_status'] ?? $order->payment_status,
            'payment_method' => $data['payment_method'] ?? $order->payment_method,
            'delivery_address' => $data['delivery_address'] ?? $order->delivery_address,
            'notes' => $data['notes'] ?? $order->notes,
        ]);

        // Update items if provided
        if (isset($data['items'])) {
            $order->items()->delete();
            $this->createOrderItemsAction->execute($order, $data['items']);
        }

        return $order->fresh(['items.book', 'items.publishingHouse']);
    }

    /**
     * Delete an order and its items.
     */
    public function deleteOrder(Order $order): bool
    {
        $order->items()->delete();
        return $order->delete();
    }
}
