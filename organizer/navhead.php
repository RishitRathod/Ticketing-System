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
    <!-- datatable Bootstrap -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <script>
function isUserLoggedIn() {
                    const cookies = document.cookie.split(';').map(cookie => cookie.trim());
                   if(!cookies){
                       console.log("User is not logged in");
                       return false;}
                    for (const cookie of cookies) {
                        if (cookie.startsWith('role=')) {
                            console.log("User is logged in");
                            return true;
                        }
                    }
                    console.log("User is not logged in");
                    return false;
            }

            if (!isUserLoggedIn()) {
                window.location.href = './organization_login.html';
            }

    </script>

    <!-- CSS -->
    <style>
        body{
            background-color: #c9d6ff;
        }
        td{
            margin-left: 5px;
            margin-right: 5px;
        }

        thead {
        background-color: #8341fe;
        color: #fff;
        padding: 2px;
    }
        fieldset {
            border: solid 1px gray;
            border-radius: 10px;
            padding-top: 5px;
            padding-right: 12px;
            padding-bottom: 10px;
            padding-left: 12px;
        }
        legend {
            float: none;
            width: inherit;
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
            background-color: #B3D9FF20;
            box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2) ;
        }
        .backOnav{
            background-color: #00023c;
        }
        .adBox {
            position: relative;
        }
        .adBox input {
            width: 100%;
            padding-right: 30px; /* Make space for the icon */
        }
        .adBox .eye {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-30%);
            cursor: pointer;
        }
        .dropdown-toggle::after { 
            content: none; 
        } 
        .stic {
            position:sticky;
            top:20px;
        }
        @media (min-width: 760px) {
            .sn{
                width:225px;   
            }
        }

    </style>
</head>
<body>  
<!-- <div class="toast-container position-fixed top-0 end-0 p-3">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <img src="..." class="rounded me-2" alt="...">
      <strong class="me-auto">Bootstrap</strong>
      <small>11 mins ago</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      Hello, world! This is a toast message.
    </div>
  </div>
</div> -->
    <div class="container-fluid w-100 backOnav text-white">
        <div class="row align-items-center">
            <a class="col-auto me-auto p-3 ml-3 mr-auto"    href="./organization_dashboard.php" style="text-decoration: none;">
                <img src="../img/logo.png" height="60" class="rounded-circle" alt="Logo">
                <b class="h5 ml-2 text-light text-decoration-none">The Organizer</b>
            </a> 
            <div class="col-sm-auto col-3 ">
                <div class="dropdown open p-3 rounded-pill">
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
        <div class="row stic flex-nowrap">  
            <div class="backOnav  col-auto col-xl-2 col-md-4 sn min-vh-100 d-flex flex-column justify-content-between g-0">
                <div class="backOnav p-2">
                    <ul class="nav nav-pills flex-column" id="parentDiv">
                        <li class="nav-item py-2">
                            <a href="./organization_dashboard.php" class="nav-link text-white"> 
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
            <div class="col">
                <div class="main-content mx-1 mx-sm-auto d-flex justify-content-center align-items-center g-0">

            <script src="../script.js"></script>
           <script> 
            // $(document).ready(function() {
            //     // Show toast automatically when the page is loaded
            //     $('.toast').toast({ delay: 2000 });
            //     $('.toast').toast('show');
            // });
            document.addEventListener('DOMContentLoaded', ()=>{
                if (!isUserLoggedIn()) {
                //    document.getElementById('login').style.display = 'none';
                //    document.getElementById('profile').style.display = 'block';
                } else {
                   window.herf = "./organization_login.html";
                }
            
            });

            window.onload = function() {
                    if (!isUserLoggedIn()) {
                //    document.getElementById('login').style.display = 'none';
                //    document.getElementById('profile').style.display = 'block';
                } else {
                   window.herf = "./organization_login.html";
                }
            }
            window.onload(setActiveLink());

               
            function isUserLoggedIn() {
                    const cookies = document.cookie.split(';').map(cookie => cookie.trim());
                   if(!cookies){
                       console.log("User is not logged in");
                       return false;}
                    for (const cookie of cookies) {
                        if (cookie.startsWith('role=')) {
                            console.log("User is logged in");
                            return true;
                        }
                    }
                    console.log("User is not logged in");
                    return false;
            }
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
       // Extract the OrgID from cookies


        async function CheckOrgStatus(OrgID) {
    try {
        console.log(OrgID);
        const response = await fetch('../fetchOrgs.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action: 'CheckOrgStatus',
                OrgID: OrgID
            })
        });

        const data = await response.json();
        console.log(data);
        //return;
        if (data.data['Status'] !== "Approved" ) {
            // event.preventDefault();
            alert('Your Profle is not verified ...!')
            window.location.href = './org_profile.html';
            // $('#liveToast').toast({ delay: 2000 });
            // $('#liveToast').toast('show');
        } 
    } catch (error) {
        console.error('Error fetching organization status:', error);
    }
}

console.log(document.cookie.split('; ').find(row => row.split('=')[0] === 'id').split('=')[1]);
// Call the function with the OrgID
CheckOrgStatus(document.cookie.split('; ').find(row => row.split('=')[0] === 'id').split('=')[1]);

// console.log(status);
// console.log("hrllo");
// if (status != "Approved") {
//     window.location.href = './org_profile.html';
// }


        </script>