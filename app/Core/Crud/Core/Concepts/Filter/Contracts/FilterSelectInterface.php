<?php

namespace App\Core\Crud\Core\Concepts\Filter\Contracts;

interface FilterSelectInterface extends FilterInputInterface
{
    public function multiple(null|Closure|bool $multiple = true): static;
    public function isMultiple(): bool;
    public function addOption(FilterSelectOptionInterface $option): static;
    public function options(array $options): static;

    /**
     * @var array<int, FilterSelectOptionInterface>
     */
    public function getOptions(): array;
}
