<!DOCTYPE html>
<html lang="<?= $site->language()->code() ?>" dir="<?= $site->language()->direction() ?>">
<head>
    <?php snippet('shell/head') ?>
</head>
<body class="antialiased">
    <?php snippet('shell/header') ?>
    
    <main class="min-h-screen">
        <!-- Hero Section -->
        <?php if ($heroTitle->isNotEmpty()): ?>
        <section class="relative overflow-hidden bg-gradient-to-br from-primary/10 to-secondary/10 dark:from-primary/20 dark:to-surface-dark py-16 md:py-24">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="text-center lg:text-right rtl:lg:text-right">
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                            <?= $heroTitle ?>
                        </h1>
                        <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto lg:mx-0">
                            <?= $heroSubtitle ?>
                        </p>
                        <?php if ($heroCtaText->isNotEmpty()): ?>
                        <a href="<?= $heroCtaLink ?? '#products' ?>" 
                           class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white bg-primary hover:bg-primary-hover rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <?= $heroCtaText ?>
                            <svg class="w-5 h-5 mr-2 rtl:mr-0 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                        <?php endif ?>
                    </div>
                    <?php if ($heroImage): ?>
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-tr from-primary/20 to-secondary/20 rounded-3xl blur-3xl"></div>
                        <?= $heroImage->thumb(['width' => 800, 'height' => 600, 'quality' => 85])->img([
                            'class' => 'relative rounded-3xl shadow-2xl w-full h-auto object-cover',
                            'loading' => 'eager',
                            'alt' => $heroTitle
                        ]) ?>
                    </div>
                    <?php endif ?>
                </div>
            </div>
        </section>
        <?php endif ?>

        <!-- Featured Products -->
        <?php if ($featuredProducts && $featuredProducts->count() > 0): ?>
        <section id="products" class="py-16 bg-white dark:bg-surface-dark">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        <?= t('featured_products', 'منتجات مميزة') ?>
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                        <?= t('featured_products_desc', 'اكتشف أفضل منتجاتنا المختارة بعناية لك') ?>
                    </p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php foreach ($featuredProducts as $product): ?>
                        <?php snippet('product/card', ['product' => $product]) ?>
                    <?php endforeach ?>
                </div>
                
                <div class="text-center mt-12">
                    <a href="<?= $pages->find('products')->url() ?>" 
                       class="inline-flex items-center px-6 py-3 border-2 border-primary text-primary hover:bg-primary hover:text-white rounded-lg font-semibold transition-all duration-300">
                        <?= t('view_all', 'عرض الكل') ?>
                    </a>
                </div>
            </div>
        </section>
        <?php endif ?>

        <!-- Categories Grid -->
        <?php if ($categories && $categories->count() > 0): ?>
        <section class="py-16 bg-gray-50 dark:bg-surface-darker">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        <?= t('categories', 'التصنيفات') ?>
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400">
                        <?= t('browse_by_category', 'تصفح حسب التصنيف') ?>
                    </p>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <?php foreach ($categories as $category): ?>
                    <a href="<?= $category->url() ?>" 
                       class="group relative overflow-hidden rounded-2xl bg-white dark:bg-surface-dark shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <?php if ($category->image()->isNotEmpty()): ?>
                            <?php $catImage = $category->image()->toFile() ?>
                            <?php if ($catImage): ?>
                            <div class="aspect-square overflow-hidden">
                                <?= $catImage->thumb(['width' => 400, 'height' => 400, 'quality' => 80])->img([
                                    'class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-500',
                                    'alt' => $category->title()
                                ]) ?>
                            </div>
                            <?php endif ?>
                        <?php else: ?>
                        <div class="aspect-square bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center">
                            <span class="text-4xl font-bold text-primary"><?= mb_substr($category->title(), 0, 1) ?></span>
                        </div>
                        <?php endif ?>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-0 right-0 p-4 text-white">
                            <h3 class="text-lg font-bold"><?= $category->title() ?></h3>
                            <p class="text-sm opacity-90"><?= $category->children()->listed()->count() ?> <?= t('products', 'منتجات') ?></p>
                        </div>
                    </a>
                    <?php endforeach ?>
                </div>
            </div>
        </section>
        <?php endif ?>

        <!-- Trust Block -->
        <?php snippet('sections/trust-block') ?>

        <!-- Testimonials -->
        <?php if ($testimonials && $testimonials->count() > 0): ?>
        <section class="py-16 bg-white dark:bg-surface-dark">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        <?= t('customer_reviews', 'آراء العملاء') ?>
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400">
                        <?= t('what_our_customers_say', 'ماذا يقول عملاؤنا عنا') ?>
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($testimonials as $testimonial): ?>
                    <div class="bg-gray-50 dark:bg-surface-darker rounded-2xl p-6 shadow-md">
                        <div class="flex items-center mb-4">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <?php endfor ?>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 mb-4 leading-relaxed">
                            "<?= $testimonial->quote() ?>"
                        </p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold ml-3 rtl:ml-0 rtl:mr-3">
                                <?= mb_substr($testimonial->name(), 0, 1) ?>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white"><?= $testimonial->name() ?></p>
                                <p class="text-sm text-gray-500 dark:text-gray-400"><?= $testimonial->location() ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
        </section>
        <?php endif ?>

        <!-- Custom Sections -->
        <?php if ($sections): ?>
            <?php foreach ($sections as $section): ?>
                <?php snippet('sections/custom-section', ['section' => $section]) ?>
            <?php endforeach ?>
        <?php endif ?>

        <!-- FAQ Section -->
        <?php snippet('sections/faq') ?>
    </main>

    <?php snippet('shell/footer') ?>
</body>
</html>
