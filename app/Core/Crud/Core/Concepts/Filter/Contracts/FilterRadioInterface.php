<?php

namespace App\Core\Crud\Core\Concepts\Filter\Contracts;

interface FilterRadioInterface extends FilterInputInterface
{
    public function addItem(FilterRadioItemInterface $item): static;
    public function items(array $items): static;

    /**
     * @var array<int, FilterRadioItemInterface>
     */
    public function getItems(): array;
}
