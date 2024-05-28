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
                        <label for="PackageName">Package Name:</label>
                        <input type="text" class="form-control" id="PackageName" name="PackageName" required>
                    </div>
                    <!-- <div class="form-group">
                        <input type="hidden" value="action">
                    </div>  -->

                    <div class="form-group">
                        <label for="PackageType">Package Type:</label>
                        <select class="form-control" id="PackageType" name="PackageType" required>
                            <option value="TimeBased">TimeBased</option>
                            <option value="TicketBased">TicketBased</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Amount">Amount:</label>
                        <input type="number" class="form-control" id="Amount" name="Amount">
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" onclick="addPackage()">Add More Package</button>
            <button type="button" class="btn btn-danger" onclick="removePackage()">Remove Last Package</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <div class="crud-table">
            <h2>Packages List</h2>
            <table class="table table-strip" id="packagesTable">
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
                        <label for="PackageName">Package Name:</label>
                        <input type="text" class="form-control" name="PackageName" required>
                    </div>
                    <div class="form-group">
                        <label for="PackageType">Package Type:</label>
                        <select class="form-control" name="PackageType" required>
                            <option value="TimeBased">TimeBased</option>
                            <option value="TicketBased">TicketBased</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Amount">Amount:</label>
                        <input type="number" class="form-control" name="Amount">
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


        //submit the Form data using json format using fetch api and async and await function
        document.getElementById('packageForm').addEventListener('submit', async function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = {};

            formData.forEach((value, key) => {
                if (!data[key]) {
                    data[key] = [];
                }
                data[key].push(value);
            });

            //add action to the data object
            data.action = 'add';
            

            console.log(data);


            console.log(JSON.stringify(data));
        
            const response = await fetch('packages.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });



            const responseData = await response.json();
            if (responseData.status === 'success') {
                alert('Data submitted successfully');
                // Clear the form
                document.getElementById('packageForm').reset();
               
                fetchPackages();
            } else {
                console.log(responseData);
                alert('Data submission failed');
            }
        });
        

        //fetch the data from the database using fetch api and async and await function
        async function fetchPackages() {
            const response = await fetch('packages.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ action: 'fetch' }),
            });

            const responseData = await response.json();
            if (responseData.status === 'success') {
                const packages = responseData.data;
                const packagesTable = document.getElementById('packagesTable').getElementsByTagName('tbody')[0];
                packagesTable.innerHTML = '';
                packages.forEach((package, index) => {
                    const row = packagesTable.insertRow();
                    row.innerHTML = `   
                        <td>${package.PackageID}</td>
                        <td>${package.PackageName}</td>
                        <td>${package.PackageType}</td>
                        <td>${package.Amount}</td>
                        <td>
                        <button class="btn btn-primary" onclick="editPackage(${package.PackageID})">Edit</button>
                        <button class="btn btn-danger" onclick="deletePackage(${package.PackageID})">Delete</button>
                        
                        </td>
                    `;
                });
            } else {
                alert('Failed to fetch packages');
            }
        }

        document.addEventListener('DOMContentLoaded', fetchPackages);


        async function deletePackage(packageID) {
            const response = await fetch('packages.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ action: 'delete', id: packageID }),
            });

            const responseData = await response.json();
            if (responseData.status === 'success') {
                alert('Data deleted successfully');
                fetchPackages();
            } else {
                alert('Failed to delete package');
            }
        }

        async function editPackage(packageID) {
            //change the html form to edit form change submit button to update button
            //populate the form with the data of the package



            const response = await fetch('packages.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ action: 'select', id: packageID }),
            });

            const responseData = await response.json();
            if (responseData.status === 'success') {
                var package = responseData.data;
                console.log(package);
                
                //parse the json data and populate the form with the data
                document.getElementById('PackageName').value = package[0].PackageName;
                document.getElementById('PackageType').value = package[0].PackageType;
                document.getElementById('Amount').value = package[0].Amount;

                
            } else {
                alert('Failed to fetch package');
            }
        }

        





        </script>
</body>
</html>
