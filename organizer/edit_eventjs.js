
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

                for (let [key, value] of formData.entries()) {
                    console.log(`${key}: ${value}`);
                }
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

// Path: organizer/edit_event.php