<?php

namespace App\Filament\Pages;

use App\Models\PlatformSettings;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getSubheading(): ?string
    {
        $profitPercentage = PlatformSettings::getSettings()?->profit_percentage ?? 0;

        return __('dashboard.platform_profit_percentage', [
            'percentage' => $profitPercentage,
        ]);
    }
}
