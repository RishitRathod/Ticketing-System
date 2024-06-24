
<?php
    include 'navhead.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration</title>
    <script>
function isUserLoggedIn() {
                    const cookies = document.cookie.split(';').map(cookie => cookie.trim());
                   if(!cookies){
                       console.log("User is not logged in");
                       return false;}
                    for (const cookie of cookies) {
                        if (cookie.startsWith('role=')) {
                            console.log("User is logged in");
                            return true;
                        }
                    }
                    console.log("User is not logged in");
                    return false;
            }

            if (!isUserLoggedIn()) {
                window.location.href = './login.html';
            }

    </script>

    <!-- date picker ui -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.0.2/dist/css/coreui.min.css" rel="stylesheet" integrity="sha384-39e9UaGkm/+yp6spIsVfzcs3j7ac7G2cg0hzmDvtG11pT1d7YMnOC26w4wMPhzsL" crossorigin="anonymous"> -->
    <style>

        .poster-input {
            margin-bottom: 10px;
        }
        .poster-preview-img {
            display: block;
            width: 150px;
            height: 150px;
            margin-top: 10px;
        }
    
        .step {
            display: none;
        }
        .step.active {
            display: block;
        }
        fieldset {
            border: solid 1px gray;
            border-radius: 10px;
            padding-top: 5px;
            padding-right: 12px;
            padding-bottom: 10px;
            padding-left: 12px;
        }
        legend {
            float: none;
            width: inherit;
        }
        .poster-input {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .poster-input label {
            margin-right: 10px;
        }

        .poster-input .form-control-file {
            flex-grow: 1;
            margin-right: 10px;
        }
        .card{
            border-radius:20px;
        }
        .req{
            color:red;
        }
        /* toast button */
        #snackbar {
        visibility: hidden;
        min-width: 250px;
        margin-left: -125px;
        background-color: #333;
        color: #fff;
        text-align: center;
        border-radius: 2px;
        padding: 16px;
        position: fixed;
        z-index: 1;
        left: 50%;
        bottom: 30px;
        font-size: 17px;
        }

        #snackbar.show {
        visibility: visible;
        -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
        animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @-webkit-keyframes fadein {
        from {bottom: 0; opacity: 0;} 
        to {bottom: 30px; opacity: 1;}
        }

        @keyframes fadein {
        from {bottom: 0; opacity: 0;}
        to {bottom: 30px; opacity: 1;}
        }

        @-webkit-keyframes fadeout {
        from {bottom: 30px; opacity: 1;} 
        to {bottom: 0; opacity: 0;}
        }

        @keyframes fadeout {
        from {bottom: 30px; opacity: 1;}
        to {bottom: 0; opacity: 0;}
        }


    </style>
</head>
<body>
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card rounded-4">
                    <div class="card-header">
                        <h2>Edit Event</h2>
                    </div>
                    <div class="card-body">
                        <form id="registrationForm" class="fs-5  " method="post" enctype="multipart/form-data" novalidate>
                            <!-- Step 1: Basic Information -->
                            <div class="step active">
                                <div class="form-group">
                                    <!-- <label for="orgid" class="form-label">Organization ID</label> -->
                                    <input type="hidden" class="form-control rounded-4" id="orgid"  name="orgid" >
                                </div>
                                <div class="form-group">
                                    <label for="eventName" class="form-label">Event Name</label><span class="req">*</span>
                                    <input type="text" class="form-control rounded-4" id="eventName" name="EventName" required>
                                    <div class="invalid-feedback">enter event name.</div>
                                </div>
                                <div class="form-group row"> 
                                <div class="form-group col">
                                    <label for="eventType">Event Type</label><span class="req">*</span>
                                    <select class="form-control rounded-4" id="eventType" name="EventType" required>
                                        <option value="">Select event type</option>
                                        <option value="Beauty">Beauty</option>
                                        <option value="Business">Business</option>
                                        <option value="Comedy">Comedy</option>
                                        <option value="Culture">Culture</option>
                                        <option value="Dance">Dance</option>
                                        <option value="Education">Education</option>
                                        <option value="Experience">Experience</option>
                                        <option value="Health">Health</option>
                                        <option value="Music">Music</option>
                                        <option value="Sports">Sports</option>
                                        <option value="custom">custom</option>
                                    </select>
                                    <div id="addEventType"></div>
                                    <div class="invalid-feedback">Select an Event type</div>
                                </div>
                                <div class="form-group col">
                                    <label for="capacity">Capacity</label><span class="req">*</span>
                                    <input type="number" onblur="setTicketQuantity()" class="form-control rounded-4" id="capacity" min="1" name="Capacity" required>
                                    <div class="invalid-feedback">Please provide a valid Capacity.</div>
                                </div>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label><span class="req">*</span>
                                    <textarea class="form-control rounded-4" id="description" name="Description" required></textarea>
                                </div>
                                <div class="form-group row justify-content-evenly" id="abc">
                                    <!-- <label class="form-check-label row-auto">Package Type<span class="req">*</span></label><br>
                                    <div class="col-auto">
                                        <input class="form-check-input" type="radio" name="choice" id="TicketBased" value ="TicketBased" required>
                                        <label class="form-check-label ml-2" for="TicketBased"> Ticket Based</label><br>
                                    </div>
                                    <div class="col-auto">
                                        <input class="form-check-input" type="radio" class="form-check-input" name="choice" id="TimeBased" value ="TimeBased" required>
                                        <label class="form-check-label ml-2" for="TimeBased">  Time Based</label>
                                    </div> -->
                                    <div class="invalid-feedback">Select a Package type</div>
                                </div>
                                <div class="d-grid d-flex justify-content-end">
                                    <button type="button" class="btn col-3  fs-6 col-xs-2 btn-lg btn-outline-primary next-step rounded-pill">Next <i class="fa fa-angle-right ml-2 ml-sm-0"></i></button>
                                </div>
                            </div>

                            <!-- Step 2: Date and Time -->
                            <div name="timeAndDate" id="timeAndDate" class="step">
                                <fieldset class="mt-3 rounded-4">
                                    <legend> Event Date <span class="req">*</span></legend>
                                <div class="row mx-auto">
                                    <div class="col-5 form-group">
                                        <label for="startDate">Start Date</label>
                                        <input type="text"  class="form-control datepicker" onfocus="(this.type = 'date')" id="startDate" placeholder="dd-mm-yyyy" name="StartDate">
                                    </div>
                                <div class="col-5 form-group">
    <label for="endDate">End Date</label>
    <input type="text" class="form-control" id="endDate" onfocus="(this.type = 'date')" placeholder="dd-mm-yyyy" name="EndDate">
