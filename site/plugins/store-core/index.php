<?php

/**
 * Store Core Plugin
 * 
 * Main plugin file for store-core
 * Handles orders, products, shipping, pricing, tracking, analytics, integrations, webhooks, and AI
 */

use Kirby\Cms\App;
use Kirby\Cms\Plugin as BasePlugin;

class StoreCorePlugin extends BasePlugin
{
    public static function init(): array
    {
        return [
            'templates' => __DIR__ . '/templates',
            'snippets' => __DIR__ . '/snippets',
        ];
    }
    
    public static function routes(): array
    {
        return [
            // Orders API
            [
                'pattern' => 'api/orders',
                'method' => 'GET',
                'action' => fn() => \Store\Core\Orders\OrderController::index(),
            ],
            [
                'pattern' => 'api/orders',
                'method' => 'POST',
                'action' => fn() => \Store\Core\Orders\OrderController::store(),
            ],
            [
                'pattern' => 'api/orders/(:num)',
                'method' => 'GET',
                'action' => fn(int $id) => \Store\Core\Orders\OrderController::show($id),
            ],
            [
                'pattern' => 'api/orders/(:num)/status',
                'method' => 'PATCH',
                'action' => fn(int $id) => \Store\Core\Orders\OrderController::updateStatus($id),
            ],
            
            // Shipping API
            [
                'pattern' => 'api/shipping/calculate',
                'method' => 'POST',
                'action' => fn() => \Store\Core\Shipping\ShippingCalculator::calculate(),
            ],
            [
                'pattern' => 'api/wilayas',
                'method' => 'GET',
                'action' => fn() => \Store\Core\Shipping\WilayaService::getAll(),
            ],
            
            // Products API
            [
                'pattern' => 'api/products',
                'method' => 'GET',
                'action' => fn() => \Store\Core\Products\ProductController::index(),
            ],
            [
                'pattern' => 'api/products/(:any)',
                'method' => 'GET',
                'action' => fn(string $slug) => \Store\Core\Products\ProductController::show($slug),
            ],
            
            // Analytics API
            [
                'pattern' => 'api/analytics/stats',
                'method' => 'GET',
                'action' => fn() => \Store\Core\Analytics\AnalyticsController::stats(),
            ],
            [
                'pattern' => 'api/analytics/events',
                'method' => 'POST',
                'action' => fn() => \Store\Core\Analytics\AnalyticsController::track(),
            ],
            
            // Webhooks API
            [
                'pattern' => 'api/webhooks/(:any)',
                'method' => 'POST',
                'action' => fn(string $provider) => \Store\Core\Webhooks\WebhookHandler::handle($provider),
            ],
            
            // Tracking API
            [
                'pattern' => 'api/tracking/order',
                'method' => 'GET',
                'action' => fn() => \Store\Core\Tracking\TrackingController::trackOrder(),
            ],
        ];
    }
}

// Initialize plugin
App::plugin('store/core', [
    'init' => fn() => StoreCorePlugin::init(),
    'routes' => fn() => StoreCorePlugin::routes(),
]);

// Autoload classes
spl_autoload_register(function ($class) {
    $prefix = 'Store\\Core\\';
    $baseDir = __DIR__ . '/src/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});
