<?php
// include 'navhead.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events with Log-Data </title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .event-card {
            display: flex;
            flex-direction: column;
            height: 10%;
            border-radius: 20px !important;
            box-shadow: 3px 3px 20px #3E00FF20;
        }
        .event-poster {
            max-height: 200px;
            object-fit: cover;
            width: 90%;
            margin: 3vmin;
            border-radius: 20px !important;
        }
        .event-details {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin-left: 3vmin;
            margin-top: 4vmin;
        }
        @media (max-width: 765px) {
            .event-details {
                margin-top: 0 !important;
                font-size: 3vw;
            }
        }
        .btn-22, .btn-22 *, .btn-22 :after, .btn-22 :before, .btn-22:after, .btn-22:before {
            border: 0 solid;
            box-sizing: border-box;
        }
        .btn-22 {
            color: white;
            -webkit-tap-highlight-color: transparent;
            /* -webkit-appearance: button; */
            background-color: #3E00FF;
            background-image: none;
            color: #fff;
            cursor: pointer;
            font-family: ui-sans-serif, system-ui, -apple-system,
              BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue,
              Arial, Noto Sans, sans-serif, Apple Color Emoji, 
              Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            font-size: 100%;
            font-weight: 900;
            line-height: 1.5;
            margin: 0;
            /* -webkit-mask-image: -webkit-radial-gradient(#000, #fff); */
            padding: 0;
            text-transform: uppercase;
        }
        .btn-22:disabled {
            cursor: default;
        }
        .btn-22:-moz-focusring {
            outline: auto;
        }
        .btn-22 svg {
            display: block;
            /* vertical-align: middle; */
        }
        .btn-22 [hidden] {
            display: none;
        }
        .btn-22 {
            border-radius: 99rem;
            border-width: 2px;
            overflow: hidden;
            padding: 0.8rem 3rem;
            position: relative;
        }
        .btn-22 span {
            mix-blend-mode: hard-light;
        }
        .btn-22:before {
            color: black !important;
            aspect-ratio: 1;
            background-color: #00000040 ;
            border-radius: 50%;
            content: "";
            left: -100%;
            position: absolute;
            top: 50%;
            transform: translateY(-50%) scale(1);
            transform-origin: left center;
            transition: transform 0.2s ease;
            width: 100%;
        }
       

        .btn-22:hover:before {
            transform: translateY(-50%) scale(2);
        }
    </style>
</head>
<body>
    <?php include 'navhead.php'; ?>

    <div id="eventsContainer">
        <h2 class="py-2">Events</h2>
        <table id="eventsTable" class="table table-responsive table-striped table-bordered">
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Rows will be added here -->
            </tbody>
        </table>
    </div>
    
   
</div>
    <!-- jQuery and Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> -->
    <script src="../script.js"></script>
    <script>
        const getCookieValue = (name) => {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        };

        console.log(getCookieValue('id'));

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
            populateEventsTable(data);
        }

        function populateEventsTable(events) {
            const eventsTable = document.querySelector('#eventsTable tbody');
            if (!Array.isArray(events)) {
                console.error('Expected an array but got:', events);
                return;
            }

            const currentDate = new Date();
            const currentMonth = currentDate.getMonth();
            const currentYear = currentDate.getFullYear();

            eventsTable.innerHTML = '';

            events.forEach((event) => {
                const eventStartDate = new Date(event.StartDate);
                const eventEndDate = new Date(event.EndDate);
                const eventStartMonth = eventStartDate.getMonth();
                const eventStartYear = eventStartDate.getFullYear();
                const eventEndMonth = eventEndDate.getMonth();
                const eventEndYear = eventEndDate.getFullYear();

                let status = '';

                if ((eventStartDate <= currentDate && eventEndDate >= currentDate) && ((eventStartMonth == currentMonth) && (eventStartYear == currentYear))) {
                    status = 'Ongoing';
                } else if ((eventStartDate > currentDate) && ((eventStartMonth >= currentMonth) && (eventStartYear >= currentYear))) {
                    status = 'Upcoming';
                } else if ((eventEndDate < currentDate) || ((eventEndMonth < currentMonth) || (eventEndYear < currentYear))) {
                    status = 'Past';
                }
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${event.EventName}</td>
                    <td>${formatDate(event.StartDate)}</td>
                    <td>${formatDate(event.EndDate)}</td>
                    <td>${status}</td>
                    <td>
                        <form action="Logtable.php" method="post">
                            <input type="hidden" name="id" value="${event.EventID}">
                            <button type="submit" class="btn-22">View Details</button>
                        </form>
                    </td>
                `;
                eventsTable.appendChild(row);
            });

            $('#eventsTable').DataTable({
                aLengthMenu: [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                "processing": true,
                "retrieve": true,
                "responsive": true,
                "autoWidth": false,
                "destroy": true,
                "columnDefs": [
                    {
                        "targets": [3,4],
                        "orderable": false,
                        

                    }
                ],
               
                initComplete: function () {
                    this.api().columns().every(function () {
                        var column = this;
                        if (column.index() === 3) { // Status column index
                            var select = $('<select><option value="">Filter by Status</option></select>')
                                .appendTo($(column.header()).empty())
                                .on('change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );
                                    column
                                        .search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                                });

                            column.data().unique().sort().each(function (d, j) {
                                select.append('<option value="' + d + '">' + d + '</option>');
                            });
                        }
                    });
                }
            });
        }


        window.onload = initialize;
       


        function formatDate(dateStr) {
    const date = new Date(dateStr);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth()).padStart(2, '0'); // Months are zero-based
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
}

    </script>

    <?php include 'footer.php'; ?>
</body>
</html>
