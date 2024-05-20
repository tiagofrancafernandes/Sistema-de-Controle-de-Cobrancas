<?php

namespace App\Enums;

enum ItemStatus: int
{
    case AVAILABLE = 10;
    case UNAVAILABLE = 20;
    case TEMPORARY_UNAVAILABLE = 30;
}
