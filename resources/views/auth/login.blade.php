<!DOCTYPE html>
<html>
<head>
        <title>Coordinator Login</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <style>
                body {

                        background: #043A3F;
                        font-family: Arial, sans-serif;
                }

                .auth-container {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                }

                .auth-card {
                        background: #EDEFF1;
                        padding: 30px;
                        border-radius: 10px;
                        width: 350px;
                        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
                }

                .auth-card h3 {
                        text-align: center;
                        margin-bottom: 20px;
                }

                .input-group {
                        display: flex;
                        align-items: center;
                        margin-bottom: 15px;
                        background: #DDE3E8;
                        border-radius: 5px;
                        overflow: hidden;
                }

                .input-group i {
                        background: #E5E7EB;
                        padding: 10px;
                        color: #9CA3AF;
                }

                .input-group input {
                        border: none;
                        outline: none;
                        padding: 10px;
                        flex: 1;
                        background: transparent;
                }

                .auth-btn {
                        width: 100%;
                        background: #F47C5C;
                        color: white;
                        border: none;
                        padding: 10px;
                        border-radius: 5px;
                        font-weight: bold;
                        cursor: pointer;
                        margin-top: 10px;
                }

                .auth-btn:hover {
                        background: #E96A4A;
                }

                .auth-link {
                        text-align: center;
                        margin-top: 15px;
                }

                .auth-link a {
                        color: #F47C5C;
                        text-decoration: none;
                }

                .message {
                        text-align: center;
                        margin-bottom: 15px;
                        font-weight: bold;
                }

                .message.success { color: green; }
                .message.error { color: red; }
        </style>
</head>
<body>
        <div class="auth-container">

                <div class="auth-card">

                        <h3>Sign in</h3>

                        <!-- Success message -->
                        @if(session('success'))
                                <div class="message success">{{ session('success') }}</div>
                        @endif

                        <!-- Error messages -->
                        @if($errors->any())
                                <div class="message error">

                                        @foreach($errors->all() as $error)
                                                <p>{{ $error }}</p>
                                        @endforeach
                                </div>
                        @endif

                        <form method="POST" action="/login">
                                @csrf

                                <div class="input-group">
                                        <i class="fa fa-user"></i>
                                        <input type="text" name="username" placeholder="Username" required>
                                </div>

                                <div class="input-group">
                                        <i class="fa fa-lock"></i>
                                        <input type="password" name="password" placeholder="Password" required>
                                </div>

                                <button class="auth-btn" type="submit">Sign in</button>
                        </form>

                        <div class="auth-link">
                                <p>Don't have an account? <a href="/register">Register</a></p>
                        </div>
                </div>
        </div>

</body>
</html>