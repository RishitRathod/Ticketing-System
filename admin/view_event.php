<head>
    <title>Event Details</title>
</head>
<?php
require_once 'admin_headnav.php';
?>
<head>
    <style>
        .tagName{
            padding: 0.5vmax;
            background-color: #2a0275;
            color:aliceblue; 
            width: max-content;

        }
        .tagDetails{
            background-color: #e0dee3;
            width: 100%;
            left: 0;
            right: 0;
            min-width:200px;
        }
        .date{
            background-color: #e0dee3;
            width: max-content;
            left: 0;
            right: 0;
            min-width:200px;
        }
        .card-header{
            background-color: #2a0275;
            width: max-content;
            color:aliceblue;
        }
        .ct{
            border-bottom: 5px solid #2a0275;
        }
    </style>

</head>

        <form action="view_user.php" method="post">
            <input type="hidden" name="UserID" id="UserID">
        </form>
<div class="container mt-2 g-0">
    <h1>Event Details</h1>
    <div id="event-details"></div>
    <h2>Event Attendees</h2>
    <div class="tableforAttendace">
        <table id="attendencetable" class="table table-responsive table-striped table-bordered">
            <thead>

            <tr>
        <th>Sr No.</th>
        <th>Username</th>
        <!-- <th>Email</th> -->
        <!-- <th>UserPhoto</th> -->
        <!-- <th>UserPhoneNumber</th> -->
        <!-- <th>TicketID</th> -->
        <th>Ticket Type</th>
        <!-- <th>TicketQuantity</th> -->
        <!-- <th>TicketAvailability</th> -->
        <!-- <th>TicketQRCode</th> -->
        <!-- <th>LimitQuantity</th> -->
        <!-- <th>Discount</th> -->
        <!-- <th>Price</th> -->
        <!-- <th>TicketSalesID</th> -->
        <!-- <th>TimeSlotID</th> -->
        <!-- <th>TicketSalesName</th> -->
        <!-- <th>TicketSalesEmail</th> -->
        <!-- <th>TicketSalesPhone</th> -->
        <th>No. Of Tickets</th>
        <th>Purchase Date</th>
        <!-- <th>TicketSalesStatus</th> -->
        <!-- <th>TicketSalesQRCode</th> -->
        <th>EventDate</th>
        <!-- <th>TimeUsageID</th> -->
        <th>EntryTime</th>
        <th>ExitTime</th>
        <!-- <th>IsAttending</th> -->
        <!-- <th>TimeUsageQuantity</th> -->
        <th>StartTime</th>
        <th>EndTime</th>
        <!-- <th>TimeslotAvailability</th> -->
        <!-- <th>Status</th> -->
        <!-- <th>Message</th> -->
    </tr>

            </thead>     


        </table>

    </div>


<script>
    

async function getEventAttende() {
    try {
        const response = await fetch('../fetchEvents.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'GetRegisterUsersForEvent',
                EventID: <?php echo $_POST['EventID']; ?>
            }),
        });
        const data = await response.json();
        console.log("tryblock",data); // Debugging: Log the response data

        if (data.error) {
            alert(data.error);
        } else {
            if (Array.isArray(data.data)) {
                console.log('Attendees:', data.data);
                console.table(data.data);
                displayEventAttendees(data.data);
            } else {
                console.error('Expected an array but got:', data.data);
            }
        }
    } catch (error) {
        console.error('Fetch error:', error);
    }
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

function GotoUser(UserID){
    document.getElementById('UserID').value = UserID;
    document.querySelector('form').submit();
}

