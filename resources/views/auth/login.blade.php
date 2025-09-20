{{--LOGIN PAGE--}} 

<x-form-layout> {{-- use layout for unenthicated page (guest) --}}
 
  <div
    x-data="{ darkMode: localStorage.getItem('dark') === '1', init(){ document.documentElement.classList.toggle('dark', localStorage.getItem('dark') === '1') }, toggle(){ this.darkMode = !this.darkMode; document.documentElement.classList.toggle('dark', this.darkMode); localStorage.setItem('dark', this.darkMode ? '1' : '0') } }"
    x-init="init()"
    class="min-h-screen items-center justify-center grid grid-cols-1 lg:grid-cols-2 bg-white dark:bg-gray-900"
  >

    {{-- Session Status --}}
    <x-auth-session-status class="mb-4" :status="session('status')" /> {{-- displays feedback box for user --}}

      {{-- Left side in deteskop --}}
      <div class=" max-w-md w-full mx-auto px-4 py-8">
        {{-- Button to go back --}}
        <a href="{{ route('welcome') }}" class="inline-flex items-center text-sm pt-3 pb-16 text-gray-500 transition-colors hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
          <svg class="stroke-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
            <path d="M12.7083 5L7.5 10.2083L12.7083 15.4167" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Back to dashboard
        </a>

        {{-- Header --}}
        <div class="mb-8">
          <h1 class="mb-2 font-bold text-gray-800 text-title-sm dark:text-white/90 sm:text-title-md text-2xl sm:text-3xl"> {{-- Combine "text-2xl sm:text-3xl" so it will be responsive for mobile --}}
            Sign In
          </h1>
          <p class="text-sm text-gray-500 dark:text-gray-400">
            Enter your email and password to sign in!
          </p>
        </div>

        {{-- Social buttons --}}
        <div>
          <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-5">
            <a href="{{ route('social.redirect', 'google') ?? '#' }}"
              class="inline-flex items-center justify-center gap-3 py-3 text-sm font-normal text-gray-700 transition-colors bg-gray-100 rounded-lg px-7 hover:bg-gray-200 hover:text-gray-800 dark:bg-white/5 dark:text-white/90 dark:hover:bg-white/10 ">
              <!-- Simple Google icon -->
              <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M18.75 10.2c0-.72-.06-1.25-.19-1.79H10.18v3.25h4.92c-.10.81-.64 1.99-1.83 2.81l2.65 2.01c1.69-1.53 2.66-3.78 2.66-6.28z" fill="#4285F4"/>
                <path d="M10.18 18.75c2.41 0 4.43-.78 5.91-2.12l-2.82-2.12c-.75.52-1.76.88-3.09.88-2.36 0-4.36-1.53-5.07-3.64l-2.76 1.09C3.67 16.78 6.69 18.75 10.18 18.75z" fill="#34A853"/>
                <path d="M5.10 11.73c-.19-.54-.30-1.12-.30-1.73 0-.61.11-1.19.29-1.73L2.29 6.03C1.70 7.26 1.35 8.59 1.35 10c0 1.41.35 2.74.94 3.94l2.82-2.21z" fill="#FBBC05"/>
                <path d="M10.18 4.63c1.68 0 2.81.71 3.44 1.32l2.52-2.41C14.60 2.12 12.58 1.25 10.18 1.25 6.69 1.25 3.67 3.22 2.20 6.08l2.89 2.12C5.81 6.16 7.82 4.63 10.18 4.63z" fill="#EB4335"/>
              </svg>
              Sign in with Google
            </a>

            <a href="{{ route('social.redirect', 'x') ?? '#' }}"
              class="inline-flex items-center justify-center gap-3 py-3 text-sm font-normal text-gray-700 transition-colors bg-gray-100 rounded-lg px-7 hover:bg-gray-200 hover:text-gray-800 dark:bg-white/5 dark:text-white/90 dark:hover:bg-white/10">
              <!-- Simple X icon -->
              <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M15.67 1.875h2.76L12.40 8.758 19.49 18.125h-5.55l-4.35-5.681L4.63 18.125H1.87L8.31 10.762 1.51 1.875h5.69l3.93 5.192L15.67 1.875z" fill="currentColor"/>
              </svg>
              Sign in with X
            </a>
          </div>
        </div>

        {{-- separator --}}
        <div class="relative my-3"> {{-- relative is like: relative itu kayak penanda atau anchor, semua anak absolute tahu harus menempel ke siapa --}}
          <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t-4 border-gray-200 dark:border-gray-800 rounded-full"></div>
          </div>
          <div class="relative flex justify-center text-sm">
            <span class="p-2 text-gray-400 bg-white dark:bg-gray-900 sm:px-5 sm:py-2 rounded-md">Or</span>
          </div>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email Address --}}
            <div class="mt-4"> {{-- these 3 is wrapped inside 1 bag, and we set margin top to 4 --}} 
                <x-input-label for="email" :value="__('Email')" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400" /> {{-- Shows text like "Email" above input form --}}
                <x-text-input id="email" {{-- Where the input field shown and this id is linking to label (above) and js targeting --}}
                              type="email" {{-- specifies that this is email input --}}
                              name="email" :value="old('email')" {{-- what user type in + pulls the previous entered value if validation failed --}}
                              placeholder="Your email address"
                              class="h-11 w-full rounded-lg border border-gray-400 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 
                                    dark:border-gray-500 dark:bg-gray-900 dark:text-white/90" {{-- for dark mode --}}
                              required autofocus autocomplete="email" /> {{-- autofocus: when page opens/after refresh, we dont need to move cursor to that field and click to enter value --}}
                <x-input-error :messages="$errors->get('email')" class="mt-2" /> {{-- receive any error from request and display it here (2px below the form field) --}}
            </div>

            {{-- Password --}}
            <div class="mt-4" x-data="{ showPassword: false }">
            <x-input-label for="password" :value="__('Password')" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400" />

            <div class="relative">
              <x-text-input
                id="password"
                name="password"
                x-bind:type="showPassword ? 'text' : 'password'"
                placeholder="Enter your password"
                class="h-11 w-full rounded-lg border border-gray-400 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 
                      dark:border-gray-500 dark:bg-gray-900 dark:text-white/90" 
                required autocomplete="new-password" />

              <!-- hide/show icons -->
              <button type="button" @click="showPassword = !showPassword" 
                      class="absolute z-30 -translate-y-1/2 right-4 top-1/2 text-gray-500 dark:text-gray-400">

                  <!-- Eye Open SVG (show if showPassword = false) -->
                  <svg x-show="!showPassword" x-cloak xmlns="http://www.w3.org/2000/svg"
                        fill="none" {{-- define the inline color inside the eye --}}
                        viewBox="0 0 24 24" {{-- like telling where it located --}}
                        stroke-width="1.5" {{-- define the thickness of that icon --}}
                        stroke="currentColor" {{-- define the color of the eye shapes --}}
                        class="h-5 w-5"> {{--defines the height and width of an icon --}}
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                  </svg>

                  <!-- Eye Closed SVG (tampil jika showPassword = true) -->
                  <svg x-show="showPassword" x-cloak xmlns="http://www.w3.org/2000/svg"
                      fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                      class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                  </svg>
              </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
          </div>

          {{-- Remember Me and checkbox --}}
          <div class="flex mt-4 items-center justify-between "> {{-- block make sure it starts on new line --}}
              <label for="remember" class="flex items-center text-sm font-normal text-gray-700 cursor-pointer select-none dark:text-gray-400">
                <input id="remember" 
                      name="remember" 
                      type="checkbox" 
                      class="mr-3 h-4 w-4 rounded border-gray-400 focus:outline-none focus:ring-0
                      dark:bg-gray-900  dark:checked:bg-indigo-500 " />
                Remember me
              </label>
              <a href="{{ route('password.request') }}" 
                class="inline-block text-sm font-normal text-indigo-500
                        hover:text-indigo-700 dark:hover:text-indigo-400">
                Forgot password?
              </a>
          </div>

          {{-- Forgot password and login button wrapped inside one class --}}
          <div class="flex mt-4 items-center justify-between">
            <x-primary-button class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-indigo-500 shadow-theme-xs hover:bg-indigo-600">
              {{ __('Sign In') }}
            </x-primary-button>
          </div>

          {{-- Haven't registered link --}}
          <div class="mt-4 text-center">
            <p class="text-sm font-normal text-gray-700 dark:text-gray-400 ">
              Haven't create an account?
              <a href="{{ route('register') }}" class="text-indigo-500 hover:text-indigo-700 dark:hover:text-indigo-400 ">Sign Up</a>
            </p>
          </div>
        </form>
      </div>

      {{-- Right side in deteskop --}}
      <div class="relative items-center hidden w-full h-full bg-blue-950 dark:bg-white/5 lg:grid "> {{-- Hidden in small screen, and split 1/2 in deteskop --}}
          <x-grid-background /> {{-- To include grid background; This one standalone --}}
          
          <div class="flex items-center justify-center ">
              <div class="flex flex-col items-center max-w-xs">
                <a class="text-indigo-600 no-underline hover:no-underline font-bold text-xl lg:text-5xl flex items-center gap-2" href="#">
                    <img src="{{ asset('images/mlogo.png') }}" alt="Logo" class="w-28 h-16 mb-4 inline-block align-middle"/>
                    MyPage
                </a>
                <p class="text-center text-gray-400 dark:text-white/60">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius aliquid iure quis quam repellat.
                </p>
              </div>
          </div>
      </div>

      <!-- Toggler -->
      <div class="fixed z-50 bottom-6 right-6">
        <button
          type="button"
          aria-label="Toggle dark mode"
          :aria-pressed="darkMode ? 'true' : 'false'"
          @click.prevent="toggle()"
          title="Toggle dark / light"
          class="inline-flex items-center justify-center text-white transition-colors rounded-full w-16 h-16 bg-indigo-500 hover:bg-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-400"
        >
          <!-- SVG for dark mode (shown when darkMode = true) -->
          <svg
            x-show="darkMode"
            x-cloak
            class="fill-current h-5 w-5"
            width="20"
            height="20"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M9.99998 1.5415C10.4142 1.5415 10.75 1.87729 10.75 2.2915V3.5415C10.75 3.95572 10.4142 4.2915 9.99998 4.2915C9.58577 4.2915 9.24998 3.95572 9.24998 3.5415V2.2915C9.24998 1.87729 9.58577 1.5415 9.99998 1.5415ZM10.0009 6.79327C8.22978 6.79327 6.79402 8.22904 6.79402 10.0001C6.79402 11.7712 8.22978 13.207 10.0009 13.207C11.772 13.207 13.2078 11.7712 13.2078 10.0001C13.2078 8.22904 11.772 6.79327 10.0009 6.79327ZM5.29402 10.0001C5.29402 7.40061 7.40135 5.29327 10.0009 5.29327C12.6004 5.29327 14.7078 7.40061 14.7078 10.0001C14.7078 12.5997 12.6004 14.707 10.0009 14.707C7.40135 14.707 5.29402 12.5997 5.29402 10.0001ZM15.9813 5.08035C16.2742 4.78746 16.2742 4.31258 15.9813 4.01969C15.6884 3.7268 15.2135 3.7268 14.9207 4.01969L14.0368 4.90357C13.7439 5.19647 13.7439 5.67134 14.0368 5.96423C14.3297 6.25713 14.8045 6.25713 15.0974 5.96423L15.9813 5.08035ZM18.4577 10.0001C18.4577 10.4143 18.1219 10.7501 17.7077 10.7501H16.4577C16.0435 10.7501 15.7077 10.4143 15.7077 10.0001C15.7077 9.58592 16.0435 9.25013 16.4577 9.25013H17.7077C18.1219 9.25013 18.4577 9.58592 18.4577 10.0001ZM14.9207 15.9806C15.2135 16.2735 15.6884 16.2735 15.9813 15.9806C16.2742 15.6877 16.2742 15.2128 15.9813 14.9199L15.0974 14.036C14.8045 13.7431 14.3297 13.7431 14.0368 14.036C13.7439 14.3289 13.7439 14.8038 14.0368 15.0967L14.9207 15.9806ZM9.99998 15.7088C10.4142 15.7088 10.75 16.0445 10.75 16.4588V17.7088C10.75 18.123 10.4142 18.4588 9.99998 18.4588C9.58577 18.4588 9.24998 18.123 9.24998 17.7088V16.4588C9.24998 16.0445 9.58577 15.7088 9.99998 15.7088ZM5.96356 15.0972C6.25646 14.8043 6.25646 14.3295 5.96356 14.0366C5.67067 13.7437 5.1958 13.7437 4.9029 14.0366L4.01902 14.9204C3.72613 15.2133 3.72613 15.6882 4.01902 15.9811C4.31191 16.274 4.78679 16.274 5.07968 15.9811L5.96356 15.0972ZM4.29224 10.0001C4.29224 10.4143 3.95645 10.7501 3.54224 10.7501H2.29224C1.87802 10.7501 1.54224 10.4143 1.54224 10.0001C1.54224 9.58592 1.87802 9.25013 2.29224 9.25013H3.54224C3.95645 9.25013 4.29224 9.58592 4.29224 10.0001ZM4.9029 5.9637C5.1958 6.25659 5.67067 6.25659 5.96356 5.9637C6.25646 5.6708 6.25646 5.19593 5.96356 4.90303L5.07968 4.01915C4.78679 3.72626 4.31191 3.72626 4.01902 4.01915C3.72613 4.31204 3.72613 4.78692 4.01902 5.07981L4.9029 5.9637Z"
            />
          </svg>

          <!-- SVG for light mode (shown when darkMode = false) -->
          <svg
            x-show="!darkMode"
            x-cloak
            class="fill-current h-5 w-5"
            width="20"
            height="20"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M17.4547 11.97L18.1799 12.1611C18.265 11.8383 18.1265 11.4982 17.8401 11.3266C17.5538 11.1551 17.1885 11.1934 16.944 11.4207L17.4547 11.97ZM8.0306 2.5459L8.57989 3.05657C8.80718 2.81209 8.84554 2.44682 8.67398 2.16046C8.50243 1.8741 8.16227 1.73559 7.83948 1.82066L8.0306 2.5459ZM12.9154 13.0035C9.64678 13.0035 6.99707 10.3538 6.99707 7.08524H5.49707C5.49707 11.1823 8.81835 14.5035 12.9154 14.5035V13.0035ZM16.944 11.4207C15.8869 12.4035 14.4721 13.0035 12.9154 13.0035V14.5035C14.8657 14.5035 16.6418 13.7499 17.9654 12.5193L16.944 11.4207ZM16.7295 11.7789C15.9437 14.7607 13.2277 16.9586 10.0003 16.9586V18.4586C13.9257 18.4586 17.2249 15.7853 18.1799 12.1611L16.7295 11.7789ZM10.0003 16.9586C6.15734 16.9586 3.04199 13.8433 3.04199 10.0003H1.54199C1.54199 14.6717 5.32892 18.4586 10.0003 18.4586V16.9586ZM3.04199 10.0003C3.04199 6.77289 5.23988 4.05695 8.22173 3.27114L7.83948 1.82066C4.21532 2.77574 1.54199 6.07486 1.54199 10.0003H3.04199ZM6.99707 7.08524C6.99707 5.52854 7.5971 4.11366 8.57989 3.05657L7.48132 2.03522C6.25073 3.35885 5.49707 5.13487 5.49707 7.08524H6.99707Z"
            />
          </svg>

          <span class="sr-only">Toggle theme</span> {{-- for those who use screen reader can recognize it --}}
        </button>
      </div>
  </div>
</x-form-layout>