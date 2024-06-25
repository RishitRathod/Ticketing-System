<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Use only Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

    


<style>
        body {
            background-color: #c9d6ff;
            width:100%;
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
        .navB{
            background: #1b155d;
        }

        .navbar-brand img {
            height: 5vmax;
        }
        .dropdown-toggle::after { 
            content: none; 
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

        /* .tickets {
            background-image: url("https://copycatjm.com/wp-content/uploads/2022/08/Tickets-Prod-Image.jpg"); 
        } */

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

        .dropdown-toggle::after { 
            content: none; 
        } 
        @media (max-width: 427px) {
            body{
                width: 98%;
            }
        }


        
    </style>
            <!-- Bootstrap 5 JS -->
            <!-- bs5.3 -->
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
            
            
            <!-- <script src="../script.js"></script> -->
            <script>

 function checkCookie(key, value) {
    // Get all cookies
    const cookies = document.cookie.split(';');

    // Iterate over cookies
    for (let i = 0; i < cookies.length; i++) {
        // Get the current cookie and trim any leading spaces
        let cookie = cookies[i].trim();

        // Check if the cookie starts with the key we're looking for
        if (cookie.startsWith(key + '=')) {
            // Get the cookie value
            let cookieValue = cookie.substring((key + '=').length);

            // Check if the cookie value matches the specified value
            if (cookieValue === value) {
                return true;
            }
        }
    }

    // Return false if the key-value pair was not found
    return false;
}

// Usage example:
// if (checkCookie('role', 'user')) {
//     document.getElementById('login').style.display = 'none';
//     document.getElementById('profile').style.display = 'block';
//     console.log('Cookie with key "username" and value "JohnDoe" exists.');
// } else {
//     console.log('Cookie with key "role" and value "user" does not exist.');
    
//     document.getElementById('profile').style.display = 'none';
//     document.getElementById('myEvents').style.display='none';
//     document.getElementById('myTicekts').style.display='none';
//     document.getElementById('login').style.display = 'block';
// }

// window.onload = function() {
//     if (checkCookie('role', 'user')) {
        
//         document.getElementById('login').style.display = 'none';
//         document.getElementById('profile').style.display = 'block';
//         console.log('Cookie with key "role" and value "user" exists.');
//     } else {
//         console.log('Cookie with key "role" and value "user" does not exist.');
        
//         document.getElementById('profile').style.display = 'none';
//         document.getElementById('myEvents').style.display='none';
//         document.getElementById('myTicekts').style.display='none';
//         document.getElementById('login').style.display = 'block';
//     }
// };


//                 function isUserLoggedIn() {
//        const cookies = document.cookie.split(';').map(cookie => cookie.trim());
//         for (const cookie of cookies) {
//         if (cookie.startsWith('role=user')) {
//             console.log("User is logged in");
//             return true;
//         }
//          }
//     console.log("User is not logged in");
    
//     return false;
// }
//                 document.addEventListener('DOMContentLoaded', function() {
//                     if (isUserLoggedIn()===true) {
//                         document.getElementById('login').style.display = 'none';
//                         document.getElementById('profile').style.display = 'block';
                       
//                     } else {
//                         document.getElementById('profile').style.display = 'none';
//                         document.getElementById('myEvents').style.display='none';
//                         document.getElementById('myTicekts').style.display='none';
//                         document.getElementById('login').style.display = 'block';
                        
//                     }
//                 });
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
</head>
<body>
<nav class="navbar fixed-top navB navbar-dark p-3 navbar-expand-lg">
    <div class="container-fluid p-0 ">
        <a class="navbar-brand fs-4" href="./user_dashboard1.php">
            <img src="../img/logo.png" class="rounded-circle pic  mx-1 mx-sm-3" alt="Logo"> USER
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" id="parentDiv">
                <li class="nav-item ml-5 ml-md-0">
                    <a class="nav-link active" aria-current="page" href="./user_dashboard1.php">Home</a>
                </li>
                <!-- <li class="nav-item ml-3 ml-md-0">
                    <a class="nav-link" href="#"> Organizations </a>
                </li> -->
                <li class="nav-item ml-5 ml-md-0" id="myEvents">
                    <a class="nav-link" href="./user_events.php"> My Events </a>
                </li>
                <li class="nav-item ml-5 ml-md-0" id="myTicekts">
                    <a class="nav-link" href="./user_tickets.php"> My Tickets </a>
                </li>
            </ul>
            <div class="col-sm-auto col-3" id="login">
                <a class="btn ls" href="user_logINsignUP.html">Login | Sign up</a>
            </div>
            <div class="col-sm-auto col-3 dropdown open rounded-pill" id="profile">
                <div class="dropdown open rounded-pill ">
                    <a class="btn rounded-pill dropdown-toggle" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="../img/user.png" height="40" class="rounded-circle" alt="User">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg-end" aria-labelledby="triggerId">
                        <a class="dropdown-item" href="./userprofile.php">Profile</a>
                        <button type="button" class="dropdown-item" onclick="logout()" href="#">Log Out</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

