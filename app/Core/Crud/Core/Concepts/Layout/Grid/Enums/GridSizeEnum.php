<?php

namespace App\Core\Crud\Core\Concepts\Layout\Grid\Enums;

enum GridSizeEnum: int
{
    case ONE = 1;
    case TWO = 2;
    case THREE = 3;
    case FOUR = 4;
    case SIX = 6;
    case EIGHT = 8;
    case TWELVE = 12;
    case FULL = 100;

    public static function getHalfOf(GridSizeEnum $grid): ColSpanSizeEnum
    {
        return $grid->getHalf();
    }

    public static function getFullOf(GridSizeEnum $grid): ColSpanSizeEnum
    {
        return $grid->getFull();
    }

    public static function getFullGridFrom(ColSpanSizeEnum $gridSizeEnum): ?GridSizeEnum
    {
        return match ($gridSizeEnum) {
            ColSpanSizeEnum::ONE => static::ONE,
            ColSpanSizeEnum::TWO => static::TWO,
            ColSpanSizeEnum::THREE => static::THREE,
            ColSpanSizeEnum::FOUR => static::FOUR,
            ColSpanSizeEnum::SIX => static::SIX,
            ColSpanSizeEnum::EIGHT => static::EIGHT,
            ColSpanSizeEnum::TWELVE => static::TWELVE,
            ColSpanSizeEnum::FULL => static::TWELVE,
            // ColSpanSizeEnum::FULL => static::FULL,

            default => null,
        };
    }

    public function getHalf(): ColSpanSizeEnum
    {
        return match ($this) {
            static::ONE => ColSpanSizeEnum::ONE,
            static::TWO => ColSpanSizeEnum::ONE,
            static::THREE => ColSpanSizeEnum::ONE,
            static::FOUR => ColSpanSizeEnum::TWO,
            static::SIX => ColSpanSizeEnum::THREE,
            static::EIGHT => ColSpanSizeEnum::FOUR,
            static::TWELVE => ColSpanSizeEnum::SIX,
            static::FULL => ColSpanSizeEnum::FULL,

            default => ColSpanSizeEnum::ONE,
        };
    }

    public function getFull(): ColSpanSizeEnum
    {
        return match ($this) {
            static::ONE => ColSpanSizeEnum::ONE,
            static::TWO => ColSpanSizeEnum::TWO,
            static::THREE => ColSpanSizeEnum::THREE,
            static::FOUR => ColSpanSizeEnum::FOUR,
            static::SIX => ColSpanSizeEnum::SIX,
            static::EIGHT => ColSpanSizeEnum::EIGHT,
            static::TWELVE => ColSpanSizeEnum::TWELVE,
            static::FULL => ColSpanSizeEnum::FULL,

            default => ColSpanSizeEnum::ONE,
        };
    }

    public function getColSpanList(): array
    {
        $allCols = [
            ColSpanSizeEnum::ONE,
            ColSpanSizeEnum::TWO,
            ColSpanSizeEnum::THREE,
            ColSpanSizeEnum::FOUR,
            ColSpanSizeEnum::SIX,
            ColSpanSizeEnum::EIGHT,
            ColSpanSizeEnum::TWELVE,
            // ColSpanSizeEnum::FULL,
            // ColSpanSizeEnum::HALF,
            // ColSpanSizeEnum::AUTO,
        ];

        $colList = match ($this) {
            static::ONE => [
                // ColSpanSizeEnum::FULL,
                ColSpanSizeEnum::ONE,
            ],
            static::TWO => [
                // ColSpanSizeEnum::FULL,
                ColSpanSizeEnum::ONE,
                ColSpanSizeEnum::TWO,
            ],
            static::THREE => [
                // ColSpanSizeEnum::FULL,
                ColSpanSizeEnum::ONE,
                ColSpanSizeEnum::TWO,
                ColSpanSizeEnum::THREE,
            ],
            static::FOUR => [
                // ColSpanSizeEnum::FULL,
                ColSpanSizeEnum::ONE,
                ColSpanSizeEnum::TWO,
                ColSpanSizeEnum::THREE,
                ColSpanSizeEnum::FOUR
            ],
            static::SIX => [
                // ColSpanSizeEnum::FULL,
                ColSpanSizeEnum::ONE,
                ColSpanSizeEnum::TWO,
                ColSpanSizeEnum::THREE,
                ColSpanSizeEnum::FOUR,
                ColSpanSizeEnum::SIX,
            ],
            static::EIGHT => [
                // ColSpanSizeEnum::FULL,
                ColSpanSizeEnum::ONE,
                ColSpanSizeEnum::TWO,
                ColSpanSizeEnum::THREE,
                ColSpanSizeEnum::FOUR,
                ColSpanSizeEnum::SIX,
            ],
            static::TWELVE => [
                // ColSpanSizeEnum::FULL,
                ColSpanSizeEnum::ONE,
                ColSpanSizeEnum::TWO,
                ColSpanSizeEnum::THREE,
                ColSpanSizeEnum::FOUR,
                ColSpanSizeEnum::SIX,
            ],
            static::FULL => $allCols,

            default => $allCols,
        };

        return $colList ?? [];
    }

    public static function getClassFor(GridSizeEnum $grid): ?string
    {
        return match ($grid) {
            static::ONE => 'col-span-1',
            static::TWO => 'col-span-2',
            static::THREE => 'col-span-3',
            static::FOUR => 'col-span-4',
            static::SIX => 'col-span-6',
            static::EIGHT => 'col-span-8 ',
            static::TWELVE, static::FULL => 'col-span-12',
            default => 'col-span-12',
        };
    }

    public function getClass(): ?string
    {
        return $this->getClassFor($this);
    }

    public function label(): string
    {
        return $this?->name;
    }
}
