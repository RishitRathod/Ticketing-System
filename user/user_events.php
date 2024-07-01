<head>
    <title>My Events</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <style>
        #bookEvents{
            margin-top: 170px;
        }
        .event-poster {
            max-height: 350px !important;
            object-fit: cover;
            max-width: 90%;
            border-radius:10px !important;
        }
        .event-poster img{
            object-fit: cover;
        }
        .event-title{
            background-color: #1b155d;
            width: 150%;
            color:aliceblue;
            display: block;
            border-top-left-radius: 10px;
        }
        .tagN{
            background-color: #1b155d;
            width: 100%;
            color:aliceblue;
            display: block;
        }
        .tagD{
            border: 2px solid #1b155d;
        }
        .btn{
            color: white !important;
            background-color: #1b155d !important;
        }
        .vd{
            box-shadow: 0px 0px 10px #4739e3 !important;
        }
        @media (max-width: 760px) {
            *{
                font-size: 97%;
            }
            .col-6{
                padding: 3px !important;
            }

        }

        /* .carousel{
            display: flex;
            justify-content: center;
            align-items: center;
        } */
        /* .carousel-inner, .carousel-indicators{
            position: absolute;
        } */
    </style>
</head>
<?php
    include 'userdashnav.php';
?>
<body>  
<div class="row mx-2 no-gutters" id="bookEvents"></div>
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
                <div class="carousel-item ${index === 0 ? 'active' : ''}" align="center">
                    <img src="${poster}" class="event-poster m-0" style="height:200px !important;"alt="Event Poster">
                </div>
            `).join('');


            const eventElement = document.createElement('div');
            eventElement.className = 'col-12 col-md-6 col-lg-4 p-0';
            const eventDetail = ` 
            <div class="card rounded-3 m-2">
                <div class="card-body p-3"> 
                    <div class="row">
                        <div class="col-6">
                            <div class="fs-3 event-title mx-0 mb-1 p-2 px-3 m-0"><strong>${event.EventName}</strong> <div class="card-title fs-5 p-0 m-0">${event.EventType}</div></div>
                            <div class="row mx-0 justify-content-between">
                                <div class="col-6 m-0 tagD mx-auto p-0"> <b class="tagN">From</b> ${new Date(event.StartDate).toLocaleDateString('en-GB')}</div>
                                <div class="col-6 m-0 tagD mx-auto p-0"> <b class="tagN">To  </b> ${new Date(event.EndDate).toLocaleDateString('en-GB')}</div>
                            </div>
                            <div class="tagD"><b class="tagN">Address: </b>${event.VenueAddress}</div>
                        </div>
                        <div class="col-6" style="min-height:210px !important; height:fit-content !important;">
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
                        <div class="position-relative mt-2 bottom-0 start-0 end-0" align="center" style="background-color:#00000000 !important;">
                            <button class="btn vd btn-md px-5 rounded-5" data-eventid="${event.EventID}" >View Details</button>
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