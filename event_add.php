<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Form</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2>Event Form</h2>
        </div>
        <div class="card-body">
        <form id="addeventform" method="post" enctype="multipart/form-data">
                <!-- <div class="form-group">
                    <label for="eventID">Event ID</label>
                    <input type="text" class="form-control" id="eventID" name="eventID">
                </div> -->

                <div class="form-group">
                    <label for="orgID">Org ID</label>
                    <input type="text" class="form-control" id="orgID" name="orgID">
                </div>

                <div class="form-group">
                    <label for="eventName">Event Name</label>
                    <input type="text" class="form-control" id="eventName" name="eventName">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="startDate">Start Date</label>
                    <input type="date" class="form-control" id="startDate" name="startDate">
                </div>

                <div class="form-group">
                    <label for="endDate">End Date</label>
                    <input type="date" class="form-control" id="endDate" name="endDate">
                </div>

                <div class="form-group">
                    <label for="capacity">Capacity</label>
                    <input type="number" class="form-control" id="capacity" name="capacity">
                </div>

                <div class="form-group">
                    <label for="pakageID">Package ID</label>
                    <input type="text" class="form-control" id="pakageID" name="pakageID">
                </div>

                <div class="form-group">
                    <label for="eventType">Event Type</label>
                    <select class="form-control" id="eventType" name="eventType">
                        <option value="1">Type 1</option>
                        <option value="2">Type 2</option>
                        <option value="3">Type 3</option>
                        <option value="4">Type 4</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="eventPoster">Event Poster</label>
                    <input type="file" class="form-control-file" id="eventPoster" name="eventPoster">
                </div>

                <div class="form-group">
                    <label for="qrCode">QR Code</label>
                    <input type="text" class="form-control" id="qrCode" name="qrCode">
                </div>

                <div class="form-group">
                    <label for="venueAddress">Venue/Address of Event</label>
                    <input type="text" class="form-control" id="venueAddress" name="venueAddress">
                </div>

                <div class="form-group">
                    <label for="venueDropdown">Venue Cascaded Dropdown</label>
                    <select class="form-control" id="venueDropdown" name="venueDropdown">
                        <!-- Options for state and city addresses would be populated here -->
                    </select>
                </div>

                <button type="button" class="btn btn-primary" id="submitForm">Submit</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  $(document).ready(function() {
        $('#submitForm').click(function(event) {
            event.preventDefault(); // Prevent default form submission behavior

            var formData = new FormData($('#addeventform')[0]);

            $.ajax({
                url: 'event_addb.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    alert('Data inserted successfully');
                    // Optionally, you can reset the form after successful submission
                    $('#addeventform')[0].reset();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('Error occurred while submitting the form');
                }
            });
        });
    });

</script>
</body>
</html>
