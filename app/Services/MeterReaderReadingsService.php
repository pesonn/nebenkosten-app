<?php

namespace App\Services;

use App\Exceptions\MeterReadingNotFoundException;
use App\Models\MeterReader;
use App\Models\MeterReading;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ItemNotFoundException;

class MeterReaderReadingsService
{

    public function __construct(private MeterReader $meterReader)
    {
        //
    }

    /**
     * @throws MeterReadingNotFoundException|ModelNotFoundException
     * @returns MeterReading
     */
    public function getClosestReadingToDate(Carbon $date): MeterReading
    {
        $dbDriver = config("database.connections." . config('database.default') . ".driver");

        $meterReading = match ($dbDriver) {
            'sqlite' => $this->meterReader->meterReadings()
                ->whereRaw('julianday(reading_date) <= julianday(?)', [$date])
                ->orderByRaw('ABS(julianday(reading_date) - julianday(?))', [$date])
                ->firstOrFail(),
            default => $this->meterReader->meterReadings()
                ->whereRaw('DATEDIFF(reading_date, ?) <= 0', [$date])
                ->orderByRaw('ABS(DATEDIFF(reading_date, ?))', [$date])
                ->firstOrFail(),
        };

        if (!Carbon::parse($meterReading->reading_date)->diffInDays($date) > 8) {
            throw new MeterReadingNotFoundException(
                "Missing Meter Reading: No Reading found at given date including 7 days before."
            );
        }

        return $meterReading;
    }

    /**
     * Month (1-12) and Year (YYYY)
     * @returns Collection<MeterReading>
     */
    public function getReadingsFromMonth(int $month, int $year): Collection
    {
        $monthStart = Carbon::create(year: $year, month: $month)->startOfMonth();

        return $this->getReadingsBetweenTimestamps($monthStart, $monthStart->copy()->endOfMonth());
    }

    /**
     * Year (YYYY)
     * @returns Collection<MeterReading>
     */
    public function getReadingsFromYear(int $year): Collection
    {
        $yearStart = Carbon::create(year: $year)->startOfYear();

        return $this->getReadingsBetweenTimestamps($yearStart, $yearStart->copy()->endOfYear());
    }

    private function getReadingsBetweenTimestamps(Carbon $from, Carbon $to): Collection
    {
        return $this->meterReader->meterReadings()
            ->whereBetween('reading_date', [$from, $to,])
            ->orderBy('reading_date')
            ->get();
    }
}
