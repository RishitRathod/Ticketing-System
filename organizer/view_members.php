<?php
// include 'navhead.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Ticketing System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  
</head>
<body>
    <?php include 'navhead.php'; ?>

    <!-- Main Content -->
    <div id="eventsContainer">
        <h2 class="py-2">Events</h2>
        <div id="eventsRow">
            <!-- Event cards will be dynamically populated here -->
        </div>
    </div>


    <script src="../script.js"></script>
    <script>
     
        async function fetchData() {
            try {

                const EventID =  <?php  echo $_POST['eventID'];?>;
                console.log(EventID);
                const response = await fetch("../fetchOrgs.php", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({action:'AttendanceByEvent', EventID: EventID }),
                });

                const result = await response.json();
                if (result.status === 'success') {
                    console.log(result.data);
                    return result.data;
                } else {
                    console.error('Error:', result.message);
                    return [];
                }
            } catch (error) {
                console.error('Error fetching data:', error);
                return [];
            }
        }

        async function initialize() {
   
            const data = await fetchData();
            // console.log(data);
            // populateEvents(data);
        }

        
        window.onload = initialize;

    </script>

    <?php include 'footer.php'; ?>
</body>
</html>
