<?php

namespace App\Enums;

enum CacheExpirationEnums: string
{
    case MINUTES_15 = 'PT15M';
    case MINUTES_30 = 'PT30M';
    case HOURS_1    = 'PT1H';
    case HOURS_6    = 'PT6H';
    case HOURS_12   = 'PT12H';
    case DAY_1      = 'P1D';
}
