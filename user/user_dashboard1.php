<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Fetch Example</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid g-0">
        <div class="row flex-nowrap">
            <div class="col-auto col-xl-2 col-md-4 col-lg-3 min-vh-100 d-md-flex d-none flex-column justify-content-between">
                <div class="card fil">
                </div>
            </div>
            <div class="col col-md-10">
                <div class="main-content justify-content-center align-items-center">
                    <div class="container mt-5">
                        <div class="mb-3">
                            <div class="row-5 sBox align-items-center g-0">
                                <input type="text" class="form-control col-auto g-0" placeholder="Search categories" id="categorySearch">
                                <button class="btn col-1 sbtn" type="button" id="searchButton"><i class="fa fa-search text-light"></i></button>
                            </div>
                        </div>
                        <div class="row">
                            <h3>All Categories</h3>
                        </div>
                        <div class="scroll-container text-center" id="categoryButtons">
                            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="business" value="business" onclick="filterEvents(this.id)">Business</button>
                            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="comedy" value="comedy" onclick="filterEvents(this.id)">Comedy</button>
                            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="beauty" value="beauty" onclick="filterEvents(this.id)">Beauty</button>
                            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="culture" value="culture" onclick="filterEvents(this.id)">Culture</button>
                            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="dance" value="dance" onclick="filterEvents(this.id)">Dance</button>
                            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="education" value="education" onclick="filterEvents(this.id)">Education</button>
                            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="health" value="health" onclick="filterEvents(this.id)">Health</button>
                            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="music" value="music" onclick="filterEvents(this.id)">Music</button>   
                            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="sports" value="sports" onclick="filterEvents(this.id)">Sports</button>            
                        </div>
                    </div>
                
                    <div class="container table-responsive mt-3"></div>
                    <div id="events" class="mt-5 g-0">
                        <!-- Events will be shown here -->
                    </div>
                    <div id="events-container" class="container d-block g-0 mt-10"></div>
                </div>
            </div>
        </div>
    </div>
    <?php 
    include 'userdashnav.php'; ?>


    <?php include 'user_footer.html'; ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const categoryButtons = document.querySelectorAll(".scroll-item");

            document.getElementById("searchButton").addEventListener("click", function() {
                const searchTerm = document.getElementById("categorySearch").value.toLowerCase();
                categoryButtons.forEach(button => {
                    const buttonText = button.textContent.toLowerCase();
                    if (buttonText.includes(searchTerm)) {
                        button.style.display = "inline-block";
                    } else {
                        button.style.display = "none";
                    }
                });
            });

            setImages();
        });

        function setImages() {
            const buttons = document.querySelectorAll(".hoverA");

            buttons.forEach(button => {
                button.addEventListener("mouseover", function() {
                    const imageValue = button.value;
                    button.style.backgroundImage = `url('../uploads/event_types/${imageValue}.png')`;
                });
                button.addEventListener("click", function() {
                    const imageValue = button.value;
                    button.style.backgroundImage = `url('../uploads/event_types/${imageValue}.png')`;
                });

                button.addEventListener("mouseout", function() {
                    button.style.backgroundImage = "";
                });
            });
        }

        let isLoading = false;
        let offset = 0;
        const limit = 19    ;
        let noMoreEvents = false;
        const displayedEventIDs = new Set();

        async function fetchEventPosters() {
            try {
                if (isLoading || noMoreEvents) return;
                isLoading = true;

                const response = await fetch('../fetchEvents.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ action: 'fetchPaginatedEventData', offset: offset, limit: limit }),
                });

                const event = await response.json();
                console.log(event);

                const eventsArray = Object.values(event);

                if (eventsArray.length === 0) {
                    noMoreEvents = true;
                    return;
                }

                const eventsContainer = document.getElementById('events-container');
               
                eventsArray.forEach(event => {
                    if (displayedEventIDs.has(event.EventID)) return;

                    const eventDiv = document.createElement('div');
                    eventDiv.classList.add('col-lg-3', 'col-md-3', 'col-sm-6', 'col-6', 'mb-4','g-none', 'd-inline-block');
                    const poster = event.Posters && event.Posters.length > 0 ? event.Posters[0] : '';
                    eventDiv.innerHTML = `
                        <div class="card h-100">
                            <img src="${poster}" class="card-img-top img-fluid event-poster" alt="${event.EventID}">
                            <div class="card-body">   <p>${event.EventName}</p>
                            <p>${event.VenueAddress}</p></div>
                            <div class="card-footer text-center">
                                <form action="get_details.php" method="POST">
                             
                                    <input type="hidden" name="id" value="${event.EventID}">
                                    <button type="submit" class="btn btn-primary">View Details</button>
                                </form>
                            </div>
                        </div>
                    `;

                    eventsContainer.appendChild(eventDiv);
                    displayedEventIDs.add(event.EventID);
                });

                offset += limit;
                isLoading = false;
            } catch (error) {
                console.error('Error fetching event posters:', error);
                isLoading = false;
            }
        }

        function onScroll() {
            const { scrollTop, clientHeight, scrollHeight } = document.documentElement;
            if (scrollTop + clientHeight >= scrollHeight - 5) {
                fetchEventPosters();
            }
        }

        window.addEventListener('scroll', onScroll);

        // Initial fetch
        fetchEventPosters();

        async function filterEvents(id) {
            offset = 0; // Reset the offset
            noMoreEvents = false; // Reset the no more events flag
            displayedEventIDs.clear(); // Clear the set of displayed event IDs
            document.getElementById('events-container').innerHTML = ''; // Clear current events

            try {
                if (isLoading) return;
                isLoading = true;

                const response = await fetch('../fetchEvents.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ action: 'GetEventsByCatagory', offset: offset,limit: limit, Catagory: id }),
                });

                const events = await response.json();
                console.log(events);

                const eventsArray = Object.values(events);

                if (eventsArray.length === 0) {
                    noMoreEvents = true;
                    return;
                }

                const eventsContainer = document.getElementById('events-container');
                eventsArray.forEach(event => {
    if (displayedEventIDs.has(event.EventID)) return;

    const eventDiv = document.createElement('div');
    eventDiv.classList.add('col-lg-3', 'col-md-3', 'col-sm-6', 'col-6', 'mb-4', 'd-inline-block');

    // Check if posters array exists and has at least one poster
    const poster1 = event.Posters && event.Posters.length > 0 ? event.Posters[0] : '';

    eventDiv.innerHTML = `
        <div class="card h-100">
            <img src="${poster1}" class="card-img-top event-poster" alt="${event.EventID}">
            <div class="card-body"></div>
            <div class="card-footer text-center">
                <form action="get_details.php" method="POST">
                    <input type="hidden" name="id" value="${event.EventID}">
                    <button type="submit" class="btn btn-primary">View Details</button>
                </form>
            </div>
        </div>
    `;

    eventsContainer.appendChild(eventDiv);
    displayedEventIDs.add(event.EventID);
});


                offset += limit;
                isLoading = false;
            } catch (error) {
                console.error('Error fetching filtered events:', error);
                isLoading = false;
            }
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
