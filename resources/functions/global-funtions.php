<?php

use Illuminate\Support\Fluent;

if (!function_exists('fluent')) {
    /**
     * function fluent
     *
     * @param mixed $data
     *
     * @return Fluent
     */
    function fluent($data = []): Fluent
    {
        if (is_a($data, Fluent::class)) {
            return $data;
        }

        return new Fluent(
            is_iterable($data) ? $data : [$data]
        );
    }
}
