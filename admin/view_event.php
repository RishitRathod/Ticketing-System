<?php
require_once 'admin_headnav.php';
?>

<div class="container mt-5">
    <h1>Event Details</h1>
    <div id="event-details"></div>
</div>

<script>
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
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">${event.EventName}</h5>
                        <p class="card-text"><strong>Description:</strong> ${event.Description}</p>
                        <p class="card-text"><strong>Start Date:</strong> ${event.StartDate}</p>
                        <p class="card-text"><strong>End Date:</strong> ${event.EndDate}</p>
                        <p class="card-text"><strong>Capacity:</strong> ${event.Capacity}</p>
                        <p class="card-text"><strong>Event Type:</strong> ${event.EventType}</p>
                        <p class="card-text"><strong>Venue Address:</strong> ${event.VenueAddress}</p>
                        <p class="card-text"><strong>Country:</strong> ${event.Country}</p>
                        <p class="card-text"><strong>State:</strong> ${event.State}</p>
                        <p class="card-text"><strong>City:</strong> ${event.City}</p>
                        <p class="card-text"><strong>Organization Name:</strong> ${event.OrgName}</p>
                        <h6 class="card-subtitle mb-2 text-muted">Posters:</h6>
                        <div class="list-group">`;

            event.Posters.forEach(poster => {
                eventDetailsHTML += `
                    <div class="list-group-item">
                        <img src="${poster}" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                    </div>`;
            });

            eventDetailsHTML += `
                        </div>
                        <h6 class="card-subtitle mb-2 text-muted">Tickets:</h6>
                        <div class="list-group">`;

            event.Tickets.forEach(ticket => {
                eventDetailsHTML += `
                    <div class="list-group-item">
                        <p class="mb-1"><strong>Ticket Type:</strong> ${ticket.TicketType}</p>
                        <p class="mb-1"><strong>Quantity:</strong> ${ticket.Quantity}</p>
                        <p class="mb-1"><strong>Limit Quantity:</strong> ${ticket.LimitQuantity}</p>
                        <p class="mb-1"><strong>Discount:</strong> ${ticket.Discount}%</p>
                        <p class="mb-1"><strong>Price:</strong> $${ticket.Price}</p>
                    </div>`;
            });

            eventDetailsHTML += `
                        </div>
                        <h6 class="card-subtitle mb-2 text-muted">Time Slots:</h6>
                        <div class="list-group">`;

            event.TimeSlots.forEach(slot => {
                eventDetailsHTML += `
                    <div class="list-group-item">
                        <p class="mb-1"><strong>Start Time:</strong> ${slot.StartTime}</p>
                        <p class="mb-1"><strong>End Time:</strong> ${slot.EndTime}</p>
                    </div>`;
            });

            eventDetailsHTML += `
                        </div>
                    </div>
                </div>`;

            eventDetailsContainer.innerHTML += eventDetailsHTML;
        });
    }

    getEventsData();
</script>