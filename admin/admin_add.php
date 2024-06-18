<?php
    include 'admin_headnav.php';
?>
        <div class="contentainer d-block">
            <div class="d-inline">
                <div class="modal-header">
                    <h2 class="modal-title">Add Admin</h2>
                </div>
                <form method="POST" id="registrationForm">
                    <div class="row justify-content-evenly mt-3">
                        <div class="col-auto mb-3">
                            <div class="d-inline-block">
                                <label for="AdminUsername" class="form-label">Username<span class="req">*</span></label>
                                <span id="error" style="color:red; font-size:10px;"></span>
                                <input type="text" autocomplete='off' name="AdminUsername" class="form-control mb-1" id="AdminUsername">
                            </div>
                            <div class="d-inline-block">
                                <label for='AdminEmail' class='form-label'>Email<span class="req">*</span></label>
                                <input type='email' name='AdminEmail' class="form-control mb-1" id="AdminEmail">
                            </div>
                            <div id="passID" style="display: inline-block">
                                <div id="passwordDiv" class="password-container d-inline-block adBox">
                                    <label for='AdminPassword' class='form-label'>Password<span class="req">*</span></label>
                                    <input type='password' name='Password' class='form-control' id="AdminPassword">
                                    <div id="eye" class="d-inline eye mt-3"><i class="fa fa-eye-slash"></i></div>
                                </div>
                                <div class="d-inline-block">
                                    <label for='ConfirmPass' class='form-label'>Confirm Password<span class="req">*</span></label>
                                    <input type="password" name="Password1" class="form-control mb-3" id="ConfirmPass">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                    <button type="button" class="btn btn-secondary" onclick="resetform()">Cancel</button>
                                    <button type="button" class="btn btn-success" id="upDate"onclick="updateAdmin()" hidden>Update</button>
                                    <button type="button" class="btn btn-success" id="add" onclick="addadmin()">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" value="admins" id="tablename" name="tablename">
                    <input type="hidden" value="" id="AdminID">
                    
            </div>
    <hr>
            <div class="d-inline" id="adminTableDiv">
                <table class="table table-bordered" id="adminTable">
                    <thead>
                        <tr>
                            <th>Admin ID</th>
                            <th>Admin Name</th>
                            <th>Email</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody id="adminBody">
                        <!-- Table rows will be populated here -->
                    </tbody>
                </table>
            </div>
        </div>
        
        <script>

        document.getElementById('AdminUsername').addEventListener('input', function () {
            var input = this.value.trim().toLowerCase();
            var table = document.getElementById('adminTable');
            var errorElement = document.getElementById('error');
            var packageNames = [];
            // Collect column names from the table header
            var rows = table.tBodies[0].rows;
            for (var i = 0; i < rows.length; i++) {
                packageNames.push(rows[i].cells[1].textContent.trim().toLowerCase());
            }
            // Check if the input value matches any column name
            if (packageNames.includes(input)) {
                errorElement.textContent = 'Please choose a different name.';
            } else {
                errorElement.textContent = '';
            }
        });
            function resetform(){
                document.querySelector("#registrationForm").reset();
                document.querySelector("#AdminUsername").disabled = false;
                document.querySelector("#AdminEmail").disabled = false;
                document.querySelector("#AdminPassword").disabled = false;
                document.querySelector("#ConfirmPass").disabled = false;
                document.querySelector("#passID").style.display = "inline-block";
                document.querySelector("#upDate").setAttribute('hidden',true);
                document.querySelector("#add").removeAttribute('hidden');

            }
            
            $(document).ready(function() {
                $('#eye').click(function() {
                    let passwordFieldType = $('#AdminPassword').attr('type');
                    $('#eye').empty();
                    if (passwordFieldType === 'password') {
                        $('#AdminPassword').attr('type', 'text');
                        let eyeOpen = `<i class="fa fa-eye"></i>`;
                        $('#eye').append(eyeOpen);
                    } else {
                        $('#AdminPassword').attr('type', 'password');
                        let eyeClose= `<i class="fa fa-eye-slash"></i>`;
                        $('#eye').append(eyeClose);
                    }
                });

                $('#ConfirmPass').keyup(function() {
                    let password = $('#AdminPassword').val();
                    let confirmPassword = $('#ConfirmPass').val();

                    if (password !== confirmPassword) {
                        $('#passwordError').text('Passwords do not match!');
                    } else {
                        $('#passwordError').text('');
                    }
                });

                $('#AdminPassword').keyup(function() {
                    $('#ConfirmPass').keyup(); // Trigger confirm password check when admin password changes
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                fetchAdmins();
            });
            async function fetchAdmins(){
                fetch('addadmin.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        'Action': 'fetch',
                        'tablename': 'admins'
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const admins = data.data;
                        const adminBody = document.querySelector('#adminBody');
                        adminBody.innerHTML = '';
                        admins.forEach(admin => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${admin.AdminID}</td>
                                <td>${admin.AdminUsername}</td>
                                <td>${admin.Email}</td> 
                                
                            
                            `;//add button to edit and delete admin
                            adminBody.appendChild(row);
                        });
                        // <!-- <td>   <button class="btn btn-primary" onclick="editAdmin(${admin.AdminID})">Edit</button> 
                        // <button class="btn btn-danger" onclick="deleteAdmin(${admin.AdminID})">Delete</button>-->
                        const numColumns = $("#adminTable thead th").length;

                        const columnWidth =  (1* numColumns)/100 + '%';
                        $('#adminTable').DataTable(
                        //     { "responsive": true,
                        //     "autoWidth": false, // Disable automatic column width calculation
                        //     "destroy": true, // Added to reinitialize DataTable
                        //     "columnDefs": [
                        //     { "width": columnWidth, "targets": "_all" } // Set the width of all columns
                        // ]}
                    );
                    } else {
                        console.log('Error: ', data.message);
                    }
                });
            }

            async function addadmin() {
            const adminUsername = document.querySelector("#AdminUsername").value;
            const password = document.querySelector("#AdminPassword").value;
            const AdminEmail = document.querySelector('#AdminEmail').value;
            const tablename = document.querySelector('#tablename').value;
            var usernamePattern = /^[a-zA-Z0-9_]{3,20}$/; // Alphanumeric, 3-20 characters
            var passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$#!%*?&])[A-Za-z\d@$#!%*?&]{8,}$/; // Minimum 8 characters, at least one letter, one number and one special character
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Simple email pattern
    
            // Validate fields
            if (!usernamePattern.test(adminUsername)) {
                var input = document.getElementById('AdminUsername').value.trim().toLowerCase();
                var table = document.getElementById('adminTable');
                var adNames = [];
                // Collect column names from the table header
                var rows = table.tBodies[0].rows;
                for (var i = 0; i < rows.length; i++) {
                    adNames.push(rows[i].cells[1].textContent.trim().toLowerCase());
                }
                // Check if the input value matches any column name
                if (adNames.includes(input)) {
                    alert('Name is Invalid');
                    return ;
                } 
                alert("Invalid username. Please enter 3-20 alphanumeric characters.");
                return;
            }
    
            if (!passwordPattern.test(password)) {
                alert("Invalid password. Please enter at least 8 characters, including at least one letter, one number, and one special character.");
                return;
            }
    
            if (!emailPattern.test(AdminEmail)) {
                alert("Invalid email address.");
                return;
            }
            let pass1 = $('#AdminPassword').val();
            let pass2 = $('#ConfirmPass').val();

                    if (pass1 !== pass2) {
                        alert("Password do not match");
                        return;
                        // $('#passwordError').text('Passwords do not match!');
                    } 
        // Construct the data object
        var data = {
            "tablename": tablename,
            "AdminUsername": adminUsername,
            "Password": password,
            "Email": AdminEmail,
            "Action" : "add"
        };
        
        // Send the form data to the server
        const response = await fetch("addadmin.php", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });
        
        const result = await response.json();
        
        if (result.status === 'success') {
            // Refresh the table
            alert("Admin added successfully");
            fetchAdmins();
            // Clear the form
            document.querySelector("#registrationForm").reset();
            
            // var modal=document.getElementById("myModal");
            // modal.setAttribute("hidden", "true");
        } else {
            console.log("Error: ", result.message);
        }
    }
    function togglePassword() {
        var passwordField = document.getElementById("AdminPassword");
        if (passwordField.type === "password") {
            passwordField.type = "text";
        } else {
            passwordField.type = "password";
        }
    }

    async function deleteAdmin(id) {
        const tablename = document.querySelector('#tablename').value;
        const response = await fetch("addadmin.php", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                "tablename": tablename,
                "id": id,
                "Action": "delete"
            }),
        });
        const result = await response.json();
        if (result.status === 'success') {
            alert("Admin deleted successfully");
            fetchAdmins();
        } else {
            console.log("Error: ", result.message);
        }
    }   

    async function editAdmin(id) {
        const tablename = document.querySelector('#tablename').value;
        document.querySelector("#passID").style.display = "none";
        document.querySelector("#upDate").removeAttribute('hidden');
        document.querySelector("#add").setAttribute('hidden',true);


        const response = await fetch("addadmin.php", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                "tablename": tablename,
                "id": id,
                "Action": "edit"
            }),
        });
        const result = await response.json();
        if (result.status === 'success') {
            const admin = result.data[0];
            document.querySelector("#AdminUsername").value = admin.AdminUsername;
            document.querySelector("#AdminEmail").value = admin.Email;
            document.querySelector("#AdminID").value = admin.AdminID;
         //   document.querySelector("#AdminPassword").value = admin.Password;
         //   document.querySelector("#ConfirmPass").value = admin.Password;
            document.querySelector("#AdminUsername").disabled = false;
            document.querySelector("#AdminEmail").disabled = false;
            document.querySelector("#AdminPassword").disabled = true;
            document.querySelector("#ConfirmPass").disabled = true;
            document.querySelector("#passwordDiv").style.display = "none";

        } else {
            console.log("Error: ", result.message);
        }
    }

    async function updateAdmin() {
        const adminUsername = document.querySelector("#AdminUsername").value;
       // const password = document.querySelector("#AdminPassword").value;
        const AdminEmail = document.querySelector('#AdminEmail').value;
        const tablename = document.querySelector('#tablename').value;
        const id = document.querySelector('#AdminID').value;
        var data = {
            "tablename": tablename,
            "AdminUsername": adminUsername,
            //"Password": password,
            "Email": AdminEmail,
            "Action" : "update",
            "id": id
        };
        const response = await fetch("addadmin.php", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });
        const result = await response.json();
        if (result.status === 'success') {
            alert("Admin updated successfully");
            fetchAdmins();
            resetform();
        } else {
            console.log("Error: ", result.message);
        }
    }

        </script>

<?php
    include 'admin_footer.php';
?>