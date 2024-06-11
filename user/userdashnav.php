<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Use only Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

    
<!-- Bootstrap 5 JS -->
<!-- bs5.3 -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>   

<script src="../script.js"></script>
<script>
   window.onload = function() {
        if (isUserLoggedIn()) {
            document.getElementById('login').style.display = 'none';
            document.getElementById('profile').style.display = 'block';
        } else {
            document.getElementById('login').style.display = 'block';
            document.getElementById('profile').style.display = 'none';
        }
    }
    function setActiveLink() {
        // Get the current path
        var currentPath = window.location.pathname;
                    
        // Get all anchor tags within the parent div
        var links = document.querySelectorAll('#parentDiv .nav-link');

        // Remove 'active' class from all anchor tags and set to active if href matches current path
        links.forEach(function(link) {
            if (link.href.endsWith(currentPath)) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    }
    document.addEventListener('DOMContentLoaded', setActiveLink);


</script>


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
            height: 70vh;
            margin: 0;
        }
        fieldset {
            border: solid 1px gray;
            padding-top: 5px;
            padding-right: 12px;
            padding-bottom: 10px;
            padding-left: 12px;
            box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2) ;
        }
        legend {
            float: none;
            width: inherit;
        }
        
        .nav{
            background: #1b155d;
        }

        .navbar-brand img {
            height: 90px;
        }
        .events {
            color: white;
            font-size: 30px;
            font-weight: bolder;
            background-size: cover;
            box-shadow: 0 0 150px #411969d4 inset;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: 100%;
            height: 50vmin;
        } 

        .events {
            background-image: url("https://png.pngtree.com/background/20221109/original/pngtree-event-management-doodle-set-picture-image_1952957.jpg");
        }

        .tickets {
            /* background-image: url("https://copycatjm.com/wp-content/uploads/2022/08/Tickets-Prod-Image.jpg"); */
        }

        /* .events:hover, .tickets:hover {
            color: black;
            box-shadow: 0 10px 20px #000000 inset, 0 0 200px #00000000 inset, 0 0 150px #00000000 inset, 0 0 100px #00000034 inset;
        } */

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
        #triggerId:active{
            box-shadow: 2px 2px 10px black;
        }

        .scroll-container {
            display: flex;
            overflow-x: auto;
            white-space: nowrap;
            padding: 10px;
            background-color: #f8f9fa00;
        }
        .scroll-item:hover{
            color: black;
            font-size: x-large;
            font-weight: bold;
            padding-top: 50%;
            /* box-shadow: 0 10px 20px #000000 inset, 0 0 200px #00000000 inset, 0 0 150px #00000000 inset, 0 0 100px #00000034 inset; */
            box-shadow: 10px 10px 20px #000000;
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
            background-color: #1b155d;
            box-shadow: 10px 10px 20px #000000 inset;
            color: white;
            border-radius: 10px;
            text-align: center;

            background-size: 200px 100px;
            background-repeat: no-repeat; /* Prevent the image from repeating */
            background-position: center; /* Center the image within the button */
        }
        #categorySearch{
                margin-top: 20vh;
        }
        .sBox{
            position: relative;

        }
        .sBox input{
            width: 100%;
            /* padding:30px; */

        }
        .sbtn{
            height: max;
            background-color: #1b155d;

        }
        .sBox .sbtn{
            position: absolute;
            right: 10px;
            top: 15px;
            transform: translateY(-30%);
            cursor: pointer;
        }
        #events-container{
            margin-top: 5px;
        }

        .fil{
            height:30vmin;
            width:10vmin;
            top:20%;
        }
        
    </style>
</head>
<body>
<nav class="navbar fixed-top nav navbar-dark p-3 navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand fs-4" href="./user_dashboard1.php">
            <img src="../img/logo.png" class="rounded-circle mx-1 mx-sm-3" alt="Logo"> USER
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" id="parentDiv">
                <li class="nav-item ml-3 ml-md-0">
                    <a class="nav-link active" aria-current="page" href="./user_dashboard1.php">Home</a>
                </li>
                <!-- <li class="nav-item ml-3 ml-md-0">
                    <a class="nav-link" href="#"> Organizations </a>
                </li> -->
                <li class="nav-item ml-3 ml-md-0">
                    <a class="nav-link" href="./user_events.php"> My Events </a>
                </li>
                <li class="nav-item ml-3 ml-md-0">
                    <a class="nav-link" href="./user_tickets.php"> My Tickets </a>
                </li>
            </ul>
            <div class="col-sm-auto col-3" id="login">
                <a class="btn ls" href="user_logINsignUP.html">Login | Sign up</a>
            </div>
            <div class="col-sm-auto col-3" id="profile">
                <div class="dropdown open p-3 rounded-pill">
                    <button class="btn rounded-pill dropdown-toggle" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="../img/user.png" height="40" class="rounded-circle" alt="User">
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                        <a class="dropdown-item" href="./userprofile.php">Profile</a>
                        <button type="button" class="dropdown-item" onclick="logout()" href="#">Log Out</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>


