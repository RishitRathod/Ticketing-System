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
                    <select class="form-control" id="event" name="event">
                        <option value="event1">Event 1</option>
                        <option value="event2">Event 2</option>
                        <option value="event3">Event 3</option>
                        <!-- More events -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="event-date">Date and Time:</label>
                    <select class="form-control" id="event-date" name="event-date">
                        <!-- Options populated based on selected event -->
                    </select>
                </div>
            </fieldset>

            <fieldset class="form-section">
                <legend>Ticket Information</legend>

                
                <div class="form-group">
                    <label for="time-slot">Time-Slot:</label>
                    <select class="form-control" id="time-slot" name="time-slot">
                        <!-- Options populated by fetchTicketType function -->
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="ticket-type">Ticket Type:</label>
                    <select class="form-control" id="ticket-type" name="ticket-type">
                        <!-- Options populated by fetchTicketType function -->
                    </select>
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
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number:</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required>
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
    // tickets.forEach(ticket => {
        tickets[0].TimeSlots.forEach(timeSlot => {
            const option = document.createElement('option');
            option.value = timeSlot.TimeSlotID[0];
            option.textContent = `${timeSlot.StartTime} - ${timeSlot.EndTime} `;
            option.dataset.limitQuantity = tickets.LimitQuantity;
            option.dataset.price = tickets.Price; // Add this line to set the price in the dataset
            timeslotSelect.appendChild(option);
        });
    // });

    const ticketTypeSelect = document.getElementById('ticket-type');
    ticketTypeSelect.innerHTML = '';
    tickets.forEach(ticket => {
        const option = document.createElement('option');
        option.value = ticket.TicketID;
        option.textContent = `${ticket.TicketType} - $${ticket.Price} (Limit: ${ticket.LimitQuantity})`;
        option.dataset.limitQuantity = ticket.LimitQuantity;
        option.dataset.price = ticket.Price; // Add this line to set the price in the dataset
        ticketTypeSelect.appendChild(option);
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

        async function SubmitForm(event) {
            event.preventDefault();
            const formData = {
                event: document.getElementById('event').value,
                eventDate: document.getElementById('event-date').value,
                ticketType: document.getElementById('ticket-type').value,
                quantity: document.getElementById('quantity').value,
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
            };

            try {
                const response = await fetch('/submit_ticket', {
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