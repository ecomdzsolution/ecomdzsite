<?php

/**
 * Kirby CMS Front Controller
 * 
 * This is the main entry point for all HTTP requests
 */

// Load environment variables from .env file
$envFile = dirname(__DIR__) . '/.env';
if (file_exists($envFile)) {
    $envVars = parse_ini_file($envFile);
    foreach ($envVars as $key => $value) {
        if (!getenv($key)) {
            putenv("$key=$value");
        }
    }
}

// Determine environment
$environment = getenv('APP_ENV') ?: 'local';

// Load Kirby
require_once dirname(__DIR__) . '/kirby/bootstrap.php';

// Load environment-specific config
$envConfigFile = __DIR__ . '/../site/config/environments/' . $environment . '.php';
if (file_exists($envConfigFile)) {
    $envConfig = require $envConfigFile;
    // Merge with main config in Kirby's config system
}

(new Kirby())->render();
