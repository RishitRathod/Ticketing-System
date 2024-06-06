<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Fetch Example</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include 'userdashnav.php'; ?>

    <div class="container mt-5">
        <div class="mb-3">
            <div class="row-5 sBox align-items-center">
                <input type="text" class="form-control col-auto" placeholder="Search categories" id="categorySearch">
                <button class="btn btn-outline-secondary col-1 sbtn" type="button" id="searchButton">Search</button>
            </div>
        </div>
        <div class="row">
            <h3>All Categories</h3>
        </div>
        <div class="scroll-container text-center" id="categoryButtons">
            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="business" value="business" onclick="filterevents(this.id)">Business</button>
            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="comedy" value="comedy" onclick="filterevents(this.id)">Comedy</button>
            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="beauty" value="beauty" onclick="filterevents(this.id)">Beauty</button>
            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="culture" value="culture" onclick="filterevents(this.id)">Culture</button>
            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="dance" value="dance" onclick="filterevents(this.id)">Dance</button>
            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="education" value="education" onclick="filterevents(this.id)">Education</button>
            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="health" value="health" onclick="filterevents(this.id)">Health</button>
            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="music" value="music" onclick="filterevents(this.id)">Music</button>   
            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="sports" value="sports" onclick="filterevents(this.id)">Sports</button>            
        </div>
    </div>

    <div class="container table-responsive mt-3"></div>
    <div id="events">
        <!-- Events will be shown here -->
    </div>

    <div id="events-container" class="container d-block"></div>

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
        const limit = 20;
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
                    eventDiv.classList.add('col-lg-3', 'col-md-3', 'col-sm-6', 'col-6', 'mb-4', 'd-inline-block');

                    eventDiv.innerHTML = `
                        <div class="card h-100">
                            <img src="${event.Posters}" class="card-img-top event-poster" alt="${event.EventID}">
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
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
