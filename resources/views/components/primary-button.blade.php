<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-mineral-green-500 dark:bg-mineral-green-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-mineral-green-800 uppercase tracking-widest hover:bg-mineral-green-700 dark:hover:bg-white focus:bg-mineral-green-700 dark:focus:bg-white active:bg-mineral-green-900 dark:active:bg-mineral-green-300 focus:outline-none focus:ring-2 focus:ring-mineral-green-500 focus:ring-offset-2 dark:focus:ring-offset-mineral-green-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
