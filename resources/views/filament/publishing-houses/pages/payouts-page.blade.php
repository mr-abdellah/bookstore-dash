<x-filament::page>
    <x-filament::tabs>
        <x-filament::tabs.item :active="$activeTab === ''" wire:click="$set('activeTab', '')">
            <x-slot name="badge">
                {{ $this->getAllCount() }}
            </x-slot>
            {{ __('payouts.all') }}
        </x-filament::tabs.item>

        <x-filament::tabs.item :active="$activeTab === 'pending'" wire:click="$set('activeTab', 'pending')">
            <x-slot name="badge">
                {{ $this->getPendingCount() }}
            </x-slot>
            {{ __('payouts.pending') }}
        </x-filament::tabs.item>

        <x-filament::tabs.item :active="$activeTab === 'sent'" wire:click="$set('activeTab', 'sent')">
            <x-slot name="badge">
                {{ $this->getSentCount() }}
            </x-slot>
            {{ __('payouts.sent') }}
        </x-filament::tabs.item>

        <x-filament::tabs.item :active="$activeTab === 'failed'" wire:click="$set('activeTab', 'failed')">
            <x-slot name="badge">
                {{ $this->getFailedCount() }}
            </x-slot>
            {{ __('payouts.failed') }}
        </x-filament::tabs.item>
    </x-filament::tabs>

    {{ $this->table }}
</x-filament::page>