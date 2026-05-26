<header class="sticky top-0 z-50 bg-white/80 dark:bg-surface-dark/80 backdrop-blur-lg border-b border-gray-200 dark:border-gray-800" x-data="{ mobileMenuOpen: false, searchOpen: false, cartOpen: false }">
    <!-- Top Bar -->
    <?php if ($site->announcement_bar_text()->isNotEmpty()): ?>
    <div class="bg-primary text-white py-2 px-4 text-center text-sm font-medium">
        <?= $site->announcement_bar_text() ?>
    </div>
    <?php endif ?>

    <!-- Main Header -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 md:h-20">
            <!-- Logo -->
            <a href="<?= $site->url() ?>" class="flex-shrink-0">
                <?php if ($logo = $site->logo()->toFile()): ?>
                    <?= $logo->thumb(['width' => 150, 'height' => 50, 'quality' => 90])->img([
                        'class' => 'h-8 md:h-10 w-auto',
                        'alt' => $site->title()
                    ]) ?>
                <?php else: ?>
                    <span class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">
                        <?= $site->title() ?>
                    </span>
                <?php endif ?>
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center space-x-8 rtl:space-x-reverse">
                <a href="<?= $site->url() ?>" class="text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary font-medium transition-colors">
                    <?= t('home', 'الرئيسية') ?>
                </a>
                
                <?php 
                $categories = $site->find('categories')?->children()?->listed();
                if ($categories && $categories->count() > 0):
                ?>
                <div class="relative group" x-data="{ dropdownOpen: false }">
                    <button @click="dropdownOpen = !dropdownOpen" 
                            @click.outside="dropdownOpen = false"
                            class="flex items-center text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary font-medium transition-colors">
                        <?= t('categories', 'التصنيفات') ?>
                        <svg class="w-4 h-4 mr-1 rtl:mr-0 rtl:ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="dropdownOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         class="absolute top-full right-0 rtl:right-auto rtl:left-0 mt-2 w-56 bg-white dark:bg-surface-dark rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="py-2">
                            <?php foreach ($categories as $category): ?>
                            <a href="<?= $category->url() ?>" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-surface-darker hover:text-primary transition-colors">
                                <?= $category->title() ?>
                            </a>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
                <?php endif ?>

                <?php if ($site->find('funnels')?->children()?->listed()?->count() > 0): ?>
                <a href="<?= $site->find('funnels')->url() ?>" class="text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary font-medium transition-colors">
                    <?= t('offers', 'العروض') ?>
                </a>
                <?php endif ?>

                <?php if ($site->about_page()->isNotEmpty()): ?>
                <a href="<?= $site->about_page() ?>" class="text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary font-medium transition-colors">
                    <?= t('about', 'من نحن') ?>
                </a>
                <?php endif ?>

                <?php if ($site->contact_page()->isNotEmpty()): ?>
                <a href="<?= $site->contact_page() ?>" class="text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary font-medium transition-colors">
                    <?= t('contact', 'اتصل بنا') ?>
                </a>
                <?php endif ?>
            </nav>

            <!-- Right Actions -->
            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                <!-- Language Switcher -->
                <?php snippet('admin/language-switcher') ?>

                <!-- Theme Toggle -->
                <?php snippet('shell/theme-toggle') ?>

                <!-- Search Button -->
                <button @click="searchOpen = true" 
                        class="p-2 text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>

                <!-- Cart Button -->
                <button @click="cartOpen = true" 
                        class="relative p-2 text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors"
                        x-data="{ cartCount: <?= count($kirby->session()->get('cart', [])) ?> }">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span x-show="cartCount > 0" 
                          x-text="cartCount"
                          class="absolute -top-1 -right-1 w-5 h-5 bg-primary text-white text-xs font-bold rounded-full flex items-center justify-center">
                    </span>
                </button>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="lg:hidden p-2 text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="lg:hidden bg-white dark:bg-surface-dark border-t border-gray-200 dark:border-gray-800">
        <div class="container mx-auto px-4 py-4 space-y-2">
            <a href="<?= $site->url() ?>" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-surface-darker rounded-lg">
                <?= t('home', 'الرئيسية') ?>
            </a>
            
            <?php if ($categories && $categories->count() > 0): ?>
            <div class="px-4 py-2">
                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-2"><?= t('categories', 'التصنيفات') ?></p>
                <div class="space-y-1">
                    <?php foreach ($categories as $category): ?>
                    <a href="<?= $category->url() ?>" class="block px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-surface-darker rounded-lg">
                        <?= $category->title() ?>
                    </a>
                    <?php endforeach ?>
                </div>
            </div>
            <?php endif ?>

            <?php if ($site->about_page()->isNotEmpty()): ?>
            <a href="<?= $site->about_page() ?>" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-surface-darker rounded-lg">
                <?= t('about', 'من نحن') ?>
            </a>
            <?php endif ?>

            <?php if ($site->contact_page()->isNotEmpty()): ?>
            <a href="<?= $site->contact_page() ?>" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-surface-darker rounded-lg">
                <?= t('contact', 'اتصل بنا') ?>
            </a>
            <?php endif ?>
        </div>
    </div>

    <!-- Search Modal -->
    <div x-show="searchOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[60] bg-black/50 backdrop-blur-sm"
         @click.self="searchOpen = false"
         style="display: none;">
        <div class="flex items-start justify-center min-h-screen pt-20 px-4">
            <div x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="w-full max-w-2xl bg-white dark:bg-surface-dark rounded-2xl shadow-2xl overflow-hidden">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <form action="<?= $site->find('products')->url() ?>" method="get" class="flex items-center">
                        <input type="text" name="q" placeholder="<?= t('search_products', 'ابحث عن المنتجات...') ?>" 
                               class="flex-1 bg-transparent text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none text-lg"
                               autofocus>
                        <button type="submit" class="p-2 text-primary hover:bg-primary/10 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                        <button type="button" @click="searchOpen = false" class="p-2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </form>
                </div>
                <!-- Search suggestions could go here -->
            </div>
        </div>
    </div>
</header>
