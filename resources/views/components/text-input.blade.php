@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight border focus:outline-none focus:ring focus:ring-black focus:ring-opacity-100 focus:border-transparent',
]) !!}>
