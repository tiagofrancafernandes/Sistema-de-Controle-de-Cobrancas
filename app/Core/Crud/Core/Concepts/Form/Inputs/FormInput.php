<?php

namespace App\Core\Crud\Core\Concepts\Form\Inputs;

use App\Core\Crud\Core\Concepts\Form\Contracts\FormInputInterface;

abstract class FormInput implements FormInputInterface
{
    protected null|Closure|string $title = null;
    protected null|Closure|bool $resettable = null;
    protected null|Closure|string $name = null;
    protected null|array|ColSpanSizeEnum $colSpan = null;
    protected null|Closure|string $label = null; // ?: title
    protected null|Closure|string|int|float|bool|DateTime $value = null;
    // [items]
    // [options]
    // ?type ?: 'text' {'text'|'number'|'date'|'datetime'|'datepicker'|'checkbox'}

    /*
    - title
    - (?resettable?)
    - name
    - colSpan
    - [items]
    - title
    - (?resettable?)
    - name
    - colSpan
    - [options]
    - title
    - name
    - colSpan
    - ?label ?: title
    - ?type ?: 'text' {'text'|'number'|'date'|'datetime'|'datepicker'|'checkbox'}
    - ?value (int|bool|float|DateTime|string)
    - (?resettable?)
    */
}
