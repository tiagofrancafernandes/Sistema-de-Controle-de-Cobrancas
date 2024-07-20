<?php

namespace App\Core\Crud\Core\Concepts\Filter\Inputs;

use App\Core\Crud\Core\Concepts\Filter\Contracts\FilterInputInterface;
use App\Core\Crud\Core\Concepts\Filter\Enums\InputTypeEnum;
use App\Helpers\EvaluateClosure;
use Closure;
use App\Core\Crud\Core\Concepts\Layout\Grid\Enums\ColSpanSizeEnum;
use App\Core\Crud\Core\Concepts\Layout\Grid\Enums\GridSizeEnum;
use DateTime;
use Stringable;
use Illuminate\Support\Arr;

abstract class FilterInputBase implements FilterInputInterface
{
    protected null|Closure|string $title = null;
    protected null|Closure|bool $resettable = null;
    protected null|Closure|string $name = null;
    protected null|Closure|string $label = null; // ?: title
    protected null|Closure|string|int|float|bool|DateTime $value = null;
    protected null|Closure|InputTypeEnum $inputType = null;
    protected null|string|int|array|ColSpanSizeEnum $colSpan = null;
    protected null|string|int|ColSpanSizeEnum $colSpanMd = null;
    protected null|string|int|ColSpanSizeEnum $colSpanLg = null;
    protected null|GridSizeEnum $gridSize = null;

    public function __construct(
        string $name,
        null|Closure|string $title = null,
        null|Closure|bool $resettable = null,
        null|Closure|string $label = null, // ?: title,
        null|Closure|string|int|float|bool|DateTime $value = null,
        null|Closure|InputTypeEnum $inputType = null,
        null|string|int|array|ColSpanSizeEnum $colSpan = null,
        null|string|int|ColSpanSizeEnum $colSpanMd = null,
        null|string|int|ColSpanSizeEnum $colSpanLg = null,
        null|GridSizeEnum $gridSize = null
    ) {
        if (filled($title)) {
            $this->title($title);
        }

        if (filled($resettable)) {
            $this->resettable($resettable);
        }

        if (filled($name)) {
            $this->name($name);
        }

        if (filled($label)) {
            $this->label($label);
        }

        if (filled($value)) {
            $this->value($value);
        }

        if (filled($inputType)) {
            $this->inputType($inputType);
        }

        if (filled($colSpan)) {
            $this->colSpan = $colSpan;
        }

        if (filled($colSpanMd)) {
            $this->colSpanMd = $colSpanMd;
        }

        if (filled($colSpanLg)) {
            $this->colSpanLg = $colSpanLg;
        }

        if (filled($gridSize)) {
            $this->gridSize($gridSize);
        }
    }

    public static function make(
        string $name,
        null|Closure|string $title = null,
        null|Closure|bool $resettable = null,
        null|Closure|string $label = null, // ?: title,
        null|Closure|string|int|float|bool|DateTime $value = null,
        null|Closure|InputTypeEnum $inputType = null,
        null|string|int|array|ColSpanSizeEnum $colSpan = null,
        null|string|int|ColSpanSizeEnum $colSpanMd = null,
        null|string|int|ColSpanSizeEnum $colSpanLg = null,
    ): static {
        return new static(
            name: $name,
            title: $title,
            resettable: $resettable,
            label: $label,
            value: $value,
            inputType: $inputType,
            colSpan: $colSpan,
            colSpanMd: $colSpanMd,
            colSpanLg: $colSpanLg,
        );
    }

    public function title(Closure|string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return EvaluateClosure::toStringOrNull($this->title, $this);
    }

    public function inputType(Closure|InputTypeEnum $inputType): static
    {
        $this->inputType = $inputType;

        return $this;
    }

    public function getInputType(): InputTypeEnum
    {
        $result = EvaluateClosure::evaluate($this->inputType, $this);

        return is_a($result, InputTypeEnum::class) ? $result : InputTypeEnum::TEXT;
    }

    public function resettable(Closure|bool $resettable): static
    {
        $this->resettable = $resettable;

        return $this;
    }

    public function isResettable(): bool
    {
        return EvaluateClosure::toBool($this->resettable ?? true, $this);
    }

    public function name(Closure|string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return EvaluateClosure::toString($this->name, $this);
    }
    public function colSpan(
        null|string|int|array|ColSpanSizeEnum $colSpan = null,
        null|string|int|ColSpanSizeEnum $colSpanMd = null,
        null|string|int|ColSpanSizeEnum $colSpanLg = null,
    ): static {
        $this->colSpan = $colSpan;
        $this->colSpanMd = $colSpanMd;
        $this->colSpanLg = $colSpanLg;

        return $this;
    }

