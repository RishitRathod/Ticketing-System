<?php
require_once 'admin_headnav.php';
?>
<head>
    <style>
        .tagName{
            padding: 0.5vmax;
            background-color: #2a0275;
            color:aliceblue; 
        }
        .tagDetails{
            background-color: #e0dee3;
        }
        .card-header{
            background-color: #2a0275;
            color:aliceblue;
        }
        .ct{
            border-bottom: 5px solid #2a0275;
        }
    </style>

</head>
<div class="container mt-2 g-0">
    <h1>Event Details</h1>
    <div id="event-details"></div>

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
        <th>TicketType</th>
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
        <th>TicketSalesQuantity</th>
        <th>PurchaseDate</th>
        <!-- <th>TicketSalesStatus</th> -->
        <!-- <th>TicketSalesQRCode</th> -->
        <th>EventDate</th>
        <!-- <th>TimeUsageID</th> -->
        <th>EntryTime</th>
        <th>ExitTime</th>
        <!-- <th>IsAttending</th> -->
        <th>TimeUsageQuantity</th>
        <th>StartTime</th>
        <th>EndTime</th>
        <!-- <th>TimeslotAvailability</th> -->
        <!-- <th>Status</th> -->
        <!-- <th>Message</th> -->
    </tr>

            </thead>     


        </table>

    </div>

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

function displayEventAttendees(data) {
    const attendencetable = document.getElementById('attendencetable');

    data.forEach((attendee, index) => {
        let tableRow = `
            <tr>
                <td>${index + 1}</td>
                <td>${attendee.Username}</td>
                <td>${attendee.TicketType}</td>
                <td>${attendee.TicketSalesQuantity}</td>
                <td>${attendee.PurchaseDate}</td>
                <td>${attendee.EventDate}</td>
                <td>${attendee.EntryTime}</td>
                <td>${attendee.ExitTime ? attendee.ExitTime : 'N/A'}</td>
                <td>${attendee.TimeUsageQuantity}</td>
                <td>${attendee.StartTime}</td>
                <td>${attendee.EndTime}</td>
            </tr>
        `;
        attendencetable.innerHTML += tableRow;
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
                <div class="card">
                    <div class="card-body">
                    <div class="row justify-content-evenly">
                        <h3 class="card-title">${event.EventName}</h3>
                        <div class="card-text m-2 p-2 col tagDetails"><strong class="tagName">Organization Name</strong> ${event.OrgName}</div>
                        <div class="card-text m-2 p-2 col tagDetails"><strong class="tagName">Capacity</strong> ${event.Capacity}</div>
                        <div class="card-text m-2 p-2 col tagDetails"><strong class="tagName">Event Type</strong> ${event.EventType}</div>
                        <div class="row g-0">
                            <div class="card-text m-2 p-2 tagDetails"><strong class="tagName">Description</strong> ${event.Description}</div>
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-auto m-2 p-2 card-text tagDetails"><strong class="tagName">Start Date</strong> ${event.StartDate}</div>
                        <div class="col-auto m-2 p-2 card-text tagDetails"><strong class="tagName">End Date</strong> ${event.EndDate}</div>
                    </div>
                    <fieldset><legend>Address</legend>
                        <div class="row justify-content-evenly">
                            <div class="card-text m-2 p-2 tagDetails"><strong class="tagName">Venue Address</strong> ${event.VenueAddress}</div>
                            <div class="card-text col m-2 p-2 tagDetails"><strong class="tagName" >Country</strong> ${event.Country}</div>
                            <div class="card-text col m-2 p-2 tagDetails"><strong class="tagName" >State</strong> ${event.State}</div>
                            <div class="card-text col m-2 p-2 tagDetails"><strong class="tagName" >City</strong> ${event.City}</div>
                        </div>
                    </fieldset>
                    <div>
                        <fieldset><legend>Posters</legend>
                        <div class="d-block">`;

            event.Posters.forEach(poster => {
                eventDetailsHTML += `
                    <div class=" d-inline-block m-2 border-none overflow-x">
                        <img src="${poster}" class="img-thumbnail img-fluid" style="max-width: 200px; max-height: 200px;">
                    </div>`;
            });

            eventDetailsHTML += `
                       </fieldset>

                        <legend>Tickets</legend>
                        <div class="row">`;

            event.Tickets.forEach(ticket => {
                eventDetailsHTML += `
                    <div class="col">
                        <div class="card">
                        <div class="mb-1 card-header"><strong>Ticket Type:</strong> ${ticket.TicketType}</div>
                        <div class="card-body g-0">
                            <div class="mb-1"><strong>Quantity:</strong> ${ticket.Quantity}</div>
                            <div class="mb-1"><strong>Limit Quantity:</strong> ${ticket.LimitQuantity}</div>
                            <div class="mb-1"><strong>Discount:</strong> ${ticket.Discount}%</div>
                            <div class="mb-1"><strong>Price:</strong> $${ticket.Price}</div>
                        </div>
                        </div>
                    </div>`;
            });

            eventDetailsHTML += `
                        </div>
                        <legend>Time slots</legend>
                        <div class="row justify">`;

            event.TimeSlots.forEach(slot => {
                eventDetailsHTML += `
                    <div class="col">
                        <div class="card">
                        <div class="card-body row g-0">
                            <div class="col-auto"><strong>Start Time:</strong> ${slot.StartTime}</div> 
                            <div class="col-auto mx-3">to</div>
                            <div class="col-auto"><strong>End Time:</strong> ${slot.EndTime}</div>
                            </div>
                        </div>
                    </div>`;
            });

            eventDetailsHTML += `
                        </div>
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