<!DOCTYPE html>
<html>
<head>
    <title>Coordinator Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #1bc2d2;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0px 10px 25px rgba(0,0,0,0.2);
            text-align: center;
        }

        h1 {
            color: #333;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            margin: 10px;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-upload { background: #28a745; }
        .btn-upload:hover { background: #218838; }

        .btn-register { background: #007bff; }
        .btn-register:hover { background: #0069d9; }

        .btn-logout { background: grey; }
        .btn-logout:hover { background: #cc0000; }

        input[type="file"] {
            padding: 10px;
            margin: 10px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .success { color: green; margin-bottom: 15px; }
        .error { color: red; margin-bottom: 15px; }

        .delete-btn {
            background-color: #8fbebf; 
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .delete-btn:hover {
            background-color: #C0392B; 
            transform: scale(1.05);
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

        <!-- Upload Students -->
        <form method="POST" action="/coordinator/upload-students" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" required>
            <button class="btn btn-upload" type="submit">Upload Students CSV</button>
        </form>
        <form method="POST" action="/coordinator/delete-uploaded-students" style="margin-top:20px;">
            @csrf
            <button type="submit" class="delete-btn">Delete Uploaded Students</button>
        </form>

        <!-- Register Supervisor -->
        <a href="/register" class="btn btn-register">Register Supervisor</a>

        <!-- Logout -->
        <form method="POST" action="/logout">
            @csrf
            <button class="btn btn-logout" type="submit">Logout</button>
        </form>
    </div>
</body>
</html>