<x-filament::page>

    <div>
        @livewire(\App\Filament\Widgets\TotalOrdersStats::class)
    </div>

    {{ $this->table }}
</x-filament::page>
