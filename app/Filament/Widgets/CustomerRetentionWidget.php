<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CustomerRetentionWidget extends ChartWidget
{
    protected static ?int $sort = 3;

    protected static ?string $heading = null; // We'll define it via translations

    public function getHeading(): string
    {
        return __('dashboard.customer_retention_analysis');
    }

    protected int|string|array $columnSpan = 'full';

    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        // Get the last 6 months for analysis
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $months->push(Carbon::now()->subMonths($i)->format('M Y'));
        }

        // Calculate returning customers per month
        $returningCustomers = collect();
        $newCustomers = collect();

        foreach ($months as $index => $month) {
            $startDate = Carbon::now()->subMonths(5 - $index)->startOfMonth();
            $endDate = Carbon::now()->subMonths(5 - $index)->endOfMonth();

            // Count returning customers
            $returning = DB::table('users')
                ->join('orders', 'users.id', '=', 'orders.user_id')
                ->where('orders.created_at', '>=', $startDate)
                ->where('orders.created_at', '<=', $endDate)
                ->whereIn('users.id', function ($query) use ($startDate) {
                    $query->select('user_id')
                        ->from('orders')
                        ->where('created_at', '<', $startDate)
                        ->distinct();
                })
                ->distinct('users.id')
                ->count('users.id');

            // Count new customers
            $new = DB::table('users')
                ->join('orders', 'users.id', '=', 'orders.user_id')
                ->where('orders.created_at', '>=', $startDate)
                ->where('orders.created_at', '<=', $endDate)
                ->whereNotIn('users.id', function ($query) use ($startDate) {
                    $query->select('user_id')
                        ->from('orders')
                        ->where('created_at', '<', $startDate)
                        ->distinct();
                })
                ->distinct('users.id')
                ->count('users.id');

            $returningCustomers->push($returning);
            $newCustomers->push($new);
        }

        return [
            'datasets' => [
                [
                    'label' => __('dashboard.returning_customers'),
                    'data' => $returningCustomers->toArray(),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#36A2EB',
                    'fill' => false,
                ],
                [
                    'label' => __('dashboard.new_customers'),
                    'data' => $newCustomers->toArray(),
                    'backgroundColor' => '#FF6384',
                    'borderColor' => '#FF6384',
                    'fill' => false,
                ],
            ],
            'labels' => $months->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'title' => [
                        'display' => true,
                        'text' => __('dashboard.number_of_customers'),
                    ],
                ],
                'x' => [
                    'title' => [
                        'display' => true,
                        'text' => __('dashboard.month'),
                    ],
                ],
            ],
            'plugins' => [
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                ],
                'legend' => [
                    'position' => 'top',
                ],
            ],
        ];
    }
}
