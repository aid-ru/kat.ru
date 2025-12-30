@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm dark:text-gray-300 text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
