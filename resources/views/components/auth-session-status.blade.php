@props(['status'])

@if ($status)
<div {{ $attributes->merge(['class' => 'font-bold text-sm text-green-600 dark:text-green-400 p-2 m-0 flex items-center justify-center mb-0']) }}>
    {{ $status }}
</div>
@endif
