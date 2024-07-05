<?php

namespace App\Core\Crud\Core\Concepts\Filter\Contracts;

use Closure;
use App\Core\Crud\Core\Concepts\Contracts\AsPropsContracts;

/**
 * @property null|bool|Closure $resettable
 * @property null|bool|Closure $show
 * @property null|bool|Closure $submitOnChange
 * @property null|bool|Closure $schema
 */
interface FreeSearchInputFilterContract extends AsPropsContracts // WIP
{
    public function resettable(bool|Closure $resettable): static;
    public function isResettable(): bool;
    public function show(bool|Closure $show = true): static;
    public function toShow(): bool;
    public function submitOnChange(bool|Closure $submitOnChange = true): static;
    public function toSubmitOnChange(): bool;
    public function schema(array|Closure $schema): static;
    public function getSchema(array|Closure $schema): array;
    public function colSpan(
        null|string|int|array|ColSpanSizeEnum $colSpan = null,
        null|string|int|ColSpanSizeEnum $colSpanMd = null,
        null|string|int|ColSpanSizeEnum $colSpanLg = null,
    ): static;
    public function getColSpan(): array;

    /*
        - (?resettable?)
        - ?show last searches? ?? false <!-- https://componentland.com/component/blog-search-1 -->
            - if true, will cache last search inputs and will show a list of last 5 as 'hastag'
        - ?submitOnChange? ?? {thisFilter.config.submitOnChange}
            - if yes, require delay (debounce)
            - if not, will show 'Search Icon' button
        - [schema]
            - customQuery `customQuery(\Closure $fn)` -> `fn (Builder $query, string $search): Builder => $query`
            - like column `like(string $column)`
            - ilike column `ilike(string $column)`
            - equal text column `equalText(string $column)`
            - equal integer column `equalInteger(string $column)`
            - equal date column `equalDate(string $column)`
            - after date column `afterDate(string $column, bool orEqual = true)`
            - before date column `beforeDate(string $column, bool orEqual = true)`
            - between dates column `betweenDates(string $column)`
    */
}
