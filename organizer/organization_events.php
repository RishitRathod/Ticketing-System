<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Events</title>
    <!-- DataTables CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"> -->
    <style>
        .loader {
            display: block; 
            width: 50px;
            height: 50px;
            position: fixed;
            left: 50%;
            right: 50%;
            top: 50%;
            border: 8px solid #f9f9f9;
            border-top: 10px solid #010575;
            border-radius: 50px;
            /* transform: translate(-50%, -50%); */
            z-index: 999;
            animation: spin 0.5s linear infinite;
        }
        .event-poster {
            max-height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
        .eventsContainer{
            opacity:0;
        }
    </style>
</head>
<body>
    <?php include 'navhead.php'; ?>
    <div class="loader">
        <i class="fa fa-3x fa-fw"></i><span class="sr-only">Loading...</span>
    </div>
    <!-- Main Content -->
        <div id="eventsContainer">
            <h2 class="py-2" align="center">Events</h2>
            <table id="eventsTable" class="display table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sr. No</th>
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
            const tableId = 'eventsTable';
            $(`#${tableId}`)
                .on('draw.dt', function () {
                    console.log('Loading');
                    showLoader();
                    hideLoader();
                })
                .on('init.dt', function () {
                    console.log('Loaded');
                    hideLoader();
                    spawn("#eventsContainer");

                    // Add any additional initialization logic here
                })
                .DataTable({
                    data: data,
                    columns: [
                        { data: null, render: (data, type, row, meta) => meta.row + 1 },
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
                                    <button type="submit" class="btn btn-primary my-auto p-1" style="font-size: 12px">View Details</button>
                                </form>
                            `
                        }
                    ],
                    processing: true,
                    retrieve: true,
                    responsive: true,
                    autoWidth: false,
                    destroy: true,
                    columnDefs: [
                        {
                            width: '20%',
                            targets: '_all',
                        },
                        {
                            targets: 4,
                            orderable: false,
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
