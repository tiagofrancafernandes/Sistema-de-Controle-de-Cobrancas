<?php

namespace App\Core\Crud\Core\Concepts\Form\Enums;

enum InputTypeEnum: string
{
    case TEXT = 'text';
    case NUMBER = 'number';
    case DATE = 'date';
    case DATETIME = 'datetime';
    case DATEPICKER = 'datepicker';
    case CHECKBOX = 'checkbox';
}
