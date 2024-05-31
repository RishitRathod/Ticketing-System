<?php
    include 'navhead.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Ticketing System</title>
    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <!-- DataTables CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"> -->
    <style>
        .event-card {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .event-card img {
            max-width: 100%;
            height: auto;
        }
        .event-poster {
            max-height: 200px;
            object-fit: cover;
            width: 100%;
        }
        .event-details {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
    </style>
</head>
<body>
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
    <!-- DataTables JS -->
    <!-- <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script> -->
    <script src="../script.js"></script>
    <script>

  
        async function fetchData(tableName) {
           console.log(document.cookie);
            var OrgID = document.cookie.split('; ').find(row => row.startsWith('id')).split('=')[1];
    console.log(OrgID);
            const response = await fetch("organization_events_backend.php", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ tablename: tableName,OrgID : OrgID }),
            });

            const result = await response.json();
            if (result.status === 'success') {
                console.log(result.data);
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
           // console.log(event.EventPoster[0]);
            let eventsRow = document.querySelector('#eventsRow');

            if (!Array.isArray(events)) {
                console.error('Expected an array but got:', events);
                return;
            }

            eventsRow.innerHTML = '';
            events.forEach((event) => {
                const eventCard = document.createElement('div');
                eventCard.classList.add('col-12', 'mb-4');

                eventCard.innerHTML = `
                    <div class="card h-100 event-card">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img src="${event.poster}" class="card-img event-poster" alt="Event Poster">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body event-details">
                                    <h5 class="card-title">${event.EventName}</h5>
                                    <p class="card-text"><strong>Time:</strong> ${event.StartDate} - ${event.EndDate}</p>
                                    <p class="card-text"><strong>Venue:</strong> ${event.VenueAddress}</p>
                                    <p class="card-text"><strong>Price:</strong> $${event.Price}</p>
                                    <p class="card-text"><strong>Available Tickets:</strong> ${event.AvailableTickets}</p>
                                    <div class="text-center">
                                        <button class="btn btn-primary">View Details</button>
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

    <?php
        include 'footer.php';
    ?>
</body>
</html>
