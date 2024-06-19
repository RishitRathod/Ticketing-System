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
        <div id="allUser">
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
            showUsers(data);
            // console.log(data);
            // populateEvents(data);
        }

        function showUsers(users){
            const ticketsContainer = document.getElementById('allUser');
            ticketsContainer.innerHTML = ''; // Clear previous tickets  
            users.forEach(user => {
            const ticketElement = document.createElement('div');
            ticketElement.className = 'col-md-4';

            const ticketContent = `
                <div class="ticket card tic">
                    <div class="card-body row g-0">
                    <h4 class="card-title col my-auto"> ${user.EventName}</h4>
                    <div class="col">
                            <img src="${user.QR_CODE}" class="img-fluid float-md-end float-md-top " alt="QR Code">
                    </div>
                    <div class="row"> 
                        <div class="row">                        
                            <div class="card-text"><strong>Date: </strong>${user.EventDate}</div>
                            <div class="card-text"><strong>Purchase Date: </strong> ${user.PurchaseDate}</div>
                        </div>
                        <div class="row ">                        
                                <div class="card-text"><strong>Ticket Type: </strong> ${user.TicketType}</div>
                                <div class="card-text"><strong> Quantity: </strong> ${user.Quantity}</div>
                        </div>
    
                    </div>
                    </div>
                </div>
            `;
            ticketElement.innerHTML = ticketContent;
            ticketsContainer.appendChild(ticketElement);
        });
        }
        
        
        window.onload = initialize;

    </script>

    <?php include 'footer.php'; ?>
</body>
</html>
