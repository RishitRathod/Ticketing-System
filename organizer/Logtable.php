<?php
include 'navhead.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Event Attendance</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>
<body>

<!-- <form id="eventForm">
    <label for="eventID">Event ID:</label>
    <input type="text" id="eventID" name="eventID" required>
    <button type="submit">Load Data</button>
</form> -->

<table id="userEventTable" class="display">
    <thead>
        <tr>
            <th>UserID</th>
            <th>Username</th>
            <th>Entry Time</th>
            <th>Exit Time</th>
            <th>View Details</th>
        </tr>
    </thead>
    <tbody>
        <!-- Data will be populated by JavaScript -->
    </tbody>
</table>

<script>
    const eventID = <?php echo $_POST['id'] ?? 'null'; ?>;
    console.log(eventID);

document.addEventListener('DOMContentLoaded', function() {
    fetchAttendanceByEvent();
});

function fetchAttendanceByEvent() {
    fetch('../fetchOrgs.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'AttendanceByEvent',
            EventID: eventID // Ensure eventID is defined or passed as a parameter
        })
    }).then(response => response.json())
    .then(data => {
        console.log(data);
        if (data.status === 'success') {
            const table = $('#userEventTable').DataTable();
            table.clear();
            data = data.data;
            data.forEach(row => {
                const entryTime = row.EntryTime ? row.EntryTime : 'Not entered';
                const exitTime = row.ExitTime ? row.ExitTime : 'Not exited';

                table.row.add([
                    row.UserID,
                    row.Username,
                    entryTime,
                    exitTime,
                    `<button onclick="viewDetails(${row.UserID})">View Details</button>`
                ]).draw();
            });

        } else {
            alert(data.message);
        }
    });
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
