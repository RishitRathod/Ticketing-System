<?php
include 'userdashnav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tickets</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .ticket {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 15px;
        }
        .tic{
            background: linear-gradient(to right bottom, #020ff725,#f7020225);
        }
        .ticket img {
            max-width: 100px;
        }
        .beg{
            margin-top: 150px;
        }
    </style>
</head>
<body class="beg">
    <div class="container mt-5">
        <h1 class="text-center">My Tickets</h1>
        <div class="row" id="tickets"></div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    async function fetchDetails(UserID) {
        try {
            const response = await fetch('../fetchTicketUsage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ UserID: UserID, action: 'GetTicketsDataByUserID' }),
            });
            const data = await response.json();
            if (data.status === 'success') {
                console.log(data.data);
                displayTickets(data.data);
            } else {
                console.error('Error:', data.message);
            }
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }

    function displayTickets(tickets) {
        const ticketsContainer = document.getElementById('tickets');
        ticketsContainer.innerHTML = ''; // Clear previous tickets

        tickets.forEach(ticket => {
            const ticketElement = document.createElement('div');
            ticketElement.className = 'col-md-4';

            const ticketContent = `
                <div class="ticket card tic">
                    <div class="card-body row g-0">
                    <h4 class="card-title col my-auto"> ${ticket.EventName}</h4>
                    <div class="col">
                            <img src="${ticket.QR_CODE}" class="img-fluid float-md-end float-md-top " alt="QR Code">
                    </div>
                    <div class="row"> 

                        <div class="row">                        
                            <div class="card-text"><strong>Date: </strong>${ new Date(ticket.EventDate).toLocaleDateString('en-GB')}</div>
                            <div class="card-text"><strong>Time: </strong> ${ticket.StartTime} - ${ticket.EndTime}</div>
                        </div>
                        <div class="row ">                        
                                <div class="card-text"><strong> Organization: </strong> ${ticket.OrgName}</div>
                                <div class="card-text"><strong>Ticket Type: </strong> ${ticket.TicketType}</div>
                                <div class="card-text"><strong> Quantity: </strong> ${ticket.Quantity}</div>
                        </div>
    
                    </div>
                    </div>
                </div>
            `;
            ticketElement.innerHTML = ticketContent;
            ticketsContainer.appendChild(ticketElement);
        });
    }

    function getUserID() {
        const cookies = document.cookie.split(';').map(cookie => cookie.trim());
        for (const cookie of cookies) {
            if (cookie.startsWith('id=')) {
                return cookie.split('=')[1];
            }
        }
        return null;
    }

    async function initialize() {
        let User = getUserID();
        console.log(User);
        const UserID = User;
        if (UserID) {
            await fetchDetails(UserID);
        } else {
            console.error("No User ID provided.");
        }
    }

    initialize();
    </script>
</body>
<?php
include 'user_footer.html';
?>
</html>