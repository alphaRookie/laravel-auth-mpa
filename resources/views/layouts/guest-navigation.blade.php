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
                <div class="flex items-center sm:hidden me-2"> {{-- hamburger logo: hid in deteskop and show in phone --}}
                    <button type="button" @click="mobileSidebar = !mobileSidebar" {{-- when clicked, it will activate the mobileSidebar (true ↔ false) --}}
                            :aria-expanded="mobileSidebar ? 'true' : 'false'" {{-- tells screen readers if the menu is open (true) or closed (false) --}}
                            aria-controls="mobile-sidebar" {{-- states that this button take controls the element with the id mobile-sidebar --}}
                            aria-label="Open left dropdown menu (mobile)" {{-- text description for screen readers --}}
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:bg-gray-100 focus:outline-none"> {{-- button styling --}}
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"> {{-- hamburger icon --}}
                            <path :class="{'hidden': mobileSidebar, 'inline-flex': !mobileSidebar}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/> {{-- If mobileSidebar == true → hide it --}}
                            <path :class="{'hidden': !mobileSidebar, 'inline-flex': mobileSidebar}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/> {{-- If mobileSidebar == false → show it --}}
                        </svg>
                    </button>
                </div>

                {{-- Logo --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}">
                        <x-main-logo class="block h-9 w-auto" /> {{-- Import and design logo --}}
                    </a>
                </div>

                {{-- Navigation Links (Desktop only) --}}
                <div class="hidden sm:flex sm:space-x-8 sm:-my-px sm:ms-10">
                    <x-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')"> 
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

            {{-- Desktop Dropdown (right part) --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">                
                {{-- container of the Dropdown button for Deteskop --}} 
                <x-dropdown align="right" width="48">    
                    <x-slot name="trigger"> {{-- Handle styling of the dropdown button --}}  
                        <button class=" inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">  
                            <img src="{{ asset('images/default-avatar.svg') }}" alt="Default Avatar" class="w-8 h-8 rounded-full mr-1"> 
                            <div class="text-sm">Guest</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content"> {{-- What are shown when we click the dropdown button (Dropdown menus) --}}
                        <x-dropdown-link :href="route('login')" :active="request()->routeIs('login')">
                            {{ __('Login (D)') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('register')" :active="request()->routeIs('register')">
                            {{ __('Register (D)') }}
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Mobile dropdown (Only logo) --}}
            <div class="flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-1 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none" aria-label="Open right dropdown menu">
                    <img src="{{ asset('images/default-avatar.svg') }}" alt="Default Avatar" class="w-8 h-8 rounded-full">
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile profile menu (right dropdown) --}}
    <div class="sm:hidden" :class="{'block': open, 'hidden': !open}">
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 flex items-center">
                <img src="{{ asset('images/default-avatar.svg') }}" alt="Default Avatar" class="w-10 h-10 rounded-full">
                <div>
                    <p class="text-sm font-medium text-gray-700">Guest</p>
                    <p class="text-xs text-gray-500">You need to log in first</p>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                    {{ __('Login (M)') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                    {{ __('Regsiter (M)') }}
                </x-responsive-nav-link>
            </div>
        </div>
    </div>

    {{-- Mobile sidebar links (left dropdown) --}}
    <div id="mobile-sidebar" x-show="mobileSidebar" x-cloak class="sm:hidden pt-2 pb-3 space-y-1 border-t border-gray-200">
        <x-responsive-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')">
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
