<div class="bg-green-100 rounded-lg px-4 py-2 text-center cursor-pointer" role="button" wire:click="redirectToPayouts">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <div class="flex items-center justify-center space-x-2">
        <x-filament::icon icon="heroicon-m-currency-dollar" class="h-4 w-4 text-green-600" />
        <span class="font-bold text-green-800 text-sm">
            {{ __('payouts.total_pending_payouts') }}:
            {{ number_format($totalPending, 2) }}
            {{ __('order_item.currency') }} </span>
    </div>
</div>