<?php

namespace App\Enums;

enum FlightStatusEnum: string
{
    case Canceled = 'Cancel';
    case Delayed = 'Delay';
}
