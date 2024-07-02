<?php

declare(strict_types=1);

namespace App\Core\Crud\Core\Concepts\Layout\Grid\Helpers;

use Illuminate\Support\Collection;
use App\Core\Crud\Core\Concepts\Layout\Grid\Enums\GridSizeEnum;
use App\Core\Crud\Core\Concepts\Layout\Grid\Enums\ColSpanSizeEnum;

class GridHelpers
{
    protected static null|Collection $gridSizeStructure = null;

    public static function generateGridSizeStructure(): Collection
    {
        $gridStructure = collect(GridSizeEnum::cases())
            ->map(function (GridSizeEnum $grid) {
                $colSpanList = collect($grid?->getColSpanList());

                return [
                    'name' => $grid?->name ?? null,
                    'label' => $grid?->label() ?? null,
                    'value' => $grid?->value ?? null,
                    'class' => $grid->getClass(),
                    'colSpanList' => $colSpanList->map(fn (ColSpanSizeEnum $colSpan) => [
                        'name' => $colSpan?->name ?? null,
                        'label' => $colSpan?->label() ?? null,
                        'value' => $colSpan?->value ?? null,
                        'class' => $colSpan->getClass(),
                        'enum' => $colSpan,
                    ]),
                    'enum' => $grid,
                ];
            });

        return collect([
            'items' => $gridStructure,
            'generatedAt' => now(),
        ]);
    }

    public static function gridSizeStructure(bool $refreshCache = false): Collection
    {
        if ($refreshCache) {
            static::$gridSizeStructure = null;
        }

        static::$gridSizeStructure = static::$gridSizeStructure ?? static::generateGridSizeStructure();

        return static::$gridSizeStructure;
    }

    public static function gridStructureList(): Collection
    {
        $items = static::gridSizeStructure()?->get('items') ?? collect();

        return $items;
    }

    public static function gridOptionList(
        ?string $labelKey = null,
        ?string $valueKey = null,
        ?\Closure $mapUsing = null,
    ): Collection {
        $labelKey ??= 'label';
        $valueKey ??= 'value';

        $gridStructureList = static::gridStructureList();

        return ($mapUsing ? $gridStructureList?->map($mapUsing) : $gridStructureList)
            ->pluck(
                $labelKey,
                $valueKey,
            );
    }

    public static function getGridStructure(GridSizeEnum $gridSize): array
    {
        return static::gridSizeStructure()
            ->get('items')
            ->first(
                fn ($item) => ($item['enum'] ?? null) === $gridSize
            ) ?: [];
    }

    public static function colSpanOptionList(
        ?string $labelKey = null,
        ?string $valueKey = null,
        ?\Closure $mapUsing = null,
        ?GridSizeEnum $gridSize = null,
    ): Collection {
        $labelKey ??= null;
        $valueKey ??= 'value';

        $gridStructureList = static::gridStructureList()->where(function ($item) use ($gridSize) {
            if ($gridSize) {
                return ($item['enum'] ?? null) === $gridSize;
            }

            return $item;
        })
            ->values()
            ->pluck('colSpanList')
            ->flatMap(fn ($item) => $item);

        $labelKey ??= is_null($mapUsing) ? 'custom_label' : 'label';

        $mapUsing ??= function ($item) {
            $item['custom_label'] = sprintf('%s (%s)', $item['value'] ?? null, $item['class'] ?? null);

            return $item;
        };

        /**
         * @var Collection $gridStructureList
         */
        $gridStructureList = $mapUsing ? $gridStructureList?->map($mapUsing) : $gridStructureList;

        return $gridStructureList
            ->pluck(
                $labelKey,
                $valueKey,
            );
    }
}
