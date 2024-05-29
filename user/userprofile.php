<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Profile</title>
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
            font-size: 23px;
        }
        #accepted{
            display: none;
            background-color: rgb(161, 255, 161);
            text-shadow: 0 0 10px rgba(0, 255, 0, 0.5); 
            box-shadow: 0 0 10px 5px rgba(14, 187, 14, 0.5); 
            padding: 10px;
            border-radius: 5px; 
        }
        #pending{
            display:none;
            background-color: rgb(246, 255, 161);
            text-shadow: 0 0 10px rgba(229, 255, 0, 0.5); 
            box-shadow: 0 0 10px 5px rgba(158, 187, 14, 0.5); 
            padding: 10px;
            border-radius: 5px; 
        }
        #rejected{
            display: none;
            background-color: rgb(255, 161, 161);
            text-shadow: 0 0 10px rgba(255, 0, 0, 0.5); 
            box-shadow: 0 0 10px 5px rgba(187, 14, 14, 0.5); 
            padding: 10px;
            border-radius: 5px;  
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
            
            <div class="col p-3">
                <div class="main-content mx-auto d-flex justify-content-center align-items-center rounded-5">
                    <form id="registrationForm" class="form-container justify-content-center flex-wrap" action="" method="POST" id="editForm"> 
                        <p class="sign" align="center">Profile</p>
                        <div class="d-flex flex-column align-items-center mb-3">
                            <img src="../img/user.png" height="180" alt="Your Profile Photo" class="shadow-lg p-2 bg-body-tertiary rounded-circle">
                        </div>
                        <fieldset class="mt-3 px-5 rounded-4">
                            <legend> Status </legend>
                            <div class="my-3 mx-3 text-black" id="status">
                                <div id="accepted"> 
                                    <i class="fs-5 fa fa-check mr-2 mx-4"></i>Approved
                                </div>
                                <div id="pending">  
                                    <i class="fs-5 fa fa-clock-os mr-2 mx-4"></i>Pending
                                </div>
                                <div id="rejected"> 
                                    <i class="fs-5 fa fa-warning mr-2 mx-4"></i>Rejected
                                    <p class="" id="reason"></p>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="mt-3 p-4 rounded-4">
                            <legend>Organization Details</legend>
                            <div class="row">
                                <div class="col">
                                <label for="name" class="ml-3"> Organization Name </label>
                                <input type="text" name="name" id="name" class="my-2 m-sm-1 form-control" disabled> 
                            </div>
                            <div class="col">
                                <label for="desc" class="ml-3"> Package </label>
                                <input type="text" name="package" id="package" class="my-2 m-sm-1 form-control" disabled>
                            </div>
                        </div>
                        <label for="email"> Email </label>
                            <input type="email" name="email" id="email" class="form-control" disabled>
                            <label for="pass"> Password </label>
                            <input type="text" name="pass" id="pass" class="form-control" disabled> 
                        </fieldset>
    
                        <fieldset class="m-auto mt-3 px-4 rounded-4">
                            <legend>  Contact Details </legend>
                            <div class="row">
                                <div class="col-12">
                                    <label for="co_name" class="m-3"> Name </label>
                                    <input type="text" name="co_name" id="co_name" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col my-2">
                                    <label for="co_email" class="m-3"> Email </label>
                                    <input type="email" name="co_email" id="co_email"  class="form-control"disabled>
                                </div>
                                <div class="col my-2">
                                    <label for="co_number" class="m-3"> Number </label>
                                    <input type="text" name="co_number" id="co_number" class="form-control" disabled>
                                </div>
                            </div>
                        </fieldset>
                       
                        <input type="hidden" id="OrgID" name="OrgID">
                        <div class="row justify-content-center">
                            <button type="button" id="edit" name="edit" class="col-2 m-auto mt-3 btn btn-outline-primary" onclick="editProfile()">Edit</button>
                            <button type="submit" id="submit" name="submit" class="col-2 m-auto mt-3 btn btn-outline-warning" onclick="updateprofile()" hidden>Submit</button>
                        </div>
                    </form>             
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
    <script>
        let userData;
        let status; 
        let resasonofrejection;

        document.addEventListener('DOMContentLoaded', async function() {
            userData = await getUser();
            console.log(userData[0].OrgID);
            showDiv(userData[0].Status);
            
            if (userData && userData.length > 0) {
                document.getElementById('name').value = userData[0].Name;
                document.getElementById('email').value = userData[0].Email;
                document.getElementById('pass').value = userData[0].Password;
                document.getElementById('co_email').value = userData[0].ContactEmail;
                document.getElementById('co_number').value = userData[0].ContactNumber;
                document.getElementById('co_name').value = userData[0].ContactName;
                document.getElementById('OrgID').value = userData[0].OrgID;
                status = userData[0].Status;
                resasonofrejection= userData[0].ReasonOfRejection;
            }
        });

        function editProfile() {
            document.getElementById('submit').removeAttribute('hidden');
            document.getElementById('name').removeAttribute('disabled');
            document.getElementById('co_email').removeAttribute('disabled');
            document.getElementById('co_number').removeAttribute('disabled');
            document.getElementById('co_name').removeAttribute('disabled');
            document.getElementById('OrgID').removeAttribute('hidden');
        }

        function updateprofile() {
            // Hide the submit button
            document.getElementById('submit').style.display = 'none';
            document.getElementById('name').setAttribute('disabled', 'true');
            document.getElementById('co_email').setAttribute('disabled', 'true');
            document.getElementById('co_number').setAttribute('disabled', 'true');
            document.getElementById('co_name').setAttribute('disabled', 'true');
            
            // Prevent the default form submission behavior
            event.preventDefault();
            
            // Get the form data
            const name = document.querySelector("#name").value;
            const contactName = document.querySelector("#co_name").value;
            const contactNumber = document.querySelector("#co_number").value;
            const contactEmail = document.querySelector("#co_email").value;
            const orgID = document.querySelector("#OrgID").value;
            
            // Construct the data object
            var data = {
                "Name": name,
                "ContactName": contactName,
                "ContactNumber": contactNumber,
                "ContactEmail": contactEmail,
                "Tablename": "organizations",
                "OrgID": orgID,
        };
        
        // Send the form data to the server
        fetch("org_profile.php", {
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

    function showDiv(status) {
      if (status === "Pending") {
        document.getElementById('pending').style.display = 'block';
      } else if (status === "Rejected") {
        document.getElementById('rejected').style.display = 'block';
      } else {
        document.getElementById('accepted').style.display = 'block';
      }
    }



    
    
    </script>

</body>
</html>