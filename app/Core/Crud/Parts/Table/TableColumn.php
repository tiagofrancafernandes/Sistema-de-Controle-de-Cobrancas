<?php

namespace App\Core\Crud\Parts\Table;

use Closure;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Support\Htmlable;
use App\Helpers\EvaluateClosure;

class TableColumn
{
    use Macroable;

    protected null|string|Closure $label = null;
    protected null|bool|Closure $sortable = null;
    protected null|bool|Closure $searchable = null;
    protected null|bool|Closure $hidden = null;
    protected null|bool|Closure $show = null;
    protected null|string|Closure $attribute = null;
    protected null|string|Closure $searchableAttribute = null;
    protected null|string|Closure $theadComponent = null;
    protected null|string|Closure $tbodyComponent = null;
    protected null|array|Closure $staticProps = null;
    protected null|array|Closure $dynamicProps = null;
    protected null|string|Htmlable|Closure $content = null;

    public function label(null|string|Closure $label = null): static
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel(): string
    {
        return EvaluateClosure::toString($this->label, $this);
    }

    public function sortable(null|bool|Closure $sortable = null): static
    {
        $this->sortable = $sortable;

        return $this;
    }

    public function getSortable(): bool
    {
        return EvaluateClosure::toBool($this->sortable, $this);
    }

    public function searchable(null|bool|Closure $searchable = null): static
    {
        $this->searchable = $searchable;

        return $this;
    }

    public function getSearchable(): bool
    {
        return EvaluateClosure::toBool($this->searchable, $this);
    }

    public function hidden(null|bool|Closure $hidden = null): static
    {
        $this->hidden = $hidden;

        return $this;
    }

    public function getHidden(): bool
    {
        return EvaluateClosure::toBool($this->hidden, $this);
    }

    public function show(null|bool|Closure $show = null): static
    {
        $this->show = $show;

        return $this;
    }

    public function getShow(): bool
    {
        return EvaluateClosure::toBool($this->show, $this);
    }

    public function attribute(null|string|Closure $attribute = null): static
    {
        $this->attribute = $attribute;

        return $this;
    }

    public function getAttribute(): string
    {
        return EvaluateClosure::evaluate($this->attribute, $this);
    }

    public function searchableAttribute(null|string|Closure $searchableAttribute = null): static
    {
        $this->searchableAttribute = $searchableAttribute;

        return $this;
    }

    public function getSearchableAttribute(): string
    {
        return EvaluateClosure::toString($this->searchableAttribute, $this);
    }

    public function theadComponent(null|string|Closure $theadComponent = null): static
    {
        $this->theadComponent = $theadComponent;

        return $this;
    }

    public function getTheadComponent(): string
    {
        return EvaluateClosure::toString($this->theadComponent, $this);
    }

    public function tbodyComponent(null|string|Closure $tbodyComponent = null): static
    {
        $this->tbodyComponent = $tbodyComponent;

        return $this;
    }

    public function getTbodyComponent(): string
    {
        return EvaluateClosure::toString($this->tbodyComponent, $this);
    }

    public function staticProps(null|array|Closure $staticProps = null): static
    {
        $this->staticProps = $staticProps;

        return $this;
    }

    public function dynamicProps(null|array|Closure $dynamicProps = null): static
    {
        $this->dynamicProps = $dynamicProps;

        return $this;
    }

    public function getStaticProps(): array
    {
        return EvaluateClosure::toArray($this->staticProps, $this);
    }

    public function getDynamicProps(): array
    {
        return EvaluateClosure::toArray($this->dynamicProps, $this);
    }

    public function getProps(): array
    {
        return [
            'staticProps' => $this->getStaticProps(),
            'dynamicProps' => $this->getDynamicProps(),
        ];
    }

    public function content(null|string|Htmlable|Closure $content = null): static
    {
        $this->content = $content;

        return $this;
    }

    public function getContent(): string
    {
        return EvaluateClosure::toString($this->content, $this);
    }
}
