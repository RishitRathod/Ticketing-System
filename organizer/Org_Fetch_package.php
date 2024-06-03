<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

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

    </style>

</head>
<body>

<div id="table-Div" class="container mt-5">
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
    <button id="buyButton" class="btn btn-primary">Buy Selected Packages</button>
</div>

<script src="../script.js"></script>
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

</body>
</html>
