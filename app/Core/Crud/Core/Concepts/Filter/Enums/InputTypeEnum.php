<?php

namespace App\Core\Crud\Core\Concepts\Filter\Enums;

enum InputTypeEnum: string
{
    case TEXT = 'text';
    case NUMBER = 'number';
    case DATE = 'date';
    case DATETIME = 'datetime';
    case DATEPICKER = 'datepicker';
    case CHECKBOX = 'checkbox';
}
