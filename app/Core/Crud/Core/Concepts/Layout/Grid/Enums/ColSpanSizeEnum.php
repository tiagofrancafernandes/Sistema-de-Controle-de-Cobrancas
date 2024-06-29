<?php

namespace App\Core\Crud\Core\Concepts\Layout\Grid\Enums;

enum ColSpanSizeEnum
{
    case ONE;
    case TWO;
    case THREE;
    case FOUR;
    case SIX;
    case EIGHT;
    case TWELVE;
    case FULL;
    case HALF;
    case AUTO;

    public static function getHalfOfGrid(GridSizeEnum $grid): static
    {
        return $grid?->getHalf();
    }

    public static function getHalfOf(GridSizeEnum $grid): static
    {
        return static::getHalfOfGrid($grid);
    }

    public function getClass(?GridSizeEnum $grid = null): string
    {
        $colSpanEnum = $grid ? $grid?->getFull() : $this;
        $halfColSpanEnum = $grid ? static::getHalfOfGrid($grid)?->value : null;

        return match ($colSpanEnum) {
            static::ONE => 'col-span-1',
            static::TWO => 'col-span-2',
            static::THREE => 'col-span-3',
            static::FOUR => 'col-span-4',
            static::SIX => 'col-span-6',
            static::EIGHT => 'col-span-8 ',
            static::TWELVE => 'col-span-12',
            static::HALF => $halfColSpanEnum ? sprintf('col-span-%s', $halfColSpanEnum ?: 12) : 'col-span-12',
            static::FULL => 'col-span-12',
            default => 'col-span-12',
        };
    }
}
