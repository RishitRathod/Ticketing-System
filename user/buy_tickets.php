<?php
include 'userdashnav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Tickets</title>
    
    <style>
        .container {
            max-width: 800px;
            margin: auto;
        }
        .form-section {
            border: 1px solid #ced4da;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        legend {
            width: auto;
            padding: 0 10px;
            font-size: 1.2em;
            margin-bottom: 10px;
        }
        body {
            margin-top: 120px !important;
            padding: 10px;
        }
        .btn-space {
            margin-bottom: 30px;
        }
        .quantity-controls {
            display: flex;
            align-items: center;
        }
        .quantity-controls button {
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            border: 1px solid #ced4da;
            background-color: #f8f9fa;
            
        }
       /* .quantity-controls input {
            width: 50px;
            text-align: center;
            margin: 0 5px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        } */
    </style>
</head>
<body>
  
    <h1 class="text-center">Buy Tickets</h1>
    <form id="form" class="container-xxl mb-5" action="/submit_ticket" method="post">
            <div class="row justify-content-center">
                <fieldset class="form-section col-12 col-md-5 mx-2">
                    <legend><strong>Event Selection</strong></legend>
                    <div class="form-group">
                        <label>Event:</label>
                        <input class="form-control" id="event" name="event" disabled>

                    </div>
                    <div class="form-group row justify-content-center">
                        <div class="form-group col-6">
                            <label>Start Date:</label>
                            <input  class="form-control" onfocus="(this.type = 'date')" id="event-date" name="event-date" disabled>
                            <!-- <input class="form-control" id="event-date" name="event-date"> -->
                        </div>
                        <div class="form-group col-6">
                            <label>End Date:</label>
                            <input class="form-control" onfocus="(this.type = 'date')" id="eevent-date"  name="eevent-date" disabled>
                            <!-- <input class="form-control" id="eevent-date" name="eevent-date"> -->
                        </div>
                        <div class="form-inline row justify-content-center">
                            <div class="form-group col-9">
                                <label class="fs-6 fw-bold mr-3" >Select Date</label>
                                <input type="text" class="form-control datepicker" onfocus="(this.type = 'date')" id="startDate" placeholder="dd-mm-yyyy" name="startDate">
                                <!-- <input type="date" class="form-control datepicker" id="startDate" name="StartDate"> -->
                            </div>
                        </div>
                    </div>

                    
                </fieldset>
                <fieldset class="form-section col-12 col-md-5 mx-2">
                    <legend><strong>Buyer Information</strong></legend>
                    <div class="form-group">
                        <label for="name">Full Name:</label>
                        <input type="text" class="form-control" id="name" name="name" >
                    </div>
                    <div class="form-group row">
                    
                    <div class="form-group col-6">
                        <label for="email">Email Address:</label>
                        <input type="email" class="form-control" id="email" name="email" >
                    </div>
                    <div class="form-group col-6">
                        <label for="phone">Phone Number:</label>
                        <input type="tel" class="form-control" id="phone" name="phone" >
                    </div>
                    </div>
                </fieldset>
                <fieldset class="form-section col-12 col-md-5 py-1 mx-2">
                    <legend><strong>Ticket Information</strong></legend>

                    <div class="form-group row p-0 g-0">
                        <div class="form-group col-4 py-0 g-0 mb-0">
                            <label for="time-slot">Time-Slot:</label>
                            <select class="form-control" id="time-slot" name="time-slot">
                                <!-- Options populated by fetchTicketType function -->
                            </select>
                            <input type="hidden" id="timeslotid" name="timeslotid">
                        </div>
                        <div class="form-group col-4 py-0 g-0 mb-0">
                            <label for="ticket-type">Ticket Type:</label>
                            <select class="form-control" id="ticket-type" name="ticket-type">
                                <!-- Options populated by fetchTicketType function -->
                            </select>
                            <input type="hidden" id="ticketid" name="ticketid">
                        </div>
                        <div class="form-group col-4 py-0 g-0 mb-0">
                            <label for="quantity">Quantity:</label>
                            <div class="quantity-controls">
                                <button type="button" id="decrease-quantity">-</button>
                                <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="10" value="1">
                                <button type="button" id="increase-quantity" >+</button>
                            </div>
                        </div>
                    </div>
                    <div align="end">
                        <div id="price"></div>
                        <div id="available_tickets"></div>
                    </div>
                </fieldset>
                <div class=" col-5 g-2 justify-content-center">
                    <div class="col-12 col-md-8 mt-3">
                    <!-- <p>Review Order:</p> -->
                    <!-- Order summary here -->
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">I agree to the terms and conditions.</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="newsletter" name="newsletter">
                            <label class="form-check-label" for="newsletter">Sign me up for the newsletter.</label>
                        </div>
                    </div>
                    <div align="center">
                        <button type="submit" class="btn btn-primary btn-space mt-3">Purchase Tickets</button>
                    </div>
                </div>
            </div>

    </form>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
   
   async function fetchDetails(eventID) {
    try {
        const response = await fetch('../fetchUser.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ EventID: eventID, action: 'GetDetailsAtBuyTickets' }),
        });
        const data = await response.json();
        if (data.status === 'success') {
            console.log(data.data);
            const eventDetails = data.data[0];
            document.getElementById('event').value = eventDetails.EventName;
            document.getElementById('event-date').value =  new Date(eventDetails.StartDate).toLocaleDateString('en-GB');
            document.getElementById('eevent-date').value =  new Date(eventDetails.EndDate).toLocaleDateString('en-GB');
            
            const startDateInput = document.getElementById('startDate');
            startDateInput.min = eventDetails.StartDate;
            startDateInput.max = eventDetails.EndDate;

            // Store all tickets data globally
            window.allTickets = data.data;

            populateTicketTypes(data.data, startDateInput.value);
        } else {
            console.error('Error:', data.message);
        }
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}