</div>

                                </div>
                                <p id="dayDifference"></p>
                                </fieldset>
                                <fieldset class="mt-3 rounded-4">
                                    <legend> Event Time <span class="req">*</span></legend>
                                    <div id="timeSlotsContainer">
                                        <div class="time-slot-group">
                                            <div class="row mx-auto">
                                                <div class="col-5 form-group">
                                                    <label for="startTimeSlot1">Start Time Slot </label>
                                                    <input type="time" class="form-control" id="startTimeSlot1" name="StartTimeSlot[]">
                                                </div>
                                                <div class="col-5 form-group">
                                                    <label for="endTimeSlot1">End Time Slot </label>
                                                    <input type="time" class="form-control" id="endTimeSlot1" name="EndTimeSlot[]">
                                                </div>
                                            </div>
                                                <button type="button" class="btn btn-danger m-2 remove-time-slot" id="removeTime"><i class="fa fa-trash mr-2"></i>Remove</button>
                                        </div>
                                    </div>
                                </fieldset>
                                
                                <div class="form-group m-2">
                                    <button type="button" class="btn btn-success rounded-3" id="addTimeSlot"><i class="fa fa-plus mr-2 ml-sm-0"></i>Add Time Slot</button>
                                </div>
                                <div class="d-grid d-flex justify-content-center gap-5">
                                    <button type="button" class="btn col-3 fs-6 col-xs-2 btn-lg btn-outline-primary prev-step rounded-pill"> <i class="fa fa-angle-left mr-2 ml-sm-0"></i>Previous</button>
                                    <button type="button" class="btn col-3 fs-6 col-xs-2 btn-lg btn-outline-primary next-step rounded-pill"> Next <i class="fa fa-angle-right ml-2 fs-sm-7 ml-sm-0"></i></button>
                                </div>
                            </div>
                            

                            <!-- Step 3: Ticket Information -->
                            <div class="step">
                                <div id="ticketContainer">
                                    <fieldset class="ticket-group m-3 fs-5 rounded-4" id="tickeType">
                                        <legend> Ticket </legend>
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="ticketType">Ticket Type<span class="req">*</span></label>
                                                <select class="form-control rounded-4" id="ticketType" name="TicketType[]" required>
                                                    <option value="">Select ticket type</option>
                                                    <option value="VIP">VIP</option>
                                                    <option value="Normal">Normal</option>
                                                    <option value="Student">Student</option>
                                                    <option value="Balcony">Balcony</option>
                                                    <option value="Child">Child</option>
                                                    <option value="Senior">Senior</option>
                                                    <option value="LastMinute">Last Minute</option>
                                                    <option value="custom">custom</option>
                                                </select>
                                                <div id="addTicType"></div>
                                            </div>
                                            <script></script>
                                            <div class="form-group col-5">
                                                <label for="quantity">Quantity<span class="req">*</span></label>
                                                <input type="number" id="quantity" value="" onload="givecapacity(this.id)" class="form-control rounded-4" min="1" name="Quantity[]" onblur="validateTicektQuntity()" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="returnable">Refundable<span class="req">*</span></label>
                                                <select class="form-control rounded-4" id="returnable" name="Returnable[]" required>
                                                    <option value="">Select returnable option</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-5">
                                                <label for="limitQuantity">Limit Quantity</label>
                                                <input type="number" id="limitQuantity" class="form-control rounded-4" min="1" name="LimitQuantity[]" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <div class="form-group col">
                                            <label for="discount">Discount</label>
                                            <input type="number" id="discount" step="0.01"  class="form-control rounded-4" min="0" name="Discount[]" placeholder="%" required>
                                        </div>
                                        <div class="form-group col">
                                            <label for="price">Price<span class="req">*</span></label>
                                            <input type="number" id="price" class="form-control rounded-4" min="0" name="Price[]" placeholder="₹" required>
                                        </div>
                                        </div>

                                        <button type="button" class="btn btn-danger remove-ticket rounded-4"> <i class="fa fa-trash mr-2"></i>Remove</button>
                                    </fieldset>
                                </div>
                                <div class="form-group m-2">
                                    <button type="button" class="btn btn-success rounded-3" id="addTicket"><i class="fa fa-plus mr-2 ml-sm-0"></i>Add Ticket Type</button>
                                </div>
                                <div class="d-grid d-flex justify-content-center gap-5">
                                    <button type="button" class="btn col-3 fs-6 col-xs-2 btn-lg btn-outline-primary prev-step rounded-pill"> <i class="fa fa-angle-left mr-2 ml-sm-0"></i>Previous</button>
                                    <button type="button" class="btn col-3 fs-6 col-xs-2 btn-lg btn-outline-primary next-step rounded-pill"> Next <i class="fa fa-angle-right ml-2 fs-sm-7 ml-sm-0"></i></button>
                                </div>
                            </div>


                            <!-- Step 4: Venue and Capacity -->
                            <div class="step ">
                                <div class="container">
                                <label for="eventPoster" class="d-block">Event Poster<span class="req">*</span></label>
                                    <div id="posterContainer" class="mb-3">
                                        <div class="form-group poster-input">
                                            <input type="file" class="form-control form-control-sm" id="eventPoster" name="EventPoster[]" accept="image/*" multiple>
                                        </div>
                                    <div id="posterPreview" class="d-flex flex-wrap"></div>
                            </div>

                                    <!-- <button type="button" id="addPosterButton" class="btn btn-primary">Add Poster</button>
                                    <button type="button" id="removePosterButton" class="btn btn-danger">Remove Poster</button> -->
                                    <div id="posterPreview" class="mt-3"></div>
                                </div>
                                <!-- <fieldset> -->
                                <div class="container">
                                    <div class="form-group row">
                                    
                                        <div class="col-4">
                                            <label for="Country"> Country </label>
                                            <input type="text"  name="Country" value="" id="Country" class="form-control" >
                                        </div>
                                        <div class="col-4">
                                            <label for="State"> State </label>
                                            <input type="text"  name="State" id="State" value=""  class="form-control" >
                                        </div>
                                        <div class="col-4">
                                            <label for="City"> City </label>
                                            <input type="text" name="City" id="City" value=""  class="form-control" >
                                        </div>
                                    </div>
     
                                     <div class="form-group">
                                         <label for="venueAddress">Venue Address<span class="req">*</span></label>
                                         <!-- <textarea class="form-control rounded-4" id="venueAddress" name="VenueAddress" required></textarea> -->
                                         <input type="textarea" class="form-control rounded-4" id="venueAddress"  name="VenueAddress" required>
                                     </div>
                                </div>
                                <!-- </fieldset> -->
                               
                                <div class="d-grid d-flex mt-3 justify-content-center gap-5">
                                    <button type="button" class="btn col-3 fs-5 col-xs-2 btn-lg btn-outline-primary prev-step rounded-pill"> <i class="fa fa-angle-left mr-2 ml-sm-0"></i>Previous</button>
                                    <button type="submit" class="btn col-3 fs-5 col-xs-2 btn-lg btn-outline-success next-step rounded-pill" > Submit <i class="fa fa-bullhorn ml-2 fs-sm-7 ml-sm-0"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>  
                </div>
            </div>
        </div>
    </div>


    <!-- <script src="edit_eventjs.js"></script> -->
    <script>

