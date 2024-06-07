
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Fetch Example</title>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css"> -->
    <style>
        .heg{
            margin-top: 15vmin;
          
        }
        .card{
            border:none !important;
            background-color: #00000000  !important;
        }
        .posters{
            height: 55vmin;
        }
        .event-poster{
            border-radius: 8px;
        }
        fieldset{
            border-radius: 5px !important;
            background-color: #ffffff50  !important;
        }

        .price{
            color:honeydew;
            background-color: #527822;
            width: max-content;
            border-radius: 5px;
            padding-inline: 5px;
        }
        .evTitle{
            background-color: #00000070;
            border-radius: 20px;
            box-shadow: 0 0 30px black;
            text-shadow: 0 0 30px black;
        }

        @media (max-width: 760px) {
            .heg{
                font-size: 12px !important;   
            }
        }

    </style>
</head>
<body >
<?php
     include 'userdashnav.php'; ?>
    <!-- Navigation bar inclusion -->
  
    
    <!-- <div class="container1"></div> -->
    <div class="heg pt-5 px-4" id="eventsContainer">   
        <h2>Event</h2>
        <div class="row px-md-5 px-0" id="eventsRow">
        
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
                    <img src="${poster}" class="event-poster img-fluid d-inline m-2 " alt="Event Poster">
                `).join('');

                const ticketsList = event.Tickets.map(ticket => `
                    <li><span class="card-text"><b>${ticket.TicketType}</b>, <strong>Quantity:</strong> ${ticket.Quantity}</li><li><strong>Discount:</strong> ${ticket.Discount}%</span></li>
                `).join('');

                const timeSlotsList = event.TimeSlots.map(slot => `
                    <li><span class="card-text">${slot.StartTime} - ${slot.EndTime}, <strong>Availability:</strong> ${slot.Availability}</span></li>
                `).join('');

                eventCard.innerHTML = `
                    <div class="card event-card">
                        <div class="row row-cols-1 row-cols-md-2 g-2 p-3">
                            <div class="col-md-8 overflow-auto card d-block poster-container ">
                                <legend><strong>Event Photos</strong></legend>
                                <div class="posters d-flex overflow-auto">
                                    ${posterItems}
                                </div>
                                <h3 class="card-title position-absolute bottom-0 start-0 text-light m-4 evTitle">${event.EventName}</h3>
                            </div>
                            <div class="col-md-4 card overflow-auto">
                                <div class="card-body event-details">
                                    <div class="mt-3"><legend><strong>Available Tickets:</strong> ${event.Capacity}</legend></div>
                                    <fieldset><legend><strong>Date</strong></legend>
                                        <div class="card-text"><strong>From</strong> ${event.StartDate} <strong>to</strong> ${event.EndDate}</div>
                                    </fieldset>
                                    <fieldset style="height:10vmax; overflow:auto;"><legend><strong>Time Slots</strong></legend>
                                        ${timeSlotsList}
                                    </fieldset>
                                    <fieldset style="height:10vmax; overflow:auto;"><legend><strong>Tickets</strong></legend>
                                        ${ticketsList}
                                    </fieldset>
                                </div>
                            </div>
                                
                            <div class="col-md-12 card py-md-2 py-0">
                                <fieldset>
                                    <legend> <strong> Discount </strong> </legend>
                                    <div class="card-text price"><s class="bg-danger opacity-50 rounded-3"> ₹${event.Price}</s>  ₹ ${event.Price - (event.Price * event.Discount)/100}</div>
                                </fieldset>                                

                                <fieldset>
                                    <legend> <strong>Description</strong> </legend>
                                    <div class="card-text">${event.Description}</div>
                                    <p class="card-text"><strong>Venue Address:</strong> ${event.VenueAddress}</p>
                                </fieldset>
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
