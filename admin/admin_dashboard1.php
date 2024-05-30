<?php
    include 'admin_headnav.php';
?>

    <div id="selectionButtonGroup" class="container d-block row mt-5">
        <div class="btn-group stic m-2" id="gB"role="group" aria-label="Basic example">
            <button type="button" aria-selected="true" value="organizations" class="btn btn-outline-primary" onclick="orgonly()">Organizations</button>
            <button type="button" value="events" class="btn btn-outline-secondary" onclick="eventonly()">Events</button>
            <button type="button" value="users" class="btn btn-outline-info" onclick="useronly()">Users</button>
        </div>      
    </div>
    <div class="row justify-content-evenly">
        <div class="container col-4 mt-5" id="addPackageBtn">
            <!-- <button type="button" class="btn btn-primary" onclick="window.location.href='add_package.php'">Add Package</button> -->
        </div>
        <div class="col-4 mt-5">
            <!-- Button HTML (to Trigger Modal) -->
            <!-- <a href="#myModal" role="button" class="btn btn-primary" data-bs-toggle="modal">ADD ADMIN</a> -->
        
            <!-- Modal HTML -->
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
        </div>
    </div>
    <div id="a" style="display: none;">
        <div class="container mt-5 " id="orgDiv">
            <h2>Organizations</h2>
            <table id="orgTable" class="table table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact Number</th>
                        <th>Contact Email</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="orgTableBody">
                    <!-- Organizations will be dynamically populated here -->
                </tbody>
            </table>
        </div>
        
    </div>
    <div id="b" style="display: none;">
        <div class="container mt-5" id="userDiv">
            <h2>Users</h2>
            <table id="userTable" class="table table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>User Photo</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    <!-- Users will be dynamically populated here -->
                </tbody>
            </table>
        </div>
        
    </div>
    <div id="c" style="display: none;">
        <div class="container mt-5" id="eventDiv">
            <h2>Events</h2>
            <table id="eventTable" class="table table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Event Name</th>
                        <th>Event Description</th>
                        <th>Organization Name</th>
                        <th>Event Time</th> <!-- both Start date and end date and time slots  -->
                        <th>Event Location</th>  
                        <th>Event Capacity</th>
                        <th>Event type</th>
                        <th>Event poster</th>
                    </tr>
                </thead>
                <tbody id="eventTableBody">
                    <!-- Events will be dynamically populated here -->
                </tbody>
            </table>
        </div>
        
    </div>
 

    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>

        window.onload = function() {
            document.querySelector('#eventTable').style.display = 'block';
            document.querySelector('#userTable').style.display = 'block';
            document.querySelector('#orgTable').style.display = 'block';
        };
        function orgonly()
        {
            document.getElementById('a').style.display = 'block';
            document.getElementById('b').style.display = 'none';
            document.getElementById('c').style.display = 'none';
        }
        function useronly()
        {
            document.getElementById('a').style.display = 'none';
            document.getElementById('b').style.display = 'block';
            document.getElementById('c').style.display = 'none';
        }
        function eventonly()
        {
            document.getElementById('a').style.display = 'none';
            document.getElementById('b').style.display = 'none';
            document.getElementById('c').style.display = 'block';
        }

        let currentTableName = '';

        document.querySelectorAll('.btn-group .btn').forEach((button) => {
            button.addEventListener('click', async (event) => {
                // Hide all tables
                document.querySelectorAll('.container .table').forEach((table) => {
                    table.style.display = 'none';
                });

                // Show the table that corresponds to the button that was clicked
                const value = event.target.value;
                currentTableName = value;

                // Show and populate the selected table
                let tableBody;
                if (value === 'organizations') {
                    tableBody = document.querySelector('#orgTableBody');
                    document.querySelector('#orgTable').style.display = 'block';
                    document.querySelector('#eventTable').style.display = 'none';
                    document.querySelector('#userTable').style.display = 'none';
                } else if (value === 'events') {
                    tableBody = document.querySelector('#eventTableBody');
                    document.querySelector('#eventTable').style.display = 'block';
                    document.querySelector('#orgTable').style.display = 'none';
                    document.querySelector('#userTable').style.display = 'none';
                } else if (value === 'users') {
                    tableBody = document.querySelector('#userTableBody');
                    document.querySelector('#userTable').style.display = 'block';
                    document.querySelector('#orgTable').style.display = 'none';
                    document.querySelector('#eventTable').style.display = 'none';
                }

                const data = await fetchData(value);
                populateTable(data, value);
            });
        });

        async function fetchData(tableName) {
            const response = await fetch("../admin/admin_dashboard.php", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({tablename: tableName, action: 'fetch'}),
            });

            const result = await response.json();
            if (result.status === 'success') {
                return result.data;
            } else {
                console.error('Error:', result.message);
                return [];
            }
        }

        function populateTable(data, tableName) {
            let tbody;
            if (tableName === 'organizations') {
                tbody = document.querySelector('#orgTableBody');
            } else if (tableName === 'events') {
                tbody = document.querySelector('#eventTableBody');
            } else if (tableName === 'users') {
                tbody = document.querySelector('#userTableBody');
            }

            if (!Array.isArray(data)) {
                console.error('Expected an array but got:', data);
                return;
            }

            tbody.innerHTML = '';
            data.forEach((row) => {
                const tr = document.createElement('tr');
                if (tableName === 'organizations') {
                    tr.innerHTML = `
                        <td>${row.OrgID}</td>
                        <td>${row.Name}</td>
                        <td>${row.Email}</td>   
                        <td>${row.ContactNumber}</td>
                        <td>${row.ContactEmail}</td>
                        <td>${row.Address}</td>
                        <td>${row.Status}</td>
                        <td>
                            <button class="btn btn-success approve-btn" data-id="${row.OrgID}" data-table="${tableName}">Approve</button>
                            <button class="btn btn-danger reject-btn" data-id="${row.OrgID}" data-table="${tableName}">Reject</button>
                        </td>
                    `;
                } else if (tableName === 'events') {
                    tr.innerHTML = `
                        <td>${row.EventID}</td>
                        <td>${row.EventName}</td>
                        <td>${row.Description}</td>
                        <td>${row.OrgID}</td>
                        <td>${row.StartDate} - ${row.EndDate}</td>
                        <td>${row.VenueAddress}</td>
                        <td>${row.Capacity}</td>
                        <td>${row.EventType}</td>
                        <td><img src="../${row.EventPoster}" alt="Event Poster" height="50" width="50"></td>
                    `;
                } else if (tableName === 'users') {
                    tr.innerHTML = `
                        <td>${row.UserID}</td>
                        <td>${row.Username}</td>
                        <td>${row.Email}</td>
                        <td><img src="../${row.UserPhoto}" alt="User Photo" width="50"></td>
                    `;
                }
                tbody.appendChild(tr);
            });

            // Initialize DataTable for the specific table
            $(`#${tableName === 'organizations' ? 'orgTable' : tableName === 'events' ? 'eventTable' : 'userTable'}`).DataTable();
        }

        // Handle approve and reject buttons for organizations table
        document.addEventListener('click', async function(event) {
            if (event.target.classList.contains('approve-btn')) {
                const orgID = event.target.getAttribute('data-id');
                const tableName = event.target.getAttribute('data-table');
                await approveOrganization(orgID, tableName);
            } else if (event.target.classList.contains('reject-btn')) {
                const orgID = event.target.getAttribute('data-id');
                const tableName = event.target.getAttribute('data-table');
                await rejectOrganization(orgID, tableName);
            }
        });

        async function approveOrganization(orgID, tableName) {
            const response = await fetch("admin_dashboard.php", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({tablename: tableName, action: 'approve', 'columnName': "orgID", 'columnValue': orgID}),
            });

            const result = await response.json();
            if (result.status === 'success') {
                // Refresh the table
                const data = await fetchData(tableName);
                populateTable(data, tableName);
            } else {
                console.error('Error:', result.message);
            }
        }

        async function rejectOrganization(orgID, tableName) {
            const reason = prompt("Enter reason for rejection:");
            if (reason) {
                const response = await fetch("admin_dashboard.php", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({tablename: tableName, action: 'reject', 'columnName': "orgID", 'columnValue': orgID, reason: reason}),
                });

                const result = await response.json();
                if (result.status === 'success') {
                    // Refresh the table
                    const data = await fetchData(tableName);
                    populateTable(data, tableName);
                } else {
                    console.error('Error:', result.message);
                }
            }
        }

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
<?php
    include 'admin_footer.php';
?>
