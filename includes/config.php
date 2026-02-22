<?php

declare(strict_types=1);

const APP_NAME = 'Arts Stationery';
const BASE_URL = '/';

function env(string $key, string $default = ''): string
{
    $value = getenv($key);
    return $value === false ? $default : $value;
}

const DB_HOST = '127.0.0.1';
const DB_PORT = '3306';
const DB_NAME = 'arts_shop';
const DB_USER = 'root';
const DB_PASS = '';

function dbConfig(): array
{
    return [
        'host' => env('DB_HOST', DB_HOST),
        'port' => env('DB_PORT', DB_PORT),
        'name' => env('DB_NAME', DB_NAME),
        'user' => env('DB_USER', DB_USER),
        'pass' => env('DB_PASS', DB_PASS),
    ];
}
