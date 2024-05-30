<?php
    include 'navhead.php';
?>
<!-- The Main buttons come here -->
<div id="c" >
    <div class="container mt-5" id="eventDiv">
        <h2>Events</h2>
        <table id="eventTable" class="table table-responsive table-bordered">
            <thead>
                <tr>
                    <th>Event Name</th>
                 
           
                    <th>Event Time</th> <!-- both Start date and end date and time slots  -->
                    <th>Event Location</th>  
                
                    <th>Event type</th>
                    <th>Event poster</th>
                    <th>view Details</th>
                </tr>
            </thead>
            <tbody id="eventTableBody">
                <!-- Events will be dynamically populated here -->
            </tbody>
        </table>
    </div>
</div>

<!-- Include DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    async function fetchData(tableName) {
        const response = await fetch("../admin/admin_dashboard.php", {
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

    async function initialize() {
        var value = 'events';
        const data = await fetchData(value);
        populateTable(data, value);
    }

    function populateTable(data, tableName) {
        let tbody = document.querySelector('#eventTableBody');
     
        if (!Array.isArray(data)) {
            console.error('Expected an array but got:', data);
            return;
        }

        tbody.innerHTML = '';
        data.forEach((row) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
              
                <td>${row.EventName}</td>
             
                <td>${row.StartDate} - ${row.EndDate}</td>
                <td>${row.VenueAddress}</td>
               
                <td>${row.EventType}</td>
                <td><img src="../${row.EventPoster}" alt="Event Poster" height="50" width="50"></td>
                <td><a href="show_events.php"><button>view details</button></a></td>
            `;
            tbody.appendChild(tr);
        });

        // Initialize DataTable for the specific table
        $('#eventTable').DataTable();
    }

    window.onload = initialize;
</script>

<?php
    include 'footer.php';
?>
