<!-- resources/views/auth/login.blade.php -->
<head>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<form action="{{ route('login') }}" method="POST" class="max-w-md mx-auto p-8 bg-white shadow-lg rounded-lg space-y-6">
    @csrf
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" id="email" required class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" name="password" id="password" required class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
    </div>

    <div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Login</button>
    </div>
</form>

@if(session('success'))
    <p class="mt-4 text-green-600 text-center">{{ session('success') }}</p>
@endif

@if(session('access_token'))
    <script>
        var accessToken = "{{ session('access_token') }}";
        console.log('Access Token: ', accessToken);
    </script>
@endif
