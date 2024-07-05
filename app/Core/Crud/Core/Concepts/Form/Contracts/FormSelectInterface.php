<?php

namespace App\Core\Crud\Core\Concepts\Form\Contracts;

interface FormSelectInterface extends FormInputInterface
{
    public function multiple(null|Closure|bool $multiple = true): static;
    public function isMultiple(): bool;
    public function addOption(FormSelectOptionInterface $option): static;
    public function options(array $options): static;

    /**
     * @var array<int, FormSelectOptionInterface>
     */
    public function getOptions(): array;
}
