<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>
    <!-- Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap JS and Popper.js (required for tooltips) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>   
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    

    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0;
        }
        table.dataTable {
            width: 100% !important;
            margin: 0 auto;
        }
        .container.table-responsive {
            padding-left: 0;
            padding-right: 0;
        }
        #tooltip{
            position: relative;
            display: inline-block;
        }
        #tooltip #tooltiptext{
            visibility: hidden;
            background-color: #000;
            position: absolute;
            z-index: 1;
            

        }
        .approve-btn{
            background-image: url('https://icons.iconarchive.com/icons/fa-team/fontawesome/256/FontAwesome-Check-icon.png');
            background-size: 75%;
            background-repeat: no-repeat;
            background-position: center;
        }
        .reject-btn{
            background-image: url('https://icons.iconarchive.com/icons/ionic/ionicons/256/ban-sharp-icon.png');
            background-size: 75%;
            background-repeat: no-repeat;
            background-position: center;
        }
        .inf{
            background-image: url('https://icons.iconarchive.com/icons/aniket-suvarna/box-regular/256/bx-info-circle-icon.png');
            background-size: 75%;
            background-repeat: no-repeat;
            background-position: center;
        }
        .acBtn{
            height: 4vmin;
            width: 4vmin;
        }
        
        #tooltip:hover #tooltiptext{
            visibility: visible;
            /* transition: 0.5s; */
        }
    </style>
    </style>    

    <!-- CSS -->
    <style>
        *{
            font-family: Roboto, sans sarif;
        }
        body{
            background: linear-gradient(to bottom right, #7774ff7e, #a85bff47);
            width: 100%;

        }
        .nav-pills li a:hover {
            background-color: darkblue;
        }

        .dropdown-menu a:hover {
            background-color: darkblue;
            color: #fff;
        }

        .container-fluid{
            max-width: 100%;
        }
        .main-content {
            border: 1px solid #ccc;
            border-radius: 10px;
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2) ;
        }
        .stic {
            /* height: 200px; */
            /* background: #333366; */
            position:sticky;
            top:20px;
            /* color:#ffffff; */
        }
        
        .password-container {
            position: relative;
        }
        .password-container input {
            padding-right: 30px;
        }
        .password-container .eye {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        
        .themecol{
            color: #fff;
            background-color: #8341fe;
        }
        .themecol:hover{
            color: #fff;
            box-shadow: 0 5px 10px #6f21ffd1;
        }
        .themecol:active{
            color: #fff;
            font-weight: bolder;
            box-shadow: 1px 6px 20px #6f21ff47;
        }
        .backOnav{
            background-color: #000;
        }


        @media (max-width: 768px) {
            .dropdown.open {
                width: 100%;
                text-align: center;
            }
        }
        /* @table-bg-accent: #c8b6eb; */
    </style>
</head>
<body>
    <div class="container-fluid w-100 container-sm p-3 backOnav text-white">
        <div class="row align-items-center">
            <a class="col-auto me-auto p-3 ml-3 mr-auto" href="./admin_dashboard1.php"  style="text-decoration: none;">
                <img src="../img/logo.png" height="60" class="rounded-circle" alt="Logo">
                <b class="h5 ml-2 text-light text-decoration-none">The Admins</b>
            </a>  
            <div class="col-sm-auto col-3">
                <div class="dropdown open p-3 rounded-pills">
                    <button class="btn rounded-pill dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="../img/user.png" height="40" class="rounded-circle" alt="User">
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                        <a class="dropdown-item" href="#">Profile</a>
                        <a class="dropdown-item" href="admin_logout.php">Log Out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="backOnav col-auto col-xl-2 col-md-4 col-lg-3 min-vh-100 d-flex flex-column justify-content-between">
                <div class="backOnav p-2">
                    <ul class="nav nav-pills flex-column" id="parentDiv">
                        <li class="nav-item py-2">
                            <a href="./admin_dashboard1.php" class="nav-link text-white"> 
                                <i class="fs-5 fa fa-tachometer"></i> <span class="fs-5 ms-3 d-none d-sm-inline">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item py-2">
                            <a href="./admin_add.php" role="button"  class="nav-link text-white" data-bs-toggle="modal">
                                <i class="fs-5 fa fa-user"></i><span class="fs-5 ms-3 d-none d-sm-inline">Add Admin</span>
                            </a>
                        </li>
                        <li class="nav-item py-2">
                            <a type="button" class="nav-link text-white" href="./add_package.php"> 
                                <i class="fs-5 fa fa-plus"></i> <span class="fs-5 ms-3 d-none d-sm-inline">Add Package</span>
                            </a>
                        </li>
                        <li class="nav-item py-2">
                            <a href="./admin_analysis.php" class="nav-link text-white"> 
                                <i class="fs-5 fa fa-clipboard"></i> <span class="fs-5 ms-3 d-none d-sm-inline">Analysis</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <script>
                // Function to set active class to the clicked anchor tag
                function setActiveLink() {
                    // Get the current path
                    var currentPath = window.location.pathname.split("/").pop();

                    // Get all anchor tags within the parent div
                    var links = document.querySelectorAll('#parentDiv .nav-link');

                    // Remove 'active' class from all anchor tags and set to active if href matches current path
                    links.forEach(function(link) {
                        var linkHref = link.getAttribute('href');
                        if (linkHref) {
                            var linkPath = linkHref.split("/").pop();
                            if (linkPath === currentPath) {
                                link.classList.add('active');
                            } else {
                                link.classList.remove('active');
                            }
                        }
                    });
                }

                // Add event listener to set the active class when the DOM is fully loaded
                document.addEventListener('DOMContentLoaded', setActiveLink);
            </script>
            <div class="col p-3">
                <div class="main-content mx-auto justify-content-center align-items-center">
