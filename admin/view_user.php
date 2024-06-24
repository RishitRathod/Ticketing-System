<?php
include 'admin_headnav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> User Details</title>
    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <style>
        .ticket {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .ticket img {
            max-width: 100px;
        }
      
        .user-info {
            margin-bottom: 20px;
        }
        .tagName{
            padding: 0.5vmax;
            background-color: #2a0275;
            color:aliceblue; 
        }
        .tagDetails{
            padding: 0.5vmax;
            background-color: #e0dee3;
            width: max-content;
            min-width: 200px;
        }
    </style>
</head>
<body>
    <div class="container mt-2 ">
        <h1 class="text-center ">User Details</h1>
        <div id="user-info" class="user-info"></div>
        <div class="row" id="tickets"></div>
        <div class="contianer">
            <div class="UserTable2  overflow-auto">
            <table class="table table-striped table-bordered table-responsive" id="ticketsTable">
                    <thead>
                        <tr>
                            <th>Sr. No</th>
                            <th>Event Name</th>
                            <!-- <th>Event Type</th> -->
                            <!-- <th>Organization Name</th> -->
                            <th>Event Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Entry Time</th>
                            <th>Exit Time</th>
                            <th>Ticket Type</th>
                            <th>Quantity</th>
                            <th>Purchase Date</th>
                            <th>Ticket Price</th>
                            <!-- <th>Tickets Remaining</th> -->
                            <!-- <th>Ticket Status</th> -->
                            <!-- <th>Is Attending</th> -->
                            <!-- <th>Ticket ID</th> -->
                            <!-- <th>Ticket Sales ID</th>
                            <th>Time Slot ID</th>
                            <th>Time Usage ID</th>
                            <th>QR Code</th> -->
                        </tr>
                    </thead>
                    <tbody id="ticketsBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

    <script>
    
    async function getUserticketDetails(){
        fetch('../fetchUser.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                UserID: <?php echo $_POST['UserID'];?>,
                action: 'getUserEventDetails'
            }),
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if(data.error){
                alert(data.error);
            } else {
                console.table(data.data); 
                showData(data.data);
            }
        })

    }

    function formatDateTime(dateTime) {
            if (!dateTime) {
                return 'N/A';
            }
            const date = new Date(dateTime);
            if (isNaN(date)) {
                return 'N/A';
            }
            return date.toLocaleDateString('en-GB') + ' ' + date.toLocaleTimeString('en-GB');
        }

        function formatDate(date2) {
            if (!date2) {
                return 'N/A';
            }
            const date = new Date(date2);
            if (isNaN(date)) {
                return 'N/A';
            }
            return date.toLocaleDateString('en-GB');        
        }

function formatTime(dateTime) {
    if (!dateTime) {
        return 'N/A';
    }
    // Extract time part if dateTime contains date
    const time = dateTime.includes(' ') ? dateTime.split(' ')[1] : dateTime;
    const [hours, minutes, seconds] = time.split(':');
    if (hours === undefined || minutes === undefined || seconds === undefined) {
        return 'N/A';
    }
    return `${hours.padStart(2, '0')}:${minutes.padStart(2, '0')}:${seconds.padStart(2, '0')}`;
}

    function showData(data) {
            const ticketsBody = document.getElementById('ticketsBody');
            ticketsBody.innerHTML = ''; // Clear previous tickets
           

            
            data.forEach((ticket, index) => {
                const ticketRow = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${ticket.EventName || 'N/A'}</td>
                       <!-- <td>${ticket.EventType || 'N/A'}</td> -->
                      <!--  <td>${ticket.OrgID || 'N/A'}</td> -->
                        <td>${formatDate(ticket.EventDate)}</td>
                        <td>${formatTime(ticket.TimeSlotStartTime)}</td>
                        <td>${formatTime(ticket.TimeSlotEndTime)}</td>
                        <td>${formatTime(ticket.EntryTime)}</td>
                        <td>${formatTime(ticket.ExitTime)}</td>
                        <td>${ticket.TicketType}</td>
                        <td>${ticket.TicketsPurchased}</td>
                        <td>${formatDateTime(ticket.PurchaseDate)}</td>
                        <td>${ticket.TicketPrice}</td>
                       <!-- <td>${ticket.TicketsRemaining}</td>
                        <td>${ticket.TicketStatus || 'N/A'}</td>
                        <td>${ticket.IsAttending || 'N/A'}</td>
                        <td>${ticket.TicketID}</td>
                        <td>${ticket.TicketSalesID}</td>
                        <td>${ticket.TimeSlotID || 'N/A'}</td>
                        <td>${ticket.TimeUsageID || 'N/A'}</td>
                        <td>${ticket.QR_CODE ? '<img src="' + ticket.QR_CODE + '" class="img-fluid" alt="QR Code">' : 'N/A'}</td> -->
                    </tr>
                `;
                ticketsBody.insertAdjacentHTML('beforeend', ticketRow);
            });

            // Initialize DataTable
            $('#ticketsTable').DataTable();
        }
    async function getUserData(){
        fetch('../fetchUser.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                UserID: <?php echo $_POST['UserID'];?>,
                action: 'FetchUserDetails'
            }),
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if(data.error){
                alert(data.error);
            } else {
                console.log(data.data); 
                displayUserData(data.data);
            }
        })
    }
let UserID ;
    function displayUserData(user) {
        const userInfoContainer = document.getElementById('user-info');
        UserID=user.UserID
        userInfoContainer.innerHTML = `
            <div class="card">
                <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="card-text"><strong>User Photo:</strong> ${user.UserPhoto ? '<img src="' + user.UserPhoto + '" style="height:200px !important; width:400px !important;" alt="User Photo">' : 'No photo available'}</div>
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
            </div>
        `;
    }

    function displayTickets(tickets) {
        const ticketsContainer = document.getElementById('tickets');
        ticketsContainer.innerHTML = ''; // Clear previous tickets

        tickets.forEach(ticket => {
            const ticketElement = document.createElement('div');
            ticketElement.className = 'col-md-4';

            const ticketContent = `
                <div class="ticket card">
                    <div class="card-body">
                        <h5 class="card-title">Event: ${ticket.EventName}</h5>
                        <p class="card-text">Organization: ${ticket.OrgName}</p>
                        <p class="card-text">Date: ${ticket.EventDate}</p>
                        <p class="card-text">Time: ${ticket.StartTime} - ${ticket.EndTime}</p>
                        <p class="card-text">Ticket Type: ${ticket.TicketType}</p>
                        <p class="card-text">Quantity: ${ticket.Quantity}</p>
                        <img src="${ticket.QR_CODE}" class="img-fluid" alt="QR Code">
                    </div>
                </div>
            `;
            ticketElement.innerHTML = ticketContent;
            ticketsContainer.appendChild(ticketElement);
        });
    }

    async function initialize() {
        getUserData();
        getUserticketDetails();
    }

    initialize();
    </script>
</body>
<?php
include 'admin_footer.php';
?>
</html>
