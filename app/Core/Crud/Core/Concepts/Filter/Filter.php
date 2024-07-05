<?php

namespace App\Core\Crud\Core\Concepts\Filter;

use App\Core\Crud\Core\Concepts\Filter\Contracts\FilterContract;
use App\Core\Crud\Core\Concepts\Filter\Concerns\HasFilterContractMethods;
use App\Core\Crud\Core\Concepts\Filter\Contracts\FreeSearchInputFilterContract;
use Closure;
use App\Core\Crud\Core\Concepts\Layout\Grid\Enums\GridSizeEnum;

class Filter implements FilterContract
{
    use HasFilterContractMethods;

    public function __construct(
        null|bool|Closure $resettable = null,
        null|bool|Closure $show = null,
        null|bool|FreeSearchInputFilterContract $freeSearch = null,
        null|bool|Closure $submitOnChange = null,
        null|array|Closure $schema = null,
        null|GridSizeEnum $gridSize = null,
        null|string|Closure $submitFiltersButtonLabel = null,
        null|string|Closure $resetFiltersButtonLabel = null,
        null|bool|Closure $showResetFiltersButton = null,
    ) {
        if (filled($resettable)) {
            $this->resettable($resettable);
        }

        if (filled($show)) {
            $this->show($show);
        }

        if (filled($freeSearch)) {
            $this->freeSearch($freeSearch);
        }

        if (filled($submitOnChange)) {
            $this->submitOnChange($submitOnChange);
        }

        if (filled($schema)) {
            $this->schema($schema);
        }

        if (filled($gridSize)) {
            $this->gridSize($gridSize);
        }

        if (filled($submitFiltersButtonLabel)) {
            $this->submitFiltersButtonLabel($submitFiltersButtonLabel);
        }

        if (filled($resetFiltersButtonLabel)) {
            $this->resetFiltersButtonLabel($resetFiltersButtonLabel);
        }

        if (filled($showResetFiltersButton)) {
            $this->showResetFiltersButton($showResetFiltersButton);
        }
    }

    public function asProps(
        array $extraProps = [],
        bool $replace = false,
    ): array {
        $props = fn () => [
            'resettable' => $this->isResettable(),
            'show' => $this->toShow(),
            'freeSearch' => $this->getFreeSearch(),
            'submitOnChange' => $this->toSubmitOnChange(),
            'schema' => $this->getSchema(),
            'gridSize' => $this->getGridSize(),
            'submitFiltersButtonLabel' => $this->getSubmitFiltersButtonLabel(),
            'resetFiltersButtonLabel' => $this->getResetFiltersButtonLabel(),
            'showResetFiltersButton' => $this->toShowResetFiltersButton(),
        ];

        return $replace ? array_merge($props(), $extraProps) : array_merge($extraProps, $props());
    }
}
