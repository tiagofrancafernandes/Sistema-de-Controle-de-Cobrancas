<?php

namespace App\Core\Crud\Core\Concepts;

use App\Helpers\EvaluateClosure;
use Illuminate\Support\Arr;

/**
 * @todo:
 * - last id/last page
 * - page count
 * - getRequest (like Table::getRequest())
 */
class RecordsPagination
{
    protected null|\Closure|bool $show = null;
    protected ?\Illuminate\Http\Request $request = null;
    protected null|\Closure|string $previousUrl = null;
    protected null|\Closure|string $previousLabel = null;
    protected null|\Closure|string $nextUrl = null;
    protected null|\Closure|string $nextLabel = null;

    protected null|\Closure|string|int $previousPage = null;
    protected null|\Closure|string|int $nextPage = null;
    protected null|\Closure|string|int $currentPage = null;
    protected null|int|\Closure $pageCount = null;
    protected null|array $pageNumbers = null;

    public function __construct(
        null|\Closure|bool $show = null,
        null|\Closure|string $previousUrl = null,
        null|\Closure|string $previousLabel = null,
        null|\Closure|string $nextUrl = null,
        null|\Closure|string $nextLabel = null,
        null|\Closure|string|int $previousPage = null,
        null|\Closure|string|int $nextPage = null,
        null|\Closure|string|int $currentPage = null,
        null|array $pageNumbers = null,
    ) {
        $this->show($show);
        $this->previousUrl($previousUrl);
        $this->previousLabel($previousLabel);
        $this->nextUrl($nextUrl);
        $this->nextLabel($nextLabel);
        $this->previousPage($previousPage);
        $this->nextPage($nextPage);
        $this->currentPage($currentPage);
        $this->pageNumbers($pageNumbers);
    }

    public static function make(
        null|\Closure|bool $show = null,
        null|\Closure|string $previousUrl = null,
        null|\Closure|string $previousLabel = null,
        null|\Closure|string $nextUrl = null,
        null|\Closure|string $nextLabel = null,
        null|\Closure|string|int $previousPage = null,
        null|\Closure|string|int $nextPage = null,
        null|\Closure|string|int $currentPage = null,
        null|array $pageNumbers = null,
    ): static {
        return new static(
            show: $show,
            previousUrl: $previousUrl,
            previousLabel: $previousLabel,
            nextUrl: $nextUrl,
            nextLabel: $nextLabel,
            previousPage: $previousPage,
            nextPage: $nextPage,
            currentPage: $currentPage,
            pageNumbers: $pageNumbers,
        );
    }

    public function show(null|\Closure|bool $show = null): static
    {
        $this->show = $show;

        return $this;
    }

    public function getShow(): null|\Closure|bool
    {
        if (is_null($this->show)) {
            return true;
        }

        return boolval(is_a($this->show, \Closure::class) ? $this->show() : $this->show);
    }

    public function previousUrl(null|\Closure|string $previousUrl = null): static
    {
        $this->previousUrl = $previousUrl;

        return $this;
    }

    public function getPreviousUrl(): null|string
    {
        return StringHelpers::valueToString($this->previousUrl, $this);
    }

    public function previousLabel(null|\Closure|string $previousLabel = null): static
    {
        $this->previousLabel = $previousLabel;

        return $this;
    }

    public function getPreviousLabel(): null|string
    {
        return StringHelpers::valueToString($this->previousLabel, $this);
    }

    public function nextUrl(null|\Closure|string $nextUrl = null): static
    {
        $this->nextUrl = $nextUrl;

        return $this;
    }

    public function getNextUrl(): null|string
    {
        return StringHelpers::valueToString($this->nextUrl, $this);
    }

    public function nextLabel(null|\Closure|string $nextLabel = null): static
    {
        $this->nextLabel = $nextLabel;

        return $this;
    }

    public function getNextLabel(): null|string
    {
        return StringHelpers::valueToString($this->nextLabel, $this);
    }

