<?php

namespace App\Livewire\Dashboard;

use App\Enums\PublisherPayoutStatus;
use App\Filament\Pages\PayoutsPage;
use App\Models\PublisherPayout;
use Livewire\Component;

class PublisherPayoutTotal extends Component
{
    public float $totalPending = 0;

    public function mount(): void
    {
        $this->totalPending = PublisherPayout::query()
            ->where('status', PublisherPayoutStatus::PENDING)
            ->sum('amount');
    }

    public function redirectToPayouts()
    {
        return redirect(PayoutsPage::getUrl());
    }


    public function render()
    {
        return view('livewire.dashboard.publisher-payout-total');
    }
}
