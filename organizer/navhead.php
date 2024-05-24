<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
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

        .sign {
            padding-top: 10px;
            color: #00111b;
            font-family: 'Ubuntu', sans-serif;
            font-weight: bold;
            font-size: 23px;
        }
    </style>
</head>
<body>
    <div class="container-fluid p-3 mb-2 bg-dark text-white">
        <div class="row align-items-center">
            <a class="col-auto p-3 ml-3 mr-auto" href="./organization_dashboard.html">
                <img src="../img/logo.png" height="80" class="rounded-circle" alt="Logo">
                <b class="h5 ml-2 text-light text-decoration-none">The Organizer</b>
            </a>  
            <div class="col-auto">
                <div class="dropdown open p-3 rounded-pills">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
    </div>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="bg-dark col-auto col-md-4 col-lg-3 min-vh-100 d-flex flex-column justify-content-between rounded-right">
                <div class="bg-dark p-2">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item py-2">
                            <a href="./organization_dashboard.html" class="nav-link text-white"> 
                                <i class="fs-5 fa fa-tachometer"></i> <span class="fs-4 ms-3 d-none d-sm-inline">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item py-2">
                            <a href="./organization_events.html" class="nav-link text-white"> 
                                <i class="fs-5 fa fa-list"></i> <span class="fs-4 ms-3 d-none d-sm-inline">Events</span>
                            </a>
                        </li>
                        <li class="nav-item py-2">
                            <a href="./organization_plans.html" class="nav-link text-white"> 
                                <i class="fs-5 fa fa-th"></i> <span class="fs-4 ms-3 d-none d-sm-inline">Plans</span>
                            </a>
                        </li>
                        <li class="nav-item py-2">
                            <a href="./organization_analysis.html" class="nav-link text-white"> 
                                <i class="fs-5 fa fa-clipboard"></i> <span class="fs-4 ms-3 d-none d-sm-inline">Analysis</span>
                            </a>
                        </li>
                        <li class="nav-item py-2">
                            <a href="./organization_members.html" class="nav-link text-white"> 
                                <i class="fs-5 fa fa-users"></i> <span class="fs-4 ms-3 d-none d-sm-inline">Members</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>


</body>
</html>