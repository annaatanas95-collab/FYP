<!DOCTYPE html>
<html>
<head>
    <title>Registered Supervisors</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #043A3F;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background: #296374;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0px 10px 25px rgba(0,0,0,0.2);
            position: relative;
        }

        h1 {
            color: #080808;
            margin-bottom: 30px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #0e0e0e;
        }

        table th {
            background: rgb(203, 196, 192);
            color: black;
        }

        .btn {
            display: inline-block;
            margin: 2px;
            padding: 8px 15px;
            border-radius: 6px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            font-size: 13px;
        }

        .btn-edit { background: #ea5607; }
        .btn-edit:hover { background: #884f21; }

        .btn-delete { background: #db3401; }
        .btn-delete:hover { background: #A93226; }

        .btn-back { background: #eb4a05; }
        .btn-back:hover { background: #ce6c03; }

        .btn-logout { background: #eb4a05; }
        .btn-logout:hover { background: #cc0000; }

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

        .input-group {
            position: relative;
            width: 100%;
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

        .success { color: green; margin-bottom: 15px; text-align:center; }
        .error { color: red; margin-bottom: 15px; text-align:center; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registered Supervisors</h1>

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

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($supervisors as $sup)
                <tr>
                    <td>{{ $sup->name }}</td>
                    <td>{{ $sup->email }}</td>
                    <td>{{ $sup->username }}</td>
                    <td>
                        <button class="btn btn-edit openEditModal" data-id="{{ $sup->id }}" data-name="{{ $sup->name }}" data-email="{{ $sup->email }}" data-username="{{ $sup->username }}">Edit</button>
                        <form method="POST" action="/coordinator/delete-supervisor/{{ $sup->id }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-delete">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('coordinator.dashboard') }}" class="btn btn-back"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>

        <!-- Logout bottom-right -->
        <div style="position: absolute; bottom: 20px; right: 20px;">
            <form method="POST" action="/logout">
                @csrf
                <button class="btn btn-logout" type="submit"><i class="fa fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>
    </div>

    <!-- Modal Form for Edit Supervisor -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Supervisor</h2>
            <form method="POST" action="/coordinator/update-supervisor">
                @csrf
                <input type="hidden" name="id" id="editId">
                
                <div class="input-group">
                    <i class="fa fa-user"></i>
                    <input type="text" name="name" id="editName" placeholder="Full Name" required>
                </div>

                <div class="input-group">
                    <i class="fa fa-envelope"></i>
                    <input type="email" name="email" id="editEmail" placeholder="Email" required>
                </div>

                <div class="input-group">
                    <i class="fa fa-id-badge"></i>
                    <input type="text" name="username" id="editUsername" placeholder="Username" required>
                </div>

                <button class="btn btn-edit" type="submit">Update</button>
            </form>
        </div>
    </div>

    <script>
        // Edit modal logic
        var editModal = document.getElementById("editModal");
        var closeEdit = document.getElementsByClassName("close")[0];
        var editButtons = document.getElementsByClassName("openEditModal");

        Array.from(editButtons).forEach(function(btn) {
            btn.onclick = function() {
                document.getElementById('editId').value = this.dataset.id;
                document.getElementById('editName').value = this.dataset.name;
                document.getElementById('editEmail').value = this.dataset.email;
                document.getElementById('editUsername').value = this.dataset.username;
                editModal.style.display = "block";
            }
        });

        closeEdit.onclick = function() { editModal.style.display = "none"; }
        window.onclick = function(event) { if(event.target == editModal){ editModal.style.display = "none"; } }
    </script>
</body>
</html>