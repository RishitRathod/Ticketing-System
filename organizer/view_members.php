<?php
// include 'navhead.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event's Members</title>
    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <style>

        .container img{
            height: 100px;
            width: 100px;
        }
        .tagName{
            padding:5px;
            border-radius: 15px;
            margin-right: 3px;

            background-color: #2a0275;
            color:aliceblue; 
        }
        .tagDetails{
            margin: 5px;
            padding: 10px;
            border-radius: 20px;
            left:0;
            right:0;
            width:100%;
            min-width: 235px;
            background-color: #e0dee3;
        }
        .quan{
            margin: 5px;
            padding: 10px;
            border-radius: 20px;
            left:0;
            right:0;
            width:fit-content;
            min-width: 235px;
            background-color: #e0dee3;
        }

    </style>
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
            ticketElement.className = 'container';

            const ticketContent = `

                <div class="d-flex flex-column">
                    <div class="row justify-content-evenly d-flex flex-row"><h5 class="col-auto mx-auto">User</h5>
                        <div class="col-auto mx-auto">                        
                            <div class="card-text tagDetails"><strong class="tagName"> User Name </strong> ${user.Username}</div>
                        </div>
                        <div class="col-auto mx-auto">                        
                            <div class="card-text tagDetails"><strong class="tagName"> User Email </strong> ${user.Email}</div>
                            </div>
                        <div class="col-auto mx-auto">                        
                            <div class="card-text tagDetails"><strong class="tagName"> User Contact No. </strong> ${user.userphonenumber}</div>
                        </div>
                    </div>
                    <div class="row justify-content-evenly d-flex flex-row"> <h5>Ticket Details</h5>
                        <div class="col-auto justify-content-center">
                            <img src="${user.TicketQRCode}" class="col-auto mx-5" style="height:100px; width:100px;"alt="QR Code">
                            <div class="card-text quan"><strong class="tagName"> Quantity </strong> ${user.Quantity}</div>
                        </div>
                        <div class="col-auto">
                            <div class="card-text tagDetails"><strong class="tagName">Date </strong>${ new Date(user.EventDate).toLocaleDateString('en-GB')}</div>
                            <div class="card-text tagDetails"><strong class="tagName">Purchase Date </strong> ${ new Date(user.PurchaseDate).toLocaleDateString('en-GB')}</div>
                            <div class="card-text tagDetails"><strong class="tagName">Ticket Type </strong> ${user.TicketType}</div>
                        </div>
                        <div class="col-auto">                        
                        <div class="card-text col-auto tagDetails"><strong class="tagName"> Buyer </strong> ${user.BuyerName}</div>
                                <div class="card-text tagDetails"><strong class="tagName"> Buyer Email </strong> ${user.BuyerEmail}</div>
                            <div class="card-text tagDetails"><strong class="tagName"> Buyer Contact No. </strong> ${user.BuyerPhone}</div>


                        </div>
                        <div class="row m-1">                        

                        </div>
                    </div>
                    <div class="row"> 
                    <h5 class="col-auto fs-5 my-auto">Entry Data</h5>
                        <div class="col-5 mx-auto">                        
                            <div class="card-text tagDetails"><strong class="tagName">Entry Time </strong> ${user.EntryTime ? user.EntryTime : 'N/A' }</div>
                        </div>
                        <div class="col-5 mx-auto">                        
                            <div class="card-text tagDetails"><strong class="tagName"> Exit timed </strong> ${user.ExitTime ? user.ExitTime : 'N/A'}</div>
                        </div>
                    </div>
                </div>
                <!--    <img src="${user.UserPhoto}" class="img-fluid" alt="pfp"> -->
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
