<?php

use Dreamscape\Container\Container;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

if (! function_exists('app')) {
    /**
     * Get the available container instance.
     *
     * @param string $abstract
     * @return mixed|Dreamscape\Foundation\Application
     */
    function app($abstract = null)
    {
        if (is_null($abstract)) {
            return Container::getInstance();
        }

        return Container::getInstance()->make($abstract);
    }
}

if (! function_exists('view')) {
    function view($template, $with_data = [])
    {
        $template .= '.twig';
        return app('view')->render($template, $with_data);
    }
}

if (! function_exists('value')) {
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if (! function_exists('env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }

        if (strlen($value) > 1 && Str::startsWith($value, '"') && Str::endsWith($value, '"')) {
            return substr($value, 1, -1);
        }

        return $value;
    }
}

if (! function_exists('base_path')) {
    function base_path($subfolder = '') {
        return app()->basePath().($subfolder ? DIRECTORY_SEPARATOR.$subfolder : $subfolder);
    }
}

if (! function_exists('config_path')) {
    function config_path() {
        return base_path('config');
    }
}

if (! function_exists('resource_path')) {
    function resource_path($subfolder = '') {
        return base_path('resources') . DIRECTORY_SEPARATOR . $subfolder;
    }
}

if (! function_exists('storage_path')) {
    function storage_path($subfolder = '') {
        return base_path('storage') . DIRECTORY_SEPARATOR . $subfolder;
    }
}

if (! function_exists('config')) {
    function config($key, $default = null)
    {
        list($config_file, $setting) = explode('.', $key);
        $config_file = config_path() . DIRECTORY_SEPARATOR . $config_file . '.php';

        /** @noinspection PhpIncludeInspection */
        $config = require $config_file;

        return  $config[$setting] ?: value($default);
    }
}

