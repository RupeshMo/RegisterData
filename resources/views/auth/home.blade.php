<head>
    <!-- Include compiled CSS from Vite -->
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<!-- Main Content -->
<div class="flex justify-center items-center h-screen bg-gray-100">
    <div class="flex w-full max-w-[1100px] h-[420px] bg-white rounded-lg shadow-lg overflow-hidden transform transition-transform duration-300 hover:scale-105">
        
        <!-- Left Section: Content (Login, Register, and Description) -->
        <div class="flex flex-col justify-center items-start p-8 w-full lg:w-1/2">
            <h2 class="text-4xl font-semibold text-gray-800 mb-6">Welcome to Our Registration App</h2>
            <p class="text-lg text-gray-600 mb-10">Get started with our easy-to-use platform. Whether you're creating a new account or returning, we offer a quick and secure way to sign up or log in. Join us today!</p>

            <!-- Buttons for Login and Sign Up -->
            <div class="flex gap-4 justify-between w-full">
                <a href="{{ route('login') }}" class="bg-blue-700 text-white py-3 px-6 text-lg font-semibold rounded-lg transform transition-all duration-300 hover:bg-blue-800 hover:translate-y-[-2px]">Login</a>
                <a href="{{ route('register') }}" class="bg-green-500 text-white py-3 px-6 text-lg font-semibold rounded-lg transform transition-all duration-300 hover:bg-green-600 hover:translate-y-[-2px]">Sign Up</a>
            </div>
        </div>

        <!-- Right Section: Abstract Pattern Background -->
        <div class="relative w-full lg:w-1/2">
            <div class="absolute top-0 left-0 w-full h-full bg-pattern8 z-[-1] rounded-r-lg"></div> <!-- Abstract Pattern -->
        </div>
    </div>
</div>

<!-- Optional Success or Token Message -->
@if(session('success'))
    <p class="mt-4 text-green-600 text-center">{{ session('success') }}</p>
@endif

@if(session('access_token'))
    <script>
        var accessToken = "{{ session('access_token') }}";
        console.log('Access Token: ', accessToken);
    </script>
@endif
