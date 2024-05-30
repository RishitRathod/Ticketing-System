<?php
    include 'navhead.php';
?>


    <!-- Main Content -->
    <div class="container mt-5" id="eventsContainer">
        <h2>Events</h2>
        <div class="row" id="eventsRow">
            <!-- Event cards will be dynamically populated here -->
        </div>
    </div>

  
    <script>
        async function fetchData(tableName) {
            const response = await fetch("../admin/admin_dashboard.php", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ tablename: tableName, action: 'fetch' }),
            });

            const result = await response.json();
            if (result.status === 'success') {
                return result.data;
            } else {
                console.error('Error:', result.message);
                return [];
            }
        }

        async function initialize() {
            var value = 'events';
            const data = await fetchData(value);
            populateEvents(data);
        }

        function populateEvents(events) {
            let eventsRow = document.querySelector('#eventsRow');

            if (!Array.isArray(events)) {
                console.error('Expected an array but got:', events);
                return;
            }

            eventsRow.innerHTML = '';
            events.forEach((event) => {
                const eventCard = document.createElement('div');
                eventCard.classList.add('col-md-4', 'mb-4');

                eventCard.innerHTML = `
                    <div class="card h-100">
                        <img src="../${event.EventPoster}" class="card-img-top" alt="Event Poster">
                        <div class="card-body">
                            <h5 class="card-title">${event.EventName}</h5>
                            <p class="card-text"><strong>Time:</strong> ${event.StartDate} - ${event.EndDate}</p>
                            <p class="card-text"><strong>Venue:</strong> ${event.VenueAddress}</p>
                            <p class="card-text"><strong>Price:</strong> $${event.Price}</p>
                            <p class="card-text"><strong>Available Tickets:</strong> ${event.AvailableTickets}</p>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-primary">View Details</button>
                        </div>
                    </div>
                `;
                eventsRow.appendChild(eventCard);
            });
        }

        window.onload = initialize;
    </script>

    <?php
        include 'footer.php';
    ?>

