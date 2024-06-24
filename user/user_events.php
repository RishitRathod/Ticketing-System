<?php
    include 'userdashnav.php';
?>
<head>
    <title>My Events</title>
    <style>

    </style>
</head>
<body>  
        <div class="events">
        </div>

<script>


    const calluserData= (async ()=>
                {
                    const response = await fetch('../fetchCheckUser.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ action: 'getUserId' }),
                    });
                    const data = await response.json();
                    console.log(data.data)
                    //UserID = data;
                    return data.data;
                })();

            const UserID= calluserData;
    async function GetbookmarkedEvents(UserID){

        const response = await fetch('../fetchEvents.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ action: 'FetchBookmarkedEvent', UserID: UserID }),
        });
        const data = await response.json();
        console.log(data.data)
        return data.data;
    } 

    document.addEventListener('DOMContentLoaded', async function(){
        const UserID = await calluserData;
        const events = await GetbookmarkedEvents(UserID);
        console.log(events);
    });
</script>

    </body>