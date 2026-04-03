<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
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
            text-align: center;
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

        .success-msg {
            background: #D4EDDA;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .error-msg {
            background: #F8D7DA;
            color: #721C24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

    </style>
</head>
<body>


    <div class="auth-container">
        <div class="auth-card">
            <h3>Change Password</h3>

            <!-- Success message -->
            @if(session('success'))
                <div class="success-msg">{{ session('success') }}</div>
            @endif

            <!-- Validation errors -->
            @if ($errors->any())
                <div class="error-msg">
                    <ul style="margin:0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('auth.updatePassword') }}">
                @csrf

                <div class="input-group">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" placeholder="New Password" required>
                </div>

                <div class="input-group">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                </div>

                <button class="auth-btn" type="submit">Change Password</button>
            </form>
        </div>
    </div>

</body>
</html>