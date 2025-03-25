<!-- resources/views/auth/login.blade.php -->
<head>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>

<form action="{{ route('login') }}" method="POST" class="form-container">
    @csrf
    <p class="title">Login</p>
    <p class="message">Welcome back! Please login to access your account.</p>

    <!-- Email Field -->
    <div class="input-container">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required class="input-field" />
    </div>

    <!-- Password Field -->
    <div class="input-container">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required class="input-field" />
    </div>

    <!-- Submit Button -->
    <button type="submit" class="submit-btn">Login</button>

    <!-- Sign Up Link -->
    <p class="signup">Don't have an account? <a href="{{ route('register') }}">Sign Up</a></p>
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
