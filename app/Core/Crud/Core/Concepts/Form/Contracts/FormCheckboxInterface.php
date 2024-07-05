<?php

namespace App\Core\Crud\Core\Concepts\Form\Contracts;

interface FormCheckboxInterface extends FormInputInterface
{
    public function addItem(FormCheckboxItemInterface $item): static;
    public function items(array $items): static;

    /**
     * @var array<int, FormCheckboxItemInterface>
     */
    public function getItems(): array;
}
