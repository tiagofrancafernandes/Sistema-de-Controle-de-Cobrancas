<?php

namespace App\Core\Crud\Core\Concepts;

use Illuminate\Contracts\Support\Htmlable;

class StringHelpers
{
    public static function valueToString(null|\Closure|\Stringable|Htmlable|string $value = null, ...$args): ?string
    {
        if (is_null($value)) {
            return null;
        }

        if (is_string($value)) {
            return $value;
        }

        if (!is_object($value)) {
            return strval($value);
        }

        if (is_a($value, \Closure::class)) {
            return strval($value(...$args));
        }

        if (in_array(Htmlable::class, class_implements($value))) {
            return $value->toHtml();
        }

        if (in_array(\Stringable::class, class_implements($value))) {
            return $value->__toString();
        }

        return strval($value);
    }
}
