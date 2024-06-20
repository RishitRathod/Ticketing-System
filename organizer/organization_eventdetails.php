<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Ticketing System</title>
    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <style>
        .main-content{
            background-color: #00023c !important;
        }
        .event-card {
            border-radius: 20px !important;
            height: 100% !important;
            width: 100% !important;
        }
        .event-poster {
            max-height: 600px;
            object-fit: cover;
            width: 90%;
            margin: 4vmin;
            border-radius: 10px !important;
            box-shadow: 0px 0px 30px black;
        }
        .event-details {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .poster-container {
            max-height: 400px !important;
            width: max-content !important;
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
        .card-body{
            background-color: #c9d6ff;
            box-shadow: 0px 0px 10px black;
            border-radius: 10px;
        }
        ::-webkit-scrollbar {
            display: none;
        }

    </style>
</head>
<body>
    <?php include 'navhead.php'; ?>

    <!-- Main Content -->
    <div class="container p-2 g-0" id="eventsContainer">
        <h2 class="text-light">Event</h2>
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
    eventCard.classList.add('col-12');

    const posterItems = event.posters.map(poster => `
        <img src="${poster}" class="event-poster img-fluid g-0" alt="Event Poster">
    `).join('');

    const ticketsList = event.tickets.map(ticket => `
        <li><span class="card-text"><strong>TicketType:</strong> ${ticket.TicketType}   , <strong>Quantity:</strong> ${ticket.Quantity}, <strong>Price:</strong> $${ticket.Price}, <strong>Discount:</strong> ${ticket.Discount}%</span></li>
    `).join('');

    const timeSlotsList = event.timeSlots.map(slot => `
        <li><span class="card-text"> <strong>From:</strong> ${slot.StartTime} - <strong>To:</strong> ${slot.EndTime}, <strong>Availability:</strong> ${event.Capacity}</span> </li>
    `).join('');

    eventCard.innerHTML = `
        <div class="event-card ">
            <div class="row no-gutters">
                <div class="col-md-6 d-block">
                    <strong class="ml-3 text-light">Event Photos</strong>
                    <div class="posters d-flex g-0 overflow-auto">
                    ${posterItems}
                    </div>
                    <div class="text-center">
                            <form action="edit_events.php" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="${event.EventID}">
                                <button type="submit" class="btn btn-primary shadow-sm mt-3">Edit Details</button>
                            </form>
                            <form action="update_event.php" method="post" style="display:inline;">
                                <input type="hidden" name="eventID" value="${event.EventID}">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" class="btn btn-danger shadow-sm mt-3">Delete Event</button>
                            </form>
                            <form action="view_members.php" method="post" style="display:inline;">
                                <input type="hidden" name="eventID" value="${event.EventID}">
                                <button type="submit" class="btn btn-primary shadow-sm mt-3">View registered users</button>
                            </form>
                        </div>
                </div>

                <div class="col-md-6">
                    <div class="card-body event-details pl-4">
                        <h3 class="card-title"><strong>${event.EventName}</strong></h3>
                        <p class="card-text"><strong>Venue:</strong> ${event.VenueAddress}</p>
                        <fieldset class=""><legend><strong>Date</strong></legend>
                            <div class="card-text"><strong>From</strong> ${ new Date(event.StartDate).toLocaleDateString('en-GB')} <strong>to</strong> ${ new Date(event.EndDate).toLocaleDateString('en-GB')}</div>
                        </fieldset>
                        <fieldset><legend><strong>Time Slots and Tickets</strong></legend>
                            <div><strong>Time Slots</strong></div>
                            <ul>${timeSlotsList}</ul>
                            <div><strong>Tickets</strong></div>
                            <ul>${ticketsList}</ul>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    `;
 
        eventsRow.appendChild(eventCard);
            });
        }

        function isUserLoggedIn() {
                    const cookies = document.cookie.split(';').map(cookie => cookie.trim());
                    for (const cookie of cookies) {
                        if (cookie.startsWith('role=')) {
                            console.log("User is logged in");
                            return true;
                        }
                    }
                    console.log("User is not logged in");
                    return false;
            }
            window.onload = function() {
                    if (!isUserLoggedIn()) {
                //    document.getElementById('login').style.display = 'none';
                //    document.getElementById('profile').style.display = 'block';
                } else {
                   window.herf = "./organization_login.html";
                }
            }

        window.onload = initialize;
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>