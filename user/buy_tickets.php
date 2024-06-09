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
                    <label for="ticket-type">Ticket Type:</label>
                    <select class="form-control" id="ticket-type" name="ticket-type">
                        <option value="general">General Admission</option>
                        <option value="vip">VIP</option>
                        <option value="student">Student</option>
                        <option value="senior">Senior</option>
                        <!-- More types -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="10">
                </div>
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

            <!-- <fieldset class="form-section">
                <legend>Payment Information</legend>
                <div class="form-group">
                    <label for="payment-method">Payment Method:</label>
                    <select class="form-control" id="payment-method" name="payment-method">
                        <option value="credit-card">Credit/Debit Card</option>
                        <option value="paypal">PayPal</option>
                        <option value="bank-transfer">Bank Transfer</option>
                 
                    </select>
                </div>
                <div class="form-group">
                    <label for="card-number">Card Number:</label>
                    <input type="text" class="form-control" id="card-number" name="card-number" required>
                </div>
                <div class="form-group">
                    <label for="expiration-date">Expiration Date:</label>
                    <input type="text" class="form-control" id="expiration-date" name="expiration-date" placeholder="MM/YY" required>
                </div>
                <div class="form-group">
                    <label for="cvv">CVV:</label>
                    <input type="text" class="form-control" id="cvv" name="cvv" required>
                </div>
                <div class="form-group">
                    <label for="billing-address">Billing Address:</label>
                    <input type="text" class="form-control" id="billing-address" name="billing-address" required>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="city">City:</label>
                        <input type="text" class="form-control" id="city" name="city" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="state">State/Province:</label>
                        <select id="state" class="form-control" name="state">
                    
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="postal-code">Postal/ZIP Code:</label>
                        <input type="text" class="form-control" id="postal-code" name="postal-code" required>
                    </div>
                </div>
            </fieldset> -->

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
                } else {
                    console.error('Error:', data.message);
                }
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        async function initialize() {
            const eventID = 106; // Pass the actual eventID here
            await fetchDetails(eventID);
            // Populate events or handle data as needed
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

        initialize();


    </script>
    
</body>
<?php
include 'user_footer.html';
?>
</html>

