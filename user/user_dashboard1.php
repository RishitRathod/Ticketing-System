<!DOCTYPE html>
<html lang="en">
<head>
  
</head>
<body>
    <?php
     include 'userdashnav.php'; ?>

   
    <div class="container mt-5">
        <div class="mb-3">
            <div class=" row-12">
                <input type="text" class="form-control col-auto " placeholder="Search categories" id="categorySearch">
                <button class="btn btn-outline-secondary col-1 " type="button" id="searchButton">Search</button>
            </div>
        </div>
        <div class="row">
            <h3>All Categories</h3>
        </div>
        <div class="scroll-container text-center" id="categoryButtons">
            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="business" value="business" onclick="filterevents()">Business</button>
            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="comedy" value="comedy" onclick="filterevents()">Comedy</button>
            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="beauty" value="beauty" onclick="filterevents()">Beauty</button>
            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="culture" value="culture" onclick="filterevents()">Culture</button>
            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="dance" value="dance" onclick="filterevents()">Dance</button>
            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="education" value="education" onclick="filterevents()">Education</button>
            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="health" value="health" onclick="filterevents()">Health</button>
            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="music" value="music" onclick="filterevents()">Music</button>   
            <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="sports" value="sports" onclick="filterevents()">Sports</button>            
        </div>
    </div>
<div class="container table-responsive mt-3"></div>
<div id="events">
    <!-- Events will be shown here -->
</div>

    <!-- events will be shown here -->
</div>

    <div id="events-container" class="container d-block" ></div>

    <!-- Your footer content -->
    <?php
include 'user_footer.html';
?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get all category buttons
        const categoryButtons = document.querySelectorAll(".scroll-item");

        // Search functionality
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
    });
</script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        function setImanges(){
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

        async function fetchAllEvents(){
            fetch("", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
            })
            
        }


        document.addEventListener("DOMContentLoaded", setImanges() );
        </script>
        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
     document.addEventListener("DOMContentLoaded", () => {
    fetchEventPosters();

    // Add scroll event listener
    window.addEventListener('scroll', onScroll);
});

let isLoading = false;
let offset = 0;
const limit = 8; // Number of items to fetch per request
let noMoreEvents = false; // Flag to indicate if there are no more events to fetch

async function fetchEventPosters() {
    try {
        if (isLoading || noMoreEvents) return; // Stop fetching if already loading or no more events
        isLoading = true;

        const response = await fetch(`userposter_backend.php?offset=${offset}&limit=${limit}`);
        const events = await response.json();

        if (events.length === 0) {
            noMoreEvents = true; // No more events to fetch
            return;
        }

        const eventsContainer = document.getElementById('events-container');

        events.forEach(event => {
            const eventDiv = document.createElement('div');
            eventDiv.classList.add('col-lg-3', 'col-md-3', 'col-sm-6', 'col-6', 'mb-4', 'd-inline-block'); // Adjust column classes

            eventDiv.innerHTML = `
                <div class="card h-100">
                    <img src="${event.poster}" class="card-img-top event-poster" alt="${event.event_name}">
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
        });

        offset += limit; // Increment offset for next fetch
        isLoading = false;
    } catch (error) {
        console.error('Error fetching event posters:', error);
        isLoading = false;
    }
}

function onScroll() {
    const { scrollTop, clientHeight, scrollHeight } = document.documentElement;
    if (scrollTop + clientHeight >= scrollHeight -5) {
        fetchEventPosters();
    }
}

</script>