function previewImage(event) {
    const posterPreviewDiv = document.getElementById('posterPreview');
    const files = event.target.files;

    // Clear previous posters
    posterPreviewDiv.innerHTML = '';

    // Create a new DataTransfer object to store the current files
    const dataTransfer = new DataTransfer();

    // Iterate through the files and create previews and remove buttons
    for (let i = 0; i < files.length; i++) {
        const reader = new FileReader();
        const file = files[i];

        reader.onload = function(e) {
            const imgWrapper = document.createElement('div');
            imgWrapper.classList.add('d-inline-block', 'position-relative', 'm-2');

            const img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('img-thumbnail');
            img.style.maxWidth = '150px';

            // Create remove button
            const removeBtn = document.createElement('button');
            removeBtn.classList.add('btn', 'btn-sm', 'btn-danger', 'position-absolute', 'top-0', 'end-0');
            const i = document.createElement('i');
            i.classList.add('fa', 'fa-close');
            removeBtn.style.transform = 'translate(50%, -50%)';

            removeBtn.addEventListener('click', function() {
                posterPreviewDiv.removeChild(imgWrapper); // Remove the image wrapper

                // Remove the file from the DataTransfer object
                const newDataTransfer = new DataTransfer();
                for (let j = 0; j < dataTransfer.files.length; j++) {
                    if (dataTransfer.files[j] !== file) {
                        newDataTransfer.items.add(dataTransfer.files[j]);
                    }
                }

                // Update the file input with the new FileList
                event.target.files = newDataTransfer.files;
                dataTransfer.items.clear();
                for (let k = 0; k < newDataTransfer.files.length; k++) {
                    dataTransfer.items.add(newDataTransfer.files[k]);
                }
            });
            removeBtn.appendChild(i);
            imgWrapper.appendChild(img);
            imgWrapper.appendChild(removeBtn);
            posterPreviewDiv.appendChild(imgWrapper);
        };

        reader.readAsDataURL(file);
        dataTransfer.items.add(file); // Add the file to DataTransfer
    }

    // Update the file input with the new FileList
    event.target.files = dataTransfer.files;
}

