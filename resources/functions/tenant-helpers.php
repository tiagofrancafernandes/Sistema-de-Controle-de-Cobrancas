<?php

if (!function_exists('global_route')) {
    /**
     * function global_route
     *
     * @param array|string $name
     * @param mixed $parameters
     * @param bool $absolute
     *
     * @return ?string
     */
    function global_route(array|string $name, $parameters = [], $absolute = true): ?string
    {
        $url = route($name, $parameters, $absolute);
        $appHost = parse_url(config('app.url'), PHP_URL_HOST);
        $onTenantUrl = parse_url($url, PHP_URL_HOST);

        return str_replace($onTenantUrl, $appHost, $url);
    }
}

if (!function_exists('tenant_config')) {
    /**
     * function tenant_config
     *
     * @param string $key
     * @param mixed $defaultAlterValue
     *
     * @return mixed
     */
    function tenant_config(
        string $key,
        mixed $defaultAlterValue = null,
    ): mixed {
        if (!filled($key)) {
            return $defaultAlterValue;
        }

        return tenant($key) ?? config("tenant-default-config.{$key}", $defaultAlterValue);
    }
}
