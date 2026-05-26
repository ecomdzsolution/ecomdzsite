<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title><?= $page->title() ?> - <?= $site->title() ?></title>

<!-- SEO Meta Tags -->
<meta name="description" content="<?= $page->meta_description()->or($site->description()) ?>">
<meta name="keywords" content="<?= $page->meta_keywords()->or($site->keywords()) ?>">
<meta name="author" content="<?= $site->author() ?>">
<meta name="robots" content="<?= $page->meta_robots()->or('index, follow') ?>">

<!-- Canonical URL -->
<link rel="canonical" href="<?= $page->url() ?>">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="<?= $page->og_type()->or('website') ?>">
<meta property="og:url" content="<?= $page->url() ?>">
<meta property="og:title" content="<?= $page->og_title()->or($page->title()) ?>">
<meta property="og:description" content="<?= $page->og_description()->or($page->meta_description()) ?>">
<meta property="og:image" content="<?= $page->og_image()->toFile()?->url() ?? $site->logo()->toFile()?->url() ?>">
<meta property="og:locale" content="<?= $site->language()->code() ?>">
<meta property="og:site_name" content="<?= $site->title() ?>">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="<?= $page->url() ?>">
<meta name="twitter:title" content="<?= $page->og_title()->or($page->title()) ?>">
<meta name="twitter:description" content="<?= $page->og_description()->or($page->meta_description()) ?>">
<meta name="twitter:image" content="<?= $page->og_image()->toFile()?->url() ?? $site->logo()->toFile()?->url() ?>">

<!-- Favicon -->
<link rel="apple-touch-icon" sizes="180x180" href="<?= asset('assets/images/apple-touch-icon.png') ?>">
<link rel="icon" type="image/png" sizes="32x32" href="<?= asset('assets/images/favicon-32x32.png') ?>">
<link rel="icon" type="image/png" sizes="16x16" href="<?= asset('assets/images/favicon-16x16.png') ?>">
<link rel="manifest" href="<?= asset('manifest.json') ?>">
<meta name="theme-color" content="#ff00ff">

<!-- Preconnect to external domains -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://www.googletagmanager.com">

<!-- Google Fonts (Cairo for Arabic, Inter for Latin) -->
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<!-- Main Stylesheet -->
<?= css(['assets/css/app.css']) ?>

<!-- Custom CSS from settings -->
<?php if ($customCss = $site->settingsDesign()->custom_css()): ?>
<style><?= $customCss ?></style>
<?php endif ?>

<!-- Theme Toggle Script (inline for no FOUC) -->
<script>
    // Check localStorage or system preference
    const theme = localStorage.getItem('theme') || 
                  (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
    document.documentElement.classList.toggle('dark', theme === 'dark');
    document.documentElement.setAttribute('data-theme', theme);
</script>

<!-- Alpine.js -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- Analytics & Tracking Scripts -->
<?php snippet('tracking/head-scripts') ?>

<!-- Structured Data -->
<?php snippet('seo/structured-data') ?>
