<div class="relative" x-data="{ languageOpen: false }">
    <button @click="languageOpen = !languageOpen" 
            @click.outside="languageOpen = false"
            class="flex items-center space-x-1 rtl:space-x-reverse px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-surface-darker rounded-lg transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
        </svg>
        <span><?= strtoupper($kirby->language()->code()) ?></span>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <div x-show="languageOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute top-full left-0 rtl:left-auto rtl:right-0 mt-2 w-40 bg-white dark:bg-surface-dark rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden z-50">
        <div class="py-1">
            <?php foreach ($kirby->languages() as $language): ?>
            <a href="<?= $page->url($language->code()) ?>" 
               class="block px-4 py-2 text-sm <?= $kirby->language()->code() === $language->code() ? 'bg-primary/10 text-primary' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-surface-darker' ?> transition-colors">
                <div class="flex items-center justify-between">
                    <span><?= $language->name() ?></span>
                    <?php if ($kirby->language()->code() === $language->code()): ?>
                    <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <?php endif ?>
                </div>
            </a>
            <?php endforeach ?>
        </div>
    </div>
</div>
