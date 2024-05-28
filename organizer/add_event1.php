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
                                <!-- <div class="form-group"> -->
                                    <!-- <label for="orgid" class="form-label">Organization ID</label> -->
                                    <!-- <input type="text" class="form-control rounded-4" id="orgid" name="orgid" > -->
                                <!-- </div> -->
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
                                    </select>
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
                            <div class="step">
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
                                                </select>
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
                                <div class="form-group">
                                    <label for="eventPoster">Event Poster</label>
                                    <input type="file" class="form-control-file" id="eventPoster" name="EventPoster">
                                </div>
                                <div class="form-group">
                                    <label for="venueAddress">Venue Address</label>
                                    <textarea class="form-control rounded-4" id="venueAddress" name="VenueAddress"></textarea>
                                    <!-- <input type="text" class="form-control rounded-4" id="venueAddress" name="VenueAddress"> -->
                                </div>
                                <div class="form-group">
                                    <label for="venueCascadedDropdown">Country</label>
                                    <input type="text" class="form-control rounded-4" id="venueCascadedDropdown" name="VenueCascadedDropdown">
                                </div>
                                <div class="form-group">
                                    <label for="stateCityAddress">State</label>
                                    <input type="text" class="form-control rounded-4" id="stateCityAddress" name="StateCityAddress">
                                </div>
                                <div class="d-grid d-flex justify-content-center gap-5">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script>
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
            
            const nextBtns = document.querySelectorAll('.next-step');
            const prevBtns = document.querySelectorAll('.prev-step');
            const form = document.getElementById('registrationForm');
            const steps = form.querySelectorAll('.step');
            const addTicketBtn = document.getElementById('addTicket');
            const ticketContainer = document.getElementById('ticketContainer');
            let currentStep = 0;

            nextBtns.forEach(button => {
                button.addEventListener('click', () => {
                    if (currentStep < steps.length - 1) {
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
                console.log('Form submitted');

                var formData = new FormData(form);

                for (let [key, value] of formData.entries()) {
                    console.log(`${key}: ${value}`);
                }

                fetch('add_event.php', {
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
            });

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
    </script>

    <?php 
        include 'footer.php';
    ?>
</body>
</html>
