@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-mineral-green-400 dark:border-mineral-green-600 text-start text-base font-medium text-mineral-green-700 dark:text-mineral-green-300 bg-mineral-green-50 dark:bg-mineral-green-900/50 focus:outline-none focus:text-mineral-green-800 dark:focus:text-mineral-green-200 focus:bg-mineral-green-100 dark:focus:bg-mineral-green-900 focus:border-mineral-green-700 dark:focus:border-mineral-green-300 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
