<footer class="bg-white dark:bg-surface-dark border-t border-gray-200 dark:border-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                    <?= $site->title() ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">
                    <?= $site->description() ?>
                </p>
                
                <!-- Social Links -->
                <div class="flex space-x-4 rtl:space-x-reverse">
                    <?php if ($site->facebook()->isNotEmpty()): ?>
                    <a href="<?= $site->facebook() ?>" target="_blank" rel="noopener noreferrer" 
                       class="text-gray-500 hover:text-primary dark:hover:text-primary transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <?php endif ?>
                    
                    <?php if ($site->instagram()->isNotEmpty()): ?>
                    <a href="<?= $site->instagram() ?>" target="_blank" rel="noopener noreferrer" 
                       class="text-gray-500 hover:text-primary dark:hover:text-primary transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <?php endif ?>
                    
                    <?php if ($site->tiktok()->isNotEmpty()): ?>
                    <a href="<?= $site->tiktok() ?>" target="_blank" rel="noopener noreferrer" 
                       class="text-gray-500 hover:text-primary dark:hover:text-primary transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93v6.16c0 2.52-1.12 4.84-2.9 6.24-1.72 1.39-3.92 1.91-6.07 1.47-2.92-.57-5.23-2.91-5.77-5.84-.49-2.63.56-5.32 2.71-6.94 2.2-1.66 5.21-1.85 7.59-.43v4.21c-.99-.65-2.26-.82-3.4-.44-1.49.48-2.53 1.86-2.53 3.41 0 1.98 1.61 3.59 3.59 3.59 1.98 0 3.59-1.61 3.59-3.59V.02h-1.89z"/>
                        </svg>
                    </a>
                    <?php endif ?>
                    
                    <?php if ($site->whatsapp()->isNotEmpty()): ?>
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $site->whatsapp()) ?>" target="_blank" rel="noopener noreferrer" 
                       class="text-gray-500 hover:text-green-500 transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </a>
                    <?php endif ?>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                    <?= t('quick_links', 'روابط سريعة') ?>
                </h4>
                <ul class="space-y-2">
                    <li>
                        <a href="<?= $site->url() ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors">
                            <?= t('home', 'الرئيسية') ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $site->find('products')->url() ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors">
                            <?= t('all_products', 'جميع المنتجات') ?>
                        </a>
                    </li>
                    <?php if ($site->find('categories')): ?>
                    <li>
                        <a href="<?= $site->find('categories')->url() ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors">
                            <?= t('categories', 'التصنيفات') ?>
                        </a>
                    </li>
                    <?php endif ?>
                    <?php if ($site->about_page()->isNotEmpty()): ?>
                    <li>
                        <a href="<?= $site->about_page() ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors">
                            <?= t('about', 'من نحن') ?>
                        </a>
                    </li>
                    <?php endif ?>
                    <?php if ($site->contact_page()->isNotEmpty()): ?>
                    <li>
                        <a href="<?= $site->contact_page() ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors">
                            <?= t('contact', 'اتصل بنا') ?>
                        </a>
                    </li>
                    <?php endif ?>
                </ul>
            </div>

            <!-- Customer Service -->
            <div>
                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                    <?= t('customer_service', 'خدمة العملاء') ?>
                </h4>
                <ul class="space-y-2">
                    <li>
                        <a href="<?= $site->find('faq')?->url() ?? '#' ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors">
                            <?= t('faq', 'الأسئلة الشائعة') ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $site->find('shipping')?->url() ?? '#' ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors">
                            <?= t('shipping_info', 'معلومات الشحن') ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $site->find('returns')?->url() ?? '#' ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors">
                            <?= t('returns_policy', 'سياسة الإرجاع') ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $site->find('privacy')?->url() ?? '#' ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors">
                            <?= t('privacy_policy', 'سياسة الخصوصية') ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $site->find('terms')?->url() ?? '#' ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors">
                            <?= t('terms_conditions', 'الشروط والأحكام') ?>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                    <?= t('contact_us', 'تواصل معنا') ?>
                </h4>
                <ul class="space-y-3">
                    <?php if ($site->phone()->isNotEmpty()): ?>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-primary ml-2 rtl:ml-0 rtl:mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <a href="tel:<?= $site->phone() ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary transition-colors" dir="ltr">
                            <?= $site->phone() ?>
                        </a>
                    </li>
                    <?php endif ?>
                    
                    <?php if ($site->email()->isNotEmpty()): ?>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-primary ml-2 rtl:ml-0 rtl:mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <a href="mailto:<?= $site->email() ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary transition-colors">
                            <?= $site->email() ?>
                        </a>
                    </li>
                    <?php endif ?>
                    
                    <?php if ($site->address()->isNotEmpty()): ?>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-primary ml-2 rtl:ml-0 rtl:mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-gray-600 dark:text-gray-400">
                            <?= $site->address() ?>
                        </span>
                    </li>
                    <?php endif ?>
                    
                    <?php if ($site->working_hours()->isNotEmpty()): ?>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-primary ml-2 rtl:ml-0 rtl:mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-gray-600 dark:text-gray-400">
                            <?= $site->working_hours() ?>
                        </span>
                    </li>
                    <?php endif ?>
                </ul>

                <!-- Payment Methods -->
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                        <?= t('payment_methods', 'طرق الدفع') ?>
                    </p>
                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                        <div class="px-3 py-2 bg-gray-100 dark:bg-surface-darker rounded-lg text-xs font-medium text-gray-700 dark:text-gray-300">
                            💵 <?= t('cod', 'الدفع عند الاستلام') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-800">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-500 dark:text-gray-400 text-center md:text-right rtl:md:text-right">
                    &copy; <?= date('Y') ?> <?= $site->title() ?>. <?= t('all_rights_reserved', 'جميع الحقوق محفوظة') ?>.
                </p>
                
                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                    <?php snippet('admin/language-switcher') ?>
                    <?php snippet('shell/theme-toggle') ?>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Cart Drawer -->
<div x-show="cartOpen" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="translate-x-full"
     x-transition:enter-end="translate-x-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="translate-x-0"
     x-transition:leave-end="translate-x-full"
     class="fixed inset-0 z-[70]"
     style="display: none;">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="cartOpen = false"></div>
    
    <div class="absolute top-0 left-0 rtl:right-0 rtl:left-auto h-full w-full max-w-md bg-white dark:bg-surface-dark shadow-2xl">
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                    <?= t('shopping_cart', 'سلة التسوق') ?>
                </h2>
                <button @click="cartOpen = false" class="p-2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <div class="flex-1 overflow-y-auto p-4">
                <!-- Cart items will be loaded dynamically -->
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <?= t('cart_empty', 'السلة فارغة') ?>
                </div>
            </div>
            
            <div class="border-t border-gray-200 dark:border-gray-700 p-4">
                <a href="<?= $site->find('checkout')->url() ?>" 
                   class="block w-full bg-primary hover:bg-primary-hover text-white text-center font-bold py-3 rounded-xl transition-colors">
                    <?= t('checkout', 'إتمام الطلب') ?>
                </a>
            </div>
        </div>
    </div>
</div>
