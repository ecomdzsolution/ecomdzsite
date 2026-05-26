# Local Development Environment
return [
    'debug' => true,
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
];
