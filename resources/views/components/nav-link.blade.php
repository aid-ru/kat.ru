@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[#336699] text-sm font-medium leading-5 dark:text-gray-100 text-gray-900 focus:outline-none dark:focus:border-blue-500 focus:border-sky-500 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:hover:text-gray-300 hover:text-gray-700 hover:border-gray-500 focus:outline-none dark:focus:text-gray-300 focus:text-gray-700 dark:focus:border-blue-500 focus:border-sky-500 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
