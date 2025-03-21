<!-- <!DOCTYPE html> -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth - Register, Login, Logout</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        .form-container {
            margin-bottom: 20px;
        }
        .form-container input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #45a049;
        }
        #message {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <h1>Register, Login, and Logout</h1>

    <!-- Register Form -->
    <div class="form-container" id="register-form">
        <h2>Register</h2>
        <input type="text" id="register-name" placeholder="Name">
        <input type="email" id="register-email" placeholder="Email">
        <input type="password" id="register-password" placeholder="Password">
        <input type="password" id="register-password-confirm" placeholder="Confirm Password">
        <button onclick="register()">Register</button>
    </div>

    <!-- Login Form -->
    <div class="form-container" id="login-form">
        <h2>Login</h2>
        <input type="email" id="login-email" placeholder="Email">
        <input type="password" id="login-password" placeholder="Password">
        <button onclick="login()">Login</button>
    </div>

    <!-- Logout Button (Only shown when logged in) -->
    <div class="form-container" id="logout-form" style="display:none;">
        <h2>Welcome, <span id="user-name"></span></h2>
        <button onclick="logout()">Logout</button>
    </div>

    <div id="message"></div>

    <script>
        let accessToken = localStorage.getItem('access_token');
        
        // Show the correct form based on the user's login state
        if (accessToken) {
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('register-form').style.display = 'none';
            document.getElementById('logout-form').style.display = 'block';
            // Retrieve user info using the token and show user name
            getUserInfo();
        } else {
            document.getElementById('login-form').style.display = 'block';
            document.getElementById('register-form').style.display = 'block';
            document.getElementById('logout-form').style.display = 'none';
        }

        // Register function
        function register() {
            const name = document.getElementById('register-name').value;
            const email = document.getElementById('register-email').value;
            const password = document.getElementById('register-password').value;
            const passwordConfirmation = document.getElementById('register-password-confirm').value;

            if (password !== passwordConfirmation) {
                alert("Passwords don't match.");
                return;
            }

            axios.post('http://localhost:8000/api/register', {
                name: name,
                email: email,
                password: password,
                password_confirmation: passwordConfirmation
            })
            .then(response => {
                console.log(response.data);
                alert('Registration successful. You can now login.');
            })
            .catch(error => {
                console.error(error);
                alert('An error occurred during registration.');
            });
        }

        // Login function
        function login() {
            const email = document.getElementById('login-email').value;
            const password = document.getElementById('login-password').value;

            axios.post('http://localhost:8000/api/login', {
                email: email,
                password: password
            })
            .then(response => {
                accessToken = response.data.token;
                localStorage.setItem('access_token', accessToken);
                document.getElementById('login-form').style.display = 'none';
                document.getElementById('register-form').style.display = 'none';
                document.getElementById('logout-form').style.display = 'block';
                getUserInfo();
                document.getElementById('message').innerText = 'Login successful!';
            })
            .catch(error => {
                console.error(error);
                alert('Login failed.');
            });
        }

        // Get user information using the access token
        function getUserInfo() {
            axios.get('http://localhost:8000/api/user', {
                headers: {
                    Authorization: `Bearer ${accessToken}`
                }
            })
            .then(response => {
                document.getElementById('user-name').innerText = response.data.name;
            })
            .catch(error => {
                console.error(error);
                alert('Error fetching user info.');
            });
        }

        // Logout function
        function logout() {
            axios.post('http://localhost:8000/api/logout', {}, {
                headers: {
                    Authorization: `Bearer ${accessToken}`
                }
            })
            .then(response => {
                localStorage.removeItem('access_token');
                accessToken = null;
                document.getElementById('login-form').style.display = 'block';
                document.getElementById('register-form').style.display = 'block';
                document.getElementById('logout-form').style.display = 'none';
                document.getElementById('message').innerText = 'You have been logged out.';
            })
            .catch(error => {
                console.error(error);
                alert('Logout failed.');
            });
        }
    </script>
</body>
</html>
