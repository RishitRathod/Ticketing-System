<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Form and CRUD Table</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .package-form {
            margin-bottom: 20px;
        }
        .crud-table {
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Add Packages</h2>
        <form id="packageForm" action="" method="POST">
            <div id="packageContainer">
                <div class="package-form">
                    <div class="form-group">
                        <label for="PakageName">Package Name:</label>
                        <input type="text" class="form-control" id="PakageName" name="PakageName[]" required>
                    </div>
                    <div class="form-group">
                        <label for="PakageType">Package Type:</label>
                        <select class="form-control" id="PakageType" name="PakageType[]" required>
                            <option value="TimeBased">TimeBased</option>
                            <option value="TicketBased">TicketBased</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Amount">Amount:</label>
                        <input type="number" class="form-control" id="Amount" name="Amount[]">
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" onclick="addPackage()">Add More Package</button>
            <button type="button" class="btn btn-danger" onclick="removePackage()">Remove Last Package</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <div class="crud-table">
            <h2>Packages List</h2>
            <table class="table table-bordered" id="packagesTable">
                <thead>
                    <tr>
                        <th>Package ID</th>
                        <th>Package Name</th>
                        <th>Package Type</th>
                        <th>Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Table rows will be populated here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function addPackage() {
            const packageForm = `
                <div class="package-form">
                    <div class="form-group">
                        <label for="PakageName">Package Name:</label>
                        <input type="text" class="form-control" name="PakageName[]" required>
                    </div>
                    <div class="form-group">
                        <label for="PakageType">Package Type:</label>
                        <select class="form-control" name="PakageType[]" required>
                            <option value="TimeBased">TimeBased</option>
                            <option value="TicketBased">TicketBased</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Amount">Amount:</label>
                        <input type="number" class="form-control" name="Amount[]">
                    </div>
                </div>
            `;
            document.getElementById('packageContainer').insertAdjacentHTML('beforeend', packageForm);
        }

        function removePackage() {
            const packageForms = document.getElementsByClassName('package-form');
            if (packageForms.length > 1) {
                packageForms[packageForms.length - 1].remove();
            } else {
                alert('At least one package is required.');
            }
        }

        //send data through fetch API using Async and await i want to do all curd operation in this way use action to differentiate between them 

        async function fetchPackages() {
            const response = await fetch('packages.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({

                    action: 'fetch'
                }),
            });
            const data = await response.json();
            if (data.status === 'success') {
                const packages = data.data;
                const packagesTable = document.getElementById('packagesTable').getElementsByTagName('tbody')[0];
                packagesTable.innerHTML = '';
                packages.forEach((package) => {
                    const row = packagesTable.insertRow();
                    row.innerHTML = `
                        <td>${package.PackageID}</td>
                        <td>${package.PakageName}</td>
                        <td>${package.PakageType}</td>
                        <td>${package.Amount}</td>
                        <td>
                            <button class="btn btn-warning">Edit</button>
                            <button class="btn btn-danger">Delete</button>
                        </td>
                    `;
                });
            } else {
                alert(data.message);
            }
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            fetchPackages();
        });
// Prevent form from resetting on submit
async function add_package(event) {
    event.preventDefault(); // Prevent default form submission
    // Get all package forms
    const packageForms = document.querySelectorAll('.package-form');
    const packagesData = [];
    // Loop through each package form
    packageForms.forEach((form) => {
        const formData = new FormData(form);
        const data = {};
        formData.forEach(function(value, key) {
            data[key] = value;
        });
        packagesData.push(data);
    });
    // Add common fields for all packages
    packagesData.forEach((package) => {
        package['tablename'] = 'packages';
        package['action'] = 'add';
    });

    // Send packages data to the server
    const response = await fetch('packages.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(packagesData),
    });
    const responseData = await response.json();
    if (responseData.status === 'success') {
        alert(responseData.message);
        fetchPackages();
    } else {
        alert(responseData.message);
    }
}

// Fetch package details for edit
async function fetchPackageDetails(packageId) {
    const response = await fetch('packages.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'fetch',
            PackageID: packageId
        }),
    });
    const data = await response.json();
    if (data.status === 'success') {
        console.log('Package details:', data.data); // Log package details for debugging
        // Populate form fields with package details for editing
    } else {
        alert(data.message);
    }
}

// Edit/Update package
async function updatePackage(event) {
    event.preventDefault(); // Prevent default form submission
    const form = document.getElementById('packageForm');
    const formData = new FormData(form);
    const data = {};
    formData.forEach(function(value, key) {
        data[key] = value;
    });
    data['tablename'] = 'packages';
    data['action'] = 'update';
    const response = await fetch('packages.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    });
    const responseData = await response.json();
    if (responseData.status === 'success') {
        alert(responseData.message);
        fetchPackages();
    } else {
        alert(responseData.message);
    }
}

// Delete package
async function deletePackage(packageId) {
    const response = await fetch('packages.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'delete',
            PackageID: packageId
        }),
    });
    const data = await response.json();
    if (data.status === 'success') {
        alert(data.message);
        fetchPackages();
    } else {
        alert(data.message);
    }
}

// Event listeners
document.getElementById('packageForm').addEventListener('submit', add_package);
document.getElementById('packagesTable').addEventListener('click', function(event) {
    const target = event.target;
    if (target.tagName === 'BUTTON') {
        const packageId = target.closest('tr').cells[0].textContent;
        if (target.classList.contains('btn-warning')) {
            // Edit button clicked
            fetchPackageDetails(packageId);
        } else if (target.classList.contains('btn-danger')) {
            // Delete button clicked
            deletePackage(packageId);
        }
    }
});
        
        </script>
</body>
</html>
