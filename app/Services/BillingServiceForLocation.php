<?php

namespace App\Services;

use App\Enums\ServiceTypeCalculationBase;
use App\Exceptions\MeterReadingNotFoundException;
use App\Models\Location;
use App\Models\MeterReader;
use App\Models\ServiceCharges;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class BillingServiceForLocation
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private Location $location,
        private Carbon $startDate,
        private Carbon $endDate
    ) {
        //
    }

    public function calculateExpansesForLocationWithinTimespan(): Collection
    {
        $locationExpanses = collect();

        $serviceChargesWithinTimespan = ServiceCharges::where('location_id', $this->location->id)
            ->whereBetween(
                'period_started_at',
                [$this->startDate, $this->endDate]
            )->get();

        // What if $endDate is earlier than period_ended_at from service charge?

        foreach ($serviceChargesWithinTimespan as $serviceCharge) {
            if ($serviceCharge->isRechargeable() === false) {
                continue;
            }

            match ($serviceCharge->type) {
                ServiceTypeCalculationBase::Percentage => $this->calculatePercentageBasedExpanses(
                    $serviceCharge,
                    $locationExpanses
                ),
                ServiceTypeCalculationBase::Meter => $this->calculateMeterBasedExpanses(
                    $serviceCharge,
                    $locationExpanses
                ),
            };
        }

        return $locationExpanses;
    }

    private function calculatePercentageBasedExpanses(
        ServiceCharges $serviceCharge,
        Collection $locationExpanses
    ): Collection {
        $locationPercentage = $this->location->getPercentageForServiceCharge($serviceCharge);

        $locationShare = $serviceCharge->amount * $locationPercentage;

        $locationExpanses[] = [
            'serviceCharge' => $serviceCharge,
            'locationShare' => $locationShare,
        ];

        return $locationExpanses;
    }

    private function calculateMeterBasedExpanses(
        ServiceCharges $serviceCharge,
        Collection $locationExpanses,
    ): Collection {
        $locationReaderConsumption = 0;
        $totalServiceChargeConsumption = 0;

        foreach ($serviceCharge->meterReaders as $meterReader) {
            try {
                $consumption = $this->calculateConsumptionForReader($meterReader);
            } catch (MeterReadingNotFoundException $exception) {
                $locationExpanses[] = [
                    'serviceCharge' => $serviceCharge,
                    'locationShare' => null,
                    'error' => $exception->getMessage(),
                ];

                return $locationExpanses;
            }
            if ($meterReader->location === $this->location->id) {
                $locationReaderConsumption = $consumption;
            }

            $totalServiceChargeConsumption += $consumption;
        }

        $locationConsumptionRatio = $locationReaderConsumption / $totalServiceChargeConsumption;

        $locationShare = $serviceCharge->amount * $locationConsumptionRatio;

        $locationExpanses[] = [
            'serviceCharge' => $serviceCharge,
            'locationShare' => $locationShare,
        ];

        return $locationExpanses;
    }

    /**
     * @throws MeterReadingNotFoundException
     */
    private function calculateConsumptionForReader(MeterReader $meterReader): float
    {
        $readingServiceForLocation = new MeterReaderReadingsService($meterReader);
        $startReading = $readingServiceForLocation->getClosestReadingToDate($this->startDate);
        $endReading = $readingServiceForLocation->getClosestReadingToDate($this->endDate);
        //TODO: Future Feature: Calculate consumption average based on days within given Reading Dates.

        $getReadingsDiff = $endReading->reading - $startReading->reading;
    }

}
