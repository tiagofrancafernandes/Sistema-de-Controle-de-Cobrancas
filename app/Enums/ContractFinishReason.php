<?php

namespace App\Enums;

enum ContractFinishReason: int
{
    case END_OF_TERM = 10;
    case CANCELLATION = 20;
    case OTHERS = 30;
}
