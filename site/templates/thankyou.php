<!DOCTYPE html>
<html lang="<?= $site->language()->code() ?>" dir="<?= $site->language()->direction() ?>">
<head>
    <?php snippet('shell/head') ?>
</head>
<body class="antialiased">
    <?php snippet('shell/header') ?>
    
    <main class="min-h-screen py-8 bg-gray-50 dark:bg-surface-darker">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-3xl">
            <!-- Success Message -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-100 dark:bg-green-900/30 mb-6">
                    <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    <?= t('thank_you', 'شكراً لك!') ?>
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400 mb-2">
                    <?= t('order_received', 'تم استلام طلبك بنجاح') ?>
                </p>
                <p class="text-gray-500 dark:text-gray-500">
                    <?= t('we_will_contact_soon', 'سنتصل بك قريباً لتأكيد الطلب') ?>
                </p>
            </div>

            <!-- Order Details Card -->
            <div class="bg-white dark:bg-surface-dark rounded-2xl shadow-lg p-6 md:p-8 mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                            <?= t('order_details', 'تفاصيل الطلب') ?>
                        </h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            <?= t('order_number', 'رقم الطلب') ?>: 
                            <span class="font-mono font-semibold text-primary"><?= $orderNumber ?></span>
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0 text-left md:text-right rtl:md:text-right">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            <?= t('order_date', 'تاريخ الطلب') ?>
                        </p>
                        <p class="font-medium text-gray-900 dark:text-white">
                            <?= date('Y-m-d H:i', strtotime($orderDate)) ?>
                        </p>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                        <?= t('items', 'المنتجات') ?>
                    </h3>
                    <div class="space-y-3">
                        <?php foreach ($items as $item): ?>
                        <div class="flex items-center gap-4 p-3 bg-gray-50 dark:bg-surface-darker rounded-lg">
                            <?php 
                            $product = $site->find('products')->find($item['slug'] ?? '');
                            $productImage = $product?->images()->first();
                            ?>
                            <?php if ($productImage): ?>
                            <div class="w-16 h-16 flex-shrink-0 rounded-lg overflow-hidden">
                                <?= $productImage->thumb(['width' => 100, 'height' => 100, 'quality' => 80])->img([
                                    'class' => 'w-full h-full object-cover',
                                    'alt' => $product->title()
                                ]) ?>
                            </div>
                            <?php endif ?>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-gray-900 dark:text-white truncate">
                                    <?= $product?->title() ?? $item['name'] ?? 'Product' ?>
                                </h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    <?= t('quantity', 'الكمية') ?>: <?= $item['quantity'] ?>
                                    <?php if (!empty($item['variant'])): ?>
                                    | <?= t('variant', 'النوع') ?>: <?= $item['variant'] ?>
                                    <?php endif ?>
                                </p>
                            </div>
                            <div class="text-left md:text-right rtl:md:text-right">
                                <p class="font-bold text-primary">
                                    <?= number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 0) ?> د.ج
                                </p>
                            </div>
                        </div>
                        <?php endforeach ?>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <div class="space-y-2">
                        <div class="flex justify-between text-gray-600 dark:text-gray-400">
                            <span><?= t('subtotal', 'المجموع الجزئي') ?></span>
                            <span><?= number_format($order['subtotal'], 0) ?> د.ج</span>
                        </div>
                        <div class="flex justify-between text-gray-600 dark:text-gray-400">
                            <span><?= t('shipping', 'الشحن') ?></span>
                            <span><?= number_format($order['shipping_cost'], 0) ?> د.ج</span>
                        </div>
                        <?php if ((float)$order['shipping_cost'] === 0): ?>
                        <div class="text-sm text-green-600 dark:text-green-400">
                            ✓ <?= t('free_shipping_applied', 'تم تطبيق الشحن المجاني') ?>
                        </div>
                        <?php endif ?>
                        <div class="flex justify-between text-lg font-bold text-gray-900 dark:text-white pt-2 border-t border-gray-200 dark:border-gray-700">
                            <span><?= t('total', 'المجموع الكلي') ?></span>
                            <span class="text-primary"><?= number_format($total, 0) ?> د.ج</span>
                        </div>
                    </div>
                </div>

                <!-- Shipping Info -->
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                        <?= t('shipping_info', 'معلومات الشحن') ?>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 mb-1"><?= t('customer_name', 'اسم العميل') ?></p>
                            <p class="font-medium text-gray-900 dark:text-white">
                                <?= $order['customer_first_name'] ?> <?= $order['customer_last_name'] ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 mb-1"><?= t('phone', 'الهاتف') ?></p>
                            <p class="font-medium text-gray-900 dark:text-white" dir="ltr">
                                <?= $order['customer_phone'] ?>
                            </p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-gray-500 dark:text-gray-400 mb-1"><?= t('address', 'العنوان') ?></p>
                            <p class="font-medium text-gray-900 dark:text-white">
                                <?= $order['shipping_address'] ?>, 
                                <?= $order['shipping_commune'] ?>, 
                                <?= $wilayas[$order['shipping_wilaya']]['name_ar'] ?? '' ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 mb-1"><?= t('delivery_type', 'نوع التوصيل') ?></p>
                            <p class="font-medium text-gray-900 dark:text-white">
                                <?= $order['delivery_type'] === 'home' ? t('home_delivery', 'توصيل للمنزل') : t('office_delivery', 'توصيل للمكتب') ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 mb-1"><?= t('payment_method', 'طريقة الدفع') ?></p>
                            <p class="font-medium text-gray-900 dark:text-white">
                                <?= t('cod', 'الدفع عند الاستلام') ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500 dark:text-gray-400"><?= t('order_status', 'حالة الطلب') ?></span>
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                            <span class="w-2 h-2 bg-yellow-500 rounded-full ml-2 rtl:ml-0 rtl:mr-2 animate-pulse"></span>
                            <?= t('status_pending', 'قيد المعالجة') ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6 mb-8">
                <h3 class="text-lg font-bold text-blue-900 dark:text-blue-300 mb-3">
                    <?= t('what_next', 'ماذا بعد؟') ?>
                </h3>
                <ol class="space-y-2 text-blue-800 dark:text-blue-400">
                    <li class="flex items-start">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-200 dark:bg-blue-800 rounded-full flex items-center justify-center text-sm font-bold ml-3 rtl:ml-0 rtl:mr-3">1</span>
                        <span><?= t('step_1', 'سنتصل بك خلال 24 ساعة لتأكيد الطلب') ?></span>
                    </li>
                    <li class="flex items-start">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-200 dark:bg-blue-800 rounded-full flex items-center justify-center text-sm font-bold ml-3 rtl:ml-0 rtl:mr-3">2</span>
                        <span><?= t('step_2', 'سيتم تجهيز طلبك وشحنه خلال 1-3 أيام عمل') ?></span>
                    </li>
                    <li class="flex items-start">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-200 dark:bg-blue-800 rounded-full flex items-center justify-center text-sm font-bold ml-3 rtl:ml-0 rtl:mr-3">3</span>
                        <span><?= t('step_3', 'ستستلم طلبك في غضون 2-5 أيام حسب ولايتك') ?></span>
                    </li>
                    <li class="flex items-start">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-200 dark:bg-blue-800 rounded-full flex items-center justify-center text-sm font-bold ml-3 rtl:ml-0 rtl:mr-3">4</span>
                        <span><?= t('step_4', 'ادفع عند الاستلام بعد التأكد من المنتج') ?></span>
                    </li>
                </ol>
            </div>

            <!-- Upsell Products -->
            <?php if ($upsellProducts && $upsellProducts->count() > 0): ?>
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                    <?= t('you_might_also_like', 'قد يعجبك أيضاً') ?>
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <?php foreach ($upsellProducts as $upsellProduct): ?>
                    <a href="<?= $upsellProduct->url() ?>" class="group block bg-white dark:bg-surface-dark rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <?php $thumb = $upsellProduct->images()->first() ?>
                        <?php if ($thumb): ?>
                        <div class="aspect-square overflow-hidden">
                            <?= $thumb->thumb(['width' => 300, 'height' => 300, 'quality' => 80])->img([
                                'class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-500',
                                'alt' => $upsellProduct->title()
                            ]) ?>
                        </div>
                        <?php else: ?>
                        <div class="aspect-square bg-gradient-to-br from-primary/20 to-secondary/20"></div>
                        <?php endif ?>
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
                                <?= $upsellProduct->title() ?>
                            </h4>
                            <p class="text-primary font-bold">
                                <?= number_format($upsellProduct->price()->toInt(), 0) ?> د.ج
                            </p>
                        </div>
                    </a>
                    <?php endforeach ?>
                </div>
            </div>
            <?php endif ?>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?= $site->url() ?>" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-primary hover:bg-primary-hover text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                    <svg class="w-5 h-5 ml-2 rtl:ml-0 rtl:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <?= t('back_to_home', 'العودة للرئيسية') ?>
                </a>
                <a href="<?= $site->find('products')->url() ?>" 
                   class="inline-flex items-center justify-center px-6 py-3 border-2 border-primary text-primary hover:bg-primary hover:text-white font-semibold rounded-lg transition-all duration-300">
                    <svg class="w-5 h-5 ml-2 rtl:ml-0 rtl:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <?= t('continue_shopping', 'متابعة التسوق') ?>
                </a>
            </div>

            <!-- Contact Support -->
            <div class="mt-8 text-center">
                <p class="text-gray-600 dark:text-gray-400 mb-2">
                    <?= t('need_help', 'تحتاج مساعدة؟') ?>
                </p>
                <a href="tel:<?= $site->phone() ?>" class="text-primary hover:underline font-semibold">
                    <?= $site->phone() ?>
                </a>
                <span class="mx-2 text-gray-400">|</span>
                <a href="mailto:<?= $site->email() ?>" class="text-primary hover:underline font-semibold">
                    <?= $site->email() ?>
                </a>
            </div>
        </div>
    </main>

    <?php snippet('shell/footer') ?>
    
    <!-- Structured Data for Order -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Order",
        "orderId": "<?= $orderNumber ?>",
        "orderStatus": "https://schema.org/OrderProcessing",
        "orderDate": "<?= $orderDate ?>",
        "acceptedOffer": {
            "@type": "Offer",
            "priceCurrency": "DZD",
            "price": "<?= $total ?>"
        }
    }
    </script>
</body>
</html>
