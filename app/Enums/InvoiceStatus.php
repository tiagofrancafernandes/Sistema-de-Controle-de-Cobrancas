<?php

namespace App\Enums;

enum InvoiceStatus: int
{
    case PAID = 10;
    case WAITING_3RD = 20;
    case OPEN = 30;
    case CANCELED = 40;
}
