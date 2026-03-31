<!DOCTYPE html>
<html>
<head>
        <title>Login</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <style>

                body {
                        margin: 0;
                        font-family: Arial;
                        background: linear-gradient(to right, #4facfe, #00f2fe);
                        height: 100vh;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                }

                .form-container {
                        background: white;
                        padding: 30px;
                        width: 320px;
                        border-radius: 10px;
                        box-shadow: 0px 0px 15px rgba(0,0,0,0.2);
                        text-align: center;
                }

                .input-group {
                        position: relative;
                        margin: 12px 0;
                }

                .input-group i {
                        position: absolute;
                        top: 12px;
                        left: 10px;
                        color: gray;
                }

                .input-group input {
                        width: 90%;
                        padding: 10px 10px 10px 35px;
                        border-radius: 5px;
                        border: 1px solid #ccc;
                }

                input:focus {
                        outline: none;
                        border-color: #4facfe;
                }

                button {
                        width: 100%;
                        padding: 10px;
                        background: #4facfe;
                        border: none;
                        color: white;
                        border-radius: 5px;
                        cursor: pointer;
                }

                button:hover {
                        background: #007bff;
                }
                .bottom-text {
                        margin-top: 15px;
                        font-size: 14px;
                }

                .bottom-text a {
                        color: #4facfe;
                        text-decoration: none;
                }

                .bottom-text a:hover {
                        text-decoration: underline;
                }
        </style>
</head>
<body>

        <div class="form-container">
                <h2>Login</h2>

                <form method="POST" action="/login">
                        @csrf

                        <div class="input-group">
                                <i class="fa-solid fa-user"></i>
                                <input type="text" name="username" placeholder="Username" required>
                        </div>

                        <div class="input-group">
                                <i class="fa-solid fa-lock"></i>
                                <input type="password" name="password" placeholder="Password" required>
                        </div>

                        <button type="submit">Login</button>
                </form>
                <p class="bottom-text">
                        Don't have an account? <a href="/register">Register</a>
                </p>
        </div>
</body>
</html>