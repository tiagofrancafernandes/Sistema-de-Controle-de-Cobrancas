<?php

use Illuminate\Support\Facades\Config;

if (!function_exists('runOnQueueScope')) {
    /**
     * function runOnQueueScope
     *
     * @param ?string $targetQueueConnectionName
     * @param ?\Closure $callableScope
     *
     * @return mixed
     */
    function runOnQueueScope(?string $targetQueueConnectionName, ?Closure $callableScope): mixed
    {
        if (!$targetQueueConnectionName || !$callableScope) {
            return null;
        }

        $currentQueueDefault = Config::get('queue.default');

        if ($targetQueueConnectionName && ($targetQueueConnectionName != $currentQueueDefault)) {
            Config::set('queue.default', $targetQueueConnectionName);
        }

        $result = $callableScope();

        if (!$currentQueueDefault) {
            return $result ?? null;
        }

        if ($targetQueueConnectionName && ($targetQueueConnectionName != $currentQueueDefault)) {
            Config::set('queue.default', $currentQueueDefault);
        }

        return $result ?? null;
    }
}

if (!function_exists('arrayFlatten')) {
    /**
     * function arrayFlatten
     *
     * @param array $multiDimArray
     * @return array
     */
    function arrayFlatten(array $multiDimArray): array
    {
        $localFlatten = [];

        foreach ($multiDimArray as $key => $value) {
            if (\is_array($value)) {
                foreach (arrayFlatten($value) as $subKey => $subValue) {
                    $localFlatten[$subKey] = $subValue;
                }

                continue;
            }

            $localFlatten[$key] = $value;
        }

        return $localFlatten;
    }
}
