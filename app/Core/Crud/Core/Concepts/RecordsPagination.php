<?php

namespace App\Core\Crud\Core\Concepts;

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

    public function getPageNumbers(): null|array
    {
        return $this->pageNumbers;
    }
}
