{{-- REUSABLE BLADE COMPONENT TO CREATE NAVIGATION LINK --}}

@props(['href' => '#', 'active' => false]) {{-- create a special prop href, default is #. So there is definitely a valid href --}}

@php
$classes = ($active)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a href="{{ $href }}" {{ $attributes->except('href')->merge(['class' => $classes]) }}> {{-- "a href" will embedded directly in <a>, no longer mixed with $attributes --}}
    {{ $slot }}
</a>


{{-- 
Example usage:
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        {{ __('Dashboard') }}
    </x-nav-link>
--}}