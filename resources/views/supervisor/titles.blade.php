<!DOCTYPE html>
<html>
<head>
    <title>Project Titles</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #043A3F;
        }

        /* SIDEBAR */
        .sidebar {
            width: 220px;
            height: 100vh;
            background: #022c30;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
            color: white;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #05575c;
        }

        .active {
            background: #0a9396;
        }

        /* MAIN */
        .main {
            margin-left: 220px;
            padding: 20px;
        }

        .header {
            background: #2c3e50;
            color: white;
            padding: 15px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
        }

        .card {
            background: white;
            padding: 20px;
            margin-top: 20px;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #f1f1f1;
        }

        /* STATUS COLORS */
        .pending {
            background: orange;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .approved {
            background: green;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .rejected {
            background: red;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }

        /* BUTTONS */
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
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

        .btn:hover {
            opacity: 0.8;
        }

        .empty {
            text-align: center;
            color: gray;
            padding: 20px;
        }

        .logout-btn {
            background: red;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Supervisor</h2>

        <a href="{{ route('supervisor.dashboard') }}">Dashboard</a>
        <a href="{{ route('supervisor.students') }}">My Students</a>
        <a href="{{ route('supervisor.titles') }}" class="active">Project Titles</a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <!-- HEADER -->
        <div class="header">
            <div>
                <h3>Project Titles</h3>
                <p>Welcome, {{ $supervisor->name }}</p>
            </div>

            <form method="POST" action="{{ route('auth.logout') }}">
                @csrf
                <button class="logout-btn">Logout</button>
            </form>
        </div>

        <!-- SUCCESS MESSAGE -->
        @if(session('success'))
            <div style="background:#d4edda; padding:10px; margin-top:15px; border-radius:5px;">
                {{ session('success') }}
            </div>
        @endif

        <!-- ERROR MESSAGE -->
        @if(session('error'))
            <div style="background:#f8d7da; padding:10px; margin-top:15px; border-radius:5px;">
                {{ session('error') }}
            </div>
        @endif

        <!-- TABLE -->
        <div class="card">

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($students as $key => $student)

                        @if($student->project)

                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->project->title }}</td>

                            <!-- STATUS -->
                            <td>
                                @if($student->project->status == 'pending')
                                    <span class="pending">Pending</span>
                                @elseif($student->project->status == 'approved')
                                    <span class="approved">Approved</span>
                                @else
                                    <span class="rejected">Rejected</span>
                                @endif
                            </td>

                            <!-- ACTION -->
                            <td>
                                @if($student->project->status == 'pending')

                                    <form style="display:inline;"
                                        method="POST"
                                        action="{{ route('supervisor.approveTitle', $student->project->id) }}">
                                        @csrf
                                        <button class="btn approve">Approve</button>
                                    </form>

                                    <form style="display:inline;"
                                        method="POST"
                                        action="{{ route('supervisor.rejectTitle', $student->project->id) }}">
                                        @csrf
                                        <button class="btn reject">Reject</button>
                                    </form>

                                @else
                                    ---
                                @endif
                            </td>
                        </tr>

                        @endif

                    @empty
                        <tr>
                            <td colspan="5" class="empty">No titles submitted yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

    </div>

</body>
</html>