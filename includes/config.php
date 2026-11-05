<?php

/** Load database settings from the environment, with a private local config as fallback. */
function tt_db_config()
{
    $local = [];
    $local_path = __DIR__ . '/config.local.php';
    if (is_file($local_path)) {
        $local = require $local_path;
        if (!is_array($local)) {
            throw new RuntimeException('The local database config must return an array.');
        }
    }

    $keys = [
        'host' => 'TT_DB_HOST',
        'name' => 'TT_DB_NAME',
        'user' => 'TT_DB_USER',
        'pass' => 'TT_DB_PASS',
    ];
    $config = [];
    foreach ($keys as $key => $environment_variable) {
        $value = getenv($environment_variable);
        $config[$key] = $value !== false ? $value : ($local[$key] ?? null);
    }

    foreach (['host', 'name', 'user', 'pass'] as $key) {
        if (!is_string($config[$key])) {
            throw new RuntimeException(
                'Database settings are missing. Set the TT_DB_HOST, TT_DB_NAME, TT_DB_USER, and TT_DB_PASS environment variables, or create includes/config.local.php from includes/config.local.example.php.'
            );
        }
    }
    foreach (['host', 'name', 'user'] as $key) {
        if (trim($config[$key]) === '') {
            throw new RuntimeException(
                'Database settings are incomplete. Set the TT_DB_HOST, TT_DB_NAME, TT_DB_USER, and TT_DB_PASS environment variables, or create includes/config.local.php from includes/config.local.example.php.'
            );
        }
    }

    return $config;
}
