{{-- TOP NAV BAR PARTIAL, used inside app.blade.php --}}

<nav 
  x-data="{ open: false, mobileSidebar: false }" {{-- "open: false" means the menu hidden at first --}}
  class="sticky top-0 z-50 bg-white border-b border-gray-100 shadow" {{-- sticky yang bikin pas di zoom 150% ngak kepotong; z-50 semacam ngeset biar ini tu jadi tumpukan paling atas --}}
> 
    
    {{-- Deteskop Main Menu (What we directly see without clicking anything) --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"> {{-- Outer container: Sets the width and center the navbar --}}
        <div class="flex justify-between h-16"> {{-- Inner container: wrap & layout the whole content --}}
            
            {{-- Contains logo + Dropdown left part(mobile only) --}}
            <div class="flex">
                <div class="flex items-center sm:hidden me-2">
                    <button type="button" @click="mobileSidebar = !mobileSidebar"
                            :aria-expanded="mobileSidebar ? 'true' : 'false'" 
                            aria-controls="mobile-sidebar"
                            aria-label="Open left dropdown menu (mobile)"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:bg-gray-100 focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': mobileSidebar, 'inline-flex': !mobileSidebar}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path :class="{'hidden': !mobileSidebar, 'inline-flex': mobileSidebar}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Logo --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-main-logo class="block h-9 w-auto" /> {{-- Import and design logo --}}
                    </a>
                </div>

                {{-- Navigation Links (Desktop only, >=sm) --}}
                <div class="hidden sm:flex sm:space-x-8 sm:-my-px sm:ms-10">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"> 
                        {{ __('Home') }}
                    </x-nav-link>
                </div>

                <div class="hidden sm:flex sm:space-x-8 sm:-my-px sm:ms-10">
                    <x-nav-link :href="'#'">
                        {{ __('Blog') }}
                    </x-nav-link>
                </div>

                <div class="hidden sm:flex sm:space-x-8 sm:-my-px sm:ms-10">
                    <x-nav-link :href="'#'">
                        {{ __('Service') }}
                    </x-nav-link>
                </div>
            </div>

            {{-- Desktop Dropdown --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6"> {{-- hidden mobile, show desktop --}}
                
                {{-- container of the Dropdown button for Deteskop) --}}
                <x-dropdown align="right" width="48"> 

                    {{-- Only handle styling of the dropdown button (What we see) --}}
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <img src="{{ Auth::user()->profile_picture_url }}"  {{-- If no profile picture, fallback to default --}}
                                alt="Profile Picture" 
                                class="w-8 h-8 rounded-full mr-1"> {{-- rounded-full makes logo appears circle --}}
                            <span>{{ Auth::user()->name }}</span> {{-- Show user's name --}}
                            <svg class="w-4 h-4 ml-1 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" 
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    {{-- What are shown when we click the dropdown button (Dropdown menus) --}}
                     <x-slot name="content">
                        <!-- My Profile -->
                        <a href="#" class="flex items-center p-2 text-sm text-stone-800 hover:bg-stone-100 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                    d="M7 18V17C7 14.2386 9.23858 12 12 12C14.7614 12 17 14.2386 17 17V18M12 12C13.6569 12 15 10.6569 15 9C15 7.34315 13.6569 6 12 6C10.3431 6 9 7.34315 9 9C9 10.6569 10.3431 12 12 12Z" />
                                <circle cx="12" cy="12" r="10" stroke-width="1.5"></circle>
                            </svg>
                            My Profile
                        </a>

                        <!-- Edit Profile -->
                        <a href="{{ route('profile.edit') }}" class="flex items-center p-2 text-sm text-stone-800 hover:bg-stone-100 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                    d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                    d="M19.6224 10.3954L18.5247 7.7448L20 6L18 4L16.2647 5.48295L13.5578 4.36974L12.9353 2H10.981L10.3491 4.40113L7.70441 5.51596L6 4L4 6L5.45337 7.78885L4.3725 10.4463L2 11V13L4.40111 13.6555L5.51575 16.2997L4 18L6 20L7.79116 18.5403L10.397 19.6123L11 22H13L13.6045 19.6132L16.2551 18.5155L18 20L20 18L18.5159 16.2494L19.6139 13.598L21.9999 12.9772L22 11L19.6224 10.3954Z" />
                            </svg>
                            Edit Profile
                        </a>

                        <hr class="my-1 border-stone-200"> {{-- Line that separate logout and other --}}

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center p-2 text-sm text-red-500 hover:bg-red-100 rounded-md w-full text-left">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 12H19M19 12L16 15M19 12L16 9" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 6V5C19 3.89543 18.1046 3 17 3H7C5.89543 3 5 3.89543 5 5V19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19V18" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </x-slot>
                    
                </x-dropdown>
            </div>

            {{-- Mobile dropdown -> Hamburger (3 line logo) only appears when the page size is smaller than 90% or 640px --}}
            <div class="flex items-center sm:hidden"> {{-- the hamburger 3 line logo--}}
                <button @click="open = !open" class="inline-flex items-center justify-center p-1 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none" aria-label="Open right dropdown menu">
                    <img src="{{ Auth::user()->profile_picture_url }}" alt="Default Avatar" class="w-8 h-8 rounded-full">
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Right dropdown Menu (right dropdown) --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden"> {{-- Show the dropdown menu when it clicks --}}

        {{-- Responsive Dropdowns --}}
        <div class="pt-4 pb-1 border-t border-gray-2000">
           
           {{-- Container of Profile picture, name, email shown here --}}
            <div class="px-4">
                <img src="{{ Auth::user()->profile_picture_url }}" 
                alt="Profile Picture" 
                class="w-12 h-12 rounded-full mb-2">

                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div> {{-- Show name --}}
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div> {{-- Show email --}}
            </div>

            <div class="mt-3 space-y-1">
                {{-- Button that goes to Profile (Mobile) --}}
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile mobile') }}
                </x-responsive-nav-link>

                {{-- Logout button (Mobile) --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" 
                            onclick="event.preventDefault(); 
                                    this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

    {{-- Mobile left dropdown menu (left dropdown) --}}
    <div id="mobile-sidebar" x-show="mobileSidebar" x-cloak class="sm:hidden pt-2 pb-3 space-y-1 border-t border-gray-200">
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Home') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="'#'">
            {{ __('Blog') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="'#'">
            {{ __('Service') }}
        </x-responsive-nav-link>
    </div>
</nav>
