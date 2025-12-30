<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-2 py-1 dark:bg-blue-500 bg-sky-800 border border-transparent rounded-md text-s dark:text-black text-white dark:hover:bg-blue-400 hover:bg-sky-700 dark:active:bg-blue-300 active:bg-sky-500']) }}>
    {{ $slot }}
</button>
