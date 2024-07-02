<?php

namespace App\Core\Crud\Core\Concepts\Layout\Grid;

use App\Core\Crud\Core\Concepts\Layout\Grid\Helpers\GridHelpers;
use Illuminate\Support\Collection;
use App\Core\Crud\Core\Concepts\Layout\Grid\Enums\GridSizeEnum;

class Grid
{
    protected ?GridSizeEnum $gridSize = null;

    public function __construct(
        GridSizeEnum $gridSize,
    ) {
        $this->gridSize($gridSize);
    }

    public static function make(?GridSizeEnum $gridSize = null): static
    {
        return new static($gridSize ?? GridSizeEnum::TWELVE);
    }

    public function gridSize(GridSizeEnum $gridSize): static
    {
        $this->gridSize = $gridSize;

        return $this;
    }

    public function getGridSize(): GridSizeEnum
    {
        return $this->gridSize;
    }

    public function gridStructure(): array
    {
        return GridHelpers::getGridStructure($this->getGridSize());
    }

    public function getColSpanList(): array|Collection
    {
        $valueKey = 'name';

        return cache()
            ->rememberForever(
                __METHOD__ . ".getGridSize.{$valueKey}." . $this->getGridSize()?->name,
                fn () => GridHelpers::colSpanOptionList(
                    valueKey: $valueKey,
                    gridSize: $this->getGridSize()
                )
            );
    }
}
