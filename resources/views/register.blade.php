<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container">
        <h1>Register</h1>

        @if(session('success'))
            <div style="color: green;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="color: red;">
                {{ session('error') }}
            </div>
        @endif

        <form id="register-form" method="POST">
            @csrf
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div>
                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit">Register</button>
        </form>

        <p>Already have an account? <a href="{{ url('/auth') }}">Login here</a></p>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementById('register-form').addEventListener('submit', function (event) {
                    event.preventDefault();

                    const formData = new FormData(this);

                    fetch("{{ url('/api/register') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({
                            name: formData.get('name'),
                            email: formData.get('email'),
                            password: formData.get('password'),
                            password_confirmation: formData.get('password_confirmation'),
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.access_token) {
                            alert("Registration successful!");
                            window.location.href = '/dashboard';
                        } else {
                            alert("Registration failed!");
                        }
                    })
                    .catch(error => console.error(error));
                });
            });
        </script>
    </div>
</body>
</html>
