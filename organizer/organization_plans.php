<?php
    include 'navhead.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Packages</title>
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"> -->

    <style>
        /* custom.css */

        /* Customize table header */
        thead {
            background-color: #0d004d;
            color: #fff;
            padding: 2px;
        }

        /* Customize table rows */
        #packageTable tbody tr {
            transition: background-color 0.2s;
        }

        #packageTable tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Customize pagination buttons */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5rem 1rem;
            margin: 0 0.1rem;
            border-radius: 0.25rem;
            border: 1px solid #dee2e6;
            background: #f8f9fa;
            color: #343a40;
            transition: background-color 0.2s, color 0.2s;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #343a40;
            color: #fff;
        }

        /* Customize selected pagination button */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #007bff;
            color: #fff;
            border: 1px solid #007bff;
        }

        /* Customize the search box */
        .dataTables_wrapper .dataTables_filter input {
            margin-left: 0.5em;
            border-radius: 0.25rem;
            padding: 0.5rem;
            border: 1px solid #ced4da;
            background: #f8f9fa;
        }

        /* Customize the length select box */
        .dataTables_wrapper .dataTables_length select {
            margin-left: 0.5em;
            border-radius: 0.25rem;
            padding: 0.5rem;
            border: 1px solid #ced4da;
            background: #f8f9fa;
        }
        .currentPack{
            display:block;
        }
        #table-Div{
            display:none;
        }
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden; /* Hide horizontal scrollbar */
        }

        .container {
            /* Add some content height */
            height: 70vh;
        }

        .btnC {
            position: fixed;
            bottom: 30px; /* Adjust as needed */
            right: 30px; /* Adjust as needed */
            padding: 10px;
            background-color: #007bff; /* Example background color */
            color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Optional: Add shadow for better visibility */
            z-index: 999; /* Ensure it's above other content */
        }
        #btn1{
            display:block;
            background: none;
            border:none;
        }
        #btn2{
            display:none;
            border:none;
            background: none;

        }
        .loader {
            display: block; 
            width: 50px;
            height: 50px;
            position: fixed;
            left: 50%;
            right: 50%;
            top: 50%;
            border: 8px solid #f9f9f9;
            border-top: 10px solid #010575;
            border-radius: 50px;
            /* transform: translate(-50%, -50%); */
            z-index: 999;
            animation: spin 0.5s linear infinite;
        }

        #currentPack{
            opacity:0;
        }
        #table-Div{
            opacity:0;
        }
        #buyButton{
            bottom:12%;
        }
        /* #table-Div #buyButton{
            position: fixed;
            right: 0%;
        } */
    </style>

</head>
<div class="loader">
        <i class="fa fa-3x fa-fw"></i><span class="sr-only">Loading...</span>
    </div>
<div class="d-flex flex-column">
    <div class="alert alert-warning">
            <strong>warning</strong> <p id="alert"></p>
        </div>
    <div id="Balance"></div>
    <div class="btnC">
        
        <button id="btn1"> <i class="fa fa-shopping-cart"></i></button>
        <button id="btn2"> <i class="fa fa-close"></i></button>
    </div>
    <div class="row overflow-auto currentPack align-items-center px-2" id="currentPack">
        <div class="container d-block">
            <fieldset>
                <legend><h3>Active Packages</h3></legend>
                <table id="SelectedPack" class="table table-striped table-bordered">
                    <thead class="">
                        <tr>
                            <th>Sr No.</th>
                            <th>Package Name</th>
                            <th>Package Type</th>
                            <th>Amount of Tickets or Days</th> 
                            <th>Price</th>  
                            <th>Buy Date</th> 
                        </tr>
                    </thead>
                    <tbody id="selectedPack">
            
                    </tbody>
                </table>
            </fieldset>
        </div>
    </div>
    <div id="table-Div" class="container row buyPack overflow-auto">
        <fieldset>
        <legend><h3>Available Packages</h3></legend>
            <table id="packageTable" class="table table-striped table-bordered">
                <thead class="">
                    <tr>
                        <th>Select</th>
                        <th>Sr. No</th>
                        <th>Package Name</th>
                        <th>Package Type</th>
                        <th>Amount Of Days/Tickets</th>
                        <th>Amount</th>
                       
                    </tr>
                </thead>
                <tbody id="tableBody">
        
                </tbody>
            </table>
        </fieldset>
        <div class="row justify-content-center">
            <button id="buyButton"  class="btn col-2 btn-primary position-fixed \my-3 ">Buy Selected Packages</button>
        </div>
    </div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="../script.js"></script>
