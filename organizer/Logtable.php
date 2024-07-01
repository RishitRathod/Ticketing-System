<?php
include 'navhead.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Attendees</title>
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"> -->
    <style>
        /* Customize pagination buttons */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding:0.1rem 0.3rem ;
            margin: 0 0.1rem;
            border-radius: 0.25rem;
            border: 1px solid #dee2e6;
            background: #f8f9fa;
            color: #343a40;
            transition: background-color 0.2s, color 0.2s;
            text-decoration: none;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #343a40;
            color: #fff;
        }

        /* Customize selected pagination button */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            padding:0.1rem 0.5rem ;

            background: #007bff;
            color: #fff;
            border: 1px solid #007bff;
        }

        /* Customize the search box */
        .dataTables_wrapper .dataTables_filter input {
            margin-left: 0.5em;
            border-radius: 0.25rem;
            border: 1px solid #ced4da;
            background: #f8f9fa;
        }
        /* Customize the length select box */
        .dataTables_wrapper .dataTables_length select {
            border-radius: 0.25rem;
            border: 1px solid #ced4da;
            background: #f8f9fa;
        }
        #logT{
            opacity: 0;
        }
        .loader {
            display: block; 
            width: 50px;
            height: 50px;
            position: fixed;
            left: 50%;
            right: 50%;
            top: 50%;
            border: 8px solid #f9f9f9;
            border-top: 10px solid #010575;
            border-radius: 50px;
            /* transform: translate(-50%, -50%); */
            z-index: 999;
            animation: spin 0.5s linear infinite;
        }
        .tagName{
            padding: 0.5vmax;
            background-color: #00023c;
            color:aliceblue; 
        }
        .tagDetails{
            padding: 0.5vmax;
            background-color: #e0dee3;
            width: max-content;
            min-width: 200px;
        }
        #ut{
            opacity: 0;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>
<body>
<div class="loader">
        <i class="fa fa-3x fa-fw"></i><span class="sr-only">Loading...</span>
    </div>
<!-- <form id="eventForm">
    <label for="eventID">Event ID:</label>
    <input type="text" id="eventID" name="eventID" required>
    <button type="submit">Load Data</button>
</form> -->
<div id="logT" class="overflow-auto">
    <fieldset><legend>Attendees</legend>
    <table id="userEventTable" class="display table table-striped table-bordered table-responsive">
        <thead>
            <tr>
                <th>UserID</th>
                <th>Username</th>
                <th>Entry Time</th>
                <th>Exit Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be populated by JavaScript -->
        </tbody>
    </table>
    </fieldset>
    <div id="user-info" style="display:none; position:fixed; top:30%; left: 30%; right:25%; z-index:999;">
    
    </div>
</div>

<script>
    const eventID = <?php echo $_POST['id'] ?? 'null'; ?>;
    console.log(eventID);

document.addEventListener('DOMContentLoaded', function() {
    fetchAttendanceByEvent();
});

async function fetchAttendanceByEvent() {
    const response = await fetch('../fetchOrgs.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'AttendanceByEvent',
            EventID: eventID // Ensure eventID is defined or passed as a parameter
        })
    });
    const data = await response.json();
    console.log(data);

    if (data.status === 'success') {
        const userEventTable = document.querySelector("#userEventTable tbody");
        userEventTable.innerHTML = ''; // Clear existing table body

        data.data.forEach((row) => {
            const entryTime = row.EntryTime ? row.EntryTime : 'Not entered';
            const exitTime = row.ExitTime ? row.ExitTime : 'Not exited';

            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${row.UserID}</td>
                <td>${row.Username}</td>
                <td>${entryTime}</td>
                <td>${exitTime}</td>
                <td><button class="btn btn-primary btn-sm" onclick="displayUserData(${row.UserID})">View Details</button></td>
            `;
            userEventTable.appendChild(tr);
        });

        $('#userEventTable')
            .on('draw.dt', function () {
                console.log('Loading');
                showLoader();
                hideLoader();
            })
            .on('init.dt', function () {
                console.log('Loaded');
                hideLoader();
                spawn("#logT");
            })
            .DataTable({
                aLengthMenu: [
        [25, 50, 100, 200, -1],
        [25, 50, 100, 200, "All"]
    ],

                "pagingType": "full_numbers",
                "language": {
                    "paginate": {
                        "first": "<<",
                        "last": ">>",
                        "next": ">",
                        "previous": "<"
                    }
                },
                "columnDefs": [
                        {
                            "targets": 4, // Disable functionality for the 4th column (index 3)
                            // "targets": nonSortableColumnIndex,
                            "orderable": false, // Disable sorting
                        }
                    ]
            });
    } else {
        alert(data.message);
    }
}


function viewDetails(userID) {
    // Implement the logic to view details for the specified userID
    alert('View details for user: ' + userID);
}
    
function displayUserData(user) {
        const userInfoContainer = document.getElementById('user-info');
        userInfoContainer.style.display = "flex";
        UserID=user;
        userInfoContainer.innerHTML = `
            <div class="card" >
                <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="card-text"><strong>User Photo:</strong> ${user.UserPhoto ? '<img src="' + user.UserPhoto + '" style="height:100px !important; width:100px !important;  border:5px solid;   box-shadow:0 0 20px; border-radius:100px;   " alt="User Photo">' : 'No photo available'}</div>
                    </div>
                    <div class="col">
                    <h5 class="card-title">User Information</h5>
                        <div class="card-text tagDetails m-2 rounded-3"><strong class="tagName py-1 my-1 mr-4 rounded-3">UserID</strong> ${user.UserID}</div>
                        <div class="card-text tagDetails m-2 rounded-3"><strong class="tagName py-1 my-1 mr-4 rounded-3">Username</strong> ${user.Username}</div>
                    </div>
                    <div class="col">
                    <h5 class="card-title text-light">.     </h5>
                        <div class="card-text tagDetails m-2 rounded-3"><strong class="tagName py-1 my-1 mr-4 rounded-3">Email</strong> ${user.Email}</div>
                        <div class="card-text tagDetails m-2 rounded-3"><strong class="tagName py-1 my-1 mr-4 rounded-3">Phone Number</strong> ${user.userphonenumber}</div>
                    </div>
                </div>
                </div>
                <div class="card-footer align-items-end"> <button class="btn btn-danger"onclick="hideData()">Close</button></div>
            </div>
        `;
    }
function hideData(){
    const abc = document.getElementById('user-info');
    abc.style.display = "none";

}
</script>

</body>
</html>



 <?php 
    include 'footer.php';
 ?>
<!-- </body>
</html>  -->
