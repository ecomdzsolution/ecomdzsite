<!DOCTYPE html>
<html lang="<?= $site->language()->code() ?>" dir="<?= $site->language()->direction() ?>">
<head>
    <?php snippet('shell/head') ?>
</head>
<body class="antialiased">
    <?php snippet('shell/header') ?>
    
    <main class="min-h-screen py-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-8" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 rtl:space-x-reverse text-sm text-gray-500 dark:text-gray-400">
                    <li>
                        <a href="<?= $site->url() ?>" class="hover:text-primary transition-colors">
                            <?= t('home', 'الرئيسية') ?>
                        </a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 mx-2 rtl:mx-0 rtl:ml-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </li>
                    <li>
                        <a href="<?= $page->parent()->url() ?>" class="hover:text-primary transition-colors">
                            <?= $page->parent()->title() ?>
                        </a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 mx-2 rtl:mx-0 rtl:ml-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </li>
                    <li class="text-gray-900 dark:text-white font-medium">
                        <?= $page->title() ?>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                <!-- Product Gallery -->
                <div class="lg:sticky lg:top-8 lg:self-start">
                    <?php snippet('product/gallery', ['images' => $images, 'product' => $product]) ?>
                </div>

                <!-- Product Info -->
                <div>
                    <!-- Title & Price -->
                    <div class="mb-6">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2">
                            <?= $page->title() ?>
                        </h1>
                        
                        <?php if ($page->subtitle()->isNotEmpty()): ?>
                        <p class="text-lg text-gray-600 dark:text-gray-400 mb-4">
                            <?= $page->subtitle() ?>
                        </p>
                        <?php endif ?>

                        <div class="flex items-center gap-4 mb-4">
                            <?php snippet('product/price-box', ['product' => $product]) ?>
                            
                            <?php if ($product->hasStock()): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?= $product->stock()->toInt() > 0 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' ?>">
                                <?= $product->stock()->toInt() > 0 ? t('in_stock', 'متوفر') : t('out_of_stock', 'نفذت الكمية') ?>
                                (<?= $product->stock() ?> <?= t('pieces', 'قطع') ?>)
                            </span>
                            <?php endif ?>
                        </div>

                        <!-- Rating -->
                        <?php if ($page->rating()->isNotEmpty()): ?>
                        <div class="flex items-center mb-6">
                            <div class="flex items-center">
                                <?php 
                                $rating = (float)$page->rating();
                                for ($i = 1; $i <= 5; $i++): 
                                ?>
                                <svg class="w-5 h-5 <?= $i <= $rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' ?>" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <?php endfor ?>
                            </div>
                            <span class="mr-2 rtl:mr-0 rtl:ml-2 text-sm text-gray-600 dark:text-gray-400">
                                <?= number_format($rating, 1) ?> / 5
                            </span>
                        </div>
                        <?php endif ?>
                    </div>

                    <!-- Variants -->
                    <?php if (!empty($variants)): ?>
                    <div class="mb-6">
                        <?php snippet('product/variants', ['variants' => $variants, 'product' => $product]) ?>
                    </div>
                    <?php endif ?>

                    <!-- Description -->
                    <div class="prose prose-lg dark:prose-invert max-w-none mb-8">
                        <?= $page->description()->kirbytext() ?>
                    </div>

                    <!-- Features/Benefits -->
                    <?php if ($page->features()->isNotEmpty()): ?>
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                            <?= t('features', 'المميزات') ?>
                        </h3>
                        <ul class="space-y-2">
                            <?php foreach ($page->features()->toLines() as $feature): ?>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 ml-2 rtl:ml-0 rtl:ml-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300"><?= $feature ?></span>
                            </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                    <?php endif ?>

                    <!-- Add to Cart Form -->
                    <div class="bg-gray-50 dark:bg-surface-darker rounded-2xl p-6 mb-8">
                        <?php if ($addedToCart): ?>
                        <div class="bg-green-100 dark:bg-green-900/30 border border-green-500 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg mb-4">
                            <?= t('added_to_cart', 'تمت الإضافة إلى السلة بنجاح!') ?>
                        </div>
                        <?php endif ?>

                        <?php if ($cartError): ?>
                        <div class="bg-red-100 dark:bg-red-900/30 border border-red-500 text-red-700 dark:text-red-400 px-4 py-3 rounded-lg mb-4">
                            <?= $cartError ?>
                        </div>
                        <?php endif ?>

                        <form method="post" class="space-y-4">
                            <input type="hidden" name="action" value="add_to_cart">
                            
                            <?php snippet('product/cod-form', ['showFull' => false]) ?>
                            
                            <div class="flex gap-4">
                                <button type="submit" 
                                        class="flex-1 bg-primary hover:bg-primary-hover text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed"
                                        <?= $product->hasStock() && $product->stock()->toInt() === 0 ? 'disabled' : '' ?>>
                                    <?= t('add_to_cart', 'أضف إلى السلة') ?>
                                </button>
                                
                                <a href="<?= $site->find('checkout')->url() ?>" 
                                   class="inline-flex items-center justify-center px-6 py-4 border-2 border-primary text-primary hover:bg-primary hover:text-white rounded-xl font-semibold transition-all duration-300">
                                    <svg class="w-5 h-5 ml-2 rtl:ml-0 rtl:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <?= t('buy_now', 'اشترِ الآن') ?>
                                </a>
                            </div>
                        </form>

                        <!-- Trust Badges -->
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <div class="grid grid-cols-3 gap-4 text-center text-xs text-gray-600 dark:text-gray-400">
                                <div>
                                    <svg class="w-6 h-6 mx-auto mb-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <?= t('cod_available', 'الدفع عند الاستلام') ?>
                                </div>
                                <div>
                                    <svg class="w-6 h-6 mx-auto mb-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <?= t('fast_delivery', 'توصيل سريع') ?>
                                </div>
                                <div>
                                    <svg class="w-6 h-6 mx-auto mb-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    <?= t('secure_payment', 'دفع آمن') ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <?php if ($page->sku()->isNotEmpty()): ?>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400"><?= t('sku', 'الرمز') ?>:</span>
                                <span class="font-medium text-gray-900 dark:text-white mr-2 rtl:mr-0 rtl:ml-2"><?= $page->sku() ?></span>
                            </div>
                            <?php endif ?>
                            
                            <?php if ($page->brand()->isNotEmpty()): ?>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400"><?= t('brand', 'العلامة التجارية') ?>:</span>
                                <span class="font-medium text-gray-900 dark:text-white mr-2 rtl:mr-0 rtl:ml-2"><?= $page->brand() ?></span>
                            </div>
                            <?php endif ?>
                            
                            <?php if ($page->weight()->isNotEmpty()): ?>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400"><?= t('weight', 'الوزن') ?>:</span>
                                <span class="font-medium text-gray-900 dark:text-white mr-2 rtl:mr-0 rtl:ml-2"><?= $page->weight() ?> <?= t('kg', 'كغ') ?></span>
                            </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upsell Section -->
            <?php snippet('product/upsell-box', ['product' => $product]) ?>

            <!-- Related Products -->
            <?php if ($relatedProducts && $relatedProducts->count() > 0): ?>
            <section class="mt-16">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-8">
                    <?= t('related_products', 'منتجات ذات صلة') ?>
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php foreach ($relatedProducts as $relatedProduct): ?>
                        <?php snippet('product/card', ['product' => $relatedProduct]) ?>
                    <?php endforeach ?>
                </div>
            </section>
            <?php endif ?>
        </div>
    </main>

    <?php snippet('shell/footer') ?>
</body>
</html>
