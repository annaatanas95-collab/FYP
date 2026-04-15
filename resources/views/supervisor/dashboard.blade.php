<!DOCTYPE html>
<html>
<head>
    <title>Supervisor Dashboard</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
        }

        .header {
            background: #2c3e50;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h2 {
            margin: 0;
        }

        .header p {
            margin: 0;
            font-size: 14px;
            opacity: 0.9;
        }

        .container {
            padding: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th, table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background: #f1f1f1;
        }

        .badge {
            padding: 5px 10px;
            background: green;
            color: white;
            border-radius: 5px;
            font-size: 12px;
        }

        .empty {
            text-align: center;
            padding: 20px;
            color: gray;
        }

        .logout-btn {
            background: red;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: darkred;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <div>
            <h2>Supervisor Dashboard</h2>
            <p>Welcome, {{ $supervisor->name }}</p>
        </div>

        <form method="POST" action="{{ route('auth.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <!-- CONTENT -->
    <div class="container">

        <div class="card">
            <h3>My Students</h3>

            @if($students->count() > 0)

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Registration Number</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($students as $key => $student)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->registration_number }}</td>
                        <td>{{ $student->email }}</td>
                        <td><span class="badge">Assigned</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @else
                <div class="empty">
                    No students assigned yet.
                </div>
            @endif

        </div>

    </div>

</body>
</html>