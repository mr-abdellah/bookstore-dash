<?php

namespace App\Livewire\PublishingHouse;

use App\Enums\OrderStatus;
use App\Enums\PublisherPayoutStatus;
use App\Filament\Pages\PayoutsPage;
use App\Models\OrderItem;
use App\Models\PublisherPayout;
use App\Models\PublishingHouse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PublishingHouseEarnings extends Component
{
    public float $totalEarnings = 0;
    public float $totalPendingPayouts = 0;
    public float $totalSentPayouts = 0;

    public function mount(): void
    {
        $publishingHouse = PublishingHouse::where('owner_id', Auth::id())->first();

        if ($publishingHouse) {
            // Calculate total earnings from shipped order items
            $this->totalEarnings = OrderItem::where('publishing_house_id', $publishingHouse->id)
                ->where('status', OrderStatus::SHIPPED)
                ->selectRaw('SUM(unit_price * quantity * (1 - profit_percentage / 100))')
                ->value(DB::raw('SUM(unit_price * quantity * (1 - profit_percentage / 100))')) ?? 0;

            // Calculate total pending payouts
            $this->totalPendingPayouts = PublisherPayout::where('publishing_house_id', $publishingHouse->id)
                ->where('status', PublisherPayoutStatus::PENDING)
                ->sum('amount') ?? 0;

            // Calculate total sent payouts
            $this->totalSentPayouts = PublisherPayout::where('publishing_house_id', $publishingHouse->id)
                ->where('status', PublisherPayoutStatus::SENT)
                ->sum('amount') ?? 0;
        }
    }

    public function redirectToPayouts()
    {
        return redirect(PayoutsPage::getUrl());
    }
    public function render()
    {
        return view('livewire.publishing-house.publishing-house-earnings');
    }
}
