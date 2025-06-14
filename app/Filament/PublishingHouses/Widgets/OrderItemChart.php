<?php

namespace App\Filament\Widgets;

use App\Models\OrderItem;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class OrderItemChart extends ChartWidget
{
    public function getHeaderWidgetsColumns(): int|array
    {
        return 1;
    }
    public function getHeading(): string
    {
        return __("order_item.total_orders");
    }

    protected int|string|array $columnSpan = 'full';



    protected function getData(): array
    {
        // Get the number of order items created per month (you can adjust the field you want to chart)
        $orderItems = OrderItem::selectRaw('MONTH(confirmed_at) as month, SUM(quantity) as total_quantity')
            ->where('publishing_house_id', Auth::user()->publishingHouse->id) // Assuming you want to chart only confirmed order items
            ->whereYear('confirmed_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Prepare data for chart (example: total quantity of items sold per month)
        $labels = [];
        $data = [];

        foreach ($orderItems as $orderItem) {
            $labels[] = date('M', mktime(0, 0, 0, $orderItem->month, 1)); // Get the month abbreviation (Jan, Feb, ...)
            $data[] = $orderItem->total_quantity; // Total quantity sold in that month
        }

        return [
            'datasets' => [
                [
                    'label' => __("order_item.total_orders"),
                    'data' => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line'; // You can use 'bar', 'pie', etc. depending on the chart type you want.
    }
}
