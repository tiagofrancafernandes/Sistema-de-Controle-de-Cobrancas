<?php

namespace App\Core\Crud\Core\Concepts\Form\Contracts;

use Closure;
use DateTime;
use Stringable;

interface FormSelectOptionInterface
{
    public function disabled(null|Closure|bool $disabled = null): static;
    public function isDisabled(): bool;
    public function selectable(null|Closure|bool $selectable = null): static;
    public function isSelectable(): bool;
    public function selected(null|Closure|bool $selected = null): static;
    public function isSelected(): bool;
    public function label(null|Closure|string $label = null): static;
    public function getLabel(): string;
    public function value(null|Closure|string|int|float|bool|DateTime $value = null): static;
    public function getValue(): Stringable;
}
