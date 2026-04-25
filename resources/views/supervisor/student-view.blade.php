<!DOCTYPE html>
<html>
<head>
    <title>Student Details</title>

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
            padding: 20px;
            background: #f4f4f4;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        button {
            padding: 8px 12px;
            margin-right: 10px;
            border: none;
            cursor: pointer;
        }

        .approve {
            background: green;
            color: white;
        }

        .reject {
            background: red;
            color: white;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Supervisor</h2>

        <a href="{{ route('supervisor.dashboard') }}">Dashboard</a>
        <a href="{{ route('supervisor.students') }}">My Students</a>
        <a href="{{ route('supervisor.titles') }}">Titles</a>

        <form method="POST" action="{{ route('auth.logout') }}">
            @csrf
            <button class="logout-btn">Logout</button>
        </form>
    </div>

    <!-- MAIN -->
    <div class="main">

        <h2>Student Details</h2>

        <div class="card">

            <p><strong>Name:</strong> {{ $student->name }}</p>
            <p><strong>Reg Number:</strong> {{ $student->registration_number }}</p>
            <p><strong>Email:</strong> {{ $student->email }}</p>

            <hr>

            @if($student->project)

                <p><strong>Title:</strong> {{ $student->project->title }}</p>
                <p><strong>Status:</strong> {{ $student->project->status }}</p>

                @if($student->project->status == 'pending')

                    <form method="POST" action="{{ route('supervisor.approveTitle', $student->project->id) }}">
                        @csrf
                        <button class="approve">Approve</button>
                    </form>

                    <form method="POST" action="{{ route('supervisor.rejectTitle', $student->project->id) }}">
                        @csrf
                        <button class="reject">Reject</button>
                    </form>

                @endif

            @else
                <p>No title submitted</p>
            @endif

        </div>

    </div>

</body>
</html>