
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
                                <div class="form-group row justify-content-evenly">
                                    <label class="form-check-label row-auto">Package Type<span class="req">*</span></label><br>
                                    <div class="col-auto">
                                        <input class="form-check-input" type="radio" name="choice" id="TicketBased" value ="TicketBased" required>
                                        <label class="form-check-label ml-2" for="TicketBased"> Ticket Based</label><br>
                                    </div>
                                    <div class="col-auto">
                                        <input class="form-check-input" type="radio" class="form-check-input" name="choice" id="TimeBased" value ="TimeBased" required>
                                        <label class="form-check-label ml-2" for="TimeBased">  Time Based</label>
                                    </div>
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
                                            <input type="file" class="form-control form-control-sm" id="eventPoster" name="EventPoster[]" accept="image/*" onchange="previewImage(event)" multiple>
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
                                            <label for="country">Country<span class="req">*</span></label>
                                             <select name="Country" id="country" class="form-control" required> 
                                                 <option value="" selected="Selected">Select Country</option>
                                             </select>
                                        </div>
                                        <div class="col-4">
                                            <label for="state">State<span class="req">*</span></label> 
                                            <select name="State" id="state" class="form-control" required> 
                                                <option value="" selected="Selected">Select State</option>
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <label for="city">City <span class="req">*</span></label> 
                                            <select name="City" id="city" class="form-control" required> 
                                                <option value="" selected="Selected">Select City</option>
                                            </select>
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


    <script src="edit_eventjs.js"></script>
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
            const eventsRow = document.querySelector('#eventsRow');

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

            console.log(uniqueEvents);

            
            Object.values(uniqueEvents).forEach((event) => {
    document.getElementById('orgid').value =  <?php echo $_POST['id']?>; // Assuming there's a field for OrganizationID
    document.getElementById('eventName').value = event.EventName;
    document.getElementById('eventType').value = event.EventType;
    document.getElementById('description').value = event.Description;
    document.getElementById('capacity').value = event.Capacity;
    document.getElementById('startDate').value = event.StartDate;
    document.getElementById('endDate').value = event.EndDate;
    document.getElementById('startDate').value = event.StartDate;
    document.getElementById('endDate').value = event.EndDate;

    const countrySel = document.getElementById("country");
    const stateSel = document.getElementById("state");
    const citySel = document.getElementById("city");

    // Set the default value for the country dropdown
    setDropdownSelectedValue(countrySel, events.country);

    // Trigger the change event on the country dropdown to populate the states
    const countryChangeEvent = new Event('change');
    countrySel.dispatchEvent(countryChangeEvent);

    // Set the default value for the state dropdown
    setDropdownSelectedValue(stateSel, events.state);

    // Trigger the change event on the state dropdown to populate the cities
    const stateChangeEvent = new Event('change');
    stateSel.dispatchEvent(stateChangeEvent);

    // Set the default value for the city dropdown
    setDropdownSelectedValue(citySel, events.city);


function setDropdownSelectedValue(dropdown, value) {
    for (let option of dropdown.options) {
        if (option.value === value) {
            option.selected = true;
            break;
        }
    }
}
        
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

    // Populate ticket types
    // Assuming ticketContainer is the parent element containing all ticket fieldsets
const ticketContainer = document.getElementById('ticketContainer');

// Clear existing ticket fieldsets
ticketContainer.innerHTML = '';

// Iterate over each ticket and populate the fields
event.tickets.forEach((ticket, index) => {
    const newTicket = `
        <fieldset class="ticket-group m-3 fs-5 rounded-4" id="ticketType${index}">
            <legend> Ticket </legend>
            <div class="row">
                <div class="form-group col-6">
                    <label for="ticketType${index}">Ticket Type</label>
                    <select class="form-control rounded-4" id="ticketType${index}" name="TicketType[]" >
                        <option value="">Select ticket type</option>
                        <option value="VIP" ${ticket.TicketType === 'VIP' ? 'selected' : ''}>VIP</option>
                        <option value="Normal" ${ticket.TicketType === 'Normal' ? 'selected' : ''}>Normal</option>
                        <option value="Student" ${ticket.TicketType === 'Student' ? 'selected' : ''}>Student</option>
                        <!-- Add other options here -->
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
                        <option value="Yes" ${ticket.Returnable === 'Yes' ? 'selected' : ''}>Yes</option>
                        <option value="No" ${ticket.Returnable === 'No' ? 'selected' : ''}>No</option>
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
    ticketContainer.insertAdjacentHTML('beforeend', newTicket);
});



    // Populate other fields similarly
});


        }
    
        window.onload = initialize;
    </script>
    <?php 
        include 'footer.php';
    ?>
</body>
</html> 