<!-- script for toggle button -->
<script>
     const expiryDate = new Date();
        //set the expiry date to last date of the evey year
        expiryDate.setMonth(11);
        expiryDate.setDate(31);
        expiryDate.setFullYear(expiryDate.getFullYear() - 1);
    function  setBalance(data){
        let balanceDiv=document.getElementById('Balance');
        let balanceHTML=`
            <div class="row justify-content-evenly">
                <div class="col-5">
                    <h3>Balance</h3>
                    <div class="fs-6">Amount of Days: ${data.Amount_of_Days}</div>
                    <div class="fs-6">Amount of Tickets: ${data.Amount_of_Tickets}</div>
                </div>
                <div class="col-5">
                    <h1>Expiry Date</h1>
                    <div class="fs-4">${ expiryDate.toLocaleDateString('en-GB')}</div>
                </div>
            </div>  
        `;
        balanceDiv.innerHTML=balanceHTML;
    }
      function setExpiryDateWarning() {
        const alert = document.getElementById('alert');
        // const expiryDate = new Date();
        // //set the expiry date to last date of the evey year
        // expiryDate.setMonth(11);
        // expiryDate.setDate(31);
        // expiryDate.setFullYear(expiryDate.getFullYear() - 1);
        alert.innerHTML = 'Your Packages will expire on ' + expiryDate.toLocaleDateString('en-GB')+
         '. Please Use you all the balance till than or plan events in advance before 2 month.';
       
    }
        document.addEventListener('DOMContentLoaded', function() {
        var button1 = document.getElementById('btn1');
        var button2 = document.getElementById('btn2');
        var div1 = document.getElementById('currentPack');
        var div2 = document.getElementById('table-Div');
        setExpiryDateWarning();
        button1.addEventListener('click', function() {
            button1.style.display = 'none';
            button2.style.display = 'block';
            div1.style.display = 'none';
            div2.style.display = 'block';
        });

        button2.addEventListener('click', function() {
            button2.style.display = 'none';
            button1.style.display = 'block';
            div1.style.display = 'block';
            div2.style.display = 'none';
        });
        });

        //for exp date
                function daysToTimestamp(days) {
                    // Convert days to milliseconds
                    let milliseconds = days * 24 * 60 * 60 * 1000;
                    
                    // Create a new Date object with the calculated milliseconds
                    let date = new Date(milliseconds);
                    
                    // Return the timestamp
                    return date.getTime();
                }

                function dateToTimestamp(date) {
                    // Create a new Date object from the provided date string
                    var dateObject = new Date(date);
                
                    // Return the timestamp in milliseconds
                    return dateObject.getTime();
                }


                function addDays(date, days) {
                    // var result = new Date(date);
                    // // days = daysToTimestamp(days);
                    // result.setDate(result.getDate() + days);
                    // return result.toISOString().split('T')[0]; 
                    return timestampToDate(dateToTimestamp(date)+daysToTimestamp(days))

                }

                function timestampToDate(timestamp) {
                    // Create a new Date object using the provided timestamp
                    var dateObject = new Date(timestamp);
                
                    // Extract the date components
                    var year = dateObject.getFullYear();
                    var month = ("0" + (dateObject.getMonth() + 1)).slice(-2); // Months are zero-indexed, so we add 1
                    var day = ("0" + dateObject.getDate()).slice(-2);
                    
                    // Return the date in the format "YYYY-MM-DD"
                    return year + "-" + month + "-" + day;
                }

