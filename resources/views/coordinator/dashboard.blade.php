<!DOCTYPE html>
<html>
<head>
    <title>Coordinator Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #043A3F;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            max-width: 1000px;
            margin: 50px auto;
            background: #296374;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0px 10px 25px rgba(0,0,0,0.2);
            position: relative;
            min-height: 90vh;
        }

        h1 {
            color: #0b0b0b;
            margin-bottom: 30px;
            text-align: center;
        }

        .btn {
            display: inline-block;
            margin: 5px;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            font-size: 14px;
        }

        .btn-upload { background: #d7450b; }
        .btn-upload:hover { background: #f86939; }

        .btn-delete { background: #d7450b; }
        .btn-delete:hover { background: #A93226; }

        .btn-register { background: #d7450b; }
        .btn-register:hover { background: rgb(101, 162, 215); }

        .btn-view { background: #c73209; }
        .btn-view:hover { background: #5a6268; }

        .btn-logout { background: #c73209; }
        .btn-logout:hover { background: #ec5e07; }

        input[type="file"] {
            padding: 10px;
            border-radius: 7px;
            border: 1px solid rgb(18, 6, 6);
            font-size: 14px;
            width: 160px;
        }

        .row {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 20px;
            gap: 10px;
        }

        /* Modal CSS */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1000; 
            padding-top: 100px; 
            left: 0; top: 0;
            width: 100%; height: 100%; 
            overflow: auto; 
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 30px;
            border: 1px solid #888;
            width: 50%;
            border-radius: 10px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover { color: black; }

        .success { color:#ec5e07; margin-bottom: 15px; text-align:center; }
        .error { color: red; margin-bottom: 15px; text-align:center; }

        /* Input group with icons */
        .input-group {
            position: relative;
            width: 90%;
            margin-bottom: 15px;
        }

        .input-group i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #333;
        }

        .input-group input {
            width: 100%;
            padding: 10px 10px 10px 35px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Coordinator Dashboard</h1>

        @if(session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif

        @if($errors->any())
            <div class="error">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Logout bottom-right -->
        <div style="position: absolute; bottom: 20px; right: 20px;">
            <form method="POST" action="/logout">
                @csrf
                <button class="btn btn-logout" type="submit"><i class="fa fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>

        <!-- Row 1: Upload + Delete -->
        <div class="row">
            <form method="POST" action="/coordinator/upload-students" enctype="multipart/form-data" style="display:flex; align-items:center; gap:10px;">
                @csrf
                <input type="file" name="file" required>
                <button class="btn btn-upload" type="submit"><i class="fa fa-upload"></i> Upload</button>
            </form>

            <form method="POST" action="/coordinator/delete-uploaded-students">
                @csrf
                <button type="submit" class="btn btn-delete"><i class="fa fa-trash"></i> Delete Uploaded</button>
            </form>
        </div>

        <!-- Row 2: Register Supervisor + View Supervisors -->
        <div class="row">
            <button class="btn btn-register" id="openModal"><i class="fa fa-user-plus"></i> Register Supervisor</button>
            <a href="{{ route('coordinator.supervisors') }}" class="btn btn-view"><i class="fa fa-users"></i> View Supervisors</a>
        </div>
    </div>

    <!-- Modal Form for Register Supervisor -->
    <div id="supervisorModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Register Supervisor</h2>
            <form method="POST" action="/coordinator/register-supervisor">
                @csrf
                <div class="input-group">
                    <i class="fa fa-user"></i>
                    <input type="text" name="name" placeholder="Full Name" required>
                </div>

                <div class="input-group">
                    <i class="fa fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email" required>
                </div>

                <div class="input-group">
                    <i class="fa fa-id-badge"></i>
                    <input type="text" name="username" placeholder="Username" required>
                </div>

                <div class="input-group">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <button class="btn btn-register" type="submit">Register</button>
            </form>
        </div>
    </div>

    <script>
        var modal = document.getElementById("supervisorModal");
        var btn = document.getElementById("openModal");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() { modal.style.display = "block"; }
        span.onclick = function() { modal.style.display = "none"; }
        window.onclick = function(event) { if(event.target == modal){ modal.style.display = "none"; } }
    </script>
</body>
</html>