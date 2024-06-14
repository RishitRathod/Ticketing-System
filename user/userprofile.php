<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Profile</title>
    <!-- Bootstrap
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> -->

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
            max-width: 1000px;
            margin: 20px auto;  
            padding: 20px;
            /* background-color: #f9f9f9; */
            background: linear-gradient(to right, #bfbeff7e, #fffec075,#c6c0ff75);
            box-shadow:0 4px 6px 0 rgba(0, 0, 0, 0.5) ;
        }
        .main-content:hover{
            box-shadow:0 6px 9px 0 rgba(0, 0, 0, 0.5) ;
        }
        /* .pfp:hover{
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2) ;
        } */

        .sign {
            padding-top: 10px;
            color: #00111b;
            font-family: 'Ubuntu', sans-serif;
            font-weight: bold;
            font-size: 30px;
        }
        #pfp{
            height: 30vmin;
            width: 30vmin;
            min-width: 150px;
            min-height: 150px;

        }
        .changeP {
            position: absolute;
            right: 10px;
            bottom: 10vmin;
            background-color: #00023c;
            height: 4vmax;
            width: 4vmax;
            font-size: 2vmin;

        }
        .password-container {
            position: relative;
        }
        .password-container input {
            padding-right: 30px;
        }
        .password-container .eye {
            position: absolute;
            right: 20px;
            top: 35px;
            transform: translateY(-50%);
            cursor: pointer;
        }   
        @media (max-width: 760px) {
            .justMove{
                position: fixed;
                bottom: 8%;
                z-index: 999;  
            }
            .justMove button{
                border-radius: 10px;
                background-color:#00023c !important; 
            }
            fieldset label{
                font-size: 10px;
                margin-bottom: -5px;
            }
        }


    </style>
</head>
<body>
    <div class="container-fluid w-100 p-3 bg-dark text-white">
        <?php
        include 'userdashnav.php';
        ?>
    </div>
    </div>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            
            <div class="col p-3 mx-0 mx-md-5 mt-5 rounded-5">
                <div class="main-content mx-auto mt-5 d-flex justify-content-center align-items-center rounded-5">
                    <div class="modal fade" id="uploadNew" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Upload New PHoto</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <input type="file" id="photoInput" name="photo" accept="image/*">
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                              </div>
                          </div>
                        </div>
                    </div>
                    <form id="registrationForm" class="form-container justify-content-center row flex-wrap" action="" method="POST" id="editForm"> 
                        <p class="sign" align="center">Profile</p>
                        <div class="d-flex col-auto mr-0 mr-md-4 flex-column align-items-center ">
                            <img src="../img/user.png" id="pfp" alt="Your Profile Photo" class="shadow-lg p-2 bg-body-tertiary position-relative rounded-circle">
                            <button type="button" class="changeP rounded-5 mt-2" id="changeP" data-toggle="modal" data-target="#uploadNew"><i class="fa fa-pencil text-light"></i></button>      
                            <div class="row justMove justify-content-center mt-3">
                                <button type="button" id="edit" name="edit" class="col-auto m-2 btn btn-outline-primary" onclick="editProfile()">Edit</button>
                                <button type="submit" id="submit" name="submit" class="col-auto m-2 btn btn-outline-warning" onclick="updateprofile()" hidden>Submit</button>
                            </div>                   
                        </div>
                        
                        <fieldset class="p-2 p-md-4 mx-5 mx-md-1 col-auto rounded-4">
                            <legend>User Details</legend>
                            <div class="row">
                                <div class="col">
                                    <label for="name" class="ml-3"> User Name </label>
                                    <input type="text" name="name" id="name" class="my-2 m-sm-1 form-control" disabled> 
                                </div>
                                <div class="col">
                                    <label for="cno" class="ml-3"> Contact Number </label>
                                    <input type="text" name="cno" id="cno" class="my-2 m-sm-1 form-control" disabled>
                                </div>
                            </div>
                            <label for="email"> Email </label>
                            <input type="email" name="email" id="email" class="form-control" disabled>
                            <div class="password-container">
                                <label for="PassWord"> Password </label>
                                <input type="password" name="pass" id="PassWord" class="form-control"disabled >
                                <div id="eye" class="d-inline eye mt-3"><i class="fa fa-eye-slash"></i></div>
                            </div>
                            <!-- <input type="checkbox" onclick="togglePassword()"> Show Password -->
                      
                        </fieldset>
                        <input type="hidden" id="UserID" name="UserID">
                        <!-- <div class="row mt-3 justify-content-center">
                            <button type="button" id="edit" name="edit" class="col-2 m-auto btn btn-outline-primary" onclick="editProfile()">Edit</button>
                            <button type="submit" id="submit" name="submit" class="col-2 m-auto btn btn-outline-warning" onclick="updateprofile()" hidden>Submit</button>
                        </div> -->
                    </form>             
                    </div>
    
                       
                </div>
            </div>
        </div>
    </div>  


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>   

    <footer class="bg-body-tertiary p-3 text-center text-lg-start">
    <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2024 Copyright:
            <a class="text-body" href="#"> Event Scheduler </a>
        </div>
    <!-- Copyright -->
    </footer>
    <script src="../script.js"></script>
    <script src="../script_o_pass.js"></script>

    <script>
        let userData;
    

        document.addEventListener('DOMContentLoaded', async function() {
            userData = await getUser();
            console.log(userData[0].OrgID);
            // showDiv(userData[0].Status);
            var pass = document.cookie.split('; ').find(row => row.startsWith('password')).split('=')[1];
            console.log(pass);

            if (userData && userData.length > 0) {
                document.getElementById('name').value = userData[0].Username;
                document.getElementById('email').value = userData[0].Email;
                document.getElementById('PassWord').value = pass;
                document.getElementById('cno').value = userData[0].userphonenumber;
                document.getElementById('pfp').src = userData[0].UserPhoto;
                document.getElementById('UserID').value = userData[0].UserID;
            }
        });

        function editProfile() {
            document.getElementById('submit').removeAttribute('hidden');
            document.getElementById('name').removeAttribute('disabled');
            document.getElementById('PassWord').removeAttribute('disabled');
           }

        function updateprofile() {
            // Hide the submit button
            document.getElementById('submit').setAttribute('hidden', 'true');
            document.getElementById('name').setAttribute('disabled', 'true');
            document.getElementById('PassWord').setAttribute('disabled', 'true');
          
            // Prevent the default form submission behavior
            event.preventDefault();
            
            // Get the form data
            const name = document.querySelector("#name").value;
            const Password = document.querySelector("#PassWord").value;
            const UserID = document.querySelector("#UserID").value;
            // Construct the data object
            var data = {
                "Username": name,
                "Password": Password,
                "Tablename": "users",
                "UserID": UserID,
        };
        
        // Send the form data to the server
        fetch("user_prof.php", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Response from server:', data);
            // Handle the response data here
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function togglePassword() {
            var passwordField = document.getElementById("PassWord");
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }



    
    
    </script>

</body>
</html>