<?php

namespace App\Enums;

enum EntityDocumentType: int
{
    case CPF = 10;
    case CNPJ = 20;
    case OTHER = 30;
}
