<?php

namespace App\Helpers;

use Closure;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Spatie\Html\Html;

class EvaluateClosure
{
    public static function toArray(null|array|Closure $toEvaluate, ...$args): array
    {
        $toEvaluate ??= [];

        if (is_array($toEvaluate)) {
            return $toEvaluate;
        }

        $toEvaluate = is_a($toEvaluate, Closure::class) ? call_user_func($toEvaluate, ...$args) : null;

        return is_array($toEvaluate) ? $toEvaluate : [];
    }

    public static function filteredItemsFromArray(null|array|Closure $toEvaluate, ...$args): array
    {
        $result = static::toArray($toEvaluate, ...$args);

        return array_map(
            fn ($item) => is_a($item, Closure::class) ? static::evaluate($item, ...$args) : $item,
            array_filter(
                $result,
                fn ($item) => static::evaluate($item) || (is_a($item, Closure::class) && static::evaluate($item, ...$args))
            )
        );
    }

    public static function filteredClasses(null|array|Closure $toEvaluate, ...$args): array
    {
        return collect(static::filteredItemsFromArray($toEvaluate, ...$args))
            ->mapWithKeys(fn ($value, $key) => [$key => in_array(gettype($value), ['array', 'string']) ? $value : $key])
            ->values()
            ->flatMap(fn ($item) => is_array($item) ? $item : [$item])
            ->filter(fn ($item) => is_string($item) && trim($item))
            ->toArray();
    }

    public static function toBool(mixed $toEvaluate, ...$args): bool
    {
        try {
            if (!filled($toEvaluate)) {
                return false;
            }

            $toEvaluate = is_a($toEvaluate, Closure::class) ? call_user_func($toEvaluate, ...$args) : $toEvaluate;

            if (is_bool($toEvaluate)) {
                return $toEvaluate;
            }

            if (
                in_array($toEvaluate, [
                    0,
                    '',
                    '0',
                    false,
                    'false',
                    '!true',
                    'none',
                    'no',
                    'FALSE',
                    '!TRUE',
                    'NONE',
                    'NO'
                ], true)
            ) {
                return false;
            }

            $toEvaluate = filter_var($toEvaluate, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

            return is_bool($toEvaluate) ? $toEvaluate : false;
        } catch (\Throwable $th) {
            //\Log::error($th);

            return false;
        }
    }

    public static function toString(mixed $toEvaluate, ...$args): string
    {
        $toEvaluate = is_a($toEvaluate, Closure::class) ? call_user_func($toEvaluate, ...$args) : $toEvaluate;

        if (is_string($toEvaluate)) {
            return $toEvaluate;
        }

        if (EvaluateClosure::isAnHtmlable($toEvaluate)) {
            return static::objectToString($toEvaluate);
        }

        return static::objectToString($toEvaluate);
    }

    public static function toStringOrNull(mixed $toEvaluate, ...$args): ?string
    {
        return static::toString($toEvaluate, ...$args) ?: null;
    }

    public static function evaluate(mixed $toEvaluate, ...$args): mixed
    {
        if (!is_a($toEvaluate, Closure::class)) {
            return $toEvaluate;
        }

        return call_user_func($toEvaluate, ...$args);
    }

    public static function value(mixed $toEvaluate, array $args = [], mixed $defaultValue = null): mixed
    {
        return static::evaluate($toEvaluate, ...$args) ?? $defaultValue;
    }

    public static function valueToInt(mixed $toEvaluate, array $args = [], ?int $defaultValue = null): ?int
    {
        return filter_var(
            static::value($toEvaluate, $args),
            FILTER_VALIDATE_INT,
            FILTER_NULL_ON_FAILURE
        ) ?? $defaultValue;
    }

    public static function toInt(mixed $toEvaluate, array $args = [], ?int $defaultValue = null): ?int
    {
        return (int) static::valueToInt($toEvaluate, $args, $defaultValue);
    }

    public static function toIntOrNull(mixed $toEvaluate, array $args = []): ?int
    {
        return static::valueToInt($toEvaluate, $args, null);
    }

    public static function isInstaceOf(mixed $value, ...$types): bool
    {
        $types = is_array($types[0] ?? null) ? array_merge($types[0], $types) : $types;
        $types = array_unique(array_filter($types, fn ($item) => filled($item) && is_string($item)));

        if (!$types) {
            return false;
        }

        if (!is_object($value)) {
            return in_array(gettype($value), $types);
        }

        foreach ($types as $type) {
            if (is_a($value, $type)) {
                return true;
            }
        }

        return false;
    }

    public static function isAnHtmlable(mixed $toEvaluate): bool
    {
        return EvaluateClosure::isInstaceOf(
            $toEvaluate,
            [
                Htmlable::class,
                HtmlString::class,
                Html::class,
            ]
        );
    }

    public static function objectToString(mixed $toEvaluate): string
    {
        if (is_string($toEvaluate)) {
            return $toEvaluate;
        }

        if (!is_object($toEvaluate)) {
            return '';
        }

        if (method_exists($toEvaluate, 'toHtml')) {
            return strval($toEvaluate?->toHtml());
        }

        if (method_exists($toEvaluate, 'toString')) {
            return strval($toEvaluate?->toString());
        }

        if (method_exists($toEvaluate, '__toString')) {
            return strval($toEvaluate?->__toString());
        }

        return '';
    }
}
