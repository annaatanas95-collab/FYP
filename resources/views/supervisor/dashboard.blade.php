<!DOCTYPE html>
<html>
<head>
    <title>Supervisor Dashboard</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: Arial;
            display: flex;
        }

        /* SIDEBAR */
        .sidebar {
            width: 230px;
            height: 100vh;
            background: #043A3F;
            color: white;
            padding: 20px;
        }

        .sidebar h2 {
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            margin: 15px 0;
        }

        .sidebar a:hover {
            color: #1bc2d2;
        }

        .logout-btn {
            margin-top: 30px;
            background: red;
            border: none;
            padding: 10px;
            color: white;
            cursor: pointer;
            width: 100%;
        }

        /* MAIN */
        .main {
            flex: 1;
            background: #f4f4f4;
            padding: 20px;
        }

        .header {
            margin-bottom: 20px;
        }

        /* CARDS */
        .cards {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .card {
            flex: 1;
            min-width: 200px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .card i {
            font-size: 30px;
            margin-bottom: 10px;
            color: #043A3F;
        }

        .card h3 {
            margin: 10px 0;
        }

        .card p {
            font-size: 22px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Supervisor</h2>

        <a href="{{ route('supervisor.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
        <a href="{{ route('supervisor.students') }}"><i class="fas fa-users"></i> My Students</a>
        <a href="{{ route('supervisor.titles') }}"><i class="fas fa-file-alt"></i> Titles</a>
        <a href="#"><i class="fas fa-tasks"></i> Stages</a>

        <form method="POST" action="{{ route('auth.logout') }}">
            @csrf
            <button class="logout-btn">Logout</button>
        </form>
    </div>

    <!-- MAIN -->
    <div class="main">

        <div class="header">
            <h2>Welcome, {{ $supervisor->name }}</h2>
            <p>Overview of your supervision activities</p>
        </div>

        <!-- CARDS -->
        <div class="cards">

            <!-- TOTAL STUDENTS -->
            <div class="card">
                <i class="fas fa-users"></i>
                <h3>Total Students</h3>
                <p>{{ $students->count() }}</p>
            </div>

            <!-- PENDING -->
            <div class="card">
                <i class="fas fa-clock"></i>
                <h3>Pending Titles</h3>
                <p>
                    {{ $students->filter(fn($s) => $s->project && $s->project->status == 'pending')->count() }}
                </p>
            </div>

            <!-- APPROVED -->
            <div class="card">
                <i class="fas fa-check-circle"></i>
                <h3>Approved Titles</h3>
                <p>
                    {{ $students->filter(fn($s) => $s->project && $s->project->status == 'approved')->count() }}
                </p>
            </div>

        </div>

    </div>

</body>
</html>