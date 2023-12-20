<?php

namespace App\Services;

use App\Enums\FlightStatusEnum;
use App\Exceptions\LogicException;
use PrinsFrank\Standards\Country\CountryAlpha2;
use PrinsFrank\Standards\Country\Groups\EU;

class FlightClaimService
{
    /**
     * @throws LogicException
     */
    public function isFlightClaimable(?string $country = null, ?string $status = null, ?int $details = null): bool
    {
        if (! $country || ! $status || ! $details) {
            throw new LogicException('Flight data is missing!');
        }

        if  ($this->isDepartureFromEU($country)) {
            if ($this->isCanceledWithin14Days($status, $details)
            || $this->isDepartureDelayed($status, $details)) {
                return true;
            }
        }

        return false;
    }

    protected function isDepartureFromEU(string $country): bool
    {
        return CountryAlpha2::from($country)->isMemberOf(EU::class);
    }

    protected function isCanceledWithin14Days(string $status, int $details): bool
    {
        return $status === FlightStatusEnum::Canceled->value && $details <= 14;
    }

    protected function isDepartureDelayed(string $status, int $details): bool
    {
        return $status === FlightStatusEnum::Delayed->value && $details >= 3;
    }
}