<?php

namespace App\Core\Crud\Core\Concepts;

use Illuminate\Contracts\Support\Htmlable;

class TableColumn
{
    protected null|\Closure|\Stringable|Htmlable|string $label = null;
    protected null|bool $translateLabel = null;
    protected string $key;
    protected null|\Closure|\Stringable|Htmlable|string $prepareContentUsing = null;
    protected null|\Closure|array $staticProps = null;
    protected null|\Closure|array $dynamicProps = null;
    protected ?string $component = null;

    public function __construct(
        ?string $key = null,
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
            $this->setTranslateLabel($translateLabel);
        }

        if (filled($prepareContentUsing)) {
            $this->prepareContentUsing($prepareContentUsing);
        }

        if (filled($staticProps)) {
            $this->setstaticProps($staticProps);
        }

        if (filled($dynamicProps)) {
            $this->setdynamicProps($dynamicProps);
        }

        if (filled($component)) {
            $this->setcomponent($component);
        }
    }

    public static function make(
        ?string $key = null,
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

    public function setKey(?string $key = null): static
    {
        $this->key = $key;

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
            $this->setTranslateLabel($translateLabel);
        }

        return $this;
    }

    public function getLabel(): string
    {
        $label = StringHelpers::valueToString($this->label, $this) ?? str($this->getKey())->title()->toString();

        return $this->getTranslateLabel() ? __($label) : $label;
    }

    public function setTranslateLabel(bool $translateLabel): static
    {
        $this->translateLabel = $translateLabel;

        return $this;
    }

    public function getTranslateLabel(): bool
    {
        return $this->translateLabel ?? false;
    }

    public function prepareContentUsing(\Closure|\Stringable|Htmlable|string $prepareContentUsing): static
    {
        $this->prepareContentUsing = $prepareContentUsing;

        return $this;
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

    public function setStaticProps(null|\Closure|array $staticProps = null): static
    {
        $this->staticProps = $staticProps;

        return $this;
    }

    public function getStaticProps(): array
    {
        $staticProps = $this->staticProps;

        if (!$staticProps || is_null($staticProps) || is_array($staticProps)) {
            return $staticProps ?? [];
        }

        $staticProps = $staticProps();

        return is_array($staticProps) ? $staticProps : [];
    }

    public function setDynamicProps(null|\Closure|array $dynamicProps = null): static
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
        $this->setStaticProps($staticProps);
        $this->setDynamicProps($dynamicProps);

        return $this;
    }

    public function getProps(): array // WIP
    {
        return [
            'staticProps' => $this->getStaticProps(),
            'dynamicProps' => $this->getDynamicProps(),
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
