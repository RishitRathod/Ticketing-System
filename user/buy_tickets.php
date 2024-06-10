<?php
include 'userdashnav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Purchase Form</title>
    
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
            margin-top: 150px !important;
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
        .quantity-controls input {
            width: 50px;
            text-align: center;
            margin: 0 5px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }
    </style>
</head>
<body>
  
    <div class="container">
        <h1 class="text-center">Buy Tickets</h1>
        <form id="form" action="/submit_ticket" method="post">
            <fieldset class="form-section">
                <legend>Event Selection</legend>
                <div class="form-group">
                    <label for="event">Event:</label>
                    <input class="form-control" id="event" name="event">

                </div>
                <div class="form-group">
                    <label for="event-date">Start Date:</label>
                    <input class="form-control" id="event-date" name="event-date">
                    <label for="eevent-date">End Date:</label>
                    <input class="form-control" id="eevent-date" name="eevent-date">
                 
                </div>

                <div class="col-5 form-group">
                    <label for="startDate">Select Date</label>
                    <input type="date" class="form-control datepicker" id="startDate" name="StartDate">
                </div>
            </fieldset>

            <fieldset class="form-section">
                <legend>Ticket Information</legend>

                
                <div class="form-group">
                    <label for="time-slot">Time-Slot:</label>
                    <select class="form-control" id="time-slot" name="time-slot">
                        <!-- Options populated by fetchTicketType function -->
                    </select>
                    <input type="hidden" id="timeslotid" name="timeslotid">
                </div>
                
                <div class="form-group">
                    <label for="ticket-type">Ticket Type:</label>
                    <select class="form-control" id="ticket-type" name="ticket-type">
                        <!-- Options populated by fetchTicketType function -->
                    </select>
                    <input type="hidden" id="ticketid" name="ticketid">
                </div>


                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <div class="quantity-controls">
                        <button type="button" id="decrease-quantity">-</button>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="10" value="1">
                        <button type="button" id="increase-quantity">+</button>
                    </div>
                </div>
                <div id="price"></div>
            </fieldset>

            <fieldset class="form-section">
                <legend>Buyer Information</legend>
                <div class="form-group">
                    <label for="name">Full Name:</label>
                    <input type="text" class="form-control" id="name" name="name" >
                </div>
                <div class="form-group">
                    <label for="email">Email Address:</label>
                    <input type="email" class="form-control" id="email" name="email" >
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number:</label>
                    <input type="tel" class="form-control" id="phone" name="phone" >
                </div>
            </fieldset>

            <fieldset class="form-section">
                <legend>Confirmation</legend>
                <p>Review Order:</p>
                <!-- Order summary here -->
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                    <label class="form-check-label" for="terms">I agree to the terms and conditions.</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="newsletter" name="newsletter">
                    <label class="form-check-label" for="newsletter">Sign me up for the newsletter.</label>
                </div>
            </fieldset>

            <button type="submit" class="btn btn-primary btn-block btn-space">Purchase Tickets</button>
        </form>
    </div>

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
            body: JSON.stringify({ EventID: eventID, action: 'GetDetailsAtBuyTickets' }), // Pass event ID here
        });
        const data = await response.json();
        if (data.status === 'success') {
            console.log(data.data);
            const eventDetails = data.data[0];
            document.getElementById('event').value = eventDetails.EventName;
            document.getElementById('event-date').value = eventDetails.StartDate;
            document.getElementById('eevent-date').value = eventDetails.EndDate;
            
            // Set constraints on the date input
            const startDateInput = document.getElementById('startDate');
            startDateInput.min = eventDetails.StartDate;
            startDateInput.max = eventDetails.EndDate;

            populateTicketTypes(data.data);
        } else {
            console.error('Error:', data.message);
        }
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}


