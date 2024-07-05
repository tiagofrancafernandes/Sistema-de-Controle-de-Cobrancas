<?php

namespace App\Core\Crud\Core\Concepts\Form\Contracts;

use Closure;
use App\Core\Crud\Core\Concepts\Layout\Grid\Enums\ColSpanSizeEnum;
use DateTime;
use App\Core\Crud\Core\Concepts\Form\Enums\InputTypeEnum;
use Stringable;

interface FormInputInterface
{
    public function title(Closure|string|null $title = null): static;
    public function getTitle(): string;
    public function inputType(Closure|InputTypeEnum|null $inputType = null): static;
    public function getInputType(): InputTypeEnum;
    public function resettable(Closure|bool|null $resettable = null): static;
    public function isResettable(): bool;
    public function name(Closure|string|null $name = null): static;
    public function getName(): string;
    public function colSpan(
        null|string|int|array|ColSpanSizeEnum $colSpan = null,
        null|string|int|ColSpanSizeEnum $colSpanMd = null,
        null|string|int|ColSpanSizeEnum $colSpanLg = null,
    ): static;
    public function getColSpan(): array;
    public function label(Closure|string|null $label = null): static;
    public function getLabel(): string;
    public function value(Closure|string|int|float|bool|DateTime|null $value = null): static;
    public function getValue(): Stringable;
    public function __toString(): string;
    public function toString(): string;
    public function toArray(): array;

    // [items]
    // [options] FormSelectInterface
}
