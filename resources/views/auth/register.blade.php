<!-- resources/views/auth/register.blade.php -->
<head>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<form action="{{ route('register') }}" method="POST">
    @csrf
    <label for="name">Name</label>
    <input type="text" name="name" id="name" required>

    <label for="email">Email</label>
    <input type="email" name="email" id="email" required>

    <label for="password">Password</label>
    <input type="password" name="password" id="password" required>

    <label for="password_confirmation">Confirm Password</label>
    <input type="password" name="password_confirmation" id="password_confirmation" required>

    <button type="submit">Register</button>
</form>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

@if(session('access_token'))
    <script>
        var accessToken = "{{ session('access_token') }}";
        console.log('Access Token: ', accessToken);
    </script>
@endif
