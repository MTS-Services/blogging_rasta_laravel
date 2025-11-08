@props(['value'])

<label
    {{ $attributes->merge(['class' => 'block font-medium text-sm text-text-primary dark:text-text-primary ltr:text-left rtl:text-right']) }}>
    {{ $value ?? $slot }}
</label>
