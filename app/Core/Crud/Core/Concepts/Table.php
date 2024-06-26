<?php

namespace App\Core\Crud\Core\Concepts;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

/*
table
    columns
        - label
        - key
        - ?content
        - props
            - staticProps
            - dynamicProps
        - ?component
*/

class Table
{
    protected ?array $columns = null;
    protected ?\Illuminate\Http\Request $request = null;
    protected null|array|\Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection $staticRecords = null;
    protected null|EloquentBuilder|QueryBuilder $queryBuilder = null;

    public function __construct(
        array $columns = [],
        null|EloquentBuilder|QueryBuilder $queryBuilder = null,
        null|array|\Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection $staticRecords = null,
    ) {
        $this->columns($columns);
        $this->queryBuilder($queryBuilder);
        $this->staticRecords($staticRecords);
    }

    public function staticRecords(null|array|\Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection $staticRecords): static
    {
        $this->staticRecords = $staticRecords;

        return $this;
    }

    public function getStaticRecords(): null|array|\Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection
    {
        return $this->staticRecords;
    }

    public function getRecords(): array|\Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection
    {
        $records = $this->getStaticRecords();

        if (!is_null($records)) {
            return $records;
        }

        $queryBuilder = $this->getQueryBuilder();

        if (is_null($queryBuilder)) {
            return [];
        }

        $queryBuilder = is_a($queryBuilder, EloquentBuilder::class)
            ? $queryBuilder?->limit($this->getRecordsLimit())->offset($this->getRecordsOffset())  // Paginate or Limit?
            : $queryBuilder?->limit($this->getRecordsLimit())->offset($this->getRecordsOffset());

        return $queryBuilder->get() ?? [];
    }

    public function getRecordsCount(): int
    {
        $records = $this->getStaticRecords();

        if (!is_null($records)) {
            return collect($records ?? [])->count();
        }

        $queryBuilder = $this->getQueryBuilder();

        if (is_null($queryBuilder)) {
            return 0;
        }

        return intval(
            is_a($queryBuilder, EloquentBuilder::class)
            ? $queryBuilder?->count()
            : $queryBuilder?->count()
        );
    }

    public function queryBuilder(null|EloquentBuilder|QueryBuilder $queryBuilder): static
    {
        $this->queryBuilder = $queryBuilder;

        return $this;
    }

    public function getQueryBuilder(): null|EloquentBuilder|QueryBuilder
    {
        return $this->queryBuilder;
    }

    public function setRequest(\Illuminate\Http\Request $request): static
    {
        $this->request = $request;

        return $this;
    }

    public function getRequest(): \Illuminate\Http\Request
    {
        return $this->request ?? request();
    }

    public function getRecordsLimit(): int
    {
        return 10;
    }

    public function getRecordsPagination(): RecordsPagination // WIP
    {
        /**
         * @var RecordsPagination $recordsPagination
         */
        return new RecordsPagination();
    }

    public function getPageNumber(): int // WIP
    {
        $pageNumber = $this->getRequest()->input('page');
        $pageNumber = filter_var($pageNumber, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);

        return $pageNumber && $pageNumber > 0 ? $pageNumber : 1;
    }

    public function getRecordsOffset(): int // WIP
    {
        $pageNumber = $this->getPageNumber();

        return $pageNumber > 1 ? (
            ($pageNumber - 1) * $this->getRecordsLimit()
        ) : 0;
    }

    public function columns(array $columns): static
    {
        $columns = array_filter($columns, fn ($column) => is_object($column) && is_a($column, TableColumn::class));

        $this->columns = $columns;

        return $this;
    }

    public function getColumns(): \Illuminate\Support\Collection
    {
        return collect(
            array_filter(
                $this->columns ?? [],
                fn ($column) => is_object($column) && is_a($column, TableColumn::class)
            )
        );
    }

    public function getKeys(): \Illuminate\Support\Collection
    {
        return $this->getColumns()
            ->map(fn (TableColumn $column) => $column->getKey());
    }

    public function getPreparedContent(?Table $table = null)
    {
        /**
         * @var Table $table
         */
        $table ??= $this;

        /**
         * @var RecordsPagination $tablePagination
         */
        $tablePagination = $table->getRecordsPagination();

        $recordsCount = $table->getRecordsCount();
        $pageCount = intval(ceil($recordsCount / $table->getRecordsLimit()));
        $lastPage = $pageCount ?: 1;
        $nextPage = $tablePagination->getNextPage() ?? (
            $tablePagination->getCurrentPage() + 1
        );
        $previousPage = $tablePagination->getPreviousPage() ?? (
            $tablePagination->getCurrentPage() - 1
        );
        $preparedContent = [
            'records' => [],
            'records_count' => $recordsCount,
            'pagination' => [
                'show' => $tablePagination->getShow(),
                'per_page' => $table->getRecordsLimit(),
                'page_count' => $pageCount,
                'links' => [
                    'previousUrl' => $tablePagination->getPreviousUrl(),
                    'previousLabel' => $tablePagination->getPreviousLabel(),
                    'nextUrl' => $tablePagination->getNextUrl(),
                    'nextLabel' => $tablePagination->getNextLabel(),
                    'currentPage' => $tablePagination->getCurrentPage(),
                    'pageNumbers' => $tablePagination->getPageNumbers() ?? $pageCount,

                    'previousPage' => $previousPage > 0 ? $previousPage : null,
                    'nextPage' => $nextPage <= $lastPage ? $nextPage : null,
                    'activePage' => ($pageCount ?: 1) === $tablePagination->getCurrentPage(),
                    'lastPage' => $lastPage,
                ],
            ],
        ];

        foreach ($table->getRecords() as $record) {
            $recordPreparedContent = [];
            $table->getColumns()
                ->each(function (TableColumn $column) use ($record, $table, &$recordPreparedContent) {
                    $key = $column?->getKey();

                    $content = $column->getColumnValue($table, $record);
                    $props = $column->getProps();
                    $component = $column->getComponent();

                    $recordPreparedContent[] = [
                        'key' => $key,
                        'column' => [
                            // 'column' => $column,
                            'key' => $column->getKey(),
                            'label' => $column->getLabel(),
                            // 'content' => $content,
                            'props' => $props,
                            'component' => $component,
                        ],
                        'props' => $props,
                        'content' => $content,
                        'component' => $component,
                    ];
                });

            $preparedContent['records'][] = $recordPreparedContent;
        }

        return $preparedContent;
    }
}
