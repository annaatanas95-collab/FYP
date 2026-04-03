<!DOCTYPE html>
<html>
<head>

    <title>Student Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #FFB347; /* light orange background */
            font-family: Arial, sans-serif;
        }

        .auth-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .auth-card {
            background: #fff;
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
            background: #FF7E5F;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        .auth-btn:hover {
            background: #EB6752;
        }

        .auth-link {
            text-align: center;
            margin-top: 15px;
        }

        .auth-link a {
            color: #FF7E5F;
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
            <h3>Student Login</h3>

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

            <form method="POST" action="{{ route('auth.studentLogin') }}">
                @csrf

                <div class="input-group">
                    <i class="fa fa-user-graduate"></i>
                    <input type="text" name="username" placeholder="Registration Number" required>
                </div>

                <div class="input-group">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <button class="auth-btn" type="submit">Sign in</button>
            </form>
        </div>
    </div>

</body>
</html>