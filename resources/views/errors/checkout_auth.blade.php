<x-guest-layout>
    <div class="container my-5 p-5">
        <div class="bg-pink text-center p-3 rounded">
            <h1>Error: 403 - Login Required</h1>
            <p>Oops! You must be logged in to proceed with the checkout .</p>
            <a href="{{ route('login')}}" class="btn btn-sm rounded btn-purple">Log in</a>
        </div>
    </div>

    <script>
        const { createApp } = Vue;
    </script>
</x-guest-layout>
 