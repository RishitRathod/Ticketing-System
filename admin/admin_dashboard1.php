<head>
    <title>Dashboard</title>
    <style>
        /* .loader {
            display: none; 
            width: 70px;
            height: 70px;
            position: fixed;
            left: 50%;
            right: 50%;
            top: 50%;
            border: 12px solid #f9f9f9;
            border-top: 10px solid #8341fe;
            border-radius: 50px;
            transform: translate(-50%, -50%);
            z-index: 999;
            animation: spin 0.5s linear infinite;
        } */
        #a{
            opacity: 0;
        }
        #b{
            opacity: 0;
        }
        #c{
            opacity: 0;
        }
    </style>
</head>
<?php
include 'admin_headnav.php';
?>

<form id="viewOrganizationForm" action="view_organization.php" method="post" style="display: none;">
    <input type="hidden" name="OrgID">
</form>

<form id="viewEventForm" action="view_event.php" method="post" style="display: none;">
    <input type="hidden" name="EventID">
</form>

<form id="viewUserForm" action="view_user.php" method="post" style="display: none;">
    <input type="hidden" name="UserID">
</form>
<!-- <div class="loader">
    <i class="fa fa-3x fa-fw"></i><span class="sr-only">Loading...</span>
</div> -->
<div id="selectionButtonGroup" class="container d-block row mt-2">
    <div class="btn-group m-2 " id="gB" role="group" aria-label="Basic example">
        <button type="button" id="organizations" value="organizations" class="btn themecol no-sort" onclick="orgonly(this)">Organizations</button>
        <button type="button" value="events" class="btn themecol" onclick="eventonly(this)">Events</button>
        <button type="button" value="users" class="btn themecol" onclick="useronly(this)">Users</button>
    </div>

</div>
<div id="a" style="display: block;">
    <div class="container table-responsive mt-2" id="orgDiv">
        <h2 align="center">Organizations</h2>
        <table id="orgTable" class="table table-striped table-bordered" style="width:100%; ">
            <thead style="width:100%;">
                <tr>
                    <th>Sr. No</th>
                    <th>Name</th>
                    <th>Contact Number</th>
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
    <div class="container table-responsive mt-2 mx-auto " id="eventDiv">
        <h2 align="center">Events</h2>
        <table id="eventTable" class="table table-striped table-bordered " style="width:100%;">
            <thead style="width:100%;">
                <tr>
                    <th>Sr. No</th>
                    <th>Event Name</th>
                    <th>Organization Name</th>
                    <th>Event Time</th>
                    <th>Location:City</th>
                    <th>Event Type</th>
                    <th>View Details</th>
                </tr>
            </thead>
            <tbody id="eventTableBody">
                <!-- Events will be dynamically populated here -->
            </tbody>
        </table>
    </div>
</div>
<div id="c" style="display: none;">
<div class="container table-responsive mt-2 mx-auto" id="userDiv">
        <h2 align="center">Users</h2>
        <table id="userTable" class="table table-striped table-bordered" style="width:100%; background-color: white;">
            <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>User Photo</th>
                    <th>View Details</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <!-- Users will be dynamically populated here -->
            </tbody>
        </table>
    </div>

</div>

