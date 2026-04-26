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
            background: #f4f4f4;
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

        /* MAIN */
        .main {
            flex: 1;
            padding: 20px;
        }

        /* TOP BAR */
        .top-bar {
            display: flex;
            justify-content: flex-end;
            position: relative;
            margin-bottom: 20px;
        }

        /* PROFILE */
        .profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .profile i {
            font-size: 30px;
            color: #043A3F;
        }

        /* DROPDOWN */
        .dropdown {
            position: absolute;
            top: 50px;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            width: 220px;
            display: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .dropdown a {
            display: block;
            text-decoration: none;
            color: #043A3F;
            padding: 8px 0;
        }

        .dropdown a:hover {
            color: #1bc2d2;
        }

        .dropdown-btn {
            margin-top: 10px;
            width: 100%;
            background: red;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 5px;
            cursor: pointer;
        }

        /* HEADER */
        .header h2 {
            margin: 0;
        }

        /* CARDS */
        .cards {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 20px;
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

        <a href="{{ route('supervisor.dashboard') }}">
            <i class="fas fa-home"></i> Dashboard
        </a>

        <a href="{{ route('supervisor.students') }}">
            <i class="fas fa-users"></i> My Students
        </a>

        <a href="{{ route('supervisor.titles') }}">
            <i class="fas fa-file-alt"></i> Titles
        </a>

        <a href="#">
            <i class="fas fa-tasks"></i> Stages
        </a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <!-- PROFILE -->
        <div class="top-bar">

            <div class="profile" onclick="toggleMenu()">
                <i class="fas fa-user-circle"></i>
                <div>
                    <strong>{{ $supervisor->name }}</strong><br>
                    <small>{{ $supervisor->email }}</small>
                </div>
            </div>

            <div id="profileMenu" class="dropdown">
                <p><strong>{{ $supervisor->name }}</strong></p>
                <p style="font-size:12px;">{{ $supervisor->email }}</p>

                <hr>

                <a href="#"><i class="fas fa-user"></i> My Profile</a>

                <a href="{{ route('auth.showChangePassword') }}">
                    <i class="fas fa-key"></i> Change Password
                </a>

                <form method="POST" action="{{ route('auth.logout') }}">
                    @csrf
                    <button class="dropdown-btn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>

        </div>

        <!-- HEADER -->
        <div class="header">
            <h2>Welcome, {{ $supervisor->name }}</h2>
            <p>Overview of your supervision activities</p>
        </div>

        <!-- CARDS -->
        <div class="cards">

            <div class="card">
                <i class="fas fa-users"></i>
                <h3>Total Students</h3>
                <p>{{ $students->count() }}</p>
            </div>

            <div class="card">
                <i class="fas fa-clock"></i>
                <h3>Pending Titles</h3>
                <p>
                    {{ $students->filter(fn($s) => $s->project && $s->project->status == 'pending')->count() }}
                </p>
            </div>

            <div class="card">
                <i class="fas fa-check-circle"></i>
                <h3>Approved Titles</h3>
                <p>
                    {{ $students->filter(fn($s) => $s->project && $s->project->status == 'approved')->count() }}
                </p>
            </div>

        </div>

    </div>

    <!-- JS -->
    <script>
    function toggleMenu() {
        let menu = document.getElementById("profileMenu");
        menu.style.display = menu.style.display === "block" ? "none" : "block";
    }

    document.addEventListener("click", function(event) {
        let profile = document.querySelector(".profile");
        let menu = document.getElementById("profileMenu");

        if (!profile.contains(event.target)) {
            menu.style.display = "none";
        }
    });
    </script>

</body>
</html>