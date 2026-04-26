<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            background: #043A3F;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.1);
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

        h1 {
            text-align: center;
        }

        .success-msg {
            background: #D4EDDA;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .info-box {
            background: #f1f1f1;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .section {
            margin-top: 30px;
        }

        .section h2 {
            color: #043A3F;
        }

        input[type="text"], input[type="file"] {
            padding: 10px;
            width: 70%;
            margin-top: 10px;
        }

        .form-group {
            margin-top: 10px;
        }

        .btn-submit {
            margin-top: 15px;
        }

        button {
            padding: 10px 15px;
            background: #043A3F;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #06565c;
        }

        .stage-box {
            border: 1px solid #ddd;
            padding: 15px;
            margin-top: 10px;
            border-radius: 5px;
        }

        .locked {
            color: red;
        }

        .open {
            color: green;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- PROFILE + DROPDOWN -->
        <div class="top-bar">

            <div class="profile" onclick="toggleMenu()">
                <i class="fas fa-user-circle"></i>
                <div>
                    <strong>{{ $student->name }}</strong><br>
                    <small>{{ $student->email }}</small>
                </div>
            </div>

            <div id="profileMenu" class="dropdown">
                <p><strong>{{ $student->name }}</strong></p>
                <p style="font-size:12px;">{{ $student->email }}</p>

                <hr>

                <!-- BONUS LINKS -->
                <a href="#"><i class="fas fa-user"></i> My Profile</a>
                <a href="{{ route('auth.showChangePassword') }}">
                    <i class="fas fa-key"></i> Change Password
                </a>

                <form method="POST" action="{{ route('auth.logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-btn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>

        </div>

        <h1>Student Dashboard</h1>

        @if(session('success'))
            <div class="success-msg">{{ session('success') }}</div>
        @endif

        <!-- Supervisor -->
        <div class="info-box">
            <strong>Supervisor:</strong><br>
            {{ optional($student->supervisor)->name ?? 'Not Assigned Yet' }}
        </div>

        <!-- PROJECT TITLE -->
        <div class="section">
            <h2>Project Title</h2>

            @if(!$project)
                <form method="POST" action="{{ route('student.submitTitle') }}">
                    @csrf

                    <div class="form-group">
                        <input type="text" name="title" placeholder="Enter project title" required>
                    </div>

                    <button class="btn-submit">Submit Title</button>
                </form>

            @else
                <p><strong>Title:</strong> {{ $project->title }}</p>
                <p><strong>Status:</strong> {{ $project->status }}</p>

                @if($project->status == 'pending')
                    <p style="color: orange;">Waiting for approval...</p>

                @elseif($project->status == 'rejected')
                    <p style="color:red;">Rejected. Submit again.</p>

                    <form method="POST" action="{{ route('student.submitTitle') }}">
                        @csrf

                        <div class="form-group">
                            <input type="text" name="title" placeholder="Resubmit title" required>
                        </div>

                        <button class="btn-submit">Resubmit</button>
                    </form>

                @elseif($project->status == 'approved')
                    <p style="color: green;">Approved ✔</p>
                @endif
            @endif
        </div>

        <!-- STAGES -->
        @if($project && $project->status == 'approved')

        <div class="section">
            <h2>Project Stages</h2>

            @foreach($stages as $stage)
                <div class="stage-box">

                    <h3>{{ $stage->name }}</h3>

                    @if(!$stage->is_open)
                        <p class="locked">🔒 Locked</p>
                    @else
                        <p class="open">✅ Open</p>

                        <p><strong>Deadline:</strong> {{ $stage->deadline ?? 'Not set' }}</p>

                        <form method="POST" action="{{ route('student.upload') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="stage_id" value="{{ $stage->id }}">

                            <div class="form-group">
                                <input type="file" name="file" required>
                            </div>

                            <button class="btn-submit">Upload</button>
                        </form>
                    @endif

                </div>
            @endforeach

        </div>

        @endif

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