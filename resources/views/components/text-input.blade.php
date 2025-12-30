@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'dark:border-gray-700 border-gray-300 dark:focus:border-blue-500 focus:border-sky-500 dark:focus:ring-blue-500 focus:ring-sky-500 rounded-md shadow-sm dark:bg-gray-900 bg-gray-100 dark:text-gray-200 text-gray-800']) }}>
