<div class="bg-green-100 rounded-lg px-4 py-2 text-center cursor-pointer" role="button" wire:click="redirectToPayouts">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <div class="flex flex-col items-center space-y-2">
        <div class="flex items-center justify-center space-x-2">
            <x-filament::icon icon="heroicon-m-currency-dollar" class="h-4 w-4 text-green-600" />
            <span class="font-bold text-green-800 text-sm">
                {{ __('dashboard.total_earnings') }}:
                {{ number_format($totalEarnings, 2) }}
                {{ __('order_item.currency') }}
            </span>
        </div>
        <div class="flex items-center justify-center space-x-2">
            <x-filament::icon icon="heroicon-m-clock" class="h-4 w-4 text-yellow-600" />
            <span class="font-bold text-yellow-800 text-sm">
                {{ __('payouts.total_pending_payouts') }}:
                {{ number_format($totalPendingPayouts, 2) }}
                {{ __('order_item.currency') }}
            </span>
        </div>
        <div class="flex items-center justify-center space-x-2">
            <x-filament::icon icon="heroicon-m-check-circle" class="h-4 w-4 text-blue-600" />
            <span class="font-bold text-blue-800 text-sm">
                {{ __('payouts.total_sent_payouts') }}:
                {{ number_format($totalSentPayouts, 2) }}
                {{ __('order_item.currency') }}
            </span>
        </div>
    </div>
</div>