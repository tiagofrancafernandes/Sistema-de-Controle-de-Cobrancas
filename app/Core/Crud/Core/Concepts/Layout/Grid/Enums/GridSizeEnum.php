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
    case FULL = 12;

    public static function getHalfOf(GridSizeEnum $grid): ColSpanSizeEnum
    {
        return $grid->getHalf();
    }

    public static function getFullOf(GridSizeEnum $grid): ColSpanSizeEnum
    {
        return $grid->getFull();
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
}
