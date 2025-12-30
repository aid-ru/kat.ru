<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-2 py-1 dark:bg-gray-600 bg-gray-400 border border-transparent rounded-md text-s dark:text-black text-white dark:hover:bg-gray-500 hover:bg-gray-500 dark:active:bg-gray-400 active:bg-gray-600']) }}>
    {{ $slot }}
</button>
