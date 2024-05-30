<?php
    include 'admin_headnav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Form and CRUD Table</title>
    <!-- Bootstrap CSS -->
    <style>
        .package-form {
            margin-bottom: 20px;
        }
        .crud-table {
            margin-top: 40px;
        }
        #updatebtn {
            display: none;
        }
        #abortUdpatebtn{
            display: none;
        }
    </style>
</head>
<body>
    <div class="container mt-5 ">
        <h2>Add Packages</h2>
        <form id="packageForm" action="" method="POST">
            <div id="packageContainer">
                <hr>
                <div class="row package-form w-50 mx-auto">
                    <div class="form-group">
                        <label for="PackageName">Package Name:</label>
                        <input type="text" class="form-control" id="PackageName" name="PackageName" required>
                    </div>
                    
                    <div class="row form-group justify-content-evenly">
                        <div class="col-auto">
                            <label for="PackageType">Package Type:</label>
                            <select class="form-control" id="PackageType" name="PackageType" required>
                                <option value="TimeBased">TimeBased</option>
                                <option value="TicketBased">TicketBased</option>
                            </select>
                            </div>
                        <div class="col-auto">
                            <label for="Amount">Amount:</label>
                            <input type="number" class="form-control" id="Amount" name="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="packageIDInput">
                    </div>
                </div>
            </div>
            <div id="button-div"  class="row justify-content-evenly">
            <button type="button" class="btn btn-primary col m-sm-2 m-0 " onclick="addPackage()">Add More Package</button>
            <button type="button" class="btn btn-danger col m-sm-2 m-0" onclick="removePackage()">Remove Last Package</button>
            <button type="submit" id="submitbtn" class="btn btn-success col m-sm-2 m-0">Submit</button>
            <button type="button" id="abortUdpatebtn" class="btn btn-warning col m-sm-2 m-0">Abort Update</button>
            <button type="button" id="updatebtn" class="btn btn-primary col m-sm-2 m-0" onclick="updatePackage()">Update</button>
            </div>
        </form>
        <hr>
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

        <?php
            include 'adJS.php';
        ?>
    <script>


    function validateForm() {
                let isValid = true;
                const packageForms = document.getElementsByClassName('package-form');
                //regex for package name and amount amount must be a number with only postive values
                const nameRegex = /^[a-zA-Z0-9 ]+$/;
                const amountRegex = /^\d+(\.\d{1,2})?$/;


                for (let form of packageForms) {
                    const packageName = form.querySelector('input[name="PackageName"]').value.trim();
                    const packageType = form.querySelector('select[name="PackageType"]').value;
                    const amount = form.querySelector('input[name="Amount"]').value;

                    if (!nameRegex.test(packageName)) {
                        alert('Package Name should only contain alphanumeric characters and spaces');
                        isValid = false;
                        break;
                    }

                    if (packageType === '') {
                        alert('Package Type is required');
                        isValid = false;
                        break;
                    }

                    if (!amountRegex.test(amount)) {
                        alert('Amount should be a number with only positive values');
                        isValid = false;
                        break;
                    }
                }

                return isValid;
            }
        
        function addPackage() {
            const packageForm = `
            <hr>
                <div class="row package-form w-50 mx-auto">
                    <div class="form-group">
                        <label for="PackageName">Package Name:</label>
                        <input type="text" class="form-control" id="PackageName" name="PackageName" required>
                    </div>
                    
                    <div class="row form-group justify-content-evenly">
                        <div class="col-auto">
                            <label for="PackageType">Package Type:</label>
                            <select class="form-control" id="PackageType" name="PackageType" required>
                                <option value="TimeBased">TimeBased</option>
                                <option value="TicketBased">TicketBased</option>
                            </select>
                            </div>
                        <div class="col-auto">
                            <label for="Amount">Amount:</label>
                            <input type="number" class="form-control" id="Amount" name="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="packageIDInput">
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
            if (!validateForm()) return;

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

            
            //get the package data from the table packagesTable using the packageID
            const packagesTable = document.getElementById('packagesTable').getElementsByTagName('tbody')[0];
            const packageRow = Array.from(packagesTable.children).find(row => row.children[0].textContent === packageID.toString());
            const packageData = {
                PackageID: packageRow.children[0].textContent,
                PackageName: packageRow.children[1].textContent,
                PackageType: packageRow.children[2].textContent,
                Amount: packageRow.children[3].textContent,
            };

            //populate the form with the package data
            document.getElementById('PackageName').value = packageData.PackageName;
            document.getElementById('PackageType').value = packageData.PackageType;
            document.getElementById('Amount').value = packageData.Amount;

            //set the packageID in the hidden input field
            document.querySelector('input[name="packageIDInput"]').value = packageData.PackageID;

            // console.log(packageData);
            
            document.getElementById('updatebtn').style.display = 'inline';
            document.getElementById('submitbtn').style.display = 'none';
            document.getElementById('abortUdpatebtn').style.display = 'inline';

            

        }

        document.getElementById('abortUdpatebtn').addEventListener('click', function(){
            document.getElementById('updatebtn').style.display = 'none';
            document.getElementById('submitbtn').style.display = 'inline';
            document.getElementById('abortUdpatebtn').style.display = 'none';
            document.getElementById('packageForm').reset();
        });

        async function updatePackage() {
            //get the data from the form
            //send the data to the server with the action update
            //update the data in the database
            //fetch the data from the database and show it in the table
            if (!validateForm()) return;

            const data = {

                PackageName: document.getElementById('PackageName').value,
                PackageType: document.getElementById('PackageType').value,
                Amount: document.getElementById('Amount').value,
                action: 'update',
                id: document.querySelector('input[name="packageIDInput"]').value

            };

            console.log(data);

            const response = await fetch('packages.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });


            const responseData = await response.json();
            if (responseData.status === 'success') {
                alert('Data updated successfully');
                // Clear the form
                document.getElementById('packageForm').reset();
                fetchPackages();
            } else {
                console.log(responseData);
                alert('Data update failed');
            }
        }
        </script>
</body>
</html>

<?php 
    include 'admin_footer.php';
?>