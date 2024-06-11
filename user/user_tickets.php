<?php
include 'userdashnav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Purchase Form</title>
    </style>
</head>
<body>  
        <div class="tickets">
        </div>

        
    <script>
   
   async function fetchDetails(UserID) {
    try {
        const response = await fetch('../fetchTicketUsage.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ UserID: UserID, action: 'GetTicketsDataByUserID' }),
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

function getUserID() {
    const cookies = document.cookie.split(';').map(cookie => cookie.trim());
    for (const cookie of cookies) {
        if (cookie.startsWith('id=')) {
            return cookie.split('=')[1];
        }
    }
    return null;
}
// var User = getUserID();
// console.log(User);

async function initialize() {
    let User = getUserID();
    console.log(User);
    const UserID = User;
    if (UserID) {
        await fetchDetails(UserID);
    } else {
        console.error("No event ID provided.");
    }
}

initialize();
</script>
</body>
<?php
include 'user_footer.html';
?>
</html>