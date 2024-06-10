<?php
    include 'navhead.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"> -->

    <style>
        /* custom.css */

        /* Customize table header */
        #packageTable thead {
            background-color: #343a40;
            color: #fff;
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
    </style>

</head>
<div class="btnC">
    <button id="btn1"> <i class="fa fa-shopping-cart"></i></button>
    <button id="btn2"> <i class="fa fa-close"></i></button>
</div>
<div class="row currentPack align-items-center px-2" id="currentPack">
    <div class="container d-block">
        <fieldset>
            <legend><h3>Active Packages</h3></legend>
            <table id="SelectedPack" class="table table-responsive table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Package ID</th>
                        <th>Package Name</th>
                        <th>Package Type</th>
                        <th>Package Price</th>
                        <th>Exp. Date</th>
                    </tr>
                </thead>
                <tbody id="selectedPack">
        
                </tbody>
            </table>
        </fieldset>
    </div>
</div>
    <div id="table-Div" class="container buyPack mt-5">
        <fieldset>
        <legend><h3>Available Packages</h3></legend>
            <table id="packageTable" class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Select</th>
                        <th>Package ID</th>
                        <th>Package Name</th>
                        <th>Package Type</th>
                        <th>Package Price</th>
                        <th>Time Duration In Months</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
        
                </tbody>
            </table>
        </fieldset>
        <button id="buyButton" class="btn btn-primary">Buy Selected Packages</button>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="../script.js"></script>
<!-- script for toggle button -->
<script>
        document.addEventListener('DOMContentLoaded', function() {
        var button1 = document.getElementById('btn1');
        var button2 = document.getElementById('btn2');
        var div1 = document.getElementById('currentPack');
        var div2 = document.getElementById('table-Div');

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
    const OrgID =document.cookie.split('; ').find(row => row.startsWith('id')).split('=')[1];


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
            data.forEach(row => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td><input type="checkbox" class="package-checkbox" data-package-id="${row.PackageID}"></td>
                    <td>${row.PackageID}</td>
                    <td>${row.PackageName}</td>
                    <td>${row.PackageType}</td>
                    <td>${row.Amount}</td>
                    <td>${row.TimeDurationInMonths}</td>
                `;
                tableBody.appendChild(tr);
            });
            $('#packageTable').DataTable({
                "pagingType": "full_numbers", // Example of a custom option
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
            document.querySelectorAll(".package-checkbox:checked").forEach(checkbox => {
                selectedPackages.push(checkbox.getAttribute("data-package-id"));
            });

            if (selectedPackages.length > 0) {
                console.log("Selected Packages: ", selectedPackages);
                // You can now send selectedPackages array to your server or handle it as needed.
                alert("Selected Packages: " + selectedPackages.join(", "));
                
                //console.log(OrgID);
                fetch("buy_packages.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        orgid: OrgID,
                        selectedPackages: selectedPackages
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
</script>


<?php
    include 'footer.php';
?>
 