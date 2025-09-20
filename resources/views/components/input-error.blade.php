{{-- SHOW VALIDATION ERROR MESSAGE (with medium font and red color) --}}

@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif

{{-- 
In blade view, we call this to show error message like this :
    <x-input-error :messages="$errors->get('email')" />
--}}