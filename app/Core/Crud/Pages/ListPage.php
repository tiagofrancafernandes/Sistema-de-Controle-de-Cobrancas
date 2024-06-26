<?php

namespace App\Core\Crud\Pages;

use Closure;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use App\Helpers\EvaluateClosure;
use App\Core\Crud\Core\TableHeaders;

class ListPage
{
    protected null|string|int|float $pageUid = null;
    protected null|string|Closure $pageTitle = null;
    protected null|array|Closure $pageConfig = null;
    protected null|string|Closure $pageSubtitle = null;
    protected null|array|Closure $table = null;
    protected null|LengthAwarePaginator $paginatedRecords = null;
    protected null|array|Closure|LengthAwarePaginator|EloquentCollection|Collection $records = null;

    public function __construct(
        null|array|Closure $pageConfig = null,
    ) {
        $this->pageUid ??= uniqid();
        $this->setPageConfig($pageConfig);
    }

    public static function make(...$args): static
    {
        return new static(...$args);
    }

    public function getPageUid(): string
    {
        $this->pageUid = strval($this->pageUid ?: '');
        $this->pageUid = strlen($this->pageUid) >= 5 ? $this->pageUid : uniqid();

        return $this->pageUid;
    }

    public function setPageConfig(null|array|Closure $pageConfig = null): static
    {
        $this->pageConfig = $pageConfig;

        return $this;
    }

    public function getPageConfig(null|array|Closure $pageConfig = null): array
    {
        return EvaluateClosure::toArray($pageConfig ?? $this->pageConfig);
    }

    public function getTableHeaders(): array
    {
        return $this->getTable()['headers'] ?? [];
    }

    public function setTable(null|array|Closure $table = null): static
    {
        $this->table = $table;

        return $this;
    }

    public function getTable(null|array|Closure $table = null, bool $merge = false): array
    {
        $table = !is_null($table) ? EvaluateClosure::toArray($table, $this) : null;

        if (is_array($table) && !$merge) {
            return $table;
        }

        $instTable = EvaluateClosure::toArray($this->table, $this);

        if (!$merge) {
            return $instTable;
        }

        $tableHeaders = TableHeaders::make();
        $tableHeaders->add('id', __('ID'), [], false);

        return array_merge(
            [
                'headers' => $tableHeaders->getHeaders(true),
            ],
            $instTable ?? [],
            $table ?? [],
        );
    }

    public function getCachedTable(null|array|Closure $table = null, bool $merge = false, bool $refreshCache = false): array
    {
        if ($refreshCache) {
            cache()->forget(__METHOD__ . $this->getPageUid());
        }

        return (array) cache()->remember(
            __METHOD__ . $this->getPageUid(),
            30,
            fn () => $this->getTable($table, $merge)
        );
    }

    public function setPageTitle(null|string|Closure $pageTitle = null): static
    {
        $this->pageTitle = $pageTitle;

        return $this;
    }

    public function getPageTitle(null|string|Closure $pageTitle = null): string
    {
        return EvaluateClosure::toString($pageTitle ?? $this->pageTitle);
    }

    public function setPageSubtitle(null|string|Closure $pageSubtitle = null): static
    {
        $this->pageSubtitle = $pageSubtitle;

        return $this;
    }

    public function getPageSubtitle(null|string|Closure $pageSubtitle = null): string
    {
        return EvaluateClosure::toString($pageSubtitle ?? $this->pageSubtitle);
    }

    public function setPaginatedRecords(null|LengthAwarePaginator $paginatedRecords = null): static
    {
        $this->paginatedRecords = $paginatedRecords;

        return $this;
    }

    public function getPaginatedRecords(): ?LengthAwarePaginator
    {
        return is_a($this->paginatedRecords, LengthAwarePaginator::class) ? $this->paginatedRecords : null;
    }

    public function setRecords(
        null|array|Closure|LengthAwarePaginator|EloquentCollection|Collection $records = null,
    ): static {
        $this->records = $records;

        return $this;
    }

    public function getRecords(): array|LengthAwarePaginator|EloquentCollection|Collection
    {
        $records = EvaluateClosure::evaluate(
            $this->getPaginatedRecords() ?: ($this->records ?? null),
            $this
        );

        if (
            EvaluateClosure::isInstaceOf(
                $records,
                [
                    'array',
                    LengthAwarePaginator::class,
                    EloquentCollection::class,
                    Collection::class,
                ]
            )
        ) {
            return $records;
        }

        return [];
    }

    public function getPageData(): array
    {
        $data = [];

        $data['records'] = $this->paginatedRecords ? $this->getRecords() : [];
        $data['table'] = $this->getTable();
        $data['pageTitle'] = $this->getPageTitle();
        $data['pageSubtitle'] = $this->getPageSubtitle();
        $data['pageData'] = $this->getPageData();
        $data['page'] = $this;

        return $data;
    }
}
