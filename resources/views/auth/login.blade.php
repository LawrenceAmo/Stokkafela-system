{{-- <link rel="stylesheet" href="{{ asset('mdb/css/mdb.min.css') }}"> --}}

<x-guest-layout>
    <x-auth-card>
       <x-slot name="logo">
            <a >
                <div class="font-weight-bold">Log In</div>
                {{-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> --}}
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}" class="  m-0">
            @csrf

            <!-- Email Address -->
            <div class=" ">
                <x-label for="email" :value="__('Email Address')" />
                <x-input id="email" class="block mt-1 w-full form-control" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full form-control"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-2">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="       mt-4">
                 <button class="btn btn-sm btn-info ml-3 form-control">
                    {{ __('Log In') }}
                </button>  <br>
              <div class="d-flex justify-content-between">
                     
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 small text-dark" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>

                @endif

                 {{-- <a class="underline text-sm text-gray-600 hover:text-gray-900 small text-dark" href="{{ route('register') }}">
                        {{ __('Don\'t have an aacount?') }}
                    </a> --}}
               
              </div>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
