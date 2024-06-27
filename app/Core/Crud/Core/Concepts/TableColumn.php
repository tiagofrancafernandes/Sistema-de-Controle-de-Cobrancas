<?php

namespace App\Core\Crud\Core\Concepts;

use Illuminate\Contracts\Support\Htmlable;
use App\Helpers\EvaluateClosure;

class TableColumn
{
    protected null|\Closure|\Stringable|Htmlable|string $label = null;
    protected null|\Closure|bool $replaceUsingPreparedContent = null;
    protected null|bool $translateLabel = null;
    protected string $key;
    protected null|\Closure|\Stringable|Htmlable|string $prepareContentUsing = null;
    protected null|\Closure|array $staticProps = null;
    protected null|\Closure|array $dynamicProps = null;
    protected null|\Closure|array $columnHeaderAttributes = null;
    protected null|\Closure|array $attributes = null;
    protected ?string $component = null;

    public function __construct(
        string $key,
        null|\Closure|\Stringable|Htmlable|string $label = null,
        null|bool $translateLabel = null,
        null|\Closure|\Stringable|Htmlable|string $prepareContentUsing = null,
        null|\Closure|array $staticProps = null,
        null|\Closure|array $dynamicProps = null,
        ?string $component = null,
    ) {
        $this->setkey($key);

        if (filled($label)) {
            $this->setLabel($label, $translateLabel ?? false);
        }

        if (filled($translateLabel)) {
            $this->translateLabel($translateLabel);
        }

        if (filled($prepareContentUsing)) {
            $this->prepareContentUsing($prepareContentUsing);
        }

        if (filled($staticProps)) {
            $this->staticProps($staticProps);
        }

        if (filled($dynamicProps)) {
            $this->dynamicProps($dynamicProps);
        }

        if (filled($component)) {
            $this->setcomponent($component);
        }
    }

    public static function make(
        string $key,
        null|\Closure|\Stringable|Htmlable|string $label = null,
        null|\Closure|\Stringable|Htmlable|string $prepareContentUsing = null,
        null|bool $translateLabel = null,
        null|\Closure|array $staticProps = null,
        null|\Closure|array $dynamicProps = null,
        ?string $component = null,
    ): static {
        return new static(
            key: $key,
            label: $label,
            translateLabel: $translateLabel,
            prepareContentUsing: $prepareContentUsing,
            staticProps: $staticProps,
            dynamicProps: $dynamicProps,
            component: $component,
        );
    }

