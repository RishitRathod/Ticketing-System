<?php
require_once 'admin_headnav.php';
?>
<style>
    .btn-group .btn {
        border: 1px solid #8341fe;
    }
    .btn-group .btn:hover {
        background-color: #8341fe;
        color: #fff;
    }
    thead {
        background-color: #8341fe;
        color: #fff;
        padding: 2px;
    }
    .btn:active {
        background-color: #8341fe;
        color: #fff;
    }
    #orgInfo {
        display: block;
    }
    #orgEvents {
        display: none;
    }
    .pac {
        max-width: 20vmax;
    }

</style>

<div class="container mt-2 row justify-content-center">
    <div class="btn-group mx-auto col mb-4">
        <button type="button" class="col themecol btn" onclick="showOrg(this)">Organization</button>
        <button type="button" class="col themecol btn" onclick="showEvents(this)">Events</button>
        
    </div>
</div>
<div id="orgInfo">
    <h2 align="center">Organization Details</h2>
    <div id="organization-details"></div>
</div>

<div class="container" id="orgEvents">
    <h2 align="center" class="mt-3">Events Details</h2>
    <table id="events-table" class="table-striped">
        <thead>
            <tr>
                <th>Sr. No</th>
                <th>EventName</th>
                <!-- <th>Description</th> -->
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
    <input type="hidden" id="EventID" name="EventID" value="">
</form>

<script>
    function updateButtonStyles(clickedButton) {
            const buttons = document.querySelectorAll('.btn.themecol');
            buttons.forEach(button => {
                button.classList.remove('active-button');
            });
            clickedButton.classList.add('active-button');
    }
    function showOrg(button) {
        document.getElementById("orgInfo").style.display = "block";
        document.getElementById("orgEvents").style.display = "none";
        updateButtonStyles(button);
    }

    function showEvents(button) {
        document.getElementById("orgInfo").style.display = "none";
        document.getElementById("orgEvents").style.display = "block";
        updateButtonStyles(button);
    }

    const OrgID = parseInt(<?php echo $_POST['OrgID']; ?>);
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
            if (data.success === false) {
                alert(data.error);
            } else {
                console.log('Full event data response:', data);
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
            console.log('Raw Packages JSON:', org.Packages);

            let sanitizedPackages = org.Packages.replace(/(\d+\.\d+|")(\w+)(:)/g, '$1"$2"$3');
            let packages;
            try {
                packages = JSON.parse(`[${sanitizedPackages}]`);
            } catch (error) {
                console.error('Error parsing Packages JSON:', error);
                alert('Error parsing Packages data. Please check the console for more details.');
                return;
            }

            let orgDetailsHTML = `
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">${org.OrganizationName}</h3>
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
            <div class="row g-0">
                <h5 class="mt-3"><li>Packages:</li></h5>
            `;

            function addDays(date, days) {
                const result = new Date(date);
                result.setDate(result.getDate() + days);
                return result.toISOString().split('T')[0];
            }

            packages.forEach(pkg => {
                orgDetailsHTML += `
                <div class="list-group col-sm-4 col-auto">
                    <div class="list-group-item card pac g-0">
                        <h6 class="mb-1">${pkg.PackageName}</h6>
                        <div class="mb-1"><strong>Amount:</strong> ${pkg.Amount}</div>
                        <div class="mb-1"><strong>Type:</strong> ${pkg.PackageType}</div>
                        <div class="mb-1"><strong>Buy Date:</strong> ${new Date(pkg.BuyDate).toLocaleDateString('en-GB')}</div>
                        <div class="mb-1"><strong>Expire Date:</strong> ${pkg.PackageType === 'TimeBased' ? addDays(pkg.BuyDate, pkg.Amount_of_Days) : new Date(pkg.Expiry_date).toLocaleDateString('en-GB')}</div>
                    </div>
                </div>
                `;
            });

            orgDetailsHTML += `       
            </div>`;
            orgDetailsContainer.innerHTML += orgDetailsHTML;
        });
    }

    function populateEventTable(data) {
    const eventData = Object.keys(data)
        .filter(key => key !== 'success')
        .map(key => data[key]);

    $('#events-table').DataTable().clear().destroy();

    $('#events-table').DataTable({
        data: eventData,
        columns: [
            { 
                data: null,
                render: function(data, type, row, meta) {
                    return meta.row + 1; // Serial number based on row index
                }
            },
            { data: 'EventName' },
            { 
                data: 'StartDate',
                render: function(data, type, row) {
                    return new Date(data).toLocaleDateString('en-GB');
                }
            },
            { 
                data: 'EndDate',
                render: function(data, type, row) {
                    return new Date(data).toLocaleDateString('en-GB');
                }
            },
            { data: 'VenueAddress' },
            {
                data: null,
                render: function(data, type, row) {
                    return `<a onclick="GoToEvent(${row.EventID})" class="btn btn-outline-primary inf p-2"></a>`;
                }
            }
        ],
        "columnDefs": [
            {
                "targets": 5, // Disable functionality for the 6th column (index 5)
                "orderable": false, // Disable sorting
            }
        ]
    });
}

    function GoToEvent(EventID) {
        console.log('Event clicked');
        console.log('EventID:', EventID);
        const form = document.getElementById('GoToEvent');
        document.getElementById('EventID').value = EventID;
        form.submit();
    }

    $(document).ready(function() {
        console.log(OrgID);
        getOrgData(OrgID);
        getEventDataByOrgID(OrgID);
    });
</script>

<?php include 'admin_footer.php'; ?>
