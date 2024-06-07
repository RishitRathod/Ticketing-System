
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Fetch Example</title>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css"> -->
    <style>
        .heg{
            margin-top: 150px;
          
        }

    </style>
</head>
<body >
<?php
     include 'userdashnav.php'; ?>
    <!-- Navigation bar inclusion -->
  
    
    <!-- <div class="container1"></div> -->
    <div class="heg p-3" id="eventsContainer" style="width:70%;">   
     
        <div class="row " id="eventsRow">

        

        <h2 class="container">Events</h2>
            <!-- Event cards will be dynamically populated here -->
        </div>
    </div>

    <script>
        async function fetchData(tableName) {
            try {
                const EventID = <?php echo isset($_POST['id']) ? json_encode($_POST['id']) : 'null'; ?>;
                console.log(EventID);

                const response = await fetch('../fetchEvents.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ action: 'FetchEventDetails', EventID: EventID }),
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

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
            const value = 'events';
            const data = await fetchData(value);
            populateEvents(data);
        }

        function populateEvents(events) {
            const eventsRow = document.querySelector('#eventsRow');

            if (!Array.isArray(events)) {
                console.error('Expected an array but got:', events);
                return;
            }

            eventsRow.innerHTML = '';
            events.forEach((event) => {
                const eventCard = document.createElement('div');
                eventCard.classList.add('col-12', 'mb-4');

                const posterItems = event.Posters.map(poster => `
                    <img src="${poster}" class="event-poster img-fluid" alt="Event Poster">
                `).join('');

                const ticketsList = event.Tickets.map(ticket => `
                    <li><span class="card-text"><b>${ticket.TicketType}</b>, <strong>Quantity:</strong> ${ticket.Quantity}, <strong>Price:</strong> $${ticket.Price}, <strong>Discount:</strong> ${ticket.Discount}%</span></li>
                `).join('');

                const timeSlotsList = event.TimeSlots.map(slot => `
                    <li><span class="card-text">${slot.StartTime} - ${slot.EndTime}, <strong>Availability:</strong> ${slot.Availability}</span></li>
                `).join('');

                eventCard.innerHTML = `
                    <div class="card event-card p-5">
                        <div class="row no-gutters">
                            <div class="col-md-4 overflow-auto d-block poster-container">
                                <strong>Event Photos</strong>
                                ${posterItems}
                            </div>
                            <div class="col-md-8">
                                <div class="card-body event-details pl-4">
                                    <h3 class="card-title">${event.EventName}</h3>
                                    <p class="card-text"><strong>Price:</strong> $${event.Price}</p>
                                    <p class="card-text"><strong>Venue:</strong> ${event.VenueAddress}</p>
                                    <fieldset><legend><strong>Date</strong></legend>
                                        <div class="card-text"><strong>From</strong> ${event.StartDate} <strong>to</strong> ${event.EndDate}</div>
                                    </fieldset>
                                    <p class="card-text"><strong>Available Tickets:</strong> ${event.Capacity}</p>
                                    <fieldset><legend><strong>Time Slots</strong></legend>
                                        ${timeSlotsList}
                                    </fieldset>
                                    <fieldset><legend><strong>Tickets</strong></legend>
                                        ${ticketsList}
                                    </fieldset>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                eventsRow.appendChild(eventCard);
            });
        }

        window.onload = initialize;
    </script>

    <?php
include 'user_footer.html'
    ?>
</body>
</html>
