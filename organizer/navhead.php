<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <!-- CSS -->
    <style>
        body{
            background-color: #ffffff;
        }
        .nav-pills li a:hover {
            background-color: darkblue;
        }

        .dropdown-menu a:hover {
            background-color: darkblue;
            color: #fff;
        }

        .main-content {
            border: 1px solid #ccc;
            border-radius: 5px;
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2) ;
        }

    </style>
</head>
<body>
    <div class="container-fluid w-100 container-sm p-3 bg-dark text-white">
        <div class="row align-items-center">
            <a class="col-auto me-auto p-3 ml-3 mr-auto" href="./organization_dashboard.html"  style="text-decoration: none;">
                <img src="../img/logo.png" height="60" class="rounded-circle" alt="Logo">
                <b class="h5 ml-2 text-light text-decoration-none">The Organizer</b>
            </a>  
            <div class="col-auto">
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
            <div class="bg-dark col-auto col-xl-2 col-md-4 col-lg-2 min-vh-100 d-flex flex-column justify-content-between">
                <div class="bg-dark p-2">
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
                                <i class="fs-5 fa fa-th"></i> <span class="fs-5 ms-3 d-none d-sm-inline">Plans</span>
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

            </script>
            <div class="col p-3">
                <div class="main-content mx-auto d-flex justify-content-center align-items-center">
