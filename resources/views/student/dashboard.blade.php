<!-- resources/views/student/dashboard.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            background: #1bc2d2;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .dashboard-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            text-align: center;
            width: 400px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .success-msg {
            background: #D4EDDA;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .info-box {
            margin: 15px 0;
            padding: 10px;
            background: #f1f1f1;
            border-radius: 5px;
        }

        .logout-btn {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: white;
            background: grey;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }

        .logout-btn:hover {
            background: darkred;
        }
    </style>
</head>

<body>
    <div class="dashboard-container">

        <h1>Welcome, {{ $student->name }}!</h1>

        <!-- Success message -->
        @if(session('success'))
            <div class="success-msg">{{ session('success') }}</div>
        @endif

        <p>You are now logged in as a student.</p>

        <!-- Supervisor Info -->
        <div class="info-box">
            <strong>Supervisor:</strong><br>

            {{ optional($student->supervisor)->name ?? 'No supervisor assigned yet' }}
        </div>

        <form method="POST" action="{{ route('auth.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>

    </div>
</body>
</html>