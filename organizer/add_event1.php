
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
                                    <input type="text" class="form-control rounded-4" id="eventName" name="EventName" required>
                                </div>
                                <div class="form-group">
                                    <label for="eventType">Event Type</label>
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
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control rounded-4" id="description" name="Description" required></textarea>
                                </div>
                                <div class="form-group ml-2">
                                    <label class="form-check-label mr-5">Select Which Balance you wish to use</label><br>
                                    <input class="form-check-input" type="radio" name="choice" id="TicketBased" value ="TicketBased">
                                    <label class="form-check-label" for="TicketBased">Ticket Based</label><br>
                                    <input class="form-check-input" type="radio" class="form-check-input" name="choice" id="TimeBased" value ="TimeBased">
                                    <label class="form-check-label" for="TimeBased">Time Based</label>

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
        <input type="date" class="form-control datepicker" id="startDate" name="StartDate">
    </div>
    <div class="col-5 form-group">
        <label for="endDate">End Date</label>
        <input type="date" class="form-control" id="endDate" name="EndDate">
    </div>
</div>
<p id="dayDifference"></p>
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
                                                <label for="returnable">Refundable</label>
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
                                            <input type="number" id="discount" step="0.01"  class="form-control rounded-4" name="Discount[]" placeholder="%" >
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
                                <div class="container">
                                    <label for="eventPoster" class="d-block">Event Poster</label>
                                    <div id="posterContainer" class="mb-3">
                                        <div class="form-group poster-input">
                                            <input type="file" class="form-control form-control-sm" id="eventPoster" name="EventPoster[]" accept="image/*" onchange="previewImage(event)">
                                        </div>
                                    </div>
                                    <button type="button" id="addPosterButton" class="btn btn-primary">Add Poster</button>
                                    <button type="button" id="removePosterButton" class="btn btn-danger">Remove Poster</button>
                                    <div id="posterPreview" class="mt-3"></div>
                                </div>
                                <!-- <fieldset> -->
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
    


    <script>


       async function getOrgPackages(OrgID){
            await fetch('../fetchOrgs.php',{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'FetchOrgPackages',
                    OrgID: OrgID
                })
            })
            .then(response => response.json())
            .then(data => {
                return data;
                console.log(data);
                if(data.status === 'success'){
                    const packages = data.data;
                    console.log(packages);
                    console.log(packages[0].No_of_Days_Or_Tickets);

                    const totaldays = packages[0].No_of_Days_Or_Tickets;
                }else{
                    alert('No packages found');
                }
            })
        }
       
        // const OrgID=getCookieValue('id');
    
