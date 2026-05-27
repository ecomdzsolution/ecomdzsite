# Kirby CMS Configuration
return [
    'debug' => false,
    'languages' => true,
    'license' => '',
    'slug' => function ($page) {
        return $page->title()->slug();
    },
    'timezone' => 'Africa/Algiers',
    'date' => [
        'format' => 'd/m/Y',
        'handler' => 'date',
    ],
    
    // Security
    'security' => [
        'contentFile' => true,
        'csrf' => true,
        'hsts' => true,
        'xss' => true,
    ],
    
    // Cache
    'cache' => [
        'pages' => [
            'active' => true,
            'ignore' => ['preview']
        ],
        'files' => true,
        'html' => true,
    ],
    
    // Sessions
    'session' => [
        'duration' => 7200,
        'timeout' => 1800,
        'cookieName' => 'kirby_session',
        'sameSite' => 'Lax',
        'secure' => true,
    ],
    
    // File uploads
    'thumbs' => [
        'driver' => 'gd',
        'quality' => 85,
        'srcsets' => [
            'default' => [320, 640, 1024, 1920],
            'product' => [400, 800, 1200],
        ]
    ],
    
    // API
    'api' => [
        'allowImpersonation' => false,
        'basicAuth' => false,
        'challenge' => true,
        'ignore' => [],
    ],
    
    // Panel
    'panel' => [
        'install' => true,
        'css' => 'assets/css/admin.css',
        'js' => 'assets/js/admin.js',
    ],
];
