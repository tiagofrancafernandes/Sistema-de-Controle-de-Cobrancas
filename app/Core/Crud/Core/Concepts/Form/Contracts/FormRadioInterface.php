<?php

namespace App\Core\Crud\Core\Concepts\Form\Contracts;

interface FormRadioInterface extends FormInputInterface
{
    public function addItem(FormRadioItemInterface $item): static;
    public function items(array $items): static;

    /**
     * @var array<int, FormRadioItemInterface>
     */
    public function getItems(): array;
}