    public function getColSpan(): array
    {
        $colSpan = EvaluateClosure::evaluate($this->colSpan, $this);
        $gridSize = $this->getGridSize();
        $arrayColsPan = is_array($colSpan) ? $colSpan : [];

        if (is_array($colSpan)) {
            $colSpan = $colSpan[0] ?? $colSpan['colSpan'] ?? ColSpanSizeEnum::ONE;
        }

        if ($colSpan && !is_array($colSpan)) {
            $colSpan = is_a($colSpan, ColSpanSizeEnum::class) ? $colSpan : ColSpanSizeEnum::ONE;
        }

        $dynamicColSpan = function ($_colSpan) use ($gridSize) {
            if (
                !$_colSpan || !in_array($_colSpan, [
                    ColSpanSizeEnum::FULL,
                    ColSpanSizeEnum::AUTO,
                    ColSpanSizeEnum::HALF,
                ])
            ) {
                return $_colSpan ?: null;
            }

            return $_colSpan === ColSpanSizeEnum::HALF ? $gridSize?->getHalf() : $gridSize?->getFull();
        };

        $colSpan = $dynamicColSpan($colSpan) ?: ColSpanSizeEnum::ONE;

        $colSpanMd = EvaluateClosure::evaluate($this->colSpanMd, $this) ?? (
            $arrayColsPan['md'] ?? $arrayColsPan[1] ?? $arrayColsPan[0] ?? $colSpan ?? ColSpanSizeEnum::ONE
        );

        $colSpanLg = EvaluateClosure::evaluate($this->colSpanLg, $this) ?? (
            $arrayColsPan['lg'] ?? $arrayColsPan[2] ?? $colSpan ?? $gridSize?->getFull()
        );

        $colSpan = $colSpan && is_a($colSpan, ColSpanSizeEnum::class) ? $colSpan : ColSpanSizeEnum::ONE;
        $colSpanMd = $colSpanMd && is_a($colSpanMd, ColSpanSizeEnum::class) ? $colSpanMd : $colSpan;
        $colSpanLg = $colSpanLg && is_a($colSpanLg, ColSpanSizeEnum::class) ? $colSpanLg : $colSpan;
        $colSpanMd = $dynamicColSpan($colSpanMd) ?: $gridSize?->getHalf();
        $colSpanLg = $dynamicColSpan($colSpanLg) ?: $gridSize?->getFull();

        return [
            'colSpan' => $colSpan,
            'colSpanMd' => $colSpanMd,
            'colSpanLg' => $colSpanLg,
        ];
    }

    public function label(Closure|string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel(): string
    {
        return EvaluateClosure::toStringOrNull($this->label, $this) ?? str($this->name)->title()->toString();
    }

    public function value(Closure|string|int|float|bool|DateTime $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(): null|string|Stringable
    {
        return EvaluateClosure::valueToString($this->value, $this) ?? null;
    }

    public function gridSize(GridSizeEnum $gridSize): static
    {
        $this->gridSize = $gridSize;

        return $this;
    }

    public function getGridSize(): null|GridSizeEnum
    {
        $result = EvaluateClosure::evaluate($this->gridSize, $this);

        return is_a($result, GridSizeEnum::class) ? $result : GridSizeEnum::SIX;
    }

    public function __toString(): string
    {
        return $this->toJson();
    }

    public function toString(): string
    {
        return $this->toJson();// TODO //WIP
    }

    /**
     * @param  int $options
     *
     * @return string
     */
    public function toJson($options = 64): string
    {
        return json_encode($this->toArray(), $options);
    }

    public function jsonSerialize(): array|string
    {
        return $this->toArray();
    }

    public function getClasses(bool $asString = false): array|string // WIP
    {
        $classes = [];
        $colSpanClasses = Arr::mapWithKeys($this->getColSpan(), function ($item, $key) {
            $value = is_a($item, ColSpanSizeEnum::class) ? $item?->value : $item;

            $value = match ($key) {
                'colSpan' => 'col-span-' . $value,
                'colSpanMd' => 'md:col-span-' . $value,
                'colSpanLg' => 'lg:col-span-' . $value,
                default => $value,
            };

            return [$key => $value];
        });

        $classes = array_merge($classes, $colSpanClasses);

        $classes = array_unique(
            array_map(
                'trim',
                array_filter($classes, fn ($item) => is_string($item) && trim($item))
            )
        );

        return $asString ? implode(
            ' ',
            $classes
        ) : $classes;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->getTitle(),
            'inputType' => $this->getInputType(),
            'name' => $this->getName(),
            'colSpan' => $this->getColSpan(),
            'classes' => $this->getClasses(),
            'gridSize' => $this->getGridSize(),
            'label' => $this->getLabel(),
            'value' => $this->getValue(),
            'component' => $this->getComponent(),
        ];
    }

    public function asProps(
        array $extraProps = [],
        bool $replace = false,
    ): array {
        $props = fn () => [
            'resettable' => $this->isResettable(),
            'title' => $this->getTitle(),
            'inputType' => $this->getInputType(),
            'name' => $this->getName(),
            'colSpan' => $this->getColSpan(),
            'classes' => $this->getClasses(),
            'gridSize' => $this->getGridSize(),
            'label' => $this->getLabel(),
            'value' => $this->getValue(),
            'component' => $this->getComponent(),
        ];

        return $replace ? array_merge($props(), $extraProps) : array_merge($extraProps, $props());
    }

    abstract public function getComponent(): string;

    /*
    - title
    - (?resettable?)
    - name
    - colSpan
    - [items]
    - title
    - (?resettable?)
    - name
    - colSpan
    - [options]
    - title
    - name
    - colSpan
    - ?label ?: title
    - ?type ?: 'text' {'text'|'number'|'date'|'datetime'|'datepicker'|'checkbox'}
    - ?value (int|bool|float|DateTime|string)
    - (?resettable?)
    */
}