</script>
<script>


    //get id from cookie
    const OrgID =document.cookie.split('; ').find(row => row.split('=')[0] === 'id').split('=')[1];
    console.log(OrgID);
    console.log(OrgID);
    
    document.addEventListener("DOMContentLoaded", function() {
        fetch("../fetchOrgs.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                action: "GetOrgAnnualPlanDetail",
                OrgID: OrgID
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.status === "success") {
                const annualPlan = data.data;
                console.info("annualPlan",annualPlan);
                setBalance(annualPlan);
            } else {
                alert("Failed to fetch annual plan details");
            }
        });
    
    });

    async function FetchOrgPackages(OrgID){
        const response = await fetch("../fetchOrgs.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                action: "FetchOrgPackages",
                OrgID: OrgID
            })
        });
        const data = await response.json();
        console.log("My Packages ",data);
        if (data.status === "success") {
            const selectedPack = document.querySelector("#selectedPack");
            data.data.forEach((row, index) => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${row.PackageName}</td>
                    <td>${row.PackageType}</td>
                    <td>${row.No_of_Days_Or_Tickets}</td>
                    <td>${row.Amount}</td>
                    <td>${new Date(row.BuyDate).toLocaleDateString('en-GB')}</td>
                `;
                selectedPack.appendChild(tr);
            });
            $('#SelectedPack')
            .on('draw.dt', function () {
                console.log('Loading');
                // $('.loader').show();
                showLoader();
                hideLoader();

            })
            .on('init.dt', function () {
                console.log('Loaded');
                // $('.loader').hide();
                hideLoader();
                spawn("#currentPack");

            })
            .DataTable({
                aLengthMenu: [
        [25, 50, 100, 200, -1],
        [25, 50, 100, 200, "All"]
    ],
                "pagingType": "full_numbers",
                "language": {
                    "paginate": {
                        "first": "<<",
                        "last": ">>",
                        "next": ">",
                        "previous": "<"
                    }
                }
            });
        } else {
            alert("You don't have any packages. Please buy it.");
        }
    }

        
    document.addEventListener("DOMContentLoaded", function() {

        if (isUserLoggedIn() === false) {
            window.location.href = "organization_login.html";
            if (getUserRole() === 'organization' || getUserRole() === null) {
                alert("You are not authorized to view this page. Please login as an organization");
                window.location.href = "organization_login.html";
            }
        }

        fetch("get_Packages.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            const tableBody = document.querySelector("#tableBody");
            data = data.data;
            
            FetchOrgPackages(OrgID);
            data.forEach((row,index) => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td><input type="checkbox" class="package-checkbox" data-package-id="${row.PackageID}" data-package-type="${row.PackageType}"></td>
                    <td>${row.PackageID}</td>
                    <td>${row.PackageName}</td>
                    <td>${row.PackageType}</td>
                    <td>${row.No_of_Days_Or_Tickets}</td>
                    <!-- <td>${addDays(new Date(),row.Exp_date)}</td> -->
                    <td>${row.Amount}</td>

                `;
                tableBody.appendChild(tr);
            });
            $('#packageTable')
                .on('draw.dt', function () {
                console.log('Loading');
                // $('.loader').show();
                showLoader();
                hideLoader();

            })
            .on('init.dt', function () {
                console.log('Loaded');
                // $('.loader').hide();
                hideLoader();
                spawn("#table-Div");

            })
            .DataTable({
                aLengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100,"All"]
    ],
                    "pagingType": "full_numbers", // Example of a custom option
                    "columnDefs": [
                        {
                            "targets": 0, // Disable functionality for the 4th column (index 3)
                            // "targets": nonSortableColumnIndex,
                            "orderable": false, // Disable sorting
                        }
                    ],
                    "language": {
                        "paginate": {
                            "first": "<<",
                            "last": ">>",
                            "next": ">",
                            "previous": "<"
                        }
                    }
                });
            });

        document.querySelector("#buyButton").addEventListener("click", function() {
    const selectedPackages = [];
    const totalDaysTickets = []; // Variable to store the total number of days/tickets
    const packageType=[];
    document.querySelectorAll(".package-checkbox:checked").forEach(checkbox => {
        const packageId = checkbox.getAttribute("data-package-id");
        selectedPackages.push(packageId);
        
        // Get the number of days/tickets for the current package and add it to the total
        const daysTickets = parseInt(checkbox.closest("tr").querySelector("td:nth-child(5)").textContent);
        totalDaysTickets.push(daysTickets);
        const type = checkbox.getAttribute("data-package-type");
        packageType.push(type);
    });

    if (selectedPackages.length > 0) {
        console.log("Selected Packages: ", selectedPackages);
        console.log("Total Days/Tickets: ", totalDaysTickets); // Log the total days/tickets
        console.log("Package Type: ", packageType);

        // You can now send selectedPackages array along with totalDaysTickets to your server or handle it as needed.
        alert("Selected Packages: " + selectedPackages.join(", ") + "\nTotal Days/Tickets: " + totalDaysTickets+"\nPackage Type: "+packageType);
        
        // Send selectedPackages array and totalDaysTickets to the server
        fetch("buy_packages.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                orgid: OrgID,
                selectedPackages: selectedPackages,
                totalDaysTickets: totalDaysTickets, // Include totalDaysTickets in the request
                packageType: packageType
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.success) {
                alert("Packages bought successfully");
                location.reload();
            } else {
                alert("Failed to buy packages");
            }
        });
        
    } else {
        alert("Please select at least one package to buy.");
    }
});

    });
    function isUserLoggedIn() {
                    const cookies = document.cookie.split(';').map(cookie => cookie.trim());
                    for (const cookie of cookies) {
                        if (cookie.startsWith('role=')) {
                            console.log("User is logged in");
                            return true;
                        }
                    }
                    console.log("User is not logged in");
                    return false;
            }
            window.onload = function() {
                    if (!isUserLoggedIn()) {
                //    document.getElementById('login').style.display = 'none';
                //    document.getElementById('profile').style.display = 'block';
                } else {
                   window.herf = "./organization_login.html";
                }
            }

</script>


<?php
    include 'footer.php';
?>
 