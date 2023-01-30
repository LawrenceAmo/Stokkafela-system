<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a >
                <div class="">Create New Account</div> 
                {{-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> --}}
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- First Name -->
            <div>
                <x-label for="first_name" :value="__('First Name')" />

                <x-input id="first_name" class="block mt-1 w-full form-control" type="text" name="first_name" :value="old('first_name')" required autofocus />
            </div> 
              <!-- Last Name -->
            <div>
                <x-label for="last_name" :value="__('Last Name')" />

                <x-input id="last_name" class="block mt-1 w-full form-control" type="text" name="last_name" :value="old('last_name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full form-control" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full form-control"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full form-control"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="  mt-4">
                <x-button class="ml-4 btn btn-sm btn-info rounded form-control">
                    {{ __('Register') }}
                </x-button>
                <a class="underline text-sm text-gray-600 hover:text-gray-900 small text-dark" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
