<?php

namespace App\Services;

use App\Models\Consumption;
use Carbon\Carbon;

class ConsumptionService
{
    /**
     * Get daily sums for given resource types over a sliding window ending at $endDate.
     * Returns an array with 'dates' and for each type an array of sums.
     *
     * @param array $types
     * @param Carbon|null $endDate
     * @param int $days
     * @return array
     */
    public function getDailySumsByTypes(array $types, ?Carbon $endDate = null, int $days = 7): array
    {
        $endDate = $endDate ?: Carbon::now();

        $dates = collect();
        for ($i = $days - 1; $i >= 0; $i--) {
            $dates->push($endDate->copy()->subDays($i)->toDateString());
        }

        $result = ['dates' => $dates->toArray()];

        foreach ($types as $type) {
            $result[$type] = $dates->map(function ($date) use ($type) {
                return (float) Consumption::whereHas('resource', fn($q) => $q->where('type', $type))
                    ->whereDate('recorded_date', $date)
                    ->sum('value');
            })->toArray();
        }

        return $result;
    }
}
