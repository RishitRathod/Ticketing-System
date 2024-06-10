<?php
require_once 'admin_headnav.php';
?>
<style>
    .btn-group .btn{
        border: 1px solid #8341fe;
    }
    .btn-group .btn:hover{
        background-color: #8341fe;
        color: #fff;
    }
    thead{
        background-color: #8341fe;
        color: #fff;
        padding: 2px;

    }
    .btn:active{
        background-color: #8341fe;
        color: #fff;

    }
    #orgInfo{
        display: block;
    }
    #orgEvents{
        display:none;
    }
    .pac{
        max-width: 20vmax;
    }
</style>
<div class="container mt-2 row justify-content-center">
    <div class="btn-group mx-auto col mb-4">
        <button type="button" class="col btn" onclick="showOrg()"> Organization </button>
        <button type="button" class="col btn" onclick="showEvents()"> Events </button>
    </div>
</div>
<div id="orgInfo">
    <h2 align="center">Organization Details</h2>
    <div id="organization-details"></div>
</div>

<div class="container" id="orgEvents">
    <!-- <div id="organization-details"></div> -->
    <h2 align="center" class="mt-3">Events Details</h2>
    <table id="events-table" class="display table-striped">
        <thead>
            <tr>
                <th>EventID</th>
                <th>EventName</th>
                <th>Description</th>
                <th>StartDate</th>
                <th>EndDate</th>
                <th>Venue</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<form id="GoToEvent" action="./view_event.php" method="POST">
    <input type="hidden" id="EventID" name ="EventID" value="">
</form>

<script>
    function showOrg(){
        var a = document.getElementById("orgInfo");
        var b = document.getElementById("orgEvents");
        a.style.display="block";
        b.style.display="none";
    }
    function showEvents(){
        var a = document.getElementById("orgInfo");
        var b = document.getElementById("orgEvents");
        a.style.display= "none";
        b.style.display="block";
    }
</script>
<script>
    var OrgID = <?php echo ($_POST['OrgID']); ?>;
    OrgID = parseInt(OrgID);
    console.log(OrgID);

    async function getEventDataByOrgID(OrgID) {
        try {
            const response = await fetch('../fetchEvents.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    OrgID: OrgID,
                    action: 'FetchAllEventsByOrgID'
                }),
            });

            const data = await response.json();
            if (data.success===false) {
                alert(data.error);
            } else {
                console.log('Full event data response:', data);  // Log the full response

                populateEventTable(data);
            }
        } catch (error) {
            console.error('Error fetching event data:', error);
        }
    }

    async function getOrgData(OrgID) {
        try {
            const response = await fetch('../fetchOrgs.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    OrgID: OrgID,
                    action: 'FetchOrgDetails'
                }),
            });

            const data = await response.json();
            if (data.error) {
                alert(data.error);
            } else {
                console.log(data);
                console.log(data.data);
                displayOrgData(data.data);
            }
        } catch (error) {
            console.error('Error fetching organization data:', error);
        }
    }

    function displayOrgData(orgData) {
        const orgDetailsContainer = document.getElementById('organization-details');
        orgData.forEach(org => {
            const packages = JSON.parse("[" + org.Packages + "]");

            let orgDetailsHTML = `
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title ">${org.OrganizationName}</h3>
                    <div class="row">
                        <div class="col">
                            <div class="card-text"><strong>Email:</strong> ${org.OrganizationEmail}</div>
                            <div class="card-text"><strong>Status:</strong> ${org.OrganizationStatus}</div>
                            </div>
                        <div class="col">
                            <div class="card-text"><strong>Contact Name:</strong> ${org.OrganizationContactName}</div>
                            <div class="card-text"><strong>Contact Number:</strong> ${org.OrganizationContactNumber}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="list-group mt-3 d-sm-inlines">
                <h5 class="card-subtitle d-sm-inline"><li>Packages:</li></h5>`;
            

            function addDays(date, days) {
                var result = new Date(date);
                result.setDate(result.getDate() + days);
                return result;
            }


            packages.forEach(pkg => {
                orgDetailsHTML += `
                    <div class="list-group-item pac card">
                        <h6 class="mb-1">${pkg.PackageName}</h6>
                        <p class="mb-1"><strong>Amount:</strong> ${pkg.Amount}</p>
                        <p class="mb-1"><strong>Type:</strong> ${pkg.PackageType}</p>
                        <p class="mb-1"><strong>Buy Date:</strong> ${pkg.BuyDate}</p>  ${pkg.Days}
                        <p class="mb-1"><strong>Expire Date:</strong> `+ addDays(pkg.BuyDate,pkg.Days)+`</p>
                    </div>`;
            });
            
            orgDetailsHTML += `       
                </div>`;

            orgDetailsContainer.innerHTML += orgDetailsHTML;
        });
    }

    function populateEventTable(data) {
        // Convert data object to array
        const eventData = Object.keys(data)
            .filter(key => key !== 'success')  // Exclude 'success' key
            .map(key => data[key]);

        // Clear existing data
        $('#events-table').DataTable().clear().destroy();

        // Initialize DataTable with the event data array
        $('#events-table').DataTable({
            data: eventData,
            columns: [
                { data: 'EventID' },
                { data: 'EventName' },
                { data: 'Description' },
                { data: 'StartDate' },
                { data: 'EndDate' },
                { data: 'VenueAddress' },
                {data :null, render: function(data, type, row){
                    return `<a  onclick="GoToEvent(${row.EventID})" class="btn btn-outline-primary inf p-2"></a>`;
                }}
            ]
        });
    }

    function GoToEvent(EventID ){
        console.log('Event clicked');
        console.log('EventID:',EventID);
        const form=document.getElementById('GoToEvent');
        document.getElementById('EventID').value=EventID;
        form.submit();
    }

    $(document).ready(function() {
        console.log(OrgID);
        getOrgData(OrgID);
        getEventDataByOrgID(OrgID);
    });

</script>

<?php include 'admin_footer.php'; ?>
