<head>
    <!-- Include compiled CSS from Vite -->
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<!-- resources/views/auth/login.blade.php -->
<div class="flex items-center justify-center min-h-screen  bg-gray-100">
    <form action="{{ route('login') }}" method="POST" class="max-w-sm p-6 bg-white rounded-lg shadow-lg">
        @csrf
        <p class="text-2xl font-semibold text-center text-gray-800">Login</p>
        <p class="text-center text-gray-500 mb-6">Welcome back! Please login to access your account.</p>

        <!-- Email Field -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
        </div>

        <!-- Password Field -->
        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 transition duration-300">Login</button>

        <!-- Sign Up Link -->
        <p class="mt-4 text-center text-sm text-gray-500">Don't have an account? <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-700">Sign Up</a></p>
    </form>
</div>

@if(session('success'))
    <p class="mt-4 text-center text-green-600 font-semibold">{{ session('success') }}</p>
@endif

@if(session('access_token'))
    <script>
        var accessToken = "{{ session('access_token') }}";
        console.log('Access Token: ', accessToken);
    </script>
@endif
