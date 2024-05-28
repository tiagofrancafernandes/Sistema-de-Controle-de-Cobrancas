<?php

namespace App\Enums;

enum ProposalStaus: int
{
    case CREATED = 10;
    case SENT = 20;
    case WAITING = 30;
    case ACCEPTED = 40;
    case EXPIRED = 50;
    case CANCELED = 60;
}