// console.log(totaldays);
function validateForm() {
        const form = document.getElementById('registrationForm');
        const startDateInput = document.getElementById('startDate');
        const endDateInput = document.getElementById('endDate');

        // Get the selected start and end dates and times
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);
        const currentDate = new Date();

        // Check if the start date and time are before the end date and time
        if (startDate >= endDate) {
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
    // Get all end time inputs
    const endTimeInputs = document.querySelectorAll('input[name="EndTimeSlot[]"]');

    // Iterate over each pair of start and end time inputs
    for (let i = 0; i < startTimeInputs.length; i++) {
        const startTime = new Date(startDate.toDateString() + ' ' + startTimeInputs[i].value);
        const endTime = new Date(startDate.toDateString() + ' ' + endTimeInputs[i].value);

        // Check if the start time is before the end time
        if (startTime >= endTime) {
            alert('Start time must be before end time for each time slot.');
            return false;
        }
        if(startTime <= currentDate){
            alert('Start time must be greater than today.');
            return false;
        }
        if(endTime <= currentDate){
            alert('End time must be greater than today.');
            return false;
        }

        if(endTime <= startTime){
            alert('End time must be greater than start time.');
            return false;
        }
        if(startTimeInputs[i].value === '' || endTimeInputs[i].value === '') {
            alert('Please fill in all time slots.');
            return false;
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


        document.addEventListener("DOMContentLoaded", function() {
            fetch('../cascading.php') 
                .then(response => response.json())
                .then(data => {
                    const countrySel = document.getElementById("country");
                    const stateSel = document.getElementById("state");
                    const citySel = document.getElementById("city");

                    let countries = {};

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
                        let selectedCountry = this.value;
                        if (selectedCountry && countries[selectedCountry]) {
                            for (let state in countries[selectedCountry]) {
                                let option = new Option(state, state);
                                stateSel.add(option);
                            }
                        }
                    }

                    stateSel.onchange = function() {
                        citySel.length = 1;
                        let selectedCountry = countrySel.value;
                        let selectedState = this.value;
                        if (selectedState && countries[selectedCountry] && countries[selectedCountry][selectedState]) {
                            countries[selectedCountry][selectedState].forEach(city => {
                                let option = new Option(city, city);
                                citySel.add(option);
                            });
                        }
                    }
                });
        });
    </script>
    
    <script>
        async function validatePackage(OrgID,PackageID){
            await fetch('../fetchOrgs.php',{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'validatePackage',
                    OrgID: OrgID,
                    PackageID: PackageID
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if(data.status === 'success'){
                    const packages = data.data;
                    console.log(packages);

                }else{
                    alert('No packages found');
                }
            })
        } 
         const getCookieValue = (name) => {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
};

        document.getElementById('orgid').value = getCookieValue('id');
        console.log(document.getElementById('orgid').value);
        getOrgPackages(document.getElementById('orgid').value);
        //validatePackage(document.getElementById(');
         console.log(getCookieValue('id'));
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
                startTimeLabel.textContent = "Start Time Slot";
                timeSlotDiv1.appendChild(startTimeLabel);

                const startTimeInput = document.createElement('input');
                startTimeInput.type = 'time';
                startTimeInput.className = 'form-control';
                startTimeInput.name = "StartTimeSlot[]";
                timeSlotDiv1.appendChild(startTimeInput);

                row.appendChild(timeSlotDiv1);

                const timeSlotDiv2 = document.createElement('div');
                timeSlotDiv2.classList.add('col-5', 'form-group');

                const endTimeLabel = document.createElement('label');
                endTimeLabel.textContent = "End Time Slot";
                timeSlotDiv2.appendChild(endTimeLabel);

                const endTimeInput = document.createElement('input');
                endTimeInput.type = 'time';
                endTimeInput.className = 'form-control';
                endTimeInput.name = "EndTimeSlot[]";
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

       



const fetchPackages = () => {
    return fetch('../fetchOrgs.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'getBalance', OrgID: getCookieValue('id') })
    })
    .then(response => {
        if (!response.ok) throw new Error('Failed to fetch data');
        
        return response.json();
        
    });
};
fetchPackages().then
(function(data){
    console.log("json",data);
    checkbalance(data.data[0]);
});
    
function checkbalance(data){

        if(data.Amount_of_Days===0 && data.Amount_of_Tickets===0){
            alert("You have no balance left");
            window.location.href = './org_profile.html';
        }

}

var availbleDays;
var availbleTickets;

const validateStep = (currentStep, data) => {

    choice = document.querySelector('input[name="choice"]:checked').value;
    console.log("choice",choice);
    if (currentStep === 1 && choice === 'TimeBased') {
        const startDate = new Date(document.getElementById('startDate').value);
        const endDate = new Date(document.getElementById('endDate').value);
        const totalDays = (endDate - startDate) / (1000 * 3600 * 24);

        

        console.log("availble days",data.data[0].Amount_of_Days);
        availbleDays=data.data[0].Amount_of_Days-totalDays;
        console.log("availble days",availbleDays);
        return totalDays < data.data[0].Amount_of_Days;
    } else if (currentStep === 0 && choice === 'TicketBased') {
        const capacity = parseInt(document.getElementById('capacity').value, 10);
console.log("capacity",data.data[0].Amount_of_Tickets);
        availbleTickets=data.data[0].Amount_of_Tickets-capacity;
        console.log("availble tickets",availbleTickets);
        return capacity < data.data[0].Amount_of_Tickets;
    }

    return true; // Allow progression for steps other than 0 and 1
};

nextBtns.forEach(button => {
    button.addEventListener('click', () => {
        if (currentStep < steps.length - 1) {
            if (currentStep === 0 || currentStep === 1) {
                fetchPackages()
                    .then(data => {
                        console.log("fetch",data);
                        if (validateStep(currentStep, data)) {
                            if (currentStep === 1 && !validateForm()) {
                                console.log('Form validation failed. Staying on step 1.');
                                return; // Stay on the current step if form validation fails
                            }
                            steps[currentStep].classList.remove('active');
                            currentStep++;
                            steps[currentStep].classList.add('active');
                        } else {
                            console.log('Validation failed. Cannot proceed to the next step.');
                        }
                    })
                    .catch(error => console.error('Error fetching or processing data:', error));
            } else {
                steps[currentStep].classList.remove('active');
                currentStep++;
                steps[currentStep].classList.add('active');
            }
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
               if(!validateForm()) {
                    
                    return;
                }
                console.log('Form submitted');
             console.log('Form submitted');

                var formData = new FormData(form);
                if(choice === 'TimeBased'){
                    formData.append('Amount_of_Tickets',0)
                    formData.append('Amount_of_Days',availbleDays)
                }else{
                    formData.append('Amount_of_Tickets',availbleTickets)
                    formData.append('Amount_of_Days',0)
                }
                
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
        document.getElementById('addPosterButton').addEventListener('click', function() {
            // Create a new div for the new input field
            const newDiv = document.createElement('div');
            newDiv.classList.add('form-group', 'poster-input');

            // Create a new label
            // const newLabel = document.createElement('label');
            // newLabel.innerText = 'Event Poster';

            // Create a new input field
            const newInput = document.createElement('input');
            newInput.type = 'file';
            newInput.classList.add('form-control','form-control-sm');
            newInput.name = 'EventPoster[]';
            newInput.accept = 'image/*';
            newInput.setAttribute('onchange', 'previewImage(event)');

            // Append the label and input to the new div
           // newDiv.appendChild(newLabel);
            newDiv.appendChild(newInput);

            // Append the new div to the poster container
            document.getElementById('posterContainer').appendChild(newDiv);
        });

        document.getElementById('removePosterButton').addEventListener('click', function() {
            const posterPreviewDiv = document.getElementById('posterPreview');
            const posterInputs = document.querySelectorAll('.poster-input');
            if (posterInputs.length > 1) {
                // Correctly select the last input and remove it
                posterInputs[posterInputs.length - 1].remove();
                posterPreviewDiv.lastElementChild.remove();
            } else {
                alert('There should be at least one poster');
            }
        });

        function previewImage(event) {
            const posterPreviewDiv = document.getElementById('posterPreview');
            const files = event.target.files;
            
            for (let i = 0; i < files.length; i++) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail', 'm-2');
                    img.style.maxWidth = '150px';
                    posterPreviewDiv.appendChild(img);
                }
                reader.readAsDataURL(files[i]);
            }
        }
    </script>

<script>
        document.addEventListener('DOMContentLoaded', () => {
            // Function to calculate and update days difference
            function calculateAndDisplayDaysDifference() {
                const startDate = document.getElementById('startDate').value;
                const endDate = document.getElementById('endDate').value;

                if (startDate && endDate) {
                    const start = new Date(startDate);
                    const end = new Date(endDate);

                    // Calculate the difference in milliseconds
                    const differenceInTime = end - start;

                    // Convert milliseconds to days
                    const differenceInDays = differenceInTime / (1000 * 3600 * 24);

                    // Display the difference in days
                    document.getElementById('dayDifference').innerText = `Number of days between dates: ${differenceInDays}`;
                }
            }

            // Attach event listeners to date inputs
            document.getElementById('startDate').addEventListener('change', calculateAndDisplayDaysDifference);
            document.getElementById('endDate').addEventListener('change', calculateAndDisplayDaysDifference);

            // Initialize dayDifference element
            document.getElementById('dayDifference').innerText = 'Select dates to calculate difference';
        });



    </script>
    
<?php
include 'footer.php';
?>

</body>
</html>