<?php 
/**
 * Product Card Snippet
 * Usage: snippet('product/card', ['product' => $product])
 */

if (!isset($product)) return;

$thumb = $product->images()->first();
$price = (float)$product->price()->value();
$oldPrice = (float)($product->old_price()->value() ?? 0);
$discount = $oldPrice > $price ? round((($oldPrice - $price) / $oldPrice) * 100) : 0;
$inStock = !$product->hasStock() || $product->stock()->toInt() > 0;
?>

<a href="<?= $product->url() ?>" class="group block bg-white dark:bg-surface-dark rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
    <!-- Image Container -->
    <div class="relative aspect-square overflow-hidden bg-gray-100 dark:bg-surface-darker">
        <?php if ($thumb): ?>
            <?= $thumb->thumb(['width' => 400, 'height' => 400, 'quality' => 85])->img([
                'class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-500',
                'alt' => $product->title(),
                'loading' => 'lazy'
            ]) ?>
        <?php else: ?>
            <div class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        <?php endif; ?>

        <!-- Discount Badge -->
        <?php if ($discount > 0): ?>
        <span class="absolute top-3 right-3 rtl:right-auto rtl:left-3 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
            -<?= $discount ?>%
        </span>
        <?php endif; ?>

        <!-- Stock Badge -->
        <?php if (!$inStock): ?>
        <span class="absolute bottom-3 right-3 rtl:right-auto rtl:left-3 bg-gray-900/80 text-white text-xs font-medium px-2 py-1 rounded-lg backdrop-blur-sm">
            <?= t('out_of_stock', 'نفذت الكمية') ?>
        </span>
        <?php endif; ?>

        <!-- Quick Add Button -->
        <button type="button"
                data-product-slug="<?= $product->slug() ?>"
                data-product-name="<?= $product->title() ?>"
                data-product-price="<?= $price ?>"
                class="absolute bottom-3 left-3 rtl:left-auto rtl:right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-white dark:bg-surface-dark text-primary hover:bg-primary hover:text-white p-2 rounded-lg shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                title="<?= t('add_to_cart', 'أضف إلى السلة') ?>"
                <?= !$inStock ? 'disabled' : '' ?>>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
        </button>
    </div>

    <!-- Content -->
    <div class="p-4">
        <!-- Category -->
        <?php if ($category = $product->parent()): ?>
        <span class="text-xs text-gray-500 dark:text-gray-400 mb-1 block">
            <?= $category->title() ?>
        </span>
        <?php endif; ?>

        <!-- Title -->
        <h3 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2 min-h-[3rem] group-hover:text-primary transition-colors">
            <?= $product->title() ?>
        </h3>

        <!-- Rating -->
        <?php if ($product->rating()->isNotEmpty()): ?>
        <div class="flex items-center mb-2">
            <?php 
            $rating = (float)$product->rating();
            for ($i = 1; $i <= 5; $i++): 
            ?>
            <svg class="w-3 h-3 <?= $i <= $rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' ?>" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            <?php endfor; ?>
            <span class="text-xs text-gray-500 dark:text-gray-400 mr-1 rtl:mr-0 rtl:ml-1">
                (<?= number_format($rating, 1) ?>)
            </span>
        </div>
        <?php endif; ?>

        <!-- Price -->
        <div class="flex items-center gap-2">
            <span class="text-lg font-bold text-primary">
                <?= number_format($price, 0) ?> <span class="text-xs">د.ج</span>
            </span>
            <?php if ($oldPrice > $price): ?>
            <span class="text-sm text-gray-400 line-through">
                <?= number_format($oldPrice, 0) ?>
            </span>
            <?php endif; ?>
        </div>
    </div>
</a>
