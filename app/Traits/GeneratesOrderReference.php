<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait GeneratesOrderReference
{
    protected static function bootGeneratesOrderReference(): void
    {
        static::creating(function ($model) {
            if (empty($model->reference)) {
                $model->reference = $model->generateOrderReference();
            }
        });
    }

    public function generateOrderReference(): string
    {
        $prefix = $this->getReferencePrefix(); // Default: ORD
        $year = now()->format('Y');
        $month = now()->format('m');
        $sequence = $this->getNextMonthlySequence($year, $month);

        return sprintf('%s%s%s%04d', $prefix, $year, $month, $sequence);
    }

    protected function getReferencePrefix(): string
    {
        return property_exists($this, 'referencePrefix') ? $this->referencePrefix : 'ORD';
    }

    protected function getNextMonthlySequence(string $year, string $month): int
    {
        $last = static::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereNotNull('reference')
            ->orderByDesc('created_at')
            ->first();

        if ($last && preg_match('/\d{4}$/', $last->reference, $matches)) {
            return (int) $matches[0] + 1;
        }

        return 1;
    }
}
