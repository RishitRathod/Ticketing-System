<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Event Fetch Example</title>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css"> -->
    <style>
        .event-poster {
            width: 100%;
            /* Ensure the image takes up the full width of the card */
            height: 200px;
            /* Set a fixed height for the images */
            object-fit: cover;
            /* Ensure the image covers the entire area without distortion */
            aspect-ratio: 1/1;
        }

        /* p {
            margin-top: 100px;
        } */

        .filterPanel {
            height: max-content;
            background-color: #1b155d;
            z-index: 999;
            margin: 10px;
            /* position: relative; */
        }

        #searchButton {
            border-bottom-right-radius: 10px;
            border-top-right-radius: 10px;
        }


        .filt {
            /* margin-top: 8%; */
            /* margin-left: 4%; */

            padding: 5px;
            background-color: #1b155d;
            z-index: 250;
            /* border-bottom-left-radius: 10px;
        border-top-left-radius: 10px; 
        border-bottom-right-radius: 10px;
        border-top-right-radius: 10px;        */
        }

        select {
            background-color: #1b155d;
            border-bottom-left-radius: 10px;
            border-top-left-radius: 10px;
            /* background: transparent; */
            color: white;
            border: none;
            padding: 6px 12px;
        }

        .input-group-addon button {
            padding: 6px 12px;
            color: white;
            border: none;
            background-color: #1b155d;
        }

        .input-group-addon {
            padding: 0 !important;
        }

        p button i {
            position: fixed;
            bottom: 40px;
            /* Adjust as needed */
            right: 40px;
            /* Adjust as needed */
            padding: 20px;
            background-color: #1b155d;
            /* Example background color */
            color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            /* Optional: Add shadow for better visibility */
            z-index: 999;
        }

        .ch {
            position: fixed;
            width: 250px !important;
            height: 1100px !important;

            background: #1b155d;
            /* Example background color */
            height: inherit;
            top: 100px;
            left: 0px;
            z-index: 990;
        }

        #toggleDiv1 {
            width: 0px;
        }

        .custom-wrapper {
            width: 220px;
        }
        /* .topM {
            padding-top: 50px !important;
        } */
        .ok{
            height: 100px !important;
        }
        .col-md-1,.col-md-0{
            transition: 0.1s;
        }
        .toggleDiv1{
            display: "none";
            transition: all 1s ease-in;
        }

        @media (min-width: 760px) {
            .filterPanel {
                width: 220px;
            }

        }

        @media (max-width: 768px) {
            .filterPanel {
                display: inline-block;
                height: max-content;
            }
            p button i {
                bottom: 20px;
                right: 20px;
                padding: 20px;
                color: #fff;
            }
            .filterPanel .btn-check {
                display: inline;
            }

            p button {
                position: fixed;
                bottom: 30px;
                /* Adjust as needed */
                right: 30px;
                /* Adjust as needed */
                padding: 10px;
                background-color: #1b155d;
                /* Example background color */
                color: #fff;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
                /* Optional: Add shadow for better visibility */
                z-index: 999;
            }

            .custom-wrapper , .custom-wrapper button{
                width: 200px;
                font-size: 80%;
            }

            .ch {
                /* top: 80px; */
                left: 0px;
                z-index: 990;
                background-color: #00000000;
            }   
        }


        .box{
            width: fit-content;
            position: relative;
            text-align: left;
            z-index: 1;
            opacity: 0;
            left: -500px;
            pointer-events: none;
            transition: 0.3s;
        }
        .active_box{
            opacity: 1;
            left: 0px;
            pointer-events: fill;
        }
        

    </style>
</head>

