<?php
require_once 'admin_headnav.php';
?>

<div class="container mt-5">
    <h1>Organization Details</h1>
    <div id="organization-details"></div>
</div>

<div class="container mt-5">
    <h1>Organization Details</h1>
    <div id="organization-details"></div>
    <h2 class="mt-5">Events</h2>
    <table id="events-table" class="display">
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
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">${org.OrganizationName}</h5>
                        <p class="card-text"><strong>Email:</strong> ${org.OrganizationEmail}</p>
                        <p class="card-text"><strong>Contact Name:</strong> ${org.OrganizationContactName}</p>
                        <p class="card-text"><strong>Contact Number:</strong> ${org.OrganizationContactNumber}</p>
                        <p class="card-text"><strong>Status:</strong> ${org.OrganizationStatus}</p>
                        <h6 class="card-subtitle mb-2 text-muted">Packages:</h6>
                        <div class="list-group">`;

            packages.forEach(pkg => {
                orgDetailsHTML += `
                    <div class="list-group-item">
                        <h6 class="mb-1">${pkg.PackageName}</h6>
                        <p class="mb-1"><strong>Amount:</strong> ${pkg.Amount}</p>
                        <p class="mb-1"><strong>Type:</strong> ${pkg.PackageType}</p>
                        <p class="mb-1"><strong>Buy Date:</strong> ${pkg.BuyDate}</p>
                    </div>`;
            });

            orgDetailsHTML += `
                        </div>
                    </div>
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
                    return `<a  onclick="GoToEvent(${row.EventID})" class="btn btn-primary">View</a>`;
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