function displayEventAttendees(data) {
    const attendencetable = document.getElementById('attendencetable');

    data.forEach((attendee, index) => {
        let tableRow = `
            <tr>
                <td>${index + 1}</td>
                <td> <a href="#" onclick='GotoUser(${attendee.UserID})'> ${attendee.Username} </a> </td>
                <td>${attendee.TicketType}</td>
                <td>${attendee.TicketSalesQuantity}</td>
                <td>${formatDateTime(attendee.PurchaseDate)}</td>
                <td>${formatDate(attendee.EventDate)}</td>
                <td>${formatTime(attendee.EntryTime)}</td>
                <td>${formatTime(attendee.ExitTime)}</td>
               <!-- <td>${attendee.TimeUsageQuantity}</td> -->
                <td>${attendee.StartTime}</td>
                <td>${attendee.EndTime}</td>
            </tr>
        `;
        attendencetable.innerHTML += tableRow;
    });
    //make datatable
    $('#attendencetable').DataTable({
        responsive: true,
        autoWidth: false,
        destroy: true
    });

    
}
    //fetch data from server
    async function getEventsData(){
        fetch('../fetchEvents.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                EventID: <?php echo $_POST['EventID'];?>,
                action: 'FetchEventDetails'
            }),
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if(data.error){
                alert(data.error);
            } else {
                console.log(data.data);
                displayEventDetails(data.data); 
            }
        })
    }
    function displayEventDetails(eventData) {
    const eventDetailsContainer = document.getElementById('event-details');

    eventData.forEach(event => {
        let eventDetailsHTML = `
            <div class="row">
                <div class="row">
                    <div class="col-5 fs-3">${event.EventName}</div>
                    <div class="m-3 p-0 col-3 date"><strong class="tagName">Start Date</strong> ${new Date(event.StartDate).toLocaleDateString('en-GB')}</div>
                    <div class="m-3 p-0 col-3 date"><strong class="tagName">End Date</strong> ${new Date(event.EndDate).toLocaleDateString('en-GB')}</div>
                </div>
                <div class="col-5 justify-content-evenly">
                    <div class="my-3 tagDetails"><strong class="tagName">Organization Name</strong> ${event.OrgName}</div>
                    <div class="my-3 tagDetails"><strong class="tagName">Capacity</strong> ${event.Capacity}</div>
                    <div class="my-3 tagDetails"><strong class="tagName">Event Type</strong> ${event.EventType}</div>
                    <div class="my-3 tagDetails" style="width:100%;"><strong class="tagName">Description</strong> ${event.Description}</div>
                </div>
                <div class="col-6 row p-0 m-0 justify-content-evenly"><li class="p-0 m-0 fs-5">Address</li>
                    <div class="col-5  p-0 m-0 ">
                        <div class="my-3 tagDetails"><strong class="tagName" >Country</strong> ${event.Country}</div>
                        <div class="my-3 tagDetails"><strong class="tagName" >State</strong> ${event.State}</div>
                        <div class="my-3 tagDetails"><strong class="tagName" >City</strong> ${event.City}</div>
                    </div>
                    <div class="col-6  p-0 m-0 ">
                        <div class="my-3 tagDetails" style="width:100%;"><strong class="tagName">Venue Address</strong> ${event.VenueAddress}</div>
                    </div>
                </div>
                <div>
                    <fieldset><legend>Posters</legend>
                    <div class="d-inline overflow-x">`;

        event.Posters.forEach(poster => {
            eventDetailsHTML += `
                    <div class=" d-inline-block m-2 border-none overflow-x">
                        <img src="${poster}" class="img-thumbnail img-fluid" style="max-width: 200px; max-height: 200px;">
                    </div>`;
        });

        eventDetailsHTML += `
                   </fieldset>

                    <legend>Tickets</legend>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Ticket Type</th>
                                <th>Quantity</th>
                                <th>Limit Quantity</th>
                                <th>Discount</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>`;

        event.Tickets.forEach(ticket => {
            eventDetailsHTML += `
                <tr>
                    <td>${ticket.TicketType}</td>
                    <td>${ticket.Quantity}</td>
                    <td>${ticket.LimitQuantity}</td>
                    <td>${ticket.Discount}%</td>
                    <td>$${ticket.Price}</td>
                </tr>`;
        });

        eventDetailsHTML += `
                        </tbody>
                    </table>

                    <legend>Time slots</legend>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Start Time</th>
                                <th>End Time</th>
                            </tr>
                        </thead>
                        <tbody>`;

        event.TimeSlots.forEach(slot => {
            eventDetailsHTML += `
                <tr>
                    <td>${slot.StartTime}</td>
                    <td>${slot.EndTime}</td>
                </tr>`;
        });

        eventDetailsHTML += `
                        </tbody>
                    </table>
                </div>
            </div>`;

        eventDetailsContainer.innerHTML += eventDetailsHTML;
    });
}
    
    document.addEventListener('DOMContentLoaded', () => {
        getEventsData();
        getEventAttende();
    });

</script>