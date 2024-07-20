<?php

namespace App\Core\Crud\Core\Concepts\Filter\Contracts;

use Closure;
use App\Core\Crud\Core\Concepts\Layout\Grid\Enums\ColSpanSizeEnum;
use DateTime;
use App\Core\Crud\Core\Concepts\Filter\Enums\InputTypeEnum;
use Stringable;
use App\Core\Crud\Core\Concepts\Contracts\AsPropsContracts;
use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use App\Core\Crud\Core\Concepts\Layout\Grid\Enums\GridSizeEnum;

interface FilterInputInterface extends AsPropsContracts, JsonSerializable, Jsonable
{
    public function title(Closure|string $title): static;
    public function getTitle(): string;
    public function inputType(Closure|InputTypeEnum $inputType): static;
    public function getInputType(): InputTypeEnum;
    public function resettable(Closure|bool $resettable): static;
    public function isResettable(): bool;
    public function name(Closure|string $name): static;
    public function getName(): string;
    public function colSpan(
        null|string|int|array|ColSpanSizeEnum $colSpan = null,
        null|string|int|ColSpanSizeEnum $colSpanMd = null,
        null|string|int|ColSpanSizeEnum $colSpanLg = null,
    ): static;
    public function getColSpan(): array;
    public function label(Closure|string $label): static;
    public function getLabel(): string;
    public function value(Closure|string|int|float|bool|DateTime $value): static;
    // public function getValue(): Stringable;
    public function getValue(): null|string|Stringable;
    public function __toString(): string;
    public function toString(): string;
    public function toArray(): array;
    public function gridSize(GridSizeEnum $gridSize): static;
    public function getGridSize(): null|GridSizeEnum;
    public function getComponent(): string;

    // [items]
    // [options] FilterSelectInterface
}
