<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-2 py-1 bg-red-500 border border-transparent rounded-md text-s dark:text-black text-white hover:bg-red-600 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
