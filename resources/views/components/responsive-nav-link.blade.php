@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-gray-500 text-start text-base font-medium dark:text-gray-300 text-gray-700 dark:bg-gray-900 bg-gray-100 focus:outline-none focus:dark:text-gray-200 focus:text-gray-800 dark:focus:bg-gray-900 focus:bg-gray-100 dark:focus:border-gray-300 focus:border-gray-700 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-500 dark:hover:text-gray-200 hover:text-gray-800 dark:hover:bg-gray-900 hover:bg-gray-100 dark:hover:border-gray-700 hover:border-gray-300 focus:outline-none dark:focus:text-gray-200 focus:text-gray-800 dark:focus:bg-gray-900 focus:bg-gray-100 dark:focus:border-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
