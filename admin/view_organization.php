<?php
require_once 'admin_headnav.php';
?>
<head>
    <title>Organization Details</title>
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
    #package-details{
        opacity:0;
    }
    #orgEvents{
        opacity:0;
    }
</style>
</head>



<div class="container mt-2 row justify-content-center">
    <div class="btn-group mx-auto col mb-4">
        <button type="button" id="orgB" class="col themecol btn" onload="showOrg(this)" onclick="showOrg(this)">Organization</button>
        <button type="button" class="col themecol btn" onclick="showEvents(this)">Events</button>
    </div>
</div>
<div id="orgInfo">
    <h2 align="center">Organization Details</h2>
    <div id="organization-details"></div>
    <!-- <div class="alert alert-warning">
        <strong>warning</strong> <p id="alert"></p>
    </div -->
    <div class="" id="package-details">
    
    <table id="package-table" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Sr. No</th>
                <th>Package Name</th>
                <th>Amount</th>
                <th>Package Type</th>
                <th>Number of Days/Tickets</th>
                <th>BuyDate</th>
            </tr>
        </thead>
        <tbody id="package-table-tbody">
        </tbody>
    </table>

    </div>
</div>

<div class="container" id="orgEvents">
    <h2 align="center" class="mt-3">Events Details</h2>
    <table id="events-table" class="table table-striped table-bordered">
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
    let con1 = true;
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var button = document.getElementById("orgB");
        button.classList.add("active-button");
    });

    function setExpiryDateWarning() {
        const alert = document.getElementById('alert');
        const expiryDate = new Date();
        //set the expiry date to last date of the evey year
        expiryDate.setMonth(11);
        expiryDate.setDate(31);
        expiryDate.setFullYear(expiryDate.getFullYear() - 1);
        alert.innerHTML = 'Your Packages will expire on ' + expiryDate.toLocaleDateString('en-GB')+
         '.you can plan events upto 28-02-2025 with these balance.';
       
    }

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
        if(con1){
            showLoader();
            con1=false;
        }
            hideLoader();
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
                getPackagesData(OrgID);
            }
        } catch (error) {
            console.error('Error fetching org data:', error);
        }
    }

    async function getPackagesData(OrgID) {
    try {
        const response = await fetch('../fetchOrgs.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                OrgID: OrgID,
                action: 'FetchPackagesForOrg'
            }),
        });

        const data = await response.json();
        if (data.error) {
            alert(data.error);
        } else {
            console.log(data.data);
            displayPackagesData(data.data);
        }
    } catch (error) {
        console.error('Error fetching package data:', error);
    }
}


function displayOrgData(orgData) {
    const orgDetailsContainer = document.getElementById('organization-details');
    orgData.forEach(org => {
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
        orgDetailsContainer.innerHTML += orgDetailsHTML;
    });
}

function displayPackagesData(packages) {
    const packageTableBody = document.querySelector('#package-table-tbody');
        packages.forEach((pkg, index) => {
            let row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>${pkg.PackageName}</td>
                    <td>${pkg.Amount}</td>
                    <td>${pkg.PackageType}</td>
                    <td>${pkg.No_of_Days_Or_Tickets}</td>
                    <td>${new Date(pkg.BuyDate).toLocaleDateString('en-GB')}</td>
                </tr>
            `;
            packageTableBody.innerHTML += row;
        });

        $('#package-table')
        .on('draw.dt', function () {
            console.log('Loading');
            // $('.loader').show();
            showLoader();
            // hideLoader();
        })
        .on('init.dt', function () {
            console.log('Loaded');
            // $('.loader').hide();
            hideLoader();
            spawn("#package-details");
        })
        .DataTable({
            responsive: true,
            autoWidth: false,
            destroy: true
        });
    }



    function populateEventTable(data) {
    const eventData = Object.keys(data)
        .filter(key => key !== 'success')
        .map(key => data[key]);

    $('#events-table').DataTable().clear().destroy();

    $('#events-table')
        .on('draw.dt', function () {
            console.log('Loading');
            // $('.loader').show();
            showLoader();
            // hideLoader();
        })
        .on('init.dt', function () {
            console.log('Loaded');
            // $('.loader').hide();
            hideLoader();
            spawn("#orgEvents");
        })
    .DataTable({
        "data": eventData,
        "columns": [
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
        // setExpiryDateWarning();
        console.log(OrgID);
        getOrgData(OrgID);
        getEventDataByOrgID(OrgID);
    });
</script>

<?php include 'admin_footer.php'; ?>
