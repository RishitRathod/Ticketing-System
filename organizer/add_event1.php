
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
                        <h2>Event Registration</h2>
                    </div>
                    <div class="card-body">
                        <form id="registrationForm" class="fs-5  " method="post" enctype="multipart/form-data" novalidate>
                            <!-- Step 1: Basic Information -->
                            <div class="step active ">
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
                            <div name="timeAndDate" id="timeAndDate" class="step ">
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
                                            <label for="startTimeSlot1">Start Time Slot</label>
                                            <input type="time"  class="form-control" id="startTimeSlot1" name="StartTimeSlot[]">
                                        </div>
                                        <div class="col-5 form-group">
                                            <label for="endTimeSlot1">End Time Slot</label>
                                            <input type="time"  class="form-control" id="endTimeSlot1" name="EndTimeSlot[]">
                                        </div>
                                    </div>

                                                <button type="button" class="btn btn-danger m-2 remove-time-slot" id="removeTime"><i class="fa fa-trash mr-2"></i>Remove</button>
                                        </div>
                                    </div>
                                </fieldset>
                                
                                <div class="form-group m-2">
                                    <button type="button" class="btn btn-success rounded-3" id="addTimeSlot"><i class="fa fa-plus mr-2 ml-sm-0"></i>Add Time Slot</button>
                                </div>
                                <div class="d-grid d-flex flex-row justify-content-center gap-5">
                                    <button type="button" class="btn col-5 fs-6 btn-lg btn-outline-primary prev-step rounded-pill"> <i class="fa fa-angle-left mr-2 ml-sm-0"></i>Previous</button>
                                    <button type="button" class="btn col-5 fs-6 btn-lg btn-outline-primary next-step rounded-pill"> Next <i class="fa fa-angle-right ml-2 fs-sm-7 ml-sm-0"></i></button>
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
                                                <input type="number" id="quantity" value="" onload="givecapacity(this.id)" class="form-control rounded-4" min="1" name="Quantity[]"  required>
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
                                                <label for="limitQuantity">Limit Quantity<span class="req">*</span></label>
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
                                <div class="d-grid d-flex flex-row justify-content-center gap-5">
                                    <button type="button" class="btn col-5 fs-5 btn-lg btn-outline-primary prev-step rounded-pill"> <i class="fa fa-angle-left mr-2 ml-sm-0"></i>Previous</button>
                                    <button type="button" class="btn col-5 fs-5 btn-lg btn-outline-primary next-step rounded-pill"> Next <i class="fa fa-angle-right ml-2 fs-sm-7 ml-sm-0"></i></button>
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
                               
                                <div class="d-grid d-flex flex-row mt-3 justify-content-center gap-5">
                                    <button type="button" class="btn col-5 fs-5 btn-lg btn-outline-primary prev-step rounded-pill"> <i class="fa fa-angle-left mr-2 ml-sm-0"></i>Previous</button>
                                    <button type="submit" class="btn col-5 fs-5 btn-lg btn-outline-success next-step rounded-pill" > Submit <i class="fa fa-bullhorn ml-2 fs-sm-7 ml-sm-0"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>  
                </div>
            </div>
        </div>
    </div>
        
    <script>
        
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

        function setTicketQuantity(){
            var capacity = document.getElementById('capacity').value;
            document.getElementById('quantity').setAttribute('max', capacity);
            document.getElementById('quantity').value = capacity;
        }
        function givecapacity(id){

            var capacity = document.getElementById('capacity').value;
            document.getElementById(id).setAttribute('max', capacity);
        }

        function validateTicektQuntity(id){
            var quantity = document.getElementById('quantity').value;
            var limitQuantity = document.getElementById('limitQuantity').value ? document.getElementById('limitQuantity').value : 0;
            var EventCapacity = document.getElementById('capacity').value;
            // if(quantity > EventCapacity){
            //     alert('Quantity cannot be greater than Event Capacity');
            //     document.getElementById(id).setAttribute('max', EventCapacity);

            //     return false;
            // }   
            if(quantity < limitQuantity){
                alert('Limit Quantity cannot be greater than quantity');
                return false;
            }
            return true;
          
        }
    </script>

    <script>
        //// function vaidationFields(){
        //     var textareaValue = document.getElementById('description').value.trim(); //description
        //     var wordCountRegex = /\b\w+\b(?:\W+\b\w+\b){19,}/;
    
        //     if (wordCountRegex.test(textareaValue)) {
        //         // alert('Textarea contains at least 20 words.');
        //         console.log('Description pass');
        //     } else {
        //         alert('Textarea does not contain at least 20 words.');
        //         return false;
        //     }
        // }
        function myFunction() {

            var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
        } 
        (() => {
        'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
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
function validateForm0() {  
        if (document.getElementById('eventName').value === '') {
            alert('Please enter event name');
            return false;
        }
        if (document.getElementById('capacity').value === '' || document.getElementById('capacity').value < 0) {
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
        if (startDate >endDate) {
            alert('Start date must be before end date.');
            return false;
        }

        // Check if the start date and time are greater than today's date and time
        if (startDate <= currentDate  ) {
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
}

// If no issues found, return true
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
        const totalDays = (endDate - startDate) / (1000 * 3600 * 24)+1;

        

        console.log("availble days",data.data[0].Amount_of_Days);
        availbleDays=data.data[0].Amount_of_Days-totalDays;
        console.log("availble days",availbleDays);
        if(availbleDays<=0){
            alert("Not Enough Balance Please Recharge!");
            return false; 
        }
        return totalDays < data.data[0].Amount_of_Days;
    } else if (currentStep === 0 && choice === 'TicketBased') {
        const capacity = parseInt(document.getElementById('capacity').value, 10);
console.log("capacity",data.data[0].Amount_of_Tickets);
        availbleTickets=data.data[0].Amount_of_Tickets-capacity;
        if(availbleTickets<=0){
            alert("Not Enough Balance Please Recharge");
            return false; 
        }
        console.log("availble tickets",availbleTickets);
        return capacity < data.data[0].Amount_of_Tickets;
    }

    return true; // Allow progression for steps other than 0 and 1
};

nextBtns.forEach(button => {
    button.addEventListener('click', () => {
        if (currentStep < steps.length - 1) {
            if (currentStep === 2 && !validateFormStep2()) {
                console.log('Form validation failed. Staying on step 2.');
                return;
            }
            if (currentStep === 0 || currentStep === 1) {
                fetchPackages()
                    .then(data => {
                        console.log("fetch", data);
                        
                        if (validateStep(currentStep, data)) {
                            if (currentStep === 1 && !validateForm()) {
                                console.log('Form validation failed. Staying on step 1.');
                                return; // Stay on the current step if form validation fails
                            }
                            if (currentStep === 0 && !validateForm0()) {
                                console.log('Form validation failed. Staying on step 0.');
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



            function validateFormStep3(){

                const posterInput = document.getElementById('eventPoster');
        if (posterInput.files.length === 0) {
            alert('Please upload at least one event poster.');
           // event.preventDefault();
            return false;
        }

        // Validate country selection
        const countrySelect = document.getElementById('country');
        if (countrySelect.value === "") {
            alert('Please select a country.');
           // event.preventDefault();
            return false;
        }

        // Validate state selection
        const stateSelect = document.getElementById('state');
        if (stateSelect.value === "") {
            alert('Please select a state.');
           // event.preventDefault();
            return false;
        }

        // Validate city selection
        const citySelect = document.getElementById('city');
        if (citySelect.value === "") {
            alert('Please select a city.');
            //event.preventDefault();
            return false;
        }

        // Validate venue address
        const venueAddressInput = document.getElementById('venueAddress');
        if (venueAddressInput.value.trim() === "") {
            alert('Please enter the venue address.');
            //event.preventDefault();
            return false;
        }
        return true;
            }






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
                if (!validateFormStep3()){
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
                    alert("event created successfully");
                  //  window.location.href = './organization_events.php';
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
        // document.getElementById('addPosterButton').addEventListener('click', function() {
        //     // Create a new div for the new input field
        //     const newDiv = document.createElement('div');
        //     newDiv.classList.add('form-group', 'poster-input');

        //     // Create a new label
        //     // const newLabel = document.createElement('label');
        //     // newLabel.innerText = 'Event Poster';

        //     // Create a new input field
        //     const newInput = document.createElement('input');
        //     newInput.type = 'file';
        //     newInput.classList.add('form-control','form-control-sm');
        //     newInput.name = 'EventPoster[]';
        //     newInput.accept = 'image/*';
        //     newInput.setAttribute('onchange', 'previewImage(event)');

        //     // Append the label and input to the new div
        //    // newDiv.appendChild(newLabel);
        //     newDiv.appendChild(newInput);

        //     // Append the new div to the poster container
        //     document.getElementById('posterContainer').appendChild(newDiv);
        // });

        // document.getElementById('removePosterButton').addEventListener('click', function() {
        //     const posterPreviewDiv = document.getElementById('posterPreview');
        //     const posterInputs = document.querySelectorAll('.poster-input');
        //     if (posterInputs.length > 1) {
        //         // Correctly select the last input and remove it
        //         posterInputs[posterInputs.length - 1].remove();
        //         posterPreviewDiv.lastElementChild.remove();
        //     } else {
        //         alert('There should be at least one poster');
        //     }
        // });

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
                    document.getElementById('dayDifference').innerText = `Number of days between dates: ${differenceInDays+1}`;
                }
            }

            // Attach event listeners to date inputs
            document.getElementById('startDate').addEventListener('change', calculateAndDisplayDaysDifference);
            document.getElementById('endDate').addEventListener('change', calculateAndDisplayDaysDifference);

            // Initialize dayDifference element
            document.getElementById('dayDifference').innerText = 'Select dates to calculate difference';
        });



        // Get today's date
        var today = new Date();
var tomorrow = new Date();
tomorrow.setDate(today.getDate() + 1);
var tomorrowISOString = tomorrow.toISOString().split('T')[0];

// Set the minimum date for start date input
document.getElementById('startDate').setAttribute('min', tomorrowISOString);

// Set the minimum date for end date input (optional, if you want to limit end date too)
document.getElementById('endDate').setAttribute('min', tomorrowISOString);



</script>
    
<?php
include 'footer.php';
?>

</body>
</html>