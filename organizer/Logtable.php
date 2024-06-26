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
<div id="logT">
    <fieldset><legend>Attendees</legend>
    <table id="userEventTable" class="display table table-striped table-bordered ">
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
                <td><button class="btn btn-primary btn-sm" onclick="viewDetails(${row.UserID})">View Details</button></td>
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
    
</script>

</body>
</html>



<!-- <?php 
//include 'footer.php';
 ?>
</body>
</html> -->