    public function setKey(string $key): static
    {
        $key = str($key)->trim()->replace(' ', '')->trim()->toString();

        if (!filled($key)) {
            throw new \Exception('"key" can\'t be empty!', 1);
        }

        $this->key = trim($key);

        return $this;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setLabel(
        null|\Closure|\Stringable|Htmlable|string $label = null,
        ?bool $translateLabel = null,
    ): static {
        $this->label = $label;

        if (filled($translateLabel)) {
            $this->translateLabel($translateLabel);
        }

        return $this;
    }

    public function getLabel(): string
    {
        $label = StringHelpers::valueToString($this->label, $this) ?? str($this->getKey())->headline()->toString();

        return $this->getTranslateLabel() ? __($label) : $label;
    }

    /**
     * @deprecated Use `translateLabel()` method instead
     */
    public function setTranslateLabel(bool $translateLabel = true): static
    {
        return $this->translateLabel($translateLabel);
    }

    public function translateLabel(bool $translateLabel = true): static
    {
        $this->translateLabel = $translateLabel;

        return $this;
    }

    public function getTranslateLabel(): bool
    {
        return $this->translateLabel ?? false;
    }

    public function prepareContentUsing(
        \Closure|\Stringable|Htmlable|string $prepareContentUsing,
        null|\Closure|bool $replaceUsingPreparedContent = null,
    ): static {
        $this->prepareContentUsing = $prepareContentUsing;

        if (filled($replaceUsingPreparedContent)) {
            $this->replaceUsingPreparedContent($replaceUsingPreparedContent);
        }

        return $this;
    }

    public function hasPrepareContentUsing(): bool
    {
        return filled($this->prepareContentUsing);
    }

    public function replaceUsingPreparedContent(\Closure|bool $replaceUsingPreparedContent): static
    {
        $this->replaceUsingPreparedContent = $replaceUsingPreparedContent;

        return $this;
    }

    public function toReplaceUsingPreparedContent(): bool
    {
        return EvaluateClosure::toBool($this->replaceUsingPreparedContent);
    }

    public function getColumnHeaderContent(): mixed
    {
        return $this->getLabel();
    }

    /**
     * @deprecated Use `headerAttributes()` method instead
     */
    public function setColumnHeaderAttributes(null|\Closure|array $columnHeaderAttributes = null): static
    {
        return $this->headerAttributes($columnHeaderAttributes);
    }

    public function headerAttributes(null|\Closure|array $columnHeaderAttributes = null): static
    {
        $this->columnHeaderAttributes = $columnHeaderAttributes;

        return $this;
    }

    public function getColumnHeaderAttributes(array $toMerge = []): mixed
    {
        return array_merge(EvaluateClosure::toArray($this->columnHeaderAttributes), $toMerge);
    }

    /**
     * attributes function
     *
     * @param null|\Closure|array|null $attributes
     * @return static
     */
    public function attributes(null|\Closure|array $attributes = null): static
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * setAttributes function
     * @deprecated Use `attributes()` method instead
     * @param null|\Closure|array|null $attributes
     * @return static
     */
    public function setAttributes(null|\Closure|array $attributes = null): static
    {
        return $this->attributes($attributes);
    }

    public function getAttributes(array $toMerge = []): mixed
    {
        return array_merge(EvaluateClosure::toArray($this->attributes), $toMerge);
    }

    public function getColumnValue(
        ?Table $table = null,
        mixed $record = null,
        array $extraData = []
    ): mixed {
        /**
         * @var TableColumn $column
         */
        $column = $this;

        if (!is_null($this->prepareContentUsing)) {
            return $this->getContent(fluent(array_merge($extraData, [
                'table' => $table,
                'column' => $column,
                'record' => $record ?? fluent([]),
            ])));
        }

        $key = $column?->getKey();

        return data_get($record ?? [], $key);
    }

    public function getContent(mixed ...$params): ?string
    {
        if (is_null($this->prepareContentUsing)) {
            return null;
        }

        return StringHelpers::valueToString($this->prepareContentUsing, ...$params);
    }

    /**
     * @deprecated  Use `staticProps()` method instead
     */
    public function setStaticProps(null|\Closure|array $staticProps = null): static
    {
        return $this->staticProps($staticProps);
    }

    public function staticProps(null|\Closure|array $staticProps = null): static
    {
        $this->staticProps = $staticProps;

        return $this;
    }

    public function getStaticProps(): array
    {
        return EvaluateClosure::toArray($this->staticProps, $this);
    }

    /**
     * @deprecated  Use `dynamicProps()` method instead
     */
    public function setDynamicProps(null|\Closure|array $dynamicProps = null): static
    {
        return $this->dynamicProps($dynamicProps);
    }

    public function dynamicProps(null|\Closure|array $dynamicProps = null): static
    {
        $this->dynamicProps = $dynamicProps;

        return $this;
    }

    public function getDynamicProps(): array
    {
        $dynamicProps = $this->dynamicProps;

        if (!$dynamicProps || is_null($dynamicProps) || is_array($dynamicProps)) {
            return $dynamicProps ?? [];
        }

        $dynamicProps = $dynamicProps();

        return is_array($dynamicProps) ? $dynamicProps : [];
    }

    public function setProps(
        null|\Closure|array $staticProps = null,
        null|\Closure|array $dynamicProps = null,
    ): static {
        $this->staticProps($staticProps);
        $this->dynamicProps($dynamicProps);

        return $this;
    }

    public function getProps(): array // WIP
    {
        return [
            'staticProps' => $this->getStaticProps(),
            'dynamicProps' => $this->getDynamicProps(),
            'headerProps' => [
                'staticProps' => [], // TODO: $this->getColumnHeaderStaticProps(),
                'dynamicProps' => [], // TODO: $this->getColumnHeaderDynamicProps(),
            ],
        ];
    }

    public function setComponent(string $component): static
    {
        $this->component = $component;

        return $this;
    }

    public function getComponent(): string
    {
        return $this->component ?? str(static::class)->afterLast('\\')->prepend('EasyCrud')->toString();
    }
}
