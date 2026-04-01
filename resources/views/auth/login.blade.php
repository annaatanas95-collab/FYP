<!DOCTYPE html>
<html>
<head>
        <title>Login</title>
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
                }

                .auth-btn:hover {
                        background: #E96A4A;
                }
                .auth-link {
                        text-align: center;
                        margin-top: 10px;
                }

                .auth-link a {
                        color: #F47C5C;
                        text-decoration: none;
                }
        </style>
</head>
<body>

      <div class="auth-container">
                <div class="auth-card">
                        <h3 style="text-align:center;">Sign in</h3>

                        <form method="POST" action="/login">

                                @csrf

                                <div class="input-group">
                                        <i class="fa fa-user"></i>
                                        <input type="text" name="username" placeholder="Username">
                                </div>

                                <div class="input-group">
                                        <i class="fa fa-lock"></i>
                                        <input type="password" name="password" placeholder="Password">
                                </div>

                                <button class="auth-btn">Sign in</button>
                        </form>

                                <div class="auth-link">
                                        <p>Don't have an account? <a href="/register">Register</a></p>
                                </div>
                </div>
        </div>
</body>
</html>