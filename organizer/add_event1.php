<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>
    <!-- Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    

    <!-- CSS -->
    <style>
        body{
            background-color: #ffffff;
        }
        td{
            margin-left: 5px;
            margin-right: 5px;
        }
        .nav-pills li a:hover {
            background-color: darkblue;
        }

        .dropdown-menu a:hover {
            background-color: darkblue;
            color: #fff;
        }

        .main-content {
            border: 1px solid #ccc;
            border-radius: 5px;
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2) ;
        }
        .backOnav{
            background-color: #000;
        }
        .stic {
            position:sticky;
            top:20px;
        }

    </style>
</head>
<body>  
    <div class="container-fluid w-100 p-3 backOnav text-white">
        <div class="row align-items-center">
            <a class="col-auto me-auto p-3 ml-3 mr-auto" href="./organization_dashboard.html" style="text-decoration: none;">
                <img src="../img/logo.png" height="60" class="rounded-circle" alt="Logo">
                <b class="h5 ml-2 text-light text-decoration-none">The Organizer</b>
            </a>  
            <div class="col-sm-auto col-3 ">
                <div class="dropdown open p-3 rounded-pill">
                    <button class="btn rounded-pill dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="../img/user.png" height="40" class="rounded-circle" alt="User">
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                        <a class="dropdown-item" href="./org_profile.html">Profile</a>
                        <a class="dropdown-item" href="./organization_logout.php">Log Out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row stic flex-nowrap">
            <div class="backOnav  col-auto col-xl-2 col-md-4 col-lg-2 min-vh-100 d-flex flex-column justify-content-between">
                <div class="backOnav p-2">
                    <ul class="nav nav-pills flex-column" id="parentDiv">
                        <li class="nav-item py-2">
                            <a href="./organization_dashboard.html" class="nav-link text-white"> 
                                <i class="fs-5 fa fa-tachometer"></i> <span class="fs-5 ms-3 d-none d-sm-inline">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item py-2">
                            <a href="./organization_events.php" class="nav-link text-white"> 
                                <i class="fs-5 fa fa-list"></i> <span class="fs-5 ms-3 d-none d-sm-inline">Events</span>
                            </a>
                        </li>
                        <li class="nav-item py-2">
                            <a href="./organization_plans.php" class="nav-link text-white"> 
                                <i class="fs-5 fa fa-th"></i> <span class="fs-5 ms-3 d-none d-sm-inline">Plans</span>
                            </a>
                        </li>
                        <li class="nav-item py-2">
                            <a href="./organization_analysis.php" class="nav-link text-white"> 
                                <i class="fs-5 fa fa-clipboard"></i> <span class="fs-5 ms-3 d-none d-sm-inline">Analysis</span>
                            </a>
                        </li>
                        <li class="nav-item py-2">
                            <a href="./organization_members.php" class="nav-link text-white"> 
                                <i class="fs-5 fa fa-users"></i> <span class="fs-5 ms-3 d-none d-sm-inline">Members</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col p-3">
                <div class="main-content mx-auto d-flex justify-content-center align-items-center">

            <script src="../script.js"></script>
           <script>
               
               function isUserLoggedIn() {
    const cookies = document.cookie.split(';').map(cookie => cookie.trim());
    for (const cookie of cookies) {
        if (cookie.startsWith('role=')) {
            console.log("User is logged in");
            return true;
        }
    }
    console.log("User is not logged in");
    return false;
}
            window.onload = function() {
                    if (isUserLoggedIn()) {
                   // document.getElementById('login').style.display = 'none';
                   // document.getElementById('profile').style.display = 'block';
                } else {
                   window.herf = "./organization_login.html";
                }
            }
                // Function to set active class to the clicked anchor tag
                function setActiveLink() {
                    // Get the current path
                    var currentPath = window.location.pathname;
                    
                    // Get all anchor tags within the parent div
                    var links = document.querySelectorAll('#parentDiv .nav-link');

                    // Remove 'active' class from all anchor tags and set to active if href matches current path
                    links.forEach(function(link) {
                        if (link.href.endsWith(currentPath)) {
                            link.classList.add('active');
                        } else {
                            link.classList.remove('active');
                        }
                    });
                }

        // Add event listener to set the active class when the DOM is fully loaded
        document.addEventListener('DOMContentLoaded', setActiveLink);


        </script>
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
                                <input type="file" class="form-control-file" id="eventPoster" name="EventPoster[]" >
                            </div>
                            <button type="button" class="btn btn-primary" id="addPosterButton">Add Poster</button>

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

            nextBtns.forEach(button => {
                button.addEventListener('click', () => {
                    if (currentStep < steps.length - 1) {
                        steps[currentStep].classList.remove('active');
                        //check if we are on the step of time and date and validate the form
                        // if(currentStep == 1){
                        //     if(!validateForm()) {
                        //         currentStep =0;
                                
                        //     }
                        // }
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

                // for (let [key, value] of formData.entries()) {
                //     console.log(${key}: ${value});
                // }

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
    var newDiv = document.createElement('div');
    newDiv.classList.add('form-group', 'poster-input');

    // Create a new label
    var newLabel = document.createElement('label');
    // newLabel.innerText = 'Event Poster';

    // Create a new input field
    var newInput = document.createElement('input');
    newInput.type = 'file';
    newInput.classList.add('form-control-file');
    newInput.name = 'EventPoster[]';

    // Create a remove button
    var removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.classList.add('btn', 'btn-danger', 'removePosterButton');
    removeButton.innerText = 'Remove';

    // Append the label, input, and remove button to the new div
    newDiv.appendChild(newLabel);
    newDiv.appendChild(newInput);
    newDiv.appendChild(removeButton);

    // Append the new div to the poster container
    document.getElementById('posterContainer').appendChild(newDiv);

    // Add event listener to the remove button
    removeButton.addEventListener('click', function() {
        var posterInputs = document.querySelectorAll('.poster-input');
   
            document.getElementById('posterContainer').removeChild(newDiv);
      
    });
});



    </script>

                    </div>
            </div>
        </div>
    </div>  


    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>    -->

    <footer class="bg-body-tertiary p-3 text-center text-lg-start">
    <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2024 Copyright:
            <a class="text-body" href="#"> Event Scheduler </a>
        </div>
    <!-- Copyright -->
    </footer>

</body>
</html>