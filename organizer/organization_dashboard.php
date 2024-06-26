<?php
    include 'navhead.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <script src="../script.js"></script>
    <!-- CSS -->
    <style>
        body{
            background-color: #c9d6ff;
            /* background: lineary-gradient(to right, #e2e2e2, #c9d6ff); */

        }
        .nav-pills li a:hover {
            background-color: darkblue;
        }

        .dropdown-menu a:hover {
            background-color: darkblue;
            color: #fff;
        }

        .main-content {
            /* border: 1px solid #ccc; */
            border-radius: 5px;
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: #25252510;
            box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2) ;
        }

        .createEvent{
            --bg-color: #ffdf7e;
            --bg-color-light: #ffeeba;
            --text-color-hover: #4C5656;
            --box-shadow-color: rgba(255, 215, 97, 0.48);
        }
        .events{
            --bg-color: #B8F9D3;
            --bg-color-light: #e2fced;
            --text-color-hover: #4C5656;
            --box-shadow-color: rgba(184, 249, 211, 0.48);
        }
        .log_data {
            --bg-color: #CEB2FC;
            --bg-color-light: #F0E7FF;
            --text-color-hover: #fff;
            --box-shadow-color: rgba(206, 178, 252, 0.48);
        }

        .qr_scanner {
            --bg-color: #DCE9FF;
            --bg-color-light: #f1f7ff;
            --text-color-hover: #4C5656;
            --box-shadow-color: rgba(220, 233, 255, 0.48);
        }

        .card {
            width: 220px;
            height: 320px;
            margin: 5px;
            background: #fff;
            border-top-right-radius: 10px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            box-shadow: 0 14px 26px rgba(0,0,0,0.04);
            transition: all 0.3s ease-out;
            text-decoration: none;
        }

        .card:hover {
            transform: translateY(-5px) scale(1.005) translateZ(0);
            box-shadow: 0 24px 36px rgba(0,0,0,0.11),
            0 24px 46px var(--box-shadow-color);
        }

        .card:hover .overlay {
            transform: scale(4) translateZ(0);
        }

        .card:hover .circle {
            border-color: var(--bg-color-light);
            background: var(--bg-color);
        }

        .card:hover .circle:after {
            background: var(--bg-color-light);
        }

        .card:hover p {
            color: var(--text-color-hover);
        }

        .card:active {
            transform: scale(1) translateZ(0);
            box-shadow: 0 15px 24px rgba(0,0,0,0.11),
            0 15px 24px var(--box-shadow-color);
        }

        .card p {
            font-size: 17px;
            color: #4C5656;
            margin-top: 30px;
            z-index: 1000;
            transition: color 0.3s ease-out;
        }

        .circle {
            width: 131px;
            height: 131px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid var(--bg-color);
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            z-index: 1;
            transition: all 0.3s ease-out;
        }

        .circle:after {
            content: "";
            width: 118px;
            height: 118px;
            display: block;
            position: absolute;
            background: var(--bg-color);
            border-radius: 50%;
            top: 7px;
            left: 7px;
            transition: opacity 0.3s ease-out;
        }
        .dropdown-toggle::after { 
            content: none; 
        } 
        .overlay {
            width: 118px;
            position: absolute; 
            height: 118px;
            border-radius: 50%;
            background: var(--bg-color);
            top: 70px;
            left: 50px;
            z-index: 0;
            transition: transform 0.3s ease-out;
        }
        .backOnav{
            background-color: #00023c;
            /* background: linear-grasdient(to right bottom, #005606d5,#00254cfb); */
        }
        @media (min-width: 760px) {
            .sn{
                width:225px;   
            }
        }
        .sepia { filter: sepia(100%); }

    </style>