<body>
    <?php
    include 'userdashnav.php'; ?>
    <p>
        <button class="filt" type="button" onclick="toggleDivClass()"> <i class="fa fa-filter"></i></button>
    </p>
    <div class="d-flex mx-auto pt-2 top-0 g-0 p-0">
        <div class="box text-light filt mt-5 g-0" id="toggleDiv1">
            <form action="filterEvents.php" method="get">
                <div class="custom-wrapper filt">
                    <div class="header">
                        <p class="projtitle mt-4" align="center">
                            <strong>Sort By</strong>
                        </p>
                    </div>
                    <div>
                        <strong>Duration</strong>
                        <div class="btn-group-horizontal btn-group-md-vertical" role="group" aria-label="Vertical radio toggle button group">
                            <input type="checkbox" class="btn-check" name="thisD" id="Today" autocomplete="off">
                            <label class="btn btn-outline-primary" for="Today">Today</label>
                            <input type="checkbox" class="btn-check" name="thisW" id="ThisWeek" autocomplete="off">
                            <label class="btn btn-outline-primary" for="ThisWeek">This Week</label>
                            <input type="checkbox" class="btn-check" name="thisM" id="ThisMonth" autocomplete="off">
                            <label class="btn btn-outline-primary" for="ThisMonth">This Month</label>
                        </div>
                        <strong>Sort By Price</strong>
                        <div class="btn-group-horizontal btn-group-md-vertical" role="group" aria-label="Vertical radio toggle button group">
                            <input type="radio" class="btn-check" name="priceOrder" id="HighToLow" autocomplete="off">
                            <label class="btn btn-outline-primary" for="HighToLow"> High to Low</label>
                            <input type="radio" class="btn-check" name="priceOrder" id="LowToHigh" autocomplete="off">
                            <label class="btn btn-outline-primary" for="LowToHigh"> Low to High</label>
                        </div>
                    </div>
                </div>
                <div class="custom-wrapper filt p-1">
                    <div class="header">
                        <div class="projtitle">
                            <strong>Price Range Slider</strong>
                        </div>
                    </div>
                    <div class="price-input-container pl-3">
                        <div class="price-input row-12 justify-content-center d-block">
                            <div class="price-field col-5 d-inline">
                                <span>Min. Price</span>
                                <input type="number" name="MinPrice" id="MinPrice" class="min-input w-75 form-control" value="2500">
                            </div>
                            <div class="price-field col-5 d-inline">
                                <span>Max. Price</span>
                                <input type="number" name="MaxPrice" id="MaxPrice" class="max-input w-75 form-control" value="8500">
                            </div>
                        </div>
                        <div class="slider-container">
                            <div class="price-slider">
                                <div class="range-input">
                                    Min ₹- <input type="range" class="min-range" min="0" max="10000" value="2500" step="1"> <br>
                                    Max ₹-<input type="range" class="max-range" min="0" max="10000" value="8500" step="1">
                                </div>
                            </div>
                        </div>
                        <div class="row g-2 mt-2">
                            <button type="submit" class="btn btn-outline-success col-5 m-1" id="applyFil">Apply</button>
                            <button type="button" class="btn btn-outline-danger col-5 m-1" id="clearFil" onclick="window.location.href='user_dashboard1.php'">Clear</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="mt-5 mx-auto g-0" id="toggleDiv2">
            <div class="container mt-5 g-0">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <select id="SearchBarSelect" name="SearchBarSelect">
                                    <option value="All">All</option>
                                    <option value="City">City</option>
                                    <option value="State">State</option>
                                    <option value="Country">Country</option>
                                </select>
                            </span>
                            <input id="categorySearch" type="text" class="form-control" placeholder="Search categories">
                            <span class="input-group-addon">
                                <button type="button" id="searchButton" onclick="applyFilters(event)">Search</button>
                            </span>
                        </div>
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
                    <button class="scroll-item btn m-2 py-3 px-5 rounded-6 hoverA" id="Experience" value="Experience" onclick="filterEvents(this.id)">Experience</button>
                </div>
            </div>
            <div class="container table-responsive mt-1"></div>
            <div id="events" class="mt-3 d-block">
                <!-- Events will be shown here -->
            </div>
            <div id="events-container" class="container d-block mt-1 p-0"></div>
        </div>
    </div>

    <?php include 'user_footer.html'; ?>
    <script>
        let menu_icon_box = document.querySelector(".filt");
        let box = document.querySelector(".box");


        menu_icon_box.onclick = function(){
            menu_icon_box.classList.toggle("active");
            box.classList.toggle("active_box");
        }
        document.onclick = function(e){
            if (!menu_icon_box.contains(e.target) && !box.contains(e.target) ) {
                menu_icon_box.classList.remove("active");
                box.classList.remove("active_box");
            }
        }
    </script>
    <script>

        document.addEventListener('DOMContentLoaded', function () {
            const images = document.querySelectorAll('img[data-default]');

            images.forEach(img => {
                img.onerror = function () {
                    this.src = this.getAttribute('data-default');
                }
            });
        });
    </script>
    <script>
        function applyFilters(event) {
            event.preventDefault();
           let data = {
            //searchTerm: document.getElementById('categorySearch').value ? document.getElementById('categorySearch').value : null,
            searchTerm: document.getElementById('SearchBarSelect').value ? document.getElementById('SearchBarSelect').value : null,
            duration: document.querySelector('input[name="vbtn-radio"]:checked') ? document.querySelector('input[name="vbtn-radio"]:checked').id : null,
            price: document.querySelector('input[name="h"]:checked') ? document.querySelector('input[name="h"]:checked').id : null,
            minPrice: document.getElementById('MinPrice').value ? document.getElementById('MinPrice').value : null,
            maxPrice: document.getElementById('MaxPrice').value ? document.getElementById('MaxPrice').value : null        
        };
        console.log(data);
            getFilteredEvents(data);
           }




        
        
        async function getFilteredEvents(data){
            const response = await fetch('filterEvents.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });

            const events = await response.json();
            console.log(events);
        }
        // function toggleDivClass() {
        //     const div1 = document.getElementById('toggleDiv1');
        //     const div2 = document.getElementById('toggleDiv2');
        //     if (div2.classList.contains('col-12')) {
        //         div2.classList.remove('col-12');
        //         div2.classList.add('col-10');
        //         div1.classList.remove('col-0');
        //         div1.classList.add('col-2');
        //         // div1.style.display = 'none';
        //     } else if(div2.classList.contains('col-10')) {
        //         div1.classList.remove('col-2');
        //         div1.classList.add('col-0');
        //         div2.classList.remove('col-10');
        //         div2.classList.add('col-12');
        //         // div1.style.display = 'block';

        //     }
        // }
    </script>
    <script>



        const rangevalue = document.querySelector(".slider-container .price-slider");
        const rangeInputvalue = document.querySelectorAll(".range-input input");

        // Set the price gap 
        let priceGap = 500;

        // Adding event listners to price input elements 
        const priceInputvalue =
            document.querySelectorAll(".price-input input");
        for (let i = 0; i < priceInputvalue.length; i++) {
            priceInputvalue[i].addEventListener("input", e => {

                // Parse min and max values of the range input 
                let minp = parseInt(priceInputvalue[0].value);
                let maxp = parseInt(priceInputvalue[1].value);
                let diff = maxp - minp

                if (minp < 0) {
                    alert("minimum price cannot be less than 0");
                    priceInputvalue[0].value = 0;
                    minp = 0;
                }

                // Validate the input values 
                if (maxp > 10000) {
                    alert("maximum price cannot be greater than 10000");
                    priceInputvalue[1].value = 10000;
                    maxp = 10000;
                }

                if (minp > maxp - priceGap) {
                    priceInputvalue[0].value = maxp - priceGap;
                    minp = maxp - priceGap;

                    if (minp < 0) {
                        priceInputvalue[0].value = 0;
                        minp = 0;
                    }
                }

                // Check if the price gap is met  
                // and max price is within the range 
                if (diff >= priceGap && maxp <= rangeInputvalue[1].max) {
                    if (e.target.className === "min-input") {
                        rangeInputvalue[0].value = minp;
                        let value1 = rangeInputvalue[0].max;
                        rangevalue.style.left = `${(minp / value1) * 100}%`;
                    }
                    else {
                        rangeInputvalue[1].value = maxp;
                        let value2 = rangeInputvalue[1].max;
                        rangevalue.style.right =
                            `${100 - (maxp / value2) * 100}%`;
                    }
                }
            });

            // Add event listeners to range input elements 
            for (let i = 0; i < rangeInputvalue.length; i++) {
                rangeInputvalue[i].addEventListener("input", e => {
                    let minVal =
                        parseInt(rangeInputvalue[0].value);
                    let maxVal =
                        parseInt(rangeInputvalue[1].value);

                    let diff = maxVal - minVal

                    // Check if the price gap is exceeded 
                    if (diff < priceGap) {

                        // Check if the input is the min range input 
                        if (e.target.className === "min-range") {
                            rangeInputvalue[0].value = maxVal - priceGap;
                        }
                        else {
                            rangeInputvalue[1].value = minVal + priceGap;
                        }
                    }
                    else {

                        // Update price inputs and range progress 
                        priceInputvalue[0].value = minVal;
                        priceInputvalue[1].value = maxVal;
                        rangevalue.style.left =
                            `${(minVal / rangeInputvalue[0].max) * 100}%`;
                        rangevalue.style.right =
                            `${100 - (maxVal / rangeInputvalue[1].max) * 100}%`;
                    }
                });
            }
        }
    </script>
    <script>
        let currentFilter = '';
        let isLoading = false;
        let offset = 0;
        const limit = 19;
        let noMoreEvents = false;
        const displayedEventIDs = new Set();

        document.addEventListener("DOMContentLoaded", function () {
            const categoryButtons = document.querySelectorAll(".scroll-item");

            document.getElementById("searchButton").addEventListener("click", function () {
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
            fetchEventPosters(); // Initial fetch of events
        });

        function setImages() {
            const buttons = document.querySelectorAll(".hoverA");

            buttons.forEach(button => {
                button.addEventListener("mouseover", function () {
                    const imageValue = button.value;
                    button.style.backgroundImage = `url('../uploads/event_types/${imageValue}.png')`;
                });
                button.addEventListener("click", function () {
                    const imageValue = button.value;
                    button.style.backgroundImage = `url('../uploads/event_types/${imageValue}.png')`;
                });

                button.addEventListener("mouseout", function () {
                    button.style.backgroundImage = "";
                });
            });
        }

        async function fetchEventPosters() {
            if (isLoading || noMoreEvents) return;
            isLoading = true;

            try {
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
                if (!eventsContainer) {
                    console.error('eventsContainer element not found');
                }

                eventsArray.forEach(event => {
                    if (displayedEventIDs.has(event.EventID)) return;

                    // Debugging logs
                    console.log('Processing event:', event);

                    if (!event.EventID) {
                        console.error('EventID is missing for event:', event);
                        return;
                    }

                    const eventDiv = document.createElement('div');
                    eventDiv.classList.add('col-lg-3', 'col-md-3', 'col-sm-6', 'col-12', 'mb-4', 'd-inline-block');

                    const poster = event.Posters && event.Posters.length > 0 ? event.Posters[0] : '';
                    if (!poster) {
                        console.warn('No poster found for event:', event);
                    }

                    const  eventName = event.EventName ? event.EventName : 'Event name not available';
                    const venueAddress = event.VenueAddress ? event.VenueAddress : 'Venue address not available';

                    eventDiv.innerHTML = `
                        <div class="card d-block h-100" style="max-width: 300px">
                            <img src="${poster}" class="card-img-top event-poster" alt="${event.EventID}" style="max-height: 200px; object-fit: cover;">
                            <div class="px-4 py-2 ok overflow-auto">
                                <p style="font-size: 16px; font-weight: bold; margin-bottom: 8px;">${eventName}</p>
                                <div style="font-size: 14px; margin-bottom: 8px; line-height: 1.4;">${venueAddress}</div>
                            </div>
                            <div class="card-footer text-center">
                                <form action="get_details.php" method="POST">
                                    <input type="hidden" name="id" value="${event.EventID}">
                                    <button type="submit" class="btn btn-primary" style="width: 100%;">View Details</button>
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
                if (currentFilter) {
                    filterEvents(currentFilter, false); // Fetch filtered events on scroll
                } else {
                    fetchEventPosters(); // Fetch more events if no filter is applied
                }
            }
        }

        window.addEventListener('scroll', onScroll);

        async function filterEvents(id, isNewFilter = true) {
            currentFilter = id;
            if (isNewFilter) {
                offset = 0; // Reset the offset
                noMoreEvents = false; // Reset the no more events flag
                displayedEventIDs.clear(); // Clear the set of displayed event IDs
                document.getElementById('events-container').innerHTML = ''; // Clear current events
            }

            if (isLoading || noMoreEvents) return;
            isLoading = true;

            try {
                const response = await fetch('../fetchEvents.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ action: 'GetEventsByCatagory', offset: offset, limit: limit, Catagory: id }),
                });

                const events = await response.json();
                console.log(events);

                const eventsArray = Object.values(events);

                if (eventsArray.length === 0) {
                    noMoreEvents = true;
                    return;
                }

                const eventsContainer = document.getElementById('events-container');
                if (!eventsContainer) {
                    console.error('eventsContainer element not found');
                }

                eventsArray.forEach(event => {
                    if (displayedEventIDs.has(event.EventID)) return;

                    // Debugging logs
                    console.log('Processing event:', event);

                    if (!event.EventID) {
                        console.error('EventID is missing for event:', event);
                        return;
                    }

                    const eventDiv = document.createElement('div');
                    eventDiv.classList.add('col-lg-3', 'col-md-3', 'col-sm-6', 'col-6', 'mb-4', 'd-inline-block');

                    const poster1 = event.Posters && event.Posters.length > 0 ? event.Posters[0] : '';
                    if (!poster1) {
                        console.warn('No poster found for event:', event);
                    }

                    const  eventName = event.EventName ? event.EventName : 'Event name not available';
                    const venueAddress = event.VenueAddress ? event.VenueAddress : 'Venue address not available';

                    eventDiv.innerHTML = `
    <div class="card d-block h-100" style="max-width: 300px;">
        <img src="${poster1}" class="card-img-top event-poster" alt="${event.EventID}" style="max-height: 200px; object-fit: cover;">
        <div class="card-body" style="min-height: 100px;">
            <p style="font-size: 16px; font-weight: bold; margin-bottom: 8px;">${eventName}</p>
            <div style="font-size: 14px; margin-bottom: 8px; line-height: 1.4;">${venueAddress}</div>
        </div>
        <div class="card-footer text-center">
            <form action="get_details.php" method="POST">
                <input type="hidden" name="id" value="${event.EventID}">
                <button type="submit" class="btn btn-primary" style="width: 100%;">View Details</button>
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