function populateTicketTypes(tickets, selectedDate) {
    const timeslotSelect = document.getElementById('time-slot');
    timeslotSelect.innerHTML = '';

    const ticketTypeSelect = document.getElementById('ticket-type');
    ticketTypeSelect.innerHTML = '';
    
    tickets.forEach(ticket => {
        const option = document.createElement('option');
        option.value = ticket.TicketID;
        option.textContent = `${ticket.TicketType}`;
        option.dataset.limitQuantity = ticket.LimitQuantity;
        option.dataset.price = ticket.Price;
        option.dataset.availability = ticket.Availability; // Added availability dataset
        ticketTypeSelect.appendChild(option);
    });

    filterTimeslotsByDate(selectedDate);
    updateHiddenFields();
}

function filterTimeslotsByDate(selectedDate) {
    const timeslotSelect = document.getElementById('time-slot');
    timeslotSelect.innerHTML = '';

    window.allTickets[0].TimeSlots.forEach(timeSlot => {
        if (timeSlot.SlotDate === selectedDate) {
            const option = document.createElement('option');
            option.value = timeSlot.TimeSlotID;
            option.textContent = `${timeSlot.StartTime} - ${timeSlot.EndTime}`;
            option.dataset.limitQuantity = timeSlot.LimitQuantity;
            option.dataset.price = timeSlot.Price;
            option.dataset.availability = timeSlot.Availability;
            timeslotSelect.appendChild(option);
        }
    });

    updateHiddenFields();
}

function updateHiddenFields() {
    const timeslotSelect = document.getElementById('time-slot');
    const ticketTypeSelect = document.getElementById('ticket-type');

    const selectedTimeslot = timeslotSelect.options[timeslotSelect.selectedIndex];
    const selectedTicketType = ticketTypeSelect.options[ticketTypeSelect.selectedIndex];

    document.getElementById('timeslotid').value = selectedTimeslot ? selectedTimeslot.value : '';
    document.getElementById('ticketid').value = selectedTicketType ? selectedTicketType.value : '';

    updateQuantityLimit();
}

function updateQuantityLimit() {
    const ticketTypeSelect = document.getElementById('ticket-type');
    const selectedOption = ticketTypeSelect.options[ticketTypeSelect.selectedIndex];
    const quantityInput = document.getElementById('quantity');
    
    const limitQuantity = selectedOption ? selectedOption.dataset.limitQuantity : 10;
    quantityInput.max = limitQuantity;

    const ticketPrice = selectedOption ? parseFloat(selectedOption.dataset.price) : 0;
    const availability = selectedOption ? parseFloat(selectedOption.dataset.availability) : 0; // Corrected syntax
    const quantity = parseInt(quantityInput.value);
    const totalPrice = ticketPrice * quantity;

    const priceDiv = document.getElementById('price');
    priceDiv.textContent = `Total Price: $${totalPrice} (Availability: ${availability})`;
}

<?php
    $eventID = isset($_GET['id']) ? $_GET['id'] : null;
?>
async function initialize() {
    const eventID = <?php echo json_encode($eventID); ?>;
    if (eventID) {
        await fetchDetails(eventID);
    } else {
        console.error("No event ID provided.");
    }
}

function getUserID() {
    const cookies = document.cookie.split(';').map(cookie => cookie.trim());
    for (const cookie of cookies) {
        if (cookie.startsWith('id=')) {
            return cookie.split('=')[1];
        }
    }
    return null;
}

let User = getUserID();
if (User) {
    console.log(User);
} else {
    console.log('No user found.');
}

async function SubmitForm(event) {
    event.preventDefault();
    
    const eventDate = document.getElementById('startDate').value;
    console.log(eventDate);
    // let User = getUserID();

    const formData = {
        EventID: <?php echo json_encode($eventID); ?>,
        EventDate: eventDate,
        TicketID: document.getElementById('ticketid').value,
        TimeSlotID: document.getElementById('timeslotid').value,
        Quantity: document.getElementById('quantity').value,
        Name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        UserID: getUserID()
    };
    console.log(formData);

    try {
        const response = await fetch('./submit_ticket.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData),
        });
        const result = await response.json();
        if (result.status === 'success') {
            alert('Ticket submitted successfully');
        } else {
            alert('Failed to submit ticket: ' + result.message);
        }
    } catch (error) {
        console.error('Error submitting form:', error);
        alert('Failed to submit ticket due to an error');
    }
}

document.getElementById('form').addEventListener('submit', SubmitForm);

document.getElementById('decrease-quantity').addEventListener('click', () => {
    const quantityInput = document.getElementById('quantity');
    let quantity = parseInt(quantityInput.value, 10);
    if (quantity > 1) {
        quantityInput.value = quantity - 1;
        updateQuantityLimit();
    }
});

document.getElementById('increase-quantity').addEventListener('click', () => {
    const quantityInput = document.getElementById('quantity');
    let quantity = parseInt(quantityInput.value, 10);
    if (quantity < quantityInput.max) {
        quantityInput.value = quantity + 1;
        updateQuantityLimit();
    }
});

document.getElementById('ticket-type').addEventListener('change', updateHiddenFields);
document.getElementById('time-slot').addEventListener('change', updateHiddenFields);
document.getElementById('startDate').addEventListener('change', (event) => {
    const selectedDate = event.target.value;
    filterTimeslotsByDate(selectedDate);
});

initialize();


</script>
    
</body>
<?php
include 'user_footer.html';
?>
</html>