<script>
    
    document.addEventListener("DOMContentLoaded", async function() {
        var button = document.getElementById("organizations");
        button.classList.add("active-button");
        showLoader();
        const data = await fetchData('organizations');
        populateTable(data, 'organizations');
        hideLoader();
    });

    function showLoader() {
        document.querySelector('.loader').style.display = 'block';
    }

    function hideLoader() {
        document.querySelector('.loader').style.display = 'none';
    }

    function spawn(id){
        document.querySelector(id).style.opacity = "1";
    }
    let con1, con2 = true;
    let con3 = true;
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    window.onload = function () {
        document.querySelector('#eventTable').style.display = 'block';
        document.querySelector('#userTable').style.display = 'block';
        document.querySelector('#orgTable').style.display = 'block';
    };
        
    function updateButtonStyles(clickedButton) {
            const buttons = document.querySelectorAll('.btn.themecol');
            buttons.forEach(button => {
                button.classList.remove('active-button');
            });
            clickedButton.classList.add('active-button');
    }
    
    function orgonly(button) {
        document.getElementById('a').style.display = 'block';
        document.getElementById('b').style.display = 'none';
        document.getElementById('c').style.display = 'none';
        updateButtonStyles(button);
        if(con1){
            showLoader();
            con1=false;
        }
    }

    function useronly(button) {
        document.getElementById('a').style.display = 'none';
        document.getElementById('b').style.display = 'none';
        document.getElementById('c').style.display = 'block';
        updateButtonStyles(button);
        if(con2){
            showLoader();
            con2=false;
        }

    }

    function eventonly(button) {
        document.getElementById('a').style.display = 'none';
        document.getElementById('b').style.display = 'block';
        document.getElementById('c').style.display = 'none';
        updateButtonStyles(button);
        if(con3){
            showLoader();
            con3=false;
        }
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
            hideLoader();
        });
    });

    async function fetchData(tableName) {
        const response = await fetch("admin_dashboard.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ tablename: tableName, action: 'fetch' }),
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
data.forEach((row, index) => {
    const tr = document.createElement('tr');
    console.log(row);
    if (tableName === 'organizations') {
        tr.innerHTML = `
            <td>${index + 1}</td>
            <td>${row.Name}</td>
            <td>${row.ContactNumber}</td>
            <td>${row.Status}</td>
            <td>
                <button type="button" id="tooltip" class="btn btn-outline-success border-3 acBtn ${(row.Status === "Approved") ? 'd-none' : ''} approve-btn" data-id="${row.OrgID}" data-table="${tableName}">
                    <span id="tooltiptext" class="p-1 rounded-3">Approve</span>
                </button>
                <button type="button" id="tooltip" class="btn btn-outline-danger border-3 acBtn ${((row.Status === "Approved" || row.Status === "Rejected")) ? 'd-none' : ''} reject-btn" data-id="${row.OrgID}" data-table="${tableName}">
                </button>
                <button type="button" id="tooltip" class="btn btn-outline-primary border-3 acBtn inf view-btn" data-id="${row.OrgID}" data-table="${tableName}">
                    <span id="tooltiptext" class="p-1 rounded-3">View Details</span>
                </button>
            </td>
        `;
    } else if (tableName === 'events') {
        tr.innerHTML = `
            <td>${index + 1}</td>
            <td>${row.EventName}</td>
            <td>${row.Name}</td>
            <td>${new Date(row.StartDate).toLocaleDateString('en-GB')} - ${new Date(row.EndDate).toLocaleDateString('en-GB')}</td>
            <td>${row.City}</td>
            <td>${row.EventType}</td>
            <td><button class="btn btn-primary fs-6 view-btn in" data-id="${row.EventID}" data-table="${tableName}"><i class="fa fa-regular fa-info mr-1"></i> View Details</button></td>
        `;
    } else if (tableName === 'users') {
        tr.innerHTML = `
            <td>${index + 1}</td>
            <td>${row.Username}</td>
            <td>${row.Email}</td>
            <td><img src="${row.UserPhoto}" alt="User Photo" width="50"></td>
            <td><button class="btn btn-primary view-btn in" data-id="${row.UserID}" data-table="${tableName}"><i class="fa fa-regular fa-info mr-1"></i> View Details</button></td>
        `;
    }
    tbody.appendChild(tr);
});




        let tableId, tableId2, tableId3;

if (tableName === 'organizations') {
    tableId2 = 'orgTable';
} else if (tableName === 'events') {
    tableId = 'eventTable';
} else if (tableName === 'users') {
    tableId3 = 'userTable';
}

if (tableId) {
    const numColumns = $(`#${tableId} thead th`).length; // Get the number of columns
    const columnWidth = (1 * numColumns) / 100 + '%';

    $(`#${tableId}`)
    .on('draw.dt', function () {
            console.log('Loading');
            // $('.loader').show();
            showLoader();
            hideLoader();
        })
        .on('init.dt', function () {
            console.log('Loaded');
            // $('.loader').hide();
            hideLoader();
            spawn("#b");
        })
        .DataTable({
        //    "ServerSide": true,

        "processing": true,
        "retrieve": true,
          "responsive": true,
            "autoWidth": false, // Disable automatic column width calculation
            "destroy": true, // Added to reinitialize DataTable
        "columnDefs": [
            { 
                "width": columnWidth, 
                "targets": "_all",
            },
            {
                "targets": 6, // Disable functionality for the 6th column (index 5)
                "orderable": false, // Disable sorting
            },
        ], 
        // "language": {
        //             "processing": "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Loading..."
        //         }
    });
}

if (tableId2) {
    const numColumns = $(`#${tableId2} thead th`).length; // Get the number of columns
    const columnWidth = (1 * numColumns) / 100 + '%';

    $(`#${tableId2}`)
    .on('draw.dt', function () {
            console.log('Loading');
            // $('.loader').show();
            showLoader();
            hideLoader();
        })
        .on('init.dt', function () {
            console.log('Loaded');
            // $('.loader').hide();
            hideLoader();
            spawn("#a");

        })
        .DataTable({
        
        "processing": true,
        "retrieve": true,
       // "ServerSide": true,

        "responsive": true,
        "autoWidth": false, // Disable automatic column width calculation
        "destroy": true, // Added to reinitialize DataTable
        "columnDefs": [
            { 
                "width": columnWidth, 
                "targets": "_all",
            },
            {
                "targets": 4, // Disable functionality for the 4th column (index 3)
                "orderable": false, // Disable sorting
            }
        ],
        // "language": {
        //             "processing": "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Loading..."
        //         }
    });
}

if (tableId3) {
    
    const numColumns = $(`#${tableId3} thead th`).length; // Get the number of columns
    const columnWidth = (1 * numColumns) / 100 + '%';

    $(`#${tableId3}`) 
    .on('draw.dt', function () {
            console.log('Loading');
            // $('.loader').show();
            showLoader();
            hideLoader();

        })
        .on('init.dt', function () {
            console.log('Loaded');
            // $('.loader').hide();
            hideLoader();
            spawn("#c");

        })
        .DataTable({
       
        "processing": true,
        "retrieve": true,
        //"ServerSide": true,
        "responsive": true,
        "autoWidth": false, // Disable automatic column width calculation
        "destroy": true, // Added to reinitialize DataTable
        "columnDefs": [
            { 
                "width": columnWidth, 
                "targets": "_all",
            },
            {
                "targets": 4, // Disable functionality for the 4th column (index 3)
                // "targets": nonSortableColumnIndex,
                "orderable": false, // Disable sorting
            }
        ]
        // "language": {
        //             "processing": "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Loading..."
        //         }
                
    });
}

        // const tableId = tableName === 'organizations' ? 'orgTable' : tableName === 'events' ? 'eventTable' : 'userTable';
        // $(`#${tableId}`).DataTable({
        //     "responsive": true,
        //     "autoWidth": false, // Disable automatic column width calculation
        //     "destroy": true, // Added to reinitialize DataTable
        //     "columnDefs": [{ "width": "100%", "targets":  }] // Set the width of the first column to 100%
        // });
        // const dataTable = $(`#${tableId}`).DataTable();
        // const tableElement = $(dataTable.table().container());
        // tableElement.css('width', '100%');
        // // Get the width of the table
        // let tableWidth = tableElement.width();
        // // Log the width to the console or use it as needed
        // console.log('Table Width:', tableWidth);
    }

    // Handle approve and reject buttons for organizations table
    document.addEventListener('click', async function (event) {
        if (event.target.classList.contains('approve-btn')) {
        showLoader();
        const orgID = event.target.getAttribute('data-id');
        const tableName = event.target.getAttribute('data-table');
        await approveOrganization(orgID, tableName);
        const data = await fetchData(tableName);
        $('#orgTable').DataTable().clear().draw();
        populateTable(data, tableName);
        hideLoader();
    } else if (event.target.classList.contains('reject-btn')) {
        showLoader();
        const orgID = event.target.getAttribute('data-id');
        const tableName = event.target.getAttribute('data-table');
        await rejectOrganization(orgID, tableName);
        const data = await fetchData(tableName);
        $('#orgTable').DataTable().clear().draw();
        populateTable(data, tableName);
        hideLoader();
    }    else if (event.target.classList.contains('view-btn')) {
            const orgID = event.target.getAttribute('data-id');
            const tableName = event.target.getAttribute('data-table');

            viewDetails(orgID, tableName);
        }

    });

    async function approveOrganization(orgID, tableName) {
        const response = await fetch("admin_dashboard.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ tablename: tableName, action: 'approve', 'columnName': "orgID", 'columnValue': orgID }),
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
                body: JSON.stringify({ tablename: tableName, action: 'reject', 'columnName': "orgID", 'columnValue': orgID, reason: reason }),
            });

            const result = await response.json();
            if (result.status === 'success') {
                // Refresh the table
                const data = await fetchData(tableName);
                populateTable(data, tableName);
            } else {
                console.error('Error:', result.message);
            }
        }else{
            alert("Enter a reason...!");
            rejectOrganization(orgID, tableName);
        }
    }

    //async function to view details of organizations, events and users on diffrent page
    function viewDetails(id, tableName) {
        let form;
        if (tableName === 'organizations') {
            form = document.getElementById('viewOrganizationForm');
            form.elements.OrgID.value = id;
        } else if (tableName === 'events') {

            form = document.getElementById('viewEventForm');
            form.elements.EventID.value = id;
        } else if (tableName === 'users') {
            form = document.getElementById('viewUserForm');
            form.elements.UserID.value = id;
        }

        form.submit();
    }
    // Handle view buttons for organizations, events, and users table
document.addEventListener('click', async function (event) {
    if (event.target.classList.contains('view-btn')) {
        showLoader();
        const id = event.target.getAttribute('data-id');
        const tableName = event.target.getAttribute('data-table');
        await viewDetails(id, tableName);
        hideLoader();
    }
});

//     $(document).ready(function() {
//     $('#orgTable').DataTable({
//         "columnDefs": [
//             {
//                 "targets": 3,   // Disable functionality for the 4th column (index 3)
//                 "orderable": false,  // Disable sorting
//                 // "searchable": false  // Disable searching
//             }
//         ]
//     });
// });
</script>
<?php
include 'admin_footer.php';
?>