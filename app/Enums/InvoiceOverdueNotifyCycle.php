<?php

namespace App\Enums;

enum InvoiceOverdueNotifyCycle: int
{
    case ONCE = 10;
    case DAILY = 20;
    case WEEKLY = 30;
    case DO_NOT_NOTIFY = 40;
}
