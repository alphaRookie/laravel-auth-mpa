{{-- FORM FOR UPDATING PROFILE IMAGE --}}

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Picture') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Update your profile picture here.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.picture') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Current Image Preview --}}
        <div>
            <img src="{{ Auth::user()->profile_picture_url }}"
                alt="Profile Picture"
                class="w-24 h-24 rounded-full object-cover">
        </div>

        {{-- Upload New Image --}}
        <div>
            <x-input-label for="profile_picture" value="{{ __('Upload New Image') }}" />
            <x-text-input id="profile_picture" name="profile_picture" type="file" class="mt-1 block w-full" />
            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
        </div>

        {{-- If no changes detected, show this --}}
        @if (session('photo_status') === 'no-changes')
            <p class="text-sm text-red-600">No changes detected.</p>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
