<?php

namespace App\Actions\Orders;

use App\Models\Order;

class CalculateOrderTotalAction
{
    public function execute(Order $order): array
    {
        $subtotal = $order->items->sum(function ($item) {
            return $item->unit_price * $item->quantity;
        });

        $totalCommission = $order->items->sum('commission');
        $deliveryCost = $order->delivery_cost ?? 0;
        $total = $subtotal + $deliveryCost;

        return [
            'subtotal' => $subtotal,
            'total_commission' => $totalCommission,
            'delivery_cost' => $deliveryCost,
            'total' => $total,
        ];
    }
}
