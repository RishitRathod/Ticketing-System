<?php
    include 'admin_headnav.php';
?>
        <div class="contentainer">
            <div class="d-inline-block">
                <form method="POST" id="registrationForm">
                    <div class="row justify-content-evenly">
                        <div class="col-auto mb-3">
                            <div class="modal-header">
                                <h5 class="modal-title">ADD ADMIN</h5>
                            </div>
                            <label for="AdminUsername" class="form-label">Admin Username</label>
                            <input type="text" autocomplete='off' name="AdminUsername" class="form-control mb-1" id="AdminUsername">
                            <label for='AdminEmail' class='form-label'>Email</label>
                            <input type='email' name='AdminEmail' class="form-control mb-1" id="AdminEmail">
                            <div class="password-container">
                                <label for='AdminPassword' class='form-label'>Password</label>
                                <input type='password' name='Password' class='form-control' id="AdminPassword">
                                <div id="eye" class="d-inline mb-1"><i class="fa fa-eye-slash"></i></div><span class="d-inline" style="font-size: 12px;"> Show Password</span>
                            </div>
                            <label for='ConfirmPass' class='form-label'>Confirm Password</label>
                            <input type="password" name="Password1" class="form-control mb-3" id="ConfirmPass">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="addadmin()">Add</button>
                    </div>
                </div>
                    <input type="hidden" value="admins" id="tablename" name="tablename">
            </div>

            <div class="d-inline-block" id="adminTable">
                <table class="table table-strip" id="packagesTable">
                    <thead>
                        <tr>
                            <th>Admin ID</th>
                            <th>Admin Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Table rows will be populated here -->
                    </tbody>
                </table>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script>
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

            
        </script>
<?php
    include 'adJS.php';
?>
<?php
    include 'admin_footer.php';
?>