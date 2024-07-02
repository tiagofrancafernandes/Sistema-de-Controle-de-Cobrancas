<?php

namespace App\Core\Crud\Core\Concepts\Layout\Grid\Enums;

enum ColSpanSizeEnum: string
{
    case ONE = '1';
    case TWO = '2';
    case THREE = '3';
    case FOUR = '4';
    case SIX = '6';
    case EIGHT = '8';
    case TWELVE = '12';
    case FULL = 'full';
    case HALF = '100/50';
    case AUTO = 'auto';

    public static function getHalfOfGrid(GridSizeEnum $grid): static
    {
        return $grid?->getHalf();
    }

    public static function getHalfOf(GridSizeEnum $grid): static
    {
        return static::getHalfOfGrid($grid);
    }

    public function getFullGrid(): ?GridSizeEnum
    {
        return GridSizeEnum::getFullGridFrom($this);
    }

    public static function getFullGridFor(ColSpanSizeEnum $gridSizeEnum): ?GridSizeEnum
    {
        return GridSizeEnum::getFullGridFrom($gridSizeEnum);
    }

    public static function getColClassForGrid(GridSizeEnum $grid): ?string
    {
        /**
         * @var ColSpanSizeEnum $colSpanEnum
         */
        $colSpanEnum = $grid?->getFull();

        return $colSpanEnum?->getClass() ?: null;
    }

    public function getClass(): ?string
    {
        $colSpanEnum = $this;
        $grid = $colSpanEnum?->getFullGrid();
        $halfColSpanEnum = $grid ? static::getHalfOfGrid($grid) : null;
        $fullColSpanEnum = $grid ? $grid?->getFullGridFrom($colSpanEnum) : null;

        return match ($colSpanEnum) {
            static::ONE => 'col-span-1',
            static::TWO => 'col-span-2',
            static::THREE => 'col-span-3',
            static::FOUR => 'col-span-4',
            static::SIX => 'col-span-6',
            static::EIGHT => 'col-span-8 ',
            static::TWELVE => 'col-span-12',
            static::HALF => $halfColSpanEnum ? sprintf('col-span-%s', $halfColSpanEnum?->value ?: 12) : 'col-span-12',
            static::FULL => sprintf('col-span-%s', $fullColSpanEnum?->value ?: 12),
            default => 'col-span-12',
        };
    }

    public function label(): string
    {
        return $this?->name;
    }
}
