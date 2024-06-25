<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Events</title>
    <!-- DataTables CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"> -->
    <style>
        .event-poster {
            max-height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <?php include 'navhead.php'; ?>

    <!-- Main Content -->
    <div id="eventsContainer">
        <div class="input-group rounded">
            <input type="search" name="searchbar" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
            <span id="search-addon">
                <button name="searchbt" id="searchbtn" class="btn btn-primary" onclick="performSearch()">Search events</button>
            </span>
        </div>
        <div id="eventsContainer">
            <h2 class="py-2" align="center">Events</h2>
            <table id="eventsTable" class="display">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Start Times</th>
                        <th>End Times</th>
                        <th>Available Tickets</th>
                        <th>Posters</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <!-- DataTables JS -->
    <!-- <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> -->
    <script src="../script.js"></script>
    <script>
        const getCookieValue = (name) => {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        };

        function formatDate(dateStr) {
            const date = new Date(dateStr);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-based
            const year = date.getFullYear();
            return `${day}-${month}-${year}`;
        }

        function performSearch() {
            const searchValue = document.getElementsByName("searchbar")[0].value.toLowerCase();
            $('#eventsTable').DataTable().search(searchValue).draw();
        }

        async function fetchData() {
            try {
                const OrgID = getCookieValue('id');
                const response = await fetch("../fetchEvents.php", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ OrgID: OrgID,action:"FetchEventDetailsByOrgID" }),
                });

                const result = await response.json();
                if (result.status === 'success') {
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
    const data = await fetchData();
    const dataTable = $('#eventsTable').DataTable({
        data: data,
        columns: [
            { data: 'EventName' },
            { data: 'StartDate', render: formatDate },
            { data: 'EndDate', render: formatDate },
            { data: 'StartTimes', render: times => times.join('<br>') },
            { data: 'EndTimes', render: times => times.join('<br>') },
            {
                data: 'TimeSlots',
                render: timeSlots => {
                    const totalAvailability = timeSlots.reduce((sum, slot) => sum + (parseInt(slot.Availability) || 0), 0);
                    return totalAvailability;
                }
            },
            {
                        data: 'Posters',
                        render: posters => {
                            const uniqueId = Math.random().toString(36).substr(2, 9);
                            const posterItems = posters.map((poster, index) => `
                                <div class="carousel-item ${index === 0 ? 'active' : ''}">
                                    <img src="${poster}" class="d-block w-100 event-poster" alt="Poster">
                                </div>
                            `).join('');
                            return `
                                <div id="carousel${uniqueId}" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        ${posterItems}
                                    </div>
                                    <a class="carousel-control-prev" href="#carousel${uniqueId}" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carousel${uniqueId}" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            `;
                        }
                    },
            {
                data: 'EventID',
                render: eventID => `
                    <form action="organization_eventdetails.php" method="post" style="display:inline;">
                        <input type="hidden" name="id" value="${eventID}">
                        <button type="submit" class="btn btn-primary">View Details</button>
                    </form>
                `
            }
        ]
    });
}


        $(document).ready(() => {
            initialize();
        });
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>
