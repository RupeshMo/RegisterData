<!-- resources/views/auth/register.blade.php -->
<head>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>

<form action="{{ route('register') }}" method="POST" class="form">
    @csrf
    <p class="title">Register</p>
    <p class="message">Sign up now and get full access to our platform.</p>

    <!-- Name Field -->
    <label for="name">
        <input type="text" name="name" id="name" required class="input" />
        <span>Name</span>
    </label>

    <!-- Email Field -->
    <label for="email">
        <input type="email" name="email" id="email" required class="input" />
        <span>Email</span>
    </label>

    <!-- Password Field -->
    <label for="password">
        <input type="password" name="password" id="password" required class="input" />
        <span>Password</span>
    </label>

    <!-- Confirm Password Field -->
    <label for="password_confirmation">
        <input type="password" name="password_confirmation" id="password_confirmation" required class="input" />
        <span>Confirm Password</span>
    </label>

    <!-- Submit Button -->
    <button type="submit" class="submit">Register</button>

    <!-- Login Link -->
    <p class="signin">Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
</form>

@if(session('success'))
    <p class="success-message">{{ session('success') }}</p>
@endif

@if(session('access_token'))
    <script>
        var accessToken = "{{ session('access_token') }}";
        console.log('Access Token: ', accessToken);
    </script>
@endif
