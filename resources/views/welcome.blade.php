<!DOCTYPE html>
<html>
<head>
    <title>FYP Supervision System</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background: #191f28;
            padding: 15px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .hero {
            height: 90vh;
            background: linear-gradient(to right, #1bc2d2, #0d6efd);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: white;
            text-align: center;
        }

        .hero h1 {
            font-size: 40px;
        }

        .hero p {
            font-size: 18px;
            max-width: 600px;
        }

        .btn {
            margin-top: 20px;
            padding: 12px 25px;
            background: white;
            color: #0d6efd;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        .btn:hover {
            background: #ddd;
        }

        .section {
            padding: 60px 50px;
            text-align: center;
        }

        .section h2 {
            margin-bottom: 20px;
        }

        /* FOOTER */
        .footer {
            background: #222;
            color: white;
            text-align: center;
            padding: 20px;
        }

    </style>
</head>
<body>

    <!-- NAVBAR -->
    <div class="navbar">
        <div><strong>FYP System</strong></div>
        <div>
            <a href="#">Home</a>
            <a href="#about">About</a>
            <a href="#contact">Contact</a>
            <a href="{{ route('auth.showLogin') }}">Login</a>
            <a href="{{ route('auth.showStudentLogin') }}">Student</a>
            <a href="{{ url('/register') }}">Register</a>
        </div>
    </div>

    <!-- HERO -->
    <div class="hero">
        <h1>Final Year Project System</h1>
        <p>
            A smart platform to manage student-supervisor interactions,
            track progress, and improve communication in final year projects.
        </p>

        <a href="{{ route('auth.showLogin') }}" class="btn">Get Started</a>
    </div>

    <!-- ABOUT -->
    <div class="section" id="about">
        <h2>About Us</h2>
        <p>
            This system helps universities manage final year projects efficiently.
            Coordinators can assign supervisors, supervisors can track students,
            and students can monitor their progress easily.
        </p>
    </div>

    <!-- CONTACT -->
    <div class="section" id="contact">
        <h2>Contact</h2>
        <p>Email: support@fyp.com</p>
        <p>Phone: +255 7592171253</p>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <p>© 2026 FYP Supervision System. All rights reserved.</p>
    </div>

</body>
</html>