<?php
// include 'navhead.php';
?>
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
            display: flex;
            flex-direction: column;
            height: 10%;
            border-radius:20px !important;
            box-shadow: 3px 3px 20px #3E00FF20;
        }
        .card{
            max-height: 350px !important;
        }
        .event-poster {
            max-height: 350px !important;
            object-fit: cover;
            max-width: 90%;
            margin: 3vmin;
            border-radius:20px !important;;
        }
        .event-poster img{
            object-fit: cover;
        }
        .event-details { 
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin-left:3vmin;
            margin-top:4vmin;
            /* font-size: 3vw; */
        }
        @media (max-width: 765px) {
            .event-details {
                margin-top: 0 !important;
                font-size: 3vw;
            }
        }

        /* app ui css  */
            .btn-22,
            .btn-22 *,
            .btn-22 :after,
            .btn-22 :before,
            .btn-22:after,
            .btn-22:before {
            border: 0 solid;
            box-sizing: border-box;
            }
            .btn-22 {
                color:white;
                -webkit-tap-highlight-color:transparent;
                -webkit-appearance: button;
                background-color: #3E00FF;
                background-image: none;
                color:#fff;
                cursor: pointer;
                font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont,
                    Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif,
                    Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
                font-size: 100%;
                font-weight: 900;
                line-height: 1.5;
                margin: 0;
                -webkit-mask-image: -webkit-radial-gradient(#000, #fff);
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
                vertical-align: middle;
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
                mix-blend-mode: lighten;
            }
            .btn-22:before {
                color:black;
                aspect-ratio: 1;
                background:#000;
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
        /* end of app ui css  */
        

        /* .date{
          
            font-weight: bolder;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
        } */
    </style>
</head>
<body>
    <?php 
    include 'navhead.php'; ?>

    <!-- Main Content -->
    <div id="eventsContainer">
    <div class="input-group rounded">
    <input type="search" name="searchbar" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
            <span  id="search-addon">
                <button name="searchbt" id="searchbtn" class="btn btn-primary" onclick="sortEventsByName()" >Search events</button>
            </span>
</div>
        <div id="eventsContainer">
        <h2 class="py-2" align="center">Events</h2>
        <div id="ongoingEvents" class="event-category">
            <h3>Ongoing Events</h3>
            <div id="ongoingEventsRow" class=""></div>
        </div>
        <div id="upcomingEvents" class="event-category">
            <h3>Upcoming Events</h3>
            <div id="upcomingEventsRow" class=""></div>
        </div>
        <div id="pastEvents" class="event-category">
            <h3>Past Events</h3>
            <div id="pastEventsRow" class=""></div>
        </div>
    </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> -->
    <script src="../script.js"></script>
    <script>
        function perfromSerch(){
            var search = document.getElementsByName("searchbar")[0].value;
            console.log(search);

            if(search == ""){
                alert("Please enter a search value");
            }else{
                const OrgID =  getCookieValue('id');
                var data ={
                    OrgID: OrgID,
                    searchTerm: search,
                    action:'SearchEvents'
                } 
                fetch("../fetchOrgs.php", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: data
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Success:', data);
                    populateEvents(data);
                })
            }
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



           const getCookieValue = (name) => {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
};



         console.log(getCookieValue('id'));
        async function fetchData(tableName) {
            try {
                console.log(document.cookie);
                const OrgID =  getCookieValue('id');
                console.log(OrgID);
                const response = await fetch("organization_events_backend.php", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ tablename: tableName, OrgID: OrgID }),
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
            categorizeAndPopulateEvents(data);
        }

        function categorizeAndPopulateEvents(events) {
            const ongoingEventsRow = document.querySelector('#ongoingEventsRow');
            const upcomingEventsRow = document.querySelector('#upcomingEventsRow');
            const pastEventsRow = document.querySelector('#pastEventsRow');

            if (!Array.isArray(events)) {
                console.error('Expected an array but got:', events);
                return;
            }

            
            const currentDate1 = new Date();
const currentDate = new Date(currentDate1);
currentDate.setDate(currentDate.getDate());

            const uniqueEvents = events.reduce((acc, event) => {
    if (!acc[event.EventID]) {
        acc[event.EventID] = {
            ...event,
            posters: new Set([event.poster]),
            timeSlots: new Set([{
                TimeSlotID: event.TimeSlotID,
                StartTime: event.StartTime,
                EndTime: event.EndTime,
                Availability: event.Availability
            }]),
            tickets: new Set([{
                TicketID: event.TicketID,
                TicketType: event.TicketType,
                Quantity: event.Quantity,
                LimitQuantity: event.LimitQuantity,
                Discount: event.Discount,
                Price: event.Price
            }])
        };
    } else {
        acc[event.EventID].posters.add(event.poster);
        acc[event.EventID].timeSlots.add({
            TimeSlotID: event.TimeSlotID,
            StartTime: event.StartTime,
            EndTime: event.EndTime,
            Availability: event.Availability
        });
        acc[event.EventID].tickets.add({
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
    uniqueEvents[eventID].timeSlots = Array.from(uniqueEvents[eventID].timeSlots);
    uniqueEvents[eventID].tickets = Array.from(uniqueEvents[eventID].tickets);
});

console.log(uniqueEvents);


            ongoingEventsRow.innerHTML = '';
            upcomingEventsRow.innerHTML = '';
            pastEventsRow.innerHTML = '';

            Object.values(uniqueEvents).forEach((event) => {
                const eventStartDate = new Date(event.StartDate);
                const eventEndDate = new Date(event.EndDate);

                const eventCard = document.createElement('div');
                eventCard.classList.add('col-14', 'mb-4');

                const posterIndicators = event.posters.map((poster, index) => `
                    <li data-target="#carousel${event.EventID}" data-slide-to="${index}" class="${index === 0 ? 'active' : ''}"></li>
                `).join('');

                const posterItems = event.posters.map((poster, index) => `
                    <div class="poster carousel-item ${index === 0 ? 'active' : ''}">
                        <img src="${poster}" class=" event-poster" alt="Event Poster">
                    </div>
                `).join('');

                eventCard.innerHTML = `
                    <div class="card event-card">
                        <div class="row">
                            <div class="col-md-5">
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
                            <div class="col-md-7">
                                <div class="card-body event-details">
                                    <b><h5 class="card-title">${event.EventName}</h5></b>
                                    <div class="card-text date rounded-end-circle">
                                        <strong>Time:</strong> 
                                        <div>
                                            <div class="startD d-inline">${formatDate(event.StartDate)}</div> 
                                            <div class="d-inline">to</div> 
                                            <div class="endD d-inline">${formatDate(event.EndDate)}</div>
                                        </div>
                                    </div>

                                    <p class="card-text"><strong>Available Tickets:</strong> ${event.AvailableTickets}</p>
                                    <div class="text-center">
                                        <form action="organization_eventdetails.php" method="post" style="display:inline;">
                                            <input type="hidden" name="id" value="${event.EventID}">
                                            <button type="submit" class="btn-22"><span>View Details</span></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                if (eventStartDate <= currentDate && eventEndDate >= currentDate) {
                    // Ongoing Events
                    ongoingEventsRow.appendChild(eventCard);
                } else if (eventStartDate > currentDate) {
                    // Upcoming Events
                    upcomingEventsRow.appendChild(eventCard);
                } else if (eventEndDate < currentDate) {
                    // Past Events
                    pastEventsRow.appendChild(eventCard);
                }
            });
        }


        function sortEventsByName() {
            const searchValue = document.getElementsByName("searchbar")[0].value.toLowerCase();
            const events = document.querySelectorAll('.event-card');

            events.forEach(eventCard => {
                const eventName = eventCard.querySelector('.card-title').innerText.toLowerCase();
                if (eventName.includes(searchValue)) {
                    eventCard.style.display = 'block';
                } else {
                    eventCard.style.display = 'none';
                }
            });
        }


        window.onload = initialize;

        function formatDate(dateStr) {
    const date = new Date(dateStr);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-based
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
}
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>
