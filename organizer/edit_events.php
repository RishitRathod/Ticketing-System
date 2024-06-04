<?php
    include 'navhead.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card rounded-4">
                    <div class="card-header">
                        <h2>Event Registration</h2>
                    </div>
                    <div class="card-body">
                        <form id="registrationForm" class="fs-5" method="post" enctype="multipart/form-data">
                            <!-- Step 1: Basic Information -->
                            <div class="step active">
                                <div class="form-group">
                                    <!-- <label for="orgid" class="form-label">Organization ID</label> -->
                                    <input type="hidden" class="form-control rounded-4" id="orgid"  name="orgid" >
                                </div>
                                <div class="form-group">
                                    <label for="eventName" class="form-label">Event Name</label>
                                    <input type="text" class="form-control rounded-4" id="eventName" name="EventName" >
                                </div>
                                <div class="form-group">
                                    <label for="eventType">Event Type</label>
                                    <select class="form-control rounded-4" id="eventType" name="EventType" >
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
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control rounded-4" id="description" name="Description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="capacity">Capacity</label>
                                    <input type="number" class="form-control rounded-4" id="capacity" name="Capacity">
                                </div>
                                <div class="d-grid d-flex justify-content-end">
                                    <button type="button" class="btn col-3  fs-6 col-xs-2 btn-lg btn-outline-primary next-step rounded-pill">Next <i class="fa fa-angle-right ml-2 ml-sm-0"></i></button>
                                </div>
                            </div>

                            <!-- Step 2: Date and Time -->
                            <div name="timeAndDate" id="timeAndDate" class="step">
                                <fieldset class="mt-3 rounded-4">
                                    <legend> Event Date</legend>
                                    <div class="row mx-auto">
                                        <div class="col-5 form-group">
                                            <label for="startDate">Start Date</label>
                                            <input type="datetime-local" class="form-control" id="startDate" name="StartDate" >
                                        </div>
                                        <div class="col-5 form-group">
                                            <label for="endDate">End Date</label>
                                            <input type="datetime-local" class="form-control" id="endDate" name="EndDate" >
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="mt-3 rounded-4">
                                    <legend> Event Time</legend>
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
                                                <label for="ticketType">Ticket Type</label>
                                                <select class="form-control rounded-4" id="ticketType" name="TicketType[]" >
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
                                            <div class="form-group col-5">
                                                <label for="quantity">Quantity</label>
                                                <input type="number" id="quantity" class="form-control rounded-4" name="Quantity[]" >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="returnable">Returnable</label>
                                                <select class="form-control rounded-4" id="returnable" name="Returnable[]" >
                                                    <option value="">Select returnable option</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-5">
                                                <label for="limitQuantity">Limit Quantity</label>
                                                <input type="number" id="limitQuantity" class="form-control rounded-4" name="LimitQuantity[]" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="discount">Discount</label>
                                            <input type="number" id="discount" class="form-control rounded-4" name="Discount[]" placeholder="%" >
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Price</label>
                                            <input type="number" id="price" class="form-control rounded-4" name="Price[]" placeholder="₹">
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
                                <div class="step">
                                <div id="posterContainer" class="form-group">
                                <label for="eventPoster">Event Poster</label>
                                <input type="file" class="form-control-file" id="eventPoster" accept="image/*" onchange="previewImage(event)">
                                <div id="posterPreview"></div>
                            </div>
                            <button type="button" class="btn btn-primary" id="addPosterButton1">Add Poster</button>
                            <button type="button" class="btn btn-danger" id="removePosterButton">Remove Poster</button>

                                <div class="form-group">
                                    <label for="country">Country: </label>
                                        <select name="Country" id="country" class="form-control"> 
                                            <option value="" selected="Selected">Select Country</option>
                                        </select>
                                        <label for="state">State:</label> 
                                        <select name="State" id="state" class="form-control"> 
                                            <option value="" selected="Selected">Select State</option>
                                        </select>
                                        <label for="city">City: </label> 
                                        <select name="City" id="city" class="form-control"> 
                                            <option value="" selected="Selected">Select City</option>
                                        </select>
                                </div>

                                    <div class="form-group">
                                        <label for="venueAddress">Venue Address</label>
                                        <textarea class="form-control rounded-4" id="venueAddress" name="VenueAddress"></textarea>
                                        <!-- <input type="text" class="form-control rounded-4" id="venueAddress" name="VenueAddress"> -->
                                    </div>
                                
                                    <div class="d-grid d-flex justify-content-center gap-5">
                                        <button type="button" class="btn col-3 fs-5 col-xs-2 btn-lg btn-outline-primary prev-step rounded-pill"> <i class="fa fa-angle-left mr-2 ml-sm-0"></i>Previous</button>
                                        <button type="submit" class="btn col-3 fs-5 col-xs-2 btn-lg btn-outline-success next-step rounded-pill" > Update <i class="fa fa-bullhorn ml-2 fs-sm-7 ml-sm-0"></i></button>
                                    </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="edit_eventjs.js"></script>
    <script>

        
function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const newPreviewImg = document.createElement('img');
                newPreviewImg.src = reader.result;
                newPreviewImg.alt = 'Event Poster';
                newPreviewImg.classList.add('poster-preview-img');

                const posterPreviewDiv = document.getElementById('posterPreview');
                posterPreviewDiv.appendChild(newPreviewImg);
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        document.getElementById('addPosterButton1').addEventListener('click', function() {
           // Create a new div for the new input field
    const newDiv = document.createElement('div');
    newDiv.classList.add('form-group', 'poster-input');

    // Create a new label
    const newLabel = document.createElement('label');
    newLabel.innerText = 'Event Poster';

    // Create a new input field
    const newInput = document.createElement('input');
    newInput.type = 'file';
    newInput.classList.add('form-control-file');
    newInput.name = 'EventPoster[]';
    newInput.accept = 'image/*';
    newInput.setAttribute('onchange', 'previewImage(event)');

    // Append the label and input to the new div
    newDiv.appendChild(newLabel);
    newDiv.appendChild(newInput);

    // Append the new div to the poster container
    document.getElementById('posterContainer').appendChild(newDiv);
        });

            // document.getElementById('eventPoster').addEventListener('change', function(event) {
            //     previewImage(event);
            // });
        //remove Poster and poster preview for that input there should be alteast 1 psoter
        document.getElementById('removePosterButton').addEventListener('click', function() {
            const posterPreviewDiv = document.getElementById('posterPreview');
            const posterInputs = document.querySelectorAll('.poster-input');
            if (posterInputs.length > 0) {
                posterInputs[posterInputs.length - 1].remove();
                posterPreviewDiv.lastElementChild.remove();
            } else {
                alert('There should be at least one poster');
            }
        });

        

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
    document.getElementById('country').value = event.Country;
    document.getElementById('state').value = event.State;
    document.getElementById('city').value = event.City;
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