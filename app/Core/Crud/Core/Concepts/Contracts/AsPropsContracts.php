<?php

namespace App\Core\Crud\Core\Concepts\Contracts;

interface AsPropsContracts
{
    public function asProps(
        array $extraProps = [],
        bool $replace = false,
    ): array;
}
