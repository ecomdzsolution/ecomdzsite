# Production Environment
return [
    'debug' => false,
    'kirby' => [
        'license' => '',
    ],
    'database' => [
        'driver' => 'sqlite',
        'root' => __DIR__ . '/../../storage/db',
    ],
    'store' => [
        'currency' => 'DZD',
        'currencySymbol' => 'د.ج',
        'freeShippingThreshold' => 5000,
        'defaultTaxRate' => 0,
    ],
    'cache' => [
        'pages' => ['active' => true],
        'files' => true,
        'html' => true,
    ],
];
