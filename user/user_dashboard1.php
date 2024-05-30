<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CSS -->
    <style>
        body{
            background-color: #ffffff;
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
        @media (max-width: 768px) {
            .dropdown.open {
                width: 100%;
                text-align: center;
            }
        }
        .main-content {
            border: 1px solid #ccc;
            border-radius: 5px;
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }
        .stic {
            position: sticky;
            top: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid w-100 container-sm p-3 bg-dark text-white">
        <div class="row align-items-center">
            <a class="col-auto me-auto p-3 ml-3 mr-auto" href="./admin_dashboard.php" style="text-decoration: none;">
                <img src="../img/logo.png" height="60" class="rounded-circle" alt="Logo">
                <b class="h5 ml-2 text-light text-decoration-none">The Admins</b>
            </a>  
            <div class="col-sm-auto col-3">
                <div class="dropdown open p-3 rounded-pills">
                    <button class="btn rounded-pill dropdown-toggle" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
            <div class="bg-dark col-auto col-xl-2 col-md-4 col-lg-3 min-vh-100 d-flex flex-column justify-content-between">
                <div class="bg-dark p-2">
                    <ul class="nav nav-pills flex-column" id="parentDiv">
                        <li class="nav-item py-2">
                            <a href="./admin_dashboard1.php" class="nav-link text-white"> 
                                <i class="fs-5 fa fa-tachometer"></i> <span class="fs-5 ms-3 d-none d-sm-inline">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item py-2">
                            <a href="#myModal" role="button" class="nav-link text-white" data-bs-toggle="modal">
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
            <div class="col p-3">
                <div class="main-content mx-auto justify-content-center align-items-center">
                    <?php include 'admin_headnav.php'; ?>

                    <div id="selectionButtonGroup" class="container d-block row mt-5">
                        <div class="btn-group stic m-2" id="gB" role="group" aria-label="Basic example">
                            <button type="button" aria-selected="true" value="organizations" class="btn btn-outline-primary" onclick="orgonly()">Organizations</button>
                            <button type="button" value="events" class="btn btn-outline-secondary" onclick="eventonly()">Events</button>
                            <button type="button" value="users" class="btn btn-outline-info" onclick="useronly()">Users</button>
                        </div>      
                    </div>
                    <div class="row justify-content-evenly">
                        <div class="container col-4 mt-5" id="addPackageBtn"></div>
                        <div class="col-4 mt-5">
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
                                            </form>
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
                        <div class="container mt-5" id="orgDiv">
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
                                        <th>User ID</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Created At</th>
                                        <th>Status</th>
                                        <th>Actions</th>
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
                                        <th>Event ID</th>
                                        <th>Event Name</th>
                                        <th>Event Type</th>
                                        <th>Organizer</th>
                                        <th>Date</th>
                                        <th>Venue</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="eventTableBody">
                                    <!-- Events will be dynamically populated here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#orgTable').DataTable();
            $('#userTable').DataTable();
            $('#eventTable').DataTable();

            $('#selectionButtonGroup button').on('click', function() {
                $('#selectionButtonGroup button').removeClass('active');
                $(this).addClass('active');

                var selectedValue = $(this).val();
                $('#a, #b, #c').hide();
                if (selectedValue === 'organizations') {
                    $('#a').show();
                    populateTable('organizations');
                } else if (selectedValue === 'events') {
                    $('#c').show();
                    populateTable('events');
                } else if (selectedValue === 'users') {
                    $('#b').show();
                    populateTable('users');
                }
            });

            $('#registrationForm').on('submit', function(event) {
                event.preventDefault();
                addadmin();
            });
        });

        function populateTable(tableType) {
            let endpoint;
            switch(tableType) {
                case 'organizations':
                    endpoint = 'fetch_organizations.php';
                    break;
                case 'users':
                    endpoint = 'fetch_users.php';
                    break;
                case 'events':
                    endpoint = 'fetch_events.php';
                    break;
                default:
                    return;
            }

            fetch(endpoint)
                .then(response => response.json())
                .then(data => {
                    let tableBody;
                    switch(tableType) {
                        case 'organizations':
                            tableBody = $('#orgTableBody');
                            tableBody.empty();
                            data.forEach(org => {
                                tableBody.append(`<tr>
                                    <td>${org.id}</td>
                                    <td>${org.name}</td>
                                    <td>${org.email}</td>
                                    <td>${org.contact_number}</td>
                                    <td>${org.contact_email}</td>
                                    <td>${org.address}</td>
                                    <td>${org.status}</td>
                                    <td><button onclick="approve('${org.id}', 'organizations')" class="btn btn-success">Approve</button> <button onclick="reject('${org.id}', 'organizations')" class="btn btn-danger">Reject</button></td>
                                </tr>`);
                            });
                            break;
                        case 'users':
                            tableBody = $('#userTableBody');
                            tableBody.empty();
                            data.forEach(user => {
                                tableBody.append(`<tr>
                                    <td>${user.user_id}</td>
                                    <td>${user.username}</td>
                                    <td>${user.email}</td>
                                    <td>${user.role}</td>
                                    <td>${user.created_at}</td>
                                    <td>${user.status}</td>
                                    <td><button onclick="approve('${user.user_id}', 'users')" class="btn btn-success">Approve</button> <button onclick="reject('${user.user_id}', 'users')" class="btn btn-danger">Reject</button></td>
                                </tr>`);
                            });
                            break;
                        case 'events':
                            tableBody = $('#eventTableBody');
                            tableBody.empty();
                            data.forEach(event => {
                                tableBody.append(`<tr>
                                    <td>${event.event_id}</td>
                                    <td>${event.event_name}</td>
                                    <td>${event.event_type}</td>
                                    <td>${event.organizer}</td>
                                    <td>${event.date}</td>
                                    <td>${event.venue}</td>
                                    <td>${event.status}</td>
                                    <td><button onclick="approve('${event.event_id}', 'events')" class="btn btn-success">Approve</button> <button onclick="reject('${event.event_id}', 'events')" class="btn btn-danger">Reject</button></td>
                                </tr>`);
                            });
                            break;
                    }
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        function addadmin() {
            const formData = new FormData(document.getElementById('registrationForm'));
            fetch('add_admin.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    alert('Admin added successfully');
                    $('#myModal').modal('hide');
                    document.getElementById('registrationForm').reset();
                } else {
                    alert('Error adding admin');
                }
            })
            .catch(error => console.error('Error adding admin:', error));
        }

        function approve(id, type) {
            fetch('approve.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({id: id, type: type})
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    alert('Approved successfully');
                    populateTable(type);
                } else {
                    alert('Error approving');
                }
            })
            .catch(error => console.error('Error approving:', error));
        }

        function reject(id, type) {
            fetch('reject.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({id: id, type: type})
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    alert('Rejected successfully');
                    populateTable(type);
                } else {
                    alert('Error rejecting');
                }
            })
            .catch(error => console.error('Error rejecting:', error));
        }
    </script>
</body>
</html>