</head>
<body>
    <!-- <div class="container-fluid w-100 p-3 backOnav text-white">
        <div class="row align-items-center">
            <a class="col-auto me-auto p-3 ml-3 mr-auto" href="./organization_dashboard.html" style="text-decoration: none;">
                <img src="../img/logo.png" height="60" class="rounded-circle" alt="Logo">
                <b class="h5 ml-2 text-light text-decoration-none">The Organizer</b>
            </a>  
            <div class="col-sm-auto col-3">
                <div class="dropdown open p-3 rounded-pills">
                    <button class="btn rounded-pill dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="../img/user.png" height="40" class="rounded-circle" alt="User">
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                        <a class="dropdown-item" href="./org_profile.html">Profile</a>
                        <a class="dropdown-item" href="./organization_logout.php">Log Out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="backOnav col-auto col-xl-2 sn col-md-4 col-lg-3 min-vh-100 d-flex flex-column justify-content-between">
                <div class="">
                    <ul class="nav nav-pills flex-column" id="parentDiv">
                        <li class="nav-item py-2">
                            <a href="./organization_dashboard.html" class="nav-link text-white"> 
                                <i class="fs-5 fa fa-tachometer"></i> <span class="fs-5 ms-3 d-none d-sm-inline">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item py-2">
                            <a href="./organization_events.php" class="nav-link text-white"> 
                                <i class="fs-5 fa fa-list"></i> <span class="fs-5 ms-3 d-none d-sm-inline">Events</span>
                            </a>
                        </li>
                        <li class="nav-item py-2">
                            <a href="./organization_plans.php" class="nav-link text-white"> 
                                <i class="fs-5 fa fa-th"></i> <span class="fs-5 ms-3 d-none d-sm-inline">Package</span>
                            </a>
                        </li>
                        <li class="nav-item py-2">
                            <a href="./organization_analysis.php" class="nav-link text-white"> 
                                <i class="fs-5 fa fa-clipboard"></i> <span class="fs-5 ms-3 d-none d-sm-inline">Analysis</span>
                            </a>
                        </li>
                        <li class="nav-item py-2">
                            <a href="./organization_members.php" class="nav-link text-white"> 
                                <i class="fs-5 fa fa-users"></i> <span class="fs-5 ms-3 d-none d-sm-inline">Members</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col p-3">
                <div class="main-content mx-auto d-flex justify-content-center align-items-center">
                    <!-- The Main buttons come here -->
                    <div class="d-flex justify-content-center flex-wrap">
                        <a class="card createEvent m-2" href="./add_event1.php"> 
                            <div class="overlay"></div> 
                            <img src="https://cdn-icons-png.flaticon.com/512/2921/2921226.png" height="50px" class="circle p-1" alt="create_event">
                            <p>Create Event</p> 
                        </a>
                        <a class="card events m-2" href="./organization_events.php"> 
                            <div class="overlay"></div> 
                            <img src="https://cdn.iconscout.com/icon/free/png-256/free-event-processing-calendar-appointment-planner-schedule-reminder-2-5251.png" height="50px" class="circle p-1" alt="my_events">
                            <p>Events</p>
                        </a> 
                        <a class="card log_data m-2" href="./organization_logdata.php"> 
                            <div class="overlay" ></div> 
                            <img src="https://cdn-icons-png.flaticon.com/512/3610/3610380.png" height="50px" class="circle p-1" alt="my_events"> 
                            <p>Log Data</p> 
                        </a>
                        <a class="card qr_scanner m-2" href="./organization_scanner.php"> 
                            <div class="overlay"></div> 
                            <img src="https://icons.veryicon.com/png/o/application/wechat/qr-code-76.png" height="50px" class="circle p-1" alt="my_events">
                            <p>QR Scanner</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>   -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>   
    <script>
        // Function to set active class to the clicked anchor tag
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
        // Add event listener to set the active class when the DOM is fully loaded
        document.addEventListener('DOMContentLoaded', setActiveLink);
        document.addEventListener('DOMContentLoaded', checkloggedIN );
        function checkloggedIN(){
            if(!isUserLoggedIn())
            {   
                window.location.href = "./organization_login.html";
            }

        }


    </script>
    <footer class="bg-body-tertiary p-3 text-center text-lg-start">
    <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2024 Copyright:
            <a class="text-body" href="#"> Event Scheduler </a>
        </div>
    <!-- Copyright -->
    </footer>
</body>
</html>
