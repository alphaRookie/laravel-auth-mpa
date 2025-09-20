{{-- MAIN PROFILE PAGE (shows forms for updating name, email, password, deleting account) --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">{{-- make space up and down the form --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"> {{-- Restricted width, centered wrapper, with side padding, and vertical gaps--}}

            {{-- Profile picture Upload --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg"> {{-- Padding inside the box, white bg, shadow behind it, rounded edges --}}
                <div class="max-w-xl"> {{-- Keeps the inner form narrower (not stretching full width when zoomed out) --}}
                    @include('profile.partials.update-profile-picture-form')
                </div>
            </div> 

            {{-- Update Profile Information --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg"> 
                <div class="max-w-xl"> 
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Update Password --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete User Account --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>



