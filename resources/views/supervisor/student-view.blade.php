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
            margin-bottom: 20px;
        }

        .stage-box {
            border: 1px solid #ddd;
            padding: 15px;
            margin-top: 15px;
            border-radius: 8px;
            background: #fafafa;
        }

        button {
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .approve {
            background: green;
            color: white;
        }

        .reject {
            background: red;
            color: white;
        }

        .save {
            background: #043A3F;
            color: white;
            margin-top: 10px;
        }

        input, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }

        .status-open {
            color: green;
            font-weight: bold;
        }

        .status-closed {
            color: red;
            font-weight: bold;
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
        <a href="{{ url()->previous() }}">
            <button style="background:#043A3F; color:white; margin-bottom:15px;">
                ← Back
            </button>
        </a>

        <h2>Student Details</h2>

        <!-- STUDENT INFO -->
        <div class="card">
            <p><strong>Name:</strong> {{ $student->name }}</p>
            <p><strong>Reg Number:</strong> {{ $student->registration_number }}</p>
            <p><strong>Email:</strong> {{ $student->email }}</p>
        </div>

        <!-- PROJECT -->
        <div class="card">

            @if($student->project)

                <p><strong>Title:</strong> {{ $student->project->title }}</p>
                <p><strong>Status:</strong> {{ $student->project->status }}</p>

                <!-- APPROVE / REJECT -->
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

        <!-- STAGES (ONLY IF APPROVED) -->
        @if($student->project && $student->project->status == 'approved')

        <div class="card">
            <h3>Project Stages</h3>

            @foreach($student->project->stages as $ps)

                <div class="stage-box">

                    <h4>{{ $ps->stage->name }}</h4>

                    <p>
                        Status:
                        @if($ps->is_open)
                            <span class="status-open">OPEN</span>
                        @else
                            <span class="status-closed">LOCKED</span>
                        @endif
                    </p>

                    <p><strong>Deadline:</strong> {{ $ps->deadline ?? 'Not set' }}</p>
                    <p><strong>Deliverable:</strong> {{ $ps->deliverable ?? 'Not set' }}</p>

                    <!-- FORM UPDATE -->
                    <form method="POST" action="{{ route('supervisor.updateStage', $ps->id) }}">
                        @csrf

                        <label>Deliverable</label>
                        <textarea name="deliverable">{{ $ps->deliverable }}</textarea>

                        <label>Deadline</label>
                        <input type="date" name="deadline" value="{{ $ps->deadline }}">

                        <label>
                            <input type="checkbox" name="is_open" {{ $ps->is_open ? 'checked' : '' }}>
                            Open Stage
                        </label>

                        <button class="save">Save</button>
                    </form>

                </div>

            @endforeach

        </div>

        @endif

    </div>

</body>
</html>