var keptcapacity =0;
        async function fetchData(tableName) {
            try {
                const EventID = <?php echo isset($_POST['id']) ? json_encode($_POST['id']) : 'null'; ?>;
                console.log(EventID);

                const response = await fetch("organization_viewdetails_backend.php", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ tableName: tableName, EventID: EventID }),
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

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
                populateEvents(data);
            }

        function populateEvents(events) {
            // const eventsRow = document.querySelector('#eventsRow');

            if (!Array.isArray(events)) {
                console.error('Expected an array but got:', events);
                return;
            }

            const uniqueEvents = events.reduce((acc, event) => {
                if (!acc[event.EventID]) {
                    acc[event.EventID] = {
                        ...event,
                        posters: new Set([event.poster]),
                        timeSlots: new Map([[event.TimeSlotID, {
                            TimeSlotID: event.TimeSlotID,
                            StartTime: event.StartTime,
                            EndTime: event.EndTime,
                            Availability: event.Availability
                        }]]),
                        tickets: new Map([[`${event.TicketID}-${event.TicketType}`, {
                            TicketID: event.TicketID,
                            TicketType: event.TicketType,
                            Quantity: event.Quantity,
                            LimitQuantity: event.LimitQuantity,
                            Discount: event.Discount,
                            Price: event.Price
                        }]])
                    };
                } else {
                    acc[event.EventID].posters.add(event.poster);
                    acc[event.EventID].timeSlots.set(event.TimeSlotID, {
                        TimeSlotID: event.TimeSlotID,
                        StartTime: event.StartTime,
                        EndTime: event.EndTime,
                        Availability: event.Availability
                    });
                    acc[event.EventID].tickets.set(`${event.TicketID}-${event.TicketType}`, {
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
                uniqueEvents[eventID].timeSlots = Array.from(uniqueEvents[eventID].timeSlots.values());
                uniqueEvents[eventID].tickets = Array.from(uniqueEvents[eventID].tickets.values());
            });

            console.log("uniqueEvents",uniqueEvents);

        
            Object.values(uniqueEvents).forEach((event) => {
    document.getElementById('orgid').value =  <?php echo $_POST['id']?>; // Assuming there's a field for OrganizationID
    document.getElementById('eventName').value = event.EventName;
    document.getElementById('eventType').value = event.EventType;
    document.getElementById('description').value = event.Description;
    document.getElementById('capacity').value = event.Capacity;
     keptcapacity = event.Capacity;
     console.log("event capacity",event.Capacity);
    document.getElementById('startDate').value = event.StartDate;
    document.getElementById('endDate').value = event.EndDate;
    document.getElementById('startDate').value = event.StartDate;
    document.getElementById('endDate').value = event.EndDate;
    document.getElementById('Country').value = event.Country;
    document.getElementById('State').value = event.State;
    document.getElementById('City').value = event.City;
    document.getElementById('venueAddress').value = event.VenueAddress;
    const abc = document.getElementById('abc');
    abc.innerHTML += `<label class="form-check-label row-auto">Package Type<span class="req">*</span></label><br>
                        <div class="col-auto">
                            <input class="form-check-input" type="radio" name="choice" id="TicketBased" value ="TicketBased" required  ${event.choice === 'TicketBased' ?'checked':''} disabled>
                            <label class="form-check-label ml-2" for="TicketBased"> Ticket Based</label><br>
                        </div>
                        <div class="col-auto">
                            <input class="form-check-input" type="radio" class="form-check-input" name="choice" id="TimeBased" value ="TimeBased" required  ${event.choice === 'TimeBased' ?'checked':''} disabled>
                            <label class="form-check-label ml-2" for="TimeBased">  Time Based</label>
                        </div>`;
    
//     document.querySelectorAll('input[name="choice"]').forEach(radio => {
 
// });

//     const countrySel = document.getElementById("country");
//     const stateSel = document.getElementById("state");
//     const citySel = document.getElementById("city");

//     // Set the default value for the country dropdown
//     setDropdownSelectedValue(countrySel, events.country);

//     // Trigger the change event on the country dropdown to populate the states
//     const countryChangeEvent = new Event('change');
//     countrySel.dispatchEvent(countryChangeEvent);

//     // Set the default value for the state dropdown
//     setDropdownSelectedValue(stateSel, events.state);

//     // Trigger the change event on the state dropdown to populate the cities
//     const stateChangeEvent = new Event('change');
//     stateSel.dispatchEvent(stateChangeEvent);

//     // Set the default value for the city dropdown
//     setDropdownSelectedValue(citySel, events.city);


// function setDropdownSelectedValue(dropdown, value) {
//     for (let option of dropdown.options) {
//         if (option.value === value) {
//             option.selected = true;
//             break;
//         }
//     }
// }
        
    // Populate time slots
    const timeSlotsContainer = document.getElementById('timeSlotsContainer');
    timeSlotsContainer.innerHTML = ''; // Clear existing slots
    event.timeSlots.forEach(slot => {
        const newSlot = `
            <div class="time-slot-group">
                <div class="row mx-auto">
                    <div class="col-5 form-group">
                        <label for="startTimeSlot1">Start Time Slot </label>
                        <input type="time" class="form-control" id="startTimeSlot1" name="StartTimeSlot[]" value="${slot.StartTime}">
                    </div>
                    <div class="col-5 form-group">
                        <label for="endTimeSlot1">End Time Slot </label>
                        <input type="time" class="form-control" id="endTimeSlot1" name="EndTimeSlot[]" value="${slot.EndTime}">
                    </div>
                </div>
                <button type="button" class="btn btn-danger m-2 remove-time-slot" id="removeTime"><i class="fa fa-trash mr-2"></i>Remove</button>
            </div>`;
        timeSlotsContainer.insertAdjacentHTML('beforeend', newSlot);
    });

   

    const posterPreview = document.getElementById('posterPreview');
posterPreview.innerHTML = ''; // Clear existing content once at the start

Object.values(uniqueEvents).forEach((event) => {
    const eventCard = document.createElement('div');
    eventCard.classList.add('col-12');

    const posterItems = event.posters.map(poster => `
        <div class="poster-container position-relative">
            <img src="${poster}"  class="event-poster img-fluid g-0" alt="Event Poster">
            <button type="button" class="btn btn-danger btn-sm  top-0 right-0 delete-poster" data-poster="${poster}" ">Delete</button>
        </div>
    `).join('');

    eventCard.innerHTML = ` 
        <div class="event-card">
            <div class="row no-gutters">
                <div class="col-md-6 d-block">
                    <strong class="ml-3 text-light">Event Photos</strong>
                    <div class="posters d-flex g-0 overflow-auto">
                        ${posterItems}
                    </div>
                </div>
            </div>
        </div>
    `;

    posterPreview.appendChild(eventCard);
});

// Add event listener for delete buttons
posterPreview.addEventListener('click', (e) => {
    if (e.target.classList.contains('delete-poster')) {
        const posterElement = e.target.closest('.poster-container');
        const posterUrl = e.target.getAttribute('data-poster');
        const EventID = <?php echo isset($_POST['id']) ? json_encode($_POST['id']) : 'null'; ?>;
       const posterid = e.target.getAttribute('data-poster-posterID');
        console.log("idp",posterUrl);
        // Send delete request to the server
        fetch('../fetchEvents.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({EventID:EventID, action: 'DeleteEventPoster', path:posterUrl }),
        })
        .then(response => response.json())
        .then(data => {
            posterElement.remove();
            if (data.success) {
                // Remove poster element from the DOM
                posterElement.remove();
            } else {
                alert('Failed to delete poster.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the poster.');
        });
    }
});





    // Populate ticket types
    // Assuming ticketContainer is the parent element containing all ticket fieldsets
const ticketContainer = document.getElementById('ticketContainer');

// Clear existing ticket fieldsets
ticketContainer.innerHTML = '';

// Iterate over each ticket and populate the fields
event.tickets.forEach((ticket, index) => {
    const newTicket = `
        <fieldset class="ticket-group m-3 fs-5 rounded-4" id="ticket${index}">
            <legend> Ticket </legend>
            <div class="row">
                <div class="form-group col-6">
                    <label for="ticketType${index}">Ticket Type</label>
                    <select class="form-control rounded-4" id="ticketType${index}" name="TicketType[]" >
                        <option value="">Select ticket type</option>
                    </select>
                    <div id="addTicType"></div>
                </div>
                <div class="form-group col-5">
                    <label for="quantity${index}">Quantity</label>
                    <input type="number" id="quantity${index}" class="form-control rounded-4" name="Quantity[]" value="${ticket.Quantity}">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-6">
                    <label for="returnable${index}">Returnable</label>
                    <select class="form-control rounded-4" id="returnable${index}" name="Returnable[]" >
                        <option value="">Select returnable option</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div class="form-group col-5">
                    <label for="limitQuantity${index}">Limit Quantity</label>
                    <input type="number" id="limitQuantity${index}" class="form-control rounded-4" name="LimitQuantity[]" value="${ticket.LimitQuantity}">
                </div>
            </div>
            <div class="form-group">
                <label for="discount${index}">Discount</label>
                <input type="number" id="discount${index}" class="form-control rounded-4" name="Discount[]" placeholder="%" value="${ticket.Discount}">
            </div>
            <div class="form-group">
                <label for="price${index}">Price</label>
                <input type="number" id="price${index}" class="form-control rounded-4" name="Price[]" placeholder="₹" value="${ticket.Price}">
            </div>
            <button type="button" class="btn btn-danger remove-ticket rounded-4"> <i class="fa fa-trash mr-2"></i>Remove</button>
        </fieldset>`;
    document.getElementById('ticketContainer').insertAdjacentHTML('beforeend', newTicket);                                   

    // Populate the ticket type select options dynamically
    const ticketTypeSelect = document.getElementById(`ticketType${index}`);
    const ticketTypes = ["VIP", "Normal", "Student", "Balcony", "Child", "Senior", "LastMinute"];
    ticketTypes.forEach(type => {
        const option = document.createElement('option');
        option.value = type;
        option.text = type === "LastMinute" ? "Last Minute" : type; // Format the display text for LastMinute
        ticketTypeSelect.appendChild(option);
    });

    // Set the selected value for ticket type
    ticketTypeSelect.value = ticket.TicketType;

    // Set the selected value for returnable option
    const returnableSelect = document.getElementById(`returnable${index}`);
    returnableSelect.value = ticket.Returnable;
});




    // Populate other fields similarly
});


        }
    


        
      // Function to remove a time slot
      function removeTimeSlot(event) {
        if (event.target.classList.contains('remove-time-slot')) {
            event.target.closest('.time-slot-group').remove();
        }
    }
    
    // Function to remove a ticket
    function removeTicket(event) {
        if (event.target.classList.contains('remove-ticket')) {
            event.target.closest('.ticket-group').remove();
        }
    }
    
    // Event listener for time slot removal
    timeSlotsContainer.addEventListener('click', removeTimeSlot);
    
    // Event listener for ticket removal
    ticketContainer.addEventListener('click', removeTicket);
    function validateFormStep2(){
            const ticketTypes = document.getElementsByName('TicketType[]');
            const quantities = document.getElementsByName('Quantity[]');
            const returnables = document.getElementsByName('Returnable[]');
            const limitQuantities = document.getElementsByName('LimitQuantity[]');
            const discounts = document.getElementsByName('Discount[]');
            const prices = document.getElementsByName('Price[]');
            const capacity = document.getElementById('capacity').value;

            let isValid = true;
            let messages = [];
            let NoOfTickets=ticketTypes.length;
            let amountOfTikcetsPerType=document.getElementById('capacity').value/NoOfTickets;
            let amountOfTikcetsPerTypeRounded1=Math.floor(amountOfTikcetsPerType);
            for (let i = 0; i < ticketTypes.length; i++) {
                console.log(limitQuantities[i].value);
                console.log(quantities[i].value );
                if (ticketTypes[i].value === '') {
                    currentStep = 2;
                    isValid = false;
                    alert('Please select a ticket type.');
                }
            //     if(quantities[i].value > capacity){
            //     alert('Quantity cannot be greater than Event Capacity');
            //     document.getElementById(id).setAttribute('max', capacity);

            //     isValid = false;
            // }   
            // if(quantities[i].value < limitQuantities[i].value){
            //     alert('Limit Quantity cannot be greater than quantity');
            //     isValid = false;
            // }

                if (quantities[i].value === '' || quantities[i].value <= 0) {
                    currentStep = 2;
                    isValid = false;
                    alert('Please enter a valid quantity.');
                }
                if (returnables[i].value === '') {
                    currentStep = 2;
                    isValid = false;
                    alert('Please select if the ticket is refundable.');
                }
                if ((parseFloat(limitQuantities[i].value) >= parseFloat(quantities[i].value)) || (limitQuantities[i].value == "")) {
    currentStep = 2;
    isValid = false;
    console.log("ll", limitQuantities[i].value);
    console.log("tt", quantities[i].value);
    alert('Please enter a valid limit quantity.');
}

                // if (discounts[i].value === '' || discounts[i].value < 0) {
                //     currentStep = 2;
                //     isValid = false;
                //     alert('Please enter a valid discount.');
                // }
                if (prices[i].value === '' || prices[i].value < 0) {
                    currentStep = 2;
                    isValid = false;
                    alert('Please enter a valid price.');
                }
            }

            let kk = 0;
var capacity1 = parseInt(document.getElementById('capacity').value, 10); // Convert capacity to an integer

for (let i = 0; i < ticketTypes.length; i++) {
    kk = kk + parseInt(quantities[i].value, 10); // Ensure quantities are also treated as integers
}

console.log("capacity", capacity1);
console.log("kk", kk);

if (kk > capacity1) {
    alert('Total quantity should not exceed capacity');
    isValid = false;
}

            if (isValid) {
                //alert(messages.join('\n'));
                // Proceed to the next step or submit the form
               
                // alert('Form is valid and ready to proceed.');
                return true;
                // You can add form submission logic here
            }
          
        }    
    
    function validateForm0() {  
        if (document.getElementById('eventName').value === '') {
            alert('Please enter event name');
            return false;
        }
        if (document.getElementById('capacity').value === '' || document.getElementById('capacity').value < keptcapacity) {
            alert('Please enter valid Capacity');
            return false;
        }

        if (document.getElementById('eventType').value === '') {
            alert('Please enter eventType');
            return false;
        }

        if (document.getElementById('description').value === '') {
            alert('Please enter description');
            return false;
        }
        return true;
    }

    
    function validateForm() {
            const form = document.getElementById('registrationForm');
            const startDateInput = document.getElementById('startDate').value;
            const endDateInput = document.getElementById('endDate');
    console.log(startDateInput);
            // Get the selected start and end dates and times
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            const currentDate = new Date();
    
            // Check if the start date and time are before the end date and time
            if (startDate > endDate) {
                alert('Start date and time must be before end date and time.');
                return false;
            }
    
            // Check if the start date and time are greater than today's date and time
            if (startDate <= currentDate) {
                alert('Start date and time must be greater than today.');
                return false;
            }
            if(startDate.value === '' || endDate.value === '') {
                alert('Please fill in all date and time fields.');
                return false;
            }
         
            const startTimeInputs = document.querySelectorAll('input[name="StartTimeSlot[]"]');
const endTimeInputs = document.querySelectorAll('input[name="EndTimeSlot[]"]');

// Iterate over each pair of start and end time inputs
for (let i = 0; i < startTimeInputs.length; i++) {
    const startTime = new Date(`1970-01-01T${startTimeInputs[i].value}:00`);
    const endTime = new Date(`1970-01-01T${endTimeInputs[i].value}:00`);

    // Check if the start and end time inputs are filled
    if (startTimeInputs[i].value === '' || endTimeInputs[i].value === '') {
        alert('Please fill in all time slots.');
        return false;
    }

    // Check if the end time is greater than the start time
    // if (endTime <= startTime) {
    //     alert('End time must be greater than start time.');
    //     return false;
    // }

    // Check for overlaps with other time slots
    for (let j = 0; j < i; j++) {
        const prevStartTime = new Date(`1970-01-01T${startTimeInputs[j].value}:00`);
        const prevEndTime = new Date(`1970-01-01T${endTimeInputs[j].value}:00`);

        if (
            (startTime < prevEndTime && startTime >= prevStartTime) ||
            (endTime > prevStartTime && endTime <= prevEndTime) ||
            (prevStartTime < endTime && prevStartTime >= startTime) ||
            (prevEndTime > startTime && prevEndTime <= endTime)
        ) {
            alert('Time slots must not overlap.');
            return false;
        }
    }


       
    
            // Check if the start time of the next slot is greater than or equal to the end time of the previous slot
            if (i > 0) {
                const prevEndTime = new Date(startDate.toDateString() + ' ' + endTimeInputs[i - 1].value);
                const nextStartTime = new Date(startDate.toDateString() + ' ' + startTimeInputs[i].value);
                if (nextStartTime < prevEndTime) {
                    alert('Start time of the next slot must be after the end time of the previous slot.');
                    return false;
                }
            }
        
        }
        // If all validations pass, return true to submit the form
        return true;
    }
    
    
    function setDefaultDropdownValues(country, state, city) {
        const countrySel = document.getElementById("country");
        const stateSel = document.getElementById("state");
        const citySel = document.getElementById("city");
    
        // Set default selected country
        if (country) {
            countrySel.value = country;
        }
    
        // Set default selected state
        if (state) {
            stateSel.value = state;
        }
    
        // Set default selected city
        if (city) {
            citySel.value = city;
        }
    }
    
    // Call this function after fetching data from populateEvents
    document.addEventListener("DOMContentLoaded", function() {
        fetch('../cascading.php') 
            .then(response => response.json())
            .then(data => {
                const countrySel = document.getElementById("country");
                const stateSel = document.getElementById("state");
                const citySel = document.getElementById("city");
    
                let countries = {};
                let selectedCountry, selectedState;
                
        
    
                data.forEach(item => {
                    if (!countries[item.country]) {
                        countries[item.country] = {};
                    }
                    if (!countries[item.country][item.state]) {
                        countries[item.country][item.state] = [];
                    }
                    countries[item.country][item.state].push(item.city);
                });
    
                for (let country in countries) {
                    let option = new Option(country, country);
                    countrySel.add(option);
                }
    
                countrySel.onchange = function() {
                    stateSel.length = 1;
                    citySel.length = 1;
                    selectedCountry = this.value;
                    if (selectedCountry && countries[selectedCountry]) {
                        for (let state in countries[selectedCountry]) {
                            let option = new Option(state, state);
                            stateSel.add(option);
                        }
                    }
                    // Call the function to set default values
                    setDefaultDropdownValues(selectedCountry, null, null);
                }
    
                stateSel.onchange = function() {
                    citySel.length = 1;
                    selectedState = this.value;
                    if (selectedState && countries[selectedCountry] && countries[selectedCountry][selectedState]) {
                        countries[selectedCountry][selectedState].forEach(city => {
                            let option = new Option(city, city);
                            citySel.add(option);
                        });
                    }
                    // Call the function to set default values
                    setDefaultDropdownValues(selectedCountry, selectedState, null);
                }
    
                // Call the function to set default values with data from populateEvents
            });
    });
    
        
             document.getElementById('orgid').value = document.cookie.split('; ').find(row => row.startsWith('id')).split('=')[1];
             console.log(document.cookie.split('; ').find(row => row.startsWith('id')).split('=')[1]);
            document.addEventListener('DOMContentLoaded', function () {
                const addTimeSlotBtn = document.getElementById('addTimeSlot');
                const deleteTimeSlotBtn = document.getElementById('removeTime')
                const timeSlotsContainer = document.getElementById('timeSlotsContainer');
                let timeSlotCount = 1;
                let ticketTypes = 1;
    
                
                deleteTimeSlotBtn.addEventListener('click', function(event) {
                    if (event.target.classList.contains('remove-time-slot')) {
                        if(timeSlotCount==1){
                            console.log("time",timeSlotCount);
                        }else {
                            event.target.closest('.time-slot-group').remove();
                            timeSlotCount--;
                            console.log("time",timeSlotCount);
                        }
                    }
                });
    
                addTimeSlotBtn.addEventListener('click', function() {
                    const timeSlotGroup = document.createElement('div');
                    timeSlotGroup.classList.add('time-slot-group');
    
                    const row = document.createElement('div');
                    row.classList.add('row', 'mx-auto');
    
                    const timeSlotDiv1 = document.createElement('div');
                    timeSlotDiv1.classList.add('col-5', 'form-group');
    
                    const startTimeLabel = document.createElement('label');
                    startTimeLabel.textContent = `Start Time Slot`;
                    timeSlotDiv1.appendChild(startTimeLabel);
    
                    const startTimeInput = document.createElement('input');
                    startTimeInput.type = 'time';
                    startTimeInput.className = 'form-control';
                    startTimeInput.name = `StartTimeSlot[]`;
                    timeSlotDiv1.appendChild(startTimeInput);
    
                    row.appendChild(timeSlotDiv1);
    
                    const timeSlotDiv2 = document.createElement('div');
                    timeSlotDiv2.classList.add('col-5', 'form-group');
    
                    const endTimeLabel = document.createElement('label');
                    endTimeLabel.textContent = `End Time Slot`;
                    timeSlotDiv2.appendChild(endTimeLabel);
    
                    const endTimeInput = document.createElement('input');
                    endTimeInput.type = 'time';
                    endTimeInput.className = 'form-control';
                    endTimeInput.name = `EndTimeSlot[]`;
                    timeSlotDiv2.appendChild(endTimeInput);
    
                    row.appendChild(timeSlotDiv2);
    
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.classList.add('btn', 'btn-danger', 'm-2', 'remove-time-slot');
                    // const trash = document.createElement('i');
                    // trash.classList.add('fa', 'fa-trash', 'mr-2');
                    removeBtn.innerHTML = '<i class="fa fa-trash mr-2"></i>Remove';
                    removeBtn.addEventListener('click', function() {
                        if(timeSlotCount==1){
                            alert("Thre should be one Time slot");
                        }
                        else{
                            timeSlotGroup.remove();
                            timeSlotCount--;
                        }
                    });
    
                    
                    timeSlotGroup.appendChild(row);
                    timeSlotGroup.appendChild(removeBtn);
                    timeSlotsContainer.appendChild(timeSlotGroup);
                    timeSlotCount++;
                });
    
                document.getElementById('eventType').addEventListener('change', function () {
                const customInputContainer = document.getElementById('addEventType');
                customInputContainer.innerHTML = ''; // Clear any existing elements
                    if (this.value === 'custom') {
                        // Create input group
                        const inputGroup = document.createElement('div');
                        inputGroup.className = 'input-group';
    
                        // Create input field
                        const inputField = document.createElement('input');
                        inputField.type = 'text';
                        inputField.className = 'form-control rounded-pill mt-2 mr-2';
                        inputField.placeholder = 'Enter custom Event Type';
    
                        // Create add button
                        const addButton = document.createElement('button');
                        addButton.type = 'button';
                        addButton.className = 'btn btn-primary rounded-pill mt-2';
                        addButton.innerText = 'Add';
                        addButton.addEventListener('click', function () {
                            const eventDD = document.getElementById("eventType");
                            const option = document.createElement('option');
                            option.value = inputField.value;
                            option.innerText = inputField.value;
                            // var option = '<option value="'+inputField.value+'">'+inputField.value+'</option>';
                            eventDD.value = inputField.value;
                            eventDD.appendChild(option);
                            
                            inputField.remove();
                            addButton.remove();
                        });
    
                        // Append input field and button to input group
                        inputGroup.appendChild(inputField);
                        inputGroup.appendChild(addButton);
    
                        // Append input group to container
                        customInputContainer.appendChild(inputGroup);
    
                    }
                });
                
                document.getElementById('ticketType').addEventListener('change', function () {
                const customInputContainer = document.getElementById('addTicType');
                customInputContainer.innerHTML = ''; // Clear any existing elements
    
                    if (this.value === 'custom') {
                        // Create input group
                        const inputGroup = document.createElement('div');
                        inputGroup.className = 'input-group';
    
                        // Create input field
                        const inputField = document.createElement('input');
                        inputField.type = 'text';
                        inputField.className = 'form-control rounded-pill mt-2 mr-2';
                        inputField.placeholder = 'Enter custom ticket type';
    
                        // Create add button
                        const addButton = document.createElement('button');
                        addButton.type = 'button';
                        addButton.className = 'btn btn-primary rounded-pill mt-2';
                        addButton.innerText = 'Add';
                        addButton.addEventListener('click', function () {
                            const eventDD = document.getElementById("ticketType");
                            const option = document.createElement('option');
                            option.value = inputField.value;
                            option.innerText = inputField.value;
                            // var option = '<option value="'+inputField.value+'">'+inputField.value+'</option>';
                            eventDD.value = inputField.value;
                            eventDD.appendChild(option);
                            
                            inputField.remove();
                            addButton.remove();
                        });
    
                        // Append input field and button to input group
                        inputGroup.appendChild(inputField);
                        inputGroup.appendChild(addButton);
    
                        // Append input group to container
                        customInputContainer.appendChild(inputGroup);
    
                    }
                });
                const nextBtns = document.querySelectorAll('.next-step');
                const prevBtns = document.querySelectorAll('.prev-step');
                const form = document.getElementById('registrationForm');
                const steps = form.querySelectorAll('.step');
                // console.log(steps.length);
                const addTicketBtn = document.getElementById('addTicket');
                const ticketContainer = document.getElementById('ticketContainer');
                let currentStep = 0;
    
                nextBtns.forEach(button => {
    button.addEventListener('click', () => {
        if (currentStep < steps.length - 1) {
            // Check if we are on the step of time and date and validate the form
            if (currentStep === 0) {
                if (!validateForm0()) {
                    // Validation failed, stay on the current step
                    console.log("Validation failed");
                    return; // Exit the function, preventing further execution
                }
            }
            if (currentStep === 1 && !validateForm()) {
                    console.log('Form validation failed. Staying on step 1.');
                    return; // Stay on the current step if form validation fails
            }

            if (currentStep === 2 && !validateFormStep2()) {
                console.log('Form validation failed. Staying on step 2.');
                return;
            }
            if (currentStep === 3){
             previewImage();
            }
            // Move to the next step
            steps[currentStep].classList.remove('active');
            currentStep++;
            steps[currentStep].classList.add('active');
        }
    });
});

    
                prevBtns.forEach(button => {
                    button.addEventListener('click', () => {
                        if (currentStep > 0) {
                            steps[currentStep].classList.remove('active');
                            currentStep--;
                            steps[currentStep].classList.add('active');
                        }
                    });
                });
    
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                //    if(!validateForm()) {
                        
                //         return;
                //     }
                    console.log('Form submitted');
                 console.log('Form submitted');
    
                    var formData = new FormData(form);
    
                    for (let [key, value] of formData.entries()) {
                        console.log(`${key}: ${value}`);
                    }
                    console.log(formData.entries());
                    //add action =update in formdata
                    formData.append('action', 'update');
                    fetch('update_event.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
    
                addTicketBtn.addEventListener('click', function() {
                const newTicketGroup = document.querySelector('.ticket-group.m-3.rounded-4').cloneNode(true);
                
                ticketTypes++;
                console.log("tickets",ticketTypes);
                
                newTicketGroup.querySelectorAll('input, select').forEach(input => input.value = '');
                newTicketGroup.querySelector('.remove-ticket').addEventListener('click', function() {
                    if (event.target.classList.contains('remove-ticket')) {
                        if(ticketTypes==1){
                            alert("There should be at leas one ticket");
                            console.log("tickets",ticketTypes);
                        }else {
                            newTicketGroup.remove();
                            console.log("tickets",ticketTypes);
                        }
                    }});
                ticketContainer.appendChild(newTicketGroup);
                addDetailforstep2();
            });

            function addDetailforstep2() {
    const ticketTypes1 = document.getElementsByName('TicketType[]');
    const quantities = document.getElementsByName('Quantity[]');

    let capacity = parseInt(document.getElementById('capacity').value);
    console.log("capacity", capacity);
    let NoOfTickets = ticketTypes1.length;
    console.log("length", NoOfTickets);

    // Initialize cumulative sum
    let cc = 0;

    // Iterate through the tickets and calculate the remaining capacity
    for (let i = 0; i < NoOfTickets; i++) {
        let currentQuantity = parseInt(quantities[i].value) || 0;

        // If it's the first ticket and quantity is not manually changed, set it to the capacity
        if (i === 0 && quantities[i].value === '') {
            quantities[i].value = capacity;
            currentQuantity = capacity;
        }

        // Update cumulative sum
        cc += currentQuantity;

        // Calculate remaining capacity
        let remainingCapacity = capacity - cc;

        // Ensure the remaining capacity is not negative
        if (remainingCapacity < 0) {
            alert("no more capacity");
            remainingCapacity = 0;
            let lastChild=ticketContainer.lastChild
            ticketContainer.removeChild(lastChild);
            
            return;
        }

        // Update the quantity of the current ticket if it hasn't been manually changed
        if (i > 0 && quantities[i].value === '') {
            quantities[i].value = remainingCapacity;
        }
    }

    console.log("First ticket quantity:", quantities[0].value);
    for (let i = 1; i < NoOfTickets; i++) {
        console.log(`Ticket ${i + 1} quantity:`, quantities[i].value);
    }
}

    
                ticketContainer.addEventListener('click', function(event) {
                    if (event.target.classList.contains('remove-ticket')) {
                        if(ticketTypes==1){
                            console.log("tickets",ticketTypes);
                        }else {
                            event.target.closest('.ticket-group').remove();
                            ticketTypes--;
                            console.log("tickets",ticketTypes);
                        }
                    }
                });
            });
    
    // Path: organizer/edit_event.php
        window.onload = initialize;
    </script>
    <?php 
        include 'footer.php';
    ?>
    

    

</body>
</html> 