<button @click="toggleTheme()" 
        :aria-label="theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'"
        class="p-2 text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors"
        x-data="{ 
            theme: localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'),
            toggleTheme() {
                this.theme = this.theme === 'light' ? 'dark' : 'light';
                localStorage.setItem('theme', this.theme);
                document.documentElement.classList.toggle('dark', this.theme === 'dark');
                document.documentElement.setAttribute('data-theme', this.theme);
            }
        }">
    <!-- Sun Icon (Light Mode) -->
    <svg x-show="theme === 'light'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
    </svg>
    <!-- Moon Icon (Dark Mode) -->
    <svg x-show="theme === 'dark'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
    </svg>
</button>