    public function currentPage(null|\Closure|string|int $currentPage = null): static
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    public function getCurrentPage(): null|int|string
    {
        if ($this->currentPage) {
            return StringHelpers::valueToString($this->currentPage, $this);
        }

        $pageNumber = $this->getRequest()->input('page');
        $pageNumber = filter_var($pageNumber, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);

        return $pageNumber && $pageNumber > 0 ? $pageNumber : 1;
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

    public function previousPage(null|\Closure|string|int $previousPage = null): static
    {
        $this->previousPage = $previousPage;

        return $this;
    }

    public function getPreviousPage(): null|int|string
    {
        return StringHelpers::valueToString($this->previousPage, $this);
    }

    public function nextPage(null|\Closure|string|int $nextPage = null): static
    {
        $this->nextPage = $nextPage;

        return $this;
    }

    public function getNextPage(): null|int|string
    {
        return StringHelpers::valueToString($this->nextPage, $this);
    }

    public function pageNumbers(null|array $pageNumbers = null): static
    {
        $this->pageNumbers = $pageNumbers;

        return $this;
    }

    public function pageCount(null|int|\Closure $pageCount = null): static
    {
        $this->pageCount = $pageCount;

        return $this;
    }

    public function getPageCount(): int
    {
        return filter_var(
            EvaluateClosure::value($this->pageCount, [$this], 0),
            FILTER_VALIDATE_INT,
            FILTER_NULL_ON_FAILURE
        );
    }

    public function getPageNumbers(): array
    {
        if (filled($this->pageNumbers)) {
            return EvaluateClosure::toArray($this->pageNumbers, $this);
        }

        $pageCount = $this->getPageCount();

        return $pageCount > 0 ? range(1, $pageCount) : [];
    }

    public function getLinks(array $pagesInfo = [], ?\Illuminate\Http\Request $request = null): array //WIP
    {
        $request ??= request();

        $baseInfo = [
            'baseUrl' => null,
            'previousUrl' => null,
            'previousLabel' => null,
            'nextUrl' => null,
            'nextLabel' => null,
            'currentPage' => null,
            'pageNumbers' => null,
            'pageCount' => null,
            'previousPage' => null,
            'nextPage' => null,
            'firstPage' => null,
            'lastPage' => null,

            // "first_page_url" => "https://school.tiagofranca.com:8009?page=1",
            // "from" => 1,
            // "last_page" => 1,
            // "last_page_url" => "https://school.tiagofranca.com:8009?page=1",
            // "links" => [
            //     [
            //         "url" => null,
            //         "label" => "&laquo; Previous",
            //         "active" => false,
            //     ],
            //     [
            //         "url" => "https://school.tiagofranca.com:8009?page=1",
            //         "label" => "1",
            //         "active" => true,
            //     ],
            //     [
            //         "url" => null,
            //         "label" => "Next &raquo;",
            //         "active" => false,
            //     ],
            // ],
            // "next_page_url" => null,
            // "path" => "https://school.tiagofranca.com:8009",
            // "per_page" => 100,
            // "prev_page_url" => null,
            // "to" => 67,
            // "total" => 67,
        ];

        $pagesInfo = fluent(
            array_merge(
                $baseInfo,
                array_filter($pagesInfo, fn ($item) => !is_null($item)),
            )
        );

        $links = [
            'previous' => [
                'label' => __('easy-crud/pagination.previous_label'),
                'query' => null,
                'url' => $pagesInfo?->previousUrl ?: null,
            ],
            'next' => [
                'label' => __('easy-crud/pagination.next_label'),
                'query' => null,
                'url' => $pagesInfo?->nextUrl ?: null,
            ],
        ];

        $baseUrl = $pagesInfo?->baseUrl ?: null;
        $currentPage = intval($pagesInfo?->currentPage ?: 0);
        $baseUrl = filter_var($baseUrl, FILTER_VALIDATE_URL, FILTER_NULL_ON_FAILURE);
        $pageCount = (int) ($pagesInfo?->pageCount ?: 1);
        $pageNumbers = array_filter(Arr::wrap($pagesInfo->pageNumbers ?: [1]), 'is_numeric');

        $genLinkProps = fn (array $params) => array_merge(
            [
                'page' => null,
                'per_page' => null,
                'search' => null,
                'filter' => [
                    // ['id', 'eq', 4],
                    // ['name', 'like', 'tiago'],
                    // ...
                ],
            ],
            $params,
        );
        // urldecode(http_build_query($linkProps))

        $perPage = EvaluateClosure::toIntOrNull($request->input('per_page') || $request->input('perPage'));
        $requestQuery = (array) ($request->query() ?: []);

        $requestFilter = (array) ($request->input('filter') ?: []);
        // $requestFilter = \App\Helpers\RequestHelpers\QueryFilter::getFilters($request);

        foreach ($pageNumbers as $pageNumber) {
            $linkProps = $genLinkProps(
                array_merge(
                    $requestQuery,
                    [
                        'page' => $pageNumber,
                        'per_page' => $perPage,
                        'filter' => $requestFilter,
                    ],
                )
            );
            $query = urldecode(http_build_query($linkProps));
            $links[$pageNumber] = [
                'label' => $pageNumber,
                'query' => $query,
                'url' => implode('?', array_filter([$baseUrl, $query])),
                'active' => $pagesInfo?->currentPage === $pageNumber,
            ];
        }

        $previousQuery = urldecode(
            http_build_query(
                $genLinkProps(
                    array_merge(
                        $requestQuery,
                        [
                            // 'page' => $pageNumber,
                            'per_page' => $perPage,
                            'filter' => $requestFilter,
                        ],
                    )
                )
            )
        );

        $nextQuery = urldecode(
            http_build_query(
                $genLinkProps(
                    array_merge(
                        $requestQuery,
                        [
                            // 'page' => $pageNumber,
                            'per_page' => $perPage,
                            'filter' => $requestFilter,
                        ],
                    )
                )
            )
        );

        $links['previous']['query'] = $previousQuery;
        $links['previous']['url'] = implode('?', array_filter([$baseUrl, $previousQuery]));

        $links['next']['query'] = $nextQuery;
        $links['next']['url'] = implode('?', array_filter([$baseUrl, $nextQuery]));

        $nextVal = $links['next'] ?? null;
        unset($links['next']);

        $links['next'] = $nextVal;

        $links['prev_page_url'] = ($currentPage - 1) <= 0 ? null : $links['previous']['url'] ?? null;
        $links['next_page_url'] = ($currentPage + 1) >= $pageCount ? null : $links['next']['url'] ?? null;

        return $links;
    }
}
