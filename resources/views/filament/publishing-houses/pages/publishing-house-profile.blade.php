<x-filament-panels::page>
    <div class="space-y-6">


        <!-- Profile Form -->
        <div class=" rounded-lg shadow">
            <form wire:submit="save" class="p-6">
                {{ $this->form }}

                <div class="flex justify-end mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    {{ $this->getFormActions()[0] }}
                </div>
            </form>
        </div>
    </div>
</x-filament-panels::page>