<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Use only Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            background-color: #c9d6ff;
            background: linear-gradient(to right, #e2e2e2, #c9d6ff);
        }
        main {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }
        .navbar-brand img {
            height: 90px;
        }
        .events, .tickets {
            color: white;
            font-size: 30px;
            font-weight: bolder;
            background-size: cover;
            box-shadow: 0 0 150px #000 inset;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            height: 150px;
        }
        .events {
            background-image: url("https://png.pngtree.com/background/20221109/original/pngtree-event-management-doodle-set-picture-image_1952957.jpg");
        }
        .tickets {
            background-image: url("https://copycatjm.com/wp-content/uploads/2022/08/Tickets-Prod-Image.jpg");
        }
        .events:hover, .tickets:hover {
            color: black;
            box-shadow: 0 10px 20px #000000 inset, 0 0 200px #00000000 inset, 0 0 150px #00000000 inset, 0 0 100px #00000034 inset;
        }
        .ls {
            color: white;
            background-color: green;
            border: 5px solid black;
            border-radius: 30px;
            box-shadow: 0px 5px black;
        }
        .ls:hover {
            color: green;
            background-color: rgb(0, 255, 38);
            border: 5px solid black;
            border-radius: 30px;
            transition: 100ms;
        }
        .ls:active {
            transform: translateY(3px);
            background-color: green;
            box-shadow: 0px 1px rgba(175, 255, 175, 0.455);
        }
        .carousel-container {
            position: relative;
            width: 80%;
            max-width: 800px;
            margin: auto;
        }
        .carousel-item img {
            width: 100%;
        }
        .scroll-container {
            display: flex;
            overflow-x: auto;
            white-space: nowrap;
            padding: 10px;
            background-color: #f8f9fa00;
        }
        .scroll-item:hover {
            color: black;
            font-size: x-large;
            font-weight: bold;
            padding-top: 50%;
            box-shadow: 0 10px 20px #000000 inset, 0 0 200px #00000000 inset, 0 0 150px #00000000 inset, 0 0 100px #00000034 inset;
            transform: translateY(-5px);
        }
        .scroll-container::-webkit-scrollbar {
            display: none;
        }
        .scroll-item {
            display: inline-block;
            min-width: 200px;
            max-width: 500px;
            height: 100px;
            background-color: #007bff;
            color: white;
            border-radius: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
<nav class="navbar fixed-top navbar-dark bg-dark p-3 navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="user_dashboard1.php">
            <img src="../img/logo.png" class="rounded-circle mx-4" alt="Logo">Events
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"> Organization </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"> Events </a>
                </li>
            </ul>
            <div class="d-block" id="login">
                <a class="btn ls" href="user_logINsignUP.html">Login | Sign up</a>
            </div>
            <div class="d-block" id="profile">
                <div class="dropdown open p-3 rounded-pills">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="../img/user.png" height="40" class="rounded-circle" alt="User">
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                        <a class="dropdown-item" href="userprofile.php">Profile</a>
                        <a class="dropdown-item" href="userlogout.php">Log Out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXlDQ8VdAiW3x2yK5RZ3e2V5iZZj3yYS1t68vY0APbFiSJSwkHnd1LKA7cmA" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12wTPO8LInEvC5iFN1pB4j2RLwVEl5q4MzElr2gMZGx7HsmT" crossorigin="anonymous"></script>
</body>
</html>
