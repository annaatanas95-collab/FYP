<!-- resources/views/coordinator/register-supervisor.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Register Supervisor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #043A3F;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background: #79270b;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0px 10px 25px rgba(0,0,0,0.2);
            width: 200px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #010000;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: #e73a0a;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .submit-btn:hover {
            background-color: #de4116;
        }

        .success-msg {
            background: #D4EDDA;
            color: #ec3f0b;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .error-msg {
            background: #F8D7DA;
            color: #d31402;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .back-btn {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #fc5304;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Register Supervisor</h2>

        <!-- Success message -->
        @if(session('success'))
            <div class="success-msg">{{ session('success') }}</div>
        @endif

        <!-- Validation errors -->
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="error-msg">{{ $error }}</div>
            @endforeach
        @endif

        <form method="POST" action="{{ url('/coordinator/register-supervisor') }}">
            @csrf
            <label for="name">Full Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>

            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="{{ old('username') }}" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>

            <button type="submit" class="submit-btn">Register Supervisor</button>
        </form>

        <a href="{{ route('coordinator.dashboard') }}" class="back-btn">← Back to Dashboard</a>
    </div>
</body>
</html>