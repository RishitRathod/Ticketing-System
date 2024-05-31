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
            box-sahdow: 1px 6px 20px #6f21ff47;
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
            <a class="col-auto me-auto p-3 ml-3 mr-auto" href="./admin_dashboard.php"  style="text-decoration: none;">
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
                        <a class="dropdown-item" href="#">Log Out</a>
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
                            <a href="#myModal" role="button"  class="nav-link text-white" data-bs-toggle="modal">
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
