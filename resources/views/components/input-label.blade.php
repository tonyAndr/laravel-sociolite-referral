@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700 bark:text-gray-300']) }}>
    {{ $value ?? $slot }}
</label>
