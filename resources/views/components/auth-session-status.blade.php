{{-- DISPLAYS SESSION ERROR/SUCCESS MESSAGE (with medium font and green color) --}}

@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600']) }}>
        {{ $status }}
    </div>
@endif

{{-- 
For success message, thats why we always mention 'status' in the controller like this 
(
    return back()->with('status', 'password-updated');
)
--}}