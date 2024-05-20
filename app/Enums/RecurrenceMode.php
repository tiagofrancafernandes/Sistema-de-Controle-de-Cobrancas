<?php

namespace App\Enums;

enum RecurrenceMode: int
{
    case DAILY = 10;
    case WEEKLY = 20;
    case BIWEEKLY = 30;
    case MONTHLY = 40;
    case YEARLY = 50;
}
