<?php

namespace App\Core\Crud\Core\Concepts\Form\Contracts;

use Closure;
use DateTime;
use Stringable;

interface FormCheckboxItemInterface
{
    public function disabled(null|Closure|bool $disabled = null): static;
    public function isDisabled(): bool;
    public function checked(null|Closure|bool $checked = null): static;
    public function isChecked(): bool;
    public function label(null|Closure|string $label = null): static;
    public function getLabel(): string;
    public function value(null|Closure|string|int|float|bool|DateTime $value = null): static;
    public function getValue(): Stringable;
}