function populateTicketTypes(tickets) {
    const timeslotSelect = document.getElementById('time-slot');
    timeslotSelect.innerHTML = '';
 
        tickets[0].TimeSlots.forEach(timeSlot => {
            const option = document.createElement('option');
            option.value = timeSlot.TimeSlotID;
            option.textContent = `${timeSlot.StartTime} - ${timeSlot.EndTime}`;
            option.dataset.limitQuantity = tickets.LimitQuantity;
            option.dataset.price = tickets.Price;
            timeslotSelect.appendChild(option);
            document.getElementById('timeslotid').value = option.value;
            console.log(timeSlot.TimeSlotID);
        });
 

    const ticketTypeSelect = document.getElementById('ticket-type');
    ticketTypeSelect.innerHTML = '';
    tickets.forEach(ticket => {
        const option = document.createElement('option');
        option.value = ticket.TicketID;
        option.textContent = `${ticket.TicketType} - $${ticket.Price} (Limit: ${ticket.LimitQuantity})`;
        option.dataset.limitQuantity = ticket.LimitQuantity;
        option.dataset.price = ticket.Price;
        ticketTypeSelect.appendChild(option);
        document.getElementById('ticketid').value = option.value;
        console.log(ticket.TicketID);
    });
}





function updateQuantityLimit() {
    const ee = document.getElementById("time-slot");
    const selectedOption1 = ee.options[ee.selectedIndex]; // Get the actual selected option element
    console.log(selectedOption1);
   

    const e = document.getElementById("ticket-type");
    const selectedOption = e.options[e.selectedIndex]; // Get the actual selected option element
    console.log(selectedOption);
    const quantityInput = document.getElementById('quantity');
    
    // Set the maximum quantity based on the selected ticket
    const limitQuantity = selectedOption ? selectedOption.dataset.limitQuantity : 10; // Default to 10 if no option is selected
    quantityInput.max = limitQuantity;

    // Calculate the price
    const ticketPrice = selectedOption ? parseFloat(selectedOption.dataset.price) : 0;
    const quantity = parseInt(quantityInput.value);
    const totalPrice = ticketPrice * quantity;

    // Display the total price in the price div
    const priceDiv = document.getElementById('price');
    priceDiv.textContent = 'Total Price: $' + totalPrice;
}


        <?php
    // Check if the 'id' parameter exists and is not empty
    $eventID = isset($_GET['id']) ? $_GET['id'] : null;
    ?>
        async function initialize() {
            // Encode the PHP variable as JSON to handle special characters or null values
            const eventID = <?php echo json_encode($eventID); ?>;
            if (eventID) {
                await fetchDetails(eventID);
                updateQuantityLimit();
            } else {
                console.error("No event ID provided.");
            }
        }

//         var User = getUser();

// // Log the User array to understand its structure
// console.log(User);
function getUserID() {
    const cookies = document.cookie.split(';').map(cookie => cookie.trim());
    for (const cookie of cookies) {
        if (cookie.startsWith('id=')) {
            return cookie.split('=')[1];
        }
    }
    return null;

}
// Access and log the UserID of the first user in the array
let User = getUserID();
if (User) {
    console.log(User);
} else {
    console.log('No user found.');
}

        async function SubmitForm(event) {
            const eventDate = document.getElementById('startDate').value;
console.log(eventDate); // Verify the date value
            event.preventDefault();
            const formData = {
                EventID: <?php echo json_encode($eventID); ?>,
                EventDate: eventDate,
                TicketID: document.getElementById('ticketid').value,
                TimeSlotID: document.getElementById('timeslotid').value,
                Quantity: document.getElementById('quantity').value,
                Name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                // startDate: document.getElementById('StartDate').value,
                UserID: 5

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
            }
        });

        document.getElementById('increase-quantity').addEventListener('click', () => {
            const quantityInput = document.getElementById('quantity');
            let quantity = parseInt(quantityInput.value, 10);
            if (quantity < quantityInput.max) {
                quantityInput.value = quantity + 1;

            }
        });

        document.getElementById('ticket-type').addEventListener('change', updateQuantityLimit);

        initialize();
    </script>
    
</body>
<?php
include 'user_footer.html';
?>
</html>