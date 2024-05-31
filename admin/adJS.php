
<div id="myModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ADD ADMIN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
               <form method="POST" id="registrationForm">
                    <div class="mb-3">
                        <label for="AdminUsername" class="form-label">Admin Username</label>
                        <input type="text" autocomplete='off' name="AdminUsername" class="form-control" id="AdminUsername">
                    </div>
                    <div class="mb-3">
                        <label for='AdminPassword' class='form-label'>Password</label>
                        <input type='password' name='Password' class='form-control' id="AdminPassword">
                    </div>
                    <input type="hidden" value="admins" id="tablename" name="tablename">
                    <div class="mb-3">
                        <label for='AdminEmail' class='form-label'>Email</label>
                        <input type='email' name='AdminEmail' class="form-control" id="AdminEmail">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="addadmin()">Add</button>
            </div>
        </div>
    </div>
</div>

<script>

    
    async function addadmin() {
        const adminUsername = document.querySelector("#AdminUsername").value;
        const password = document.querySelector("#AdminPassword").value;
        const AdminEmail = document.querySelector('#AdminEmail').value;
        const tablename = document.querySelector('#tablename').value;
        // var usernamePattern = /^[a-zA-Z0-9_]{3,20}$/; // Alphanumeric, 3-20 characters
        //     var passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$#!%*?&])[A-Za-z\d@$#!%*?&]{8,}$/; // Minimum 8 characters, at least one letter, one number and one special character
        //     var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Simple email pattern
    
            // // Validate fields
            // if (!usernamePattern.test(adminUsername)) {
            //     alert("Invalid username. Please enter 3-20 alphanumeric characters.");
            //     return;
            // }
    
            // if (!passwordPattern.test(password)) {
            //     alert("Invalid password. Please enter at least 8 characters, including at least one letter, one number, and one special character.");
            //     return;
            // }
    
            // if (!emailPattern.test(AdminEmail)) {
            //     alert("Invalid email address.");
            //     return;
            // }
        // Construct the data object
        var data = {
            "tablename": tablename,
            "AdminUsername": adminUsername,
            "Password": password,
            "Email": AdminEmail
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
</script>