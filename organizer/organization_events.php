<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Events</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
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
                    { data: 'AvailableTickets' },
                    {
                        data: 'Posters',
                        render: posters => posters.map(poster => `<img src="${poster}" class="event-poster" alt="Poster">`).join(' ')
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
