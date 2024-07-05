<?php

namespace App\Core\Crud\Core\Concepts\Filter\Concerns;

use App\Core\Crud\Core\Concepts\Layout\Grid\Enums\GridSizeEnum;
use App\Helpers\EvaluateClosure;
use Closure;
use App\Core\Crud\Core\Concepts\Filter\Contracts\FreeSearchInputFilterContract;
use App\Core\Crud\Core\Concepts\Filter\Contracts\FilterSelectInterface;
use App\Core\Crud\Core\Concepts\Filter\Contracts\FilterCheckboxInterface;
use App\Core\Crud\Core\Concepts\Filter\Contracts\FilterRadioInterface;
use App\Core\Crud\Core\Concepts\Filter\Contracts\FilterInputInterface;

trait HasFilterContractMethods
{
    protected null|bool|Closure $resettable = null;
    protected null|bool|Closure $show = null;
    protected null|bool|FreeSearchInputFilterContract $freeSearch = null;
    protected null|bool|Closure $submitOnChange = null;
    protected null|array $schema = null;
    protected null|GridSizeEnum $gridSize = null;
    protected null|string|Closure $submitFiltersButtonLabel = null;
    protected null|string|Closure $resetFiltersButtonLabel = null;
    protected null|bool|Closure $showResetFiltersButton = null;

    public function resettable(bool|Closure $resettable): static
    {
        $this->resettable = $resettable;

        return $this;
    }

    public function isResettable(): bool
    {
        return EvaluateClosure::toBoolOrNull($this->resettable, true, $this) ?? true;
    }

    public function show(bool|Closure $show = true): static
    {
        $this->show = $show;

        return $this;
    }

    public function toShow(): bool
    {
        return EvaluateClosure::toBoolOrNull($this->show, true, $this) ?? true;
    }

    public function freeSearch(bool|FreeSearchInputFilterContract $freeSearch = false): static
    {
        $this->freeSearch = $freeSearch;

        return $this;
    }

    public function getfreeSearch(): FreeSearchInputFilterContract|bool
    {
        $result = EvaluateClosure::evaluate($this->freeSearch ?? false, $this);

        return is_bool($result) || is_a($result, FreeSearchInputFilterContract::class) ? $result : false;
    }

    public function submitOnChange(bool|Closure $submitOnChange = true): static
    {
        $this->submitOnChange = $submitOnChange;

        return $this;
    }

    public function toSubmitOnChange(): bool
    {
        return EvaluateClosure::toBoolOrNull($this->submitOnChange, true, $this) ?? true;
    }

    public function pushToSchema(
        FilterInputInterface|FilterRadioInterface|FilterCheckboxInterface|FilterSelectInterface $item,
    ): static {
        $this->schema ??= [];
        $this->schema[] = $item;

        return $this;
    }

    public function schema(array|Closure $schema): static // WIP
    {
        $this->schema = $schema;

        return $this;
    }

    public function getSchema(): array // WIP
    {
        $schema = array_values(
            array_filter(
                EvaluateClosure::toArray($this->schema, $this),
                fn ($item) => EvaluateClosure::isInstaceOf($item, ...[
                    FilterInputInterface::class,
                    FilterRadioInterface::class,
                    FilterCheckboxInterface::class,
                    FilterSelectInterface::class,
                ])
            )
        );

        if (is_array($schema)) {
            $schema = array_map(function ($input) {
                dump($input);
                $input->gridSize($this->getGridSize());

                return $input;
            }, $schema);
        }

        return $schema;
    }

    public function gridSize(GridSizeEnum $gridSize): static
    {
        $this->gridSize = $gridSize;

        return $this;
    }

    public function getGridSize(): GridSizeEnum
    {
        $result = EvaluateClosure::evaluate($this->gridSize, $this);

        return is_a($result, GridSizeEnum::class) ? $result : GridSizeEnum::TWELVE;
    }

    public function submitFiltersButtonLabel(string|Closure $submitFiltersButtonLabel): static
    {
        $this->submitFiltersButtonLabel = $submitFiltersButtonLabel;

        return $this;
    }

    public function getSubmitFiltersButtonLabel(): string
    {
        return EvaluateClosure::toStringOrNull(
            $this->submitFiltersButtonLabel,
            $this
        ) ?? __('easy-crud/filters.apply_filters');
    }

    public function resetFiltersButtonLabel(string|Closure $resetFiltersButtonLabel): static
    {
        $this->resetFiltersButtonLabel = $resetFiltersButtonLabel;

        return $this;
    }

    public function getResetFiltersButtonLabel(): string
    {
        return EvaluateClosure::toStringOrNull(
            $this->resetFiltersButtonLabel,
            $this
        ) ?? __('easy-crud/filters.reset_filters');
    }

    public function showResetFiltersButton(bool|Closure $showResetFiltersButton): static
    {
        $this->showResetFiltersButton = $showResetFiltersButton;

        return $this;
    }

    public function toShowResetFiltersButton(): bool
    {
        return EvaluateClosure::toBoolOrNull($this->showResetFiltersButton, null, $this) ?? true;
    }
}
