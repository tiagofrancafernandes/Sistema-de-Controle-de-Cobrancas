<?php

namespace App\Core\Crud\Core\Concepts\Filter\Contracts;

use App\Core\Crud\Core\Concepts\Layout\Grid\Enums\GridSizeEnum;
use Closure;
use App\Core\Crud\Core\Concepts\Contracts\AsPropsContracts;

/**
 * @property null|bool|Closure $resettable
 * @property null|bool|Closure $show
 * @property null|bool|Closure $submitOnChange
 * @property null|bool|Closure $schema
 */
interface FilterContract extends AsPropsContracts
{
    public function resettable(bool|Closure $resettable): static;
    public function isResettable(): bool;
    public function show(bool|Closure $show = true): static;
    public function toShow(): bool;
    public function freeSearch(bool|FreeSearchInputFilterContract $freeSearch = false): static;
    public function getfreeSearch(): FreeSearchInputFilterContract|bool;
    public function submitOnChange(bool|Closure $submitOnChange = true): static;
    public function toSubmitOnChange(): bool;
    public function pushToSchema(
        FilterInputInterface|FilterRadioInterface|FilterCheckboxInterface|FilterSelectInterface $item,
    ): static;
    public function schema(array|Closure $schema): static;
    public function getSchema(): array;
    public function gridSize(GridSizeEnum $gridSize): static;
    public function getGridSize(): GridSizeEnum;
    public function submitFiltersButtonLabel(string|Closure $submitFiltersButtonLabel): static;
    public function getSubmitFiltersButtonLabel(): string; // 'Apply filters'
    public function resetFiltersButtonLabel(string|Closure $resetFiltersButtonLabel): static;
    public function getResetFiltersButtonLabel(): string; // 'Reset filters'
    public function showResetFiltersButton(bool|Closure $showResetFiltersButton): static;
    public function toShowResetFiltersButton(): bool;

    /*
        - ?show? ?? true
        - gridSize()
        - ?submitOnChange? ?? false
            - if yes, require delay (debounce)
            - if not, will show 'Apply filters' button
        - ?showResetFiltersButton? ?? true
            - if yes, will show 'Reset filters' button
        - ?submitFiltersButtonLabel ?? 'Apply filters' (string)
        - ?resetFiltersButtonLabel ?? 'Reset filters' (string)
    */
}
