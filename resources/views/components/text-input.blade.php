@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'border-gray-300 bark:border-gray-700 bark:bg-gray-900 bark:text-gray-300 focus:border-indigo-500 bark:focus:border-indigo-600 focus:ring-indigo-500 bark:focus:ring-indigo-600 rounded-md shadow-sm',
]) !!}>
