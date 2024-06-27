<head>
    <title>My Events</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <style>
        #bookEvents{
            margin-top: 200px;
        }
        .event-poster {
            max-height: 350px !important;
            object-fit: cover;
            max-width: 90%;
            border-radius:20px !important;;
        }
        .event-poster img{
            object-fit: cover;
        }
        .event-title{
            background-color: blue;
        }
    </style>
</head>
<?php
    include 'userdashnav.php';
?>
<body>  
<div class="container-lg" id="bookEvents"></div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    

<script>
    const calluserData= (async ()=>{
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

        const a = document.getElementById("bookEvents");
        a.innerHTML = ``;
        events.forEach(event => {
            const posterIndicators = (event.Posters || []).map((poster, index) => `
                <li data-target="#carousel${event.EventID}" data-slide-to="${index}" class="${index === 0 ? 'active' : ''}"></li>
            `).join('');

            const posterItems = (event.Posters || []).map((poster, index) => `
                <div class="carousel-item ${index === 0 ? 'active' : ''}">
                    <img src="${poster}" class="event-poster m-0" style="height:200px !important;"alt="Event Poster">
                </div>
            `).join('');


            const eventElement = document.createElement('div');
            eventElement.className = 'col-md-7';
            const eventDetail = ` 
            <div class="card rounded-3 m-4">
            <div class="card-body"> 
            <div class="row">
            <div class="col-6">
            <div class="fs-3 m-0">${event.EventName} <div class="card-title fs-5 p-0 m-0">${event.EventType}</div></div>
                        <div class="row mx-2">
                            <div class="col m-0 p-0">    <b>From</b> ${new Date(event.StartDate).toLocaleDateString('en-GB')}</div>
                            <div class="col m-0 p-0"> <b>To  </b> ${new Date(event.EndDate).toLocaleDateString('en-GB')}</div>
                        </div>
                        <div><b>Address: </b>${event.VenueAddress}</div>
                        <div align="center">
                            <button class="btn btn-primary"data-eventid="${event.EventID}">View Details</button>
                        </div>
                    </div>
                    <div class="col-6" style="height:210px !important;">
                        <div id="carousel${event.EventID}" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                ${posterIndicators}
                            </ol>
                            <div class="carousel-inner">
                                ${posterItems}
                            </div>
                            <a class="carousel-control-prev" href="#carousel${event.EventID}" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carousel${event.EventID}" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            `;
            
                eventElement.innerHTML = eventDetail;
                a.appendChild(eventElement);
        });
        
    });
</script>

</body>