<?php

namespace App\Core\Crud\Core\Concepts\Filter\Contracts;

interface FilterCheckboxInterface extends FilterInputInterface
{
    public function addItem(FilterCheckboxItemInterface $item): static;
    public function items(array $items): static;

    /**
     * @var array<int, FilterCheckboxItemInterface>
     */
    public function getItems(): array;
}
