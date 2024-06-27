<?php

namespace App\Helpers\RequestHelpers;

/*
 * ? Imitar ou usar o spatie laravel-query-builder ??
 * https://spatie.be/docs/laravel-query-builder/v5/introduction
 */

class QueryFilter
{
    public const FILTER_OPERATORS = [
        'eq',
        '=',
        '==',
        'req',
        '===',
        'ge',
        '>=',
        'gt',
        '>',
        'lt',
        '<',
        'le',
        '<=',
        'like',
        'lk',
        'ilike',
        'ilk',
        'ne',
        '!=',
        '<>',
        'empty',
        'null',
        'notnull',
        'not-null',
        '!empty',
        'not-empty',
    ];

    public static function getFilters(
        ?\Illuminate\Http\Request $request = null
    ): array {
        $request ??= request();
        $requestFilter = array_filter((array) $request->input('filter', []), 'is_array');

        $requestFilter = array_filter(
            $requestFilter,
            fn ($item) => is_array($item)
            && is_string($item[0] ?? null)
            && count($item) >= 3
            && static::operatorIsValid($item[1] ?? null)
        );

        return $requestFilter;
    }

    public static function operatorIsValid(mixed $operator = null): bool
    {
        if (!is_string($operator) || !trim($operator)) {
            return false;
        }

        $operator = strtolower(trim($operator));

        return in_array($operator, static::FILTER_OPERATORS, true);
    }

    public static function getFilterOperator(mixed $operator = null, bool $returnDefault = true): ?string
    {
        $default = '=';

        if (!static::operatorIsValid($operator)) {
            return $returnDefault ? $default : null;
        }

        return strtolower(trim($operator));
    }
}
