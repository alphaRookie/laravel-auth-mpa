{{-- LABEL FORM INPUT
Shows the text like “Email” or “Password” above or beside input fields.
--}}

@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
