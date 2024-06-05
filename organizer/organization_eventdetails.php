<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Ticketing System</title>
    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <style>
        .event-card {
            border-radius: 20px !important;
            height: 100% !important;
            width: 100% !important;
        }
        .event-poster {
            max-height: 200px;
            object-fit: cover;
            width: 80%;
            margin: 4vmin;
            border-radius: 10px !important;
        }
        .event-details {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .poster-container {
            max-height: 400px !important;
            width: max-content; !important;
            overflow-y: auto;
            overflow-x: none;
            display: flex;
            flex-direction: row;
        }
        fieldset {
            border: solid 1px gray;
            border-radius: 10px;
            padding-top: 5px;
            padding-right: 12px;
            padding-bottom: 10px;
            padding-left: 12px;
        }
        legend {
            float: none;
            width: inherit;
        }
    </style>
</head>
<body>
    <?php include 'navhead.php'; ?>

    <!-- Main Content -->
    <div class="container mt-5" id="eventsContainer">
        <h2>Events</h2>
        <div class="row" id="eventsRow">
            <!-- Event cards will be dynamically populated here -->
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> -->
    <script>
        async function fetchData(tableName) {
            try {
                const EventID = <?php echo isset($_POST['id']) ? json_encode($_POST['id']) : 'null'; ?>;
                console.log(EventID);

                const response = await fetch("organization_viewdetails_backend.php", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ tableName: tableName, EventID: EventID }),
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

            const uniqueEvents = events.reduce((acc, event) => {
                if (!acc[event.EventID]) {
                    acc[event.EventID] = {
                        ...event,
                        posters: new Set([event.poster]),
                        timeSlots: new Map([[event.TimeSlotID, {
                            TimeSlotID: event.TimeSlotID,
                            StartTime: event.StartTime,
                            EndTime: event.EndTime,
                            Availability: event.Availability
                        }]]),
                        tickets: new Map([[`${event.TicketID}-${event.TicketType}`, {
                            TicketID: event.TicketID,
                            TicketType: event.TicketType,
                            Quantity: event.Quantity,
                            LimitQuantity: event.LimitQuantity,
                            Discount: event.Discount,
                            Price: event.Price
                        }]])
                    };
                } else {
                    acc[event.EventID].posters.add(event.poster);
                    acc[event.EventID].timeSlots.set(event.TimeSlotID, {
                        TimeSlotID: event.TimeSlotID,
                        StartTime: event.StartTime,
                        EndTime: event.EndTime,
                        Availability: event.Availability
                    });
                    acc[event.EventID].tickets.set(`${event.TicketID}-${event.TicketType}`, {
                        TicketID: event.TicketID,
                        TicketType: event.TicketType,
                        Quantity: event.Quantity,
                        LimitQuantity: event.LimitQuantity,
                        Discount: event.Discount,
                        Price: event.Price
                    });
                }
                return acc;
            }, {});

            // Convert sets to arrays
            Object.keys(uniqueEvents).forEach(eventID => {
                uniqueEvents[eventID].posters = Array.from(uniqueEvents[eventID].posters);
                uniqueEvents[eventID].timeSlots = Array.from(uniqueEvents[eventID].timeSlots.values());
                uniqueEvents[eventID].tickets = Array.from(uniqueEvents[eventID].tickets.values());
            });

            console.log(uniqueEvents);

            eventsRow.innerHTML = '';
            Object.values(uniqueEvents).forEach((event) => {
                const eventCard = document.createElement('div');
                eventCard.classList.add('col-12', 'mb-4');

                const posterItems = event.posters.map(poster => `
                    <img src="${poster}" class="event-poster img-fluid" alt="Event Poster">
                `).join('');

                const ticketsList = event.tickets.map(ticket => `
                    <li><span class="card-text"><b> ${ticket.TicketType}</b >, <strong>Quantity:</strong> ${ticket.Quantity}, <strong>Price:</strong> $${ticket.Price}, <strong>Discount:</strong> ${ticket.Discount}%</span></li>
                `).join('');

                const timeSlotsList = event.timeSlots.map(slot => `
                    <li><span class="card-text"> ${slot.StartTime} - ${slot.EndTime}, <strong>Availability:</strong> ${slot.Availability}</span> </li>
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
                                        <div class="card-text"><strong>From</strong> ${event.StartDate} <strong>to</strong>${event.EndDate}</div>
                                    </fieldset>
                                    <p class="card-text"><strong>Available Tickets:</strong> ${event.AvailableTickets}</p>
                                    <fieldset><legend><strong>Time Slots</strong></legend>
                                        ${timeSlotsList}
                                    </fieldset>
                                    <fieldset><legend><strong>Tickets</strong></legend>
                                        ${ticketsList}
                                    </fieldset>
                                    <div class="text-center">
                                        <form action="edit_events.php" method="post" style="display:inline;">
                                            <input type="hidden" name="id" value="${event.EventID}">
                                            <button type="submit" class="btn btn-primary mt-3">Edit Details</button>
                                        </form>
                                        <form action="update_event.php" method="post" style="display:inline;">
                                            <input type="hidden" name="eventID" value="${event.EventID}">
                                            <input type="hidden" name="action" value="delete">
                                            <button type="submit" class="btn btn-primary mt-3">Delete Event</button>
                                        </form>
                                    </div>
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

    <?php include 'footer.php'; ?>
</body>
</html>
