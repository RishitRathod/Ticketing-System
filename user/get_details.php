<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Fetch Example</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
</head>
<body>
    <?php
    //  include 'userdashnav.php'; ?>
    
<div class="container1 mt-5" ></div>
    <div class="container mt-5" id="eventsContainer">   
        <h2 class="container mt-5">Events</h2>
        <div class="row mt-5" id="eventsRow">
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

            const eventsArray = Object.values(events);

            console.log(eventsArray);

            eventsRow.innerHTML = '';
            eventsArray.forEach((event) => {
                const eventCard = document.createElement('div');
                eventCard.classList.add('col-12', 'mb-4');

                const posterIndicators = Array.isArray(event.posters) ? event.posters.map((poster, index) => `
                    <li data-target="#carousel${event.EventID}" data-slide-to="${index}" class="${index === 0 ? 'active' : ''}"></li>
                `).join('') : '';

                const posterItems = Array.isArray(event.posters) ? event.posters.map((poster, index) => `
                    <div class="carousel-item ${index === 0 ? 'active' : ''}">
                        <img src="${poster}" class="d-block w-100 event-poster" alt="Event Poster">
                    </div>
                `).join('') : '';

                const ticketsList = Array.isArray(event.tickets) ? event.tickets.map(ticket => `
                    <p class="card-text"><strong>Ticket Type:</strong> ${ticket.TicketType}, <strong>Quantity:</strong> ${ticket.Quantity}, <strong>Price:</strong> $${ticket.Price}, <strong>Discount:</strong> ${ticket.Discount}%</p>
                `).join('') : '';

                const timeSlotsList = Array.isArray(event.timeSlots) ? event.timeSlots.map(slot => `
                    <p class="card-text"><strong>Time Slot:</strong> ${slot.StartTime} - ${slot.EndTime}, <strong>Availability:</strong> ${slot.Availability}</p>
                `).join('') : '';

                eventCard.innerHTML = `
                    <div class="card h-100 event-card">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <div id="carousel${event.EventID}" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        ${posterIndicators}
                                    </ol>
                                    <div class="carousel-inner">
                                        ${posterItems}
                                    </div>
                                    <a class="carousel-control-prev" href="#carousel${event.EventID}" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carousel${event.EventID}" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body event-details">
                                    <h5 class="card-title">${event.EventName}</h5>
                                    <p class="card-text"><strong>Time:</strong> ${event.StartDate} - ${event.EndDate}</p>
                                    <p class="card-text"><strong>Venue:</strong> ${event.VenueAddress}</p>
                                    <p class="card-text"><strong>Price:</strong> $${event.Price}</p>
                                    <p class="card-text"><strong>Available Tickets:</strong> ${event.AvailableTickets}</p>
                                    ${timeSlotsList}
                                    ${ticketsList}
                                    <div class="text-center">
                                        <form action="edit_events.php" method="post" style="display:inline;">
                                            <input type="hidden" name="id" value="${event.EventID}">
                                            <button type="submit" class="btn btn-primary">Buy Ticket</button>
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
</body>
</html>
