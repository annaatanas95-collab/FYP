<!DOCTYPE html>
<html>
<head>
    <title>My Students</title>

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

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        table th, table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background: #eee;
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

        <h2>My Students</h2>

        @if($students->count() > 0)

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Reg Number</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($students as $key => $student)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->registration_number }}</td>
                    <td>{{ $student->email }}</td>
                    <td>
                        <a href="{{ route('supervisor.viewStudent', $student->id) }}">
                            View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @else
            <p>No students assigned.</p>
        @endif

    </div>

</body>
</html>