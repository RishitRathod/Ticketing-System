<?php
    include 'admin_headnav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Packages</title>
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
        #pkT{
            opacity:0;
        }
            /* #removeBtn{
                display: none;
            }
            #addBtn{
                display:none;
            } */
    </style>
</head>
<body>
    <div class="container mt-2 ">
        <h2>Add Packages</h2>
        <form id="packageForm" action="" method="POST">
            <div id="packageContainer">
                <hr>
                <div class="package-form mx-auto">
                    <div class="row form-group justify-content-evenly">
                        <div class="col-3">
                            <label for="PackageName">Package Name<span class="req">*</span></label>
                            <input type="text" class="form-control" id="PackageName" name="PackageName" required>
                            <div id="error" style="color:red; font-size:10px;"></div>
                        </div>
                        <div class="col-3">
                            <label for="PackageType">Package Type<span class="req">*</span></label>
                            <select class="form-control" id="PackageType" name="PackageType" required>
                                <option value="TimeBased">TimeBased</option>
                                <option value="TicketBased">TicketBased</option>
                            </select>
                        </div>

                        <div class="col-3">
                            <label for="noofdays">No. of Days/Tickets<span class="req">*</span></label>
                            <input type="number" class="form-control" id="noofdays" min="1" name="noofdays" required>
                        </div>

                        <div class="col-3">
                            <label for="Amount">Amount<span class="req">*</span></label>
                            <input type="number" class="form-control" id="Amount" min="0" name="Amount" required>
                        </div>

                        

                        <!-- <div class="col-2">
                            <label for="Exp_date">Set Exp_date</label>
                            <input type="number" class="form-control" id="Exp_date" name="Exp_date">
                        </div> -->

                      <div class="row justify-content-center">
                      <button type="submit" id="submitbtn" class="btn btn-success col-auto m-sm-2 m-0">Submit</button>
                        <button type="button" id="abortUdpatebtn" class="btn btn-warning col-2 m-sm-2 m-0">Abort Update</button>
                        <button type="button" id="updatebtn" class="btn btn-primary col-2 m-sm-2 m-0" onclick="updatePackage()">Update</button>
                      </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="packageIDInput">
                    </div>
                </div>
            </div>
            <!-- <div id="button-div"  class="row justify-content-center"> -->
            <!-- <button type="button" id="addBtn" class="btn btn-primary col m-sm-2 m-0 " onclick="addPackage()">Add More Package</button> -->
            <!-- <button type="button" id="removeBtn"class="btn btn-danger col m-sm-2 m-0" onclick="removePackage()">Remove Last Package</button> -->
            <!-- </div> -->
        </form>
        <hr>
        <div class="crud-table" id="pkT">
            <h2>Packages List</h2>
            <table class="table table-strip" id="packagesTable">
                <thead>
                    <tr>
                        <th>Package ID</th>
                        <th>Package Name</th>
                        <th>Package Type</th>
                        <th>No.of Days/Tickets</th>
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

    <script>

        document.getElementById('PackageName').addEventListener('input', function () {
            var input = this.value.trim().toLowerCase();
            var table = document.getElementById('packagesTable');
            var errorElement = document.getElementById('error');
            var packageNames = [];
            // Collect column names from the table header
            var rows = table.tBodies[0].rows;
            for (var i = 0; i < rows.length; i++) {
                packageNames.push(rows[i].cells[1].textContent.trim().toLowerCase());
            }
            // Check if the input value matches any column name
            if (packageNames.includes(input)) {
                errorElement.textContent = 'Please choose a different name.';
            } else {
                errorElement.textContent = '';
            }
        });

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
                var input = document.getElementById('PackageName').value.trim().toLowerCase();
                var table = document.getElementById('packagesTable');
                var packageNames = [];
                // Collect column names from the table header
                var rows = table.tBodies[0].rows;
                for (var i = 0; i < rows.length; i++) {
                    packageNames.push(rows[i].cells[1].textContent.trim().toLowerCase());
                }
                // Check if the input value matches any column name
                if (packageNames.includes(input)) {
                    alert('Name is Invalid');
                    isValid=false;
                } 
                return isValid;
        }
        var jm;
        function validateForm1() {
                let isValid = true;
                const packageForms = document.getElementsByClassName('package-form');
                //regex for package name and amount amount must be a number with only postive values
                const nameRegex = /^[a-zA-Z0-9 ]+$/;
                const amountRegex = /^\d+(\.\d{1,2})?$/;
                var dupName="";

                for (let form of packageForms) {
                    
                    const packageName = form.querySelector('input[name="PackageName"]').value.trim();
                    const packageType = form.querySelector('select[name="PackageType"]').value;
                    const amount = form.querySelector('input[name="Amount"]').value;
                    dupName=packageName;
                    console.log("pn",packageName);
                    console.log("dup",dupName);

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
                var input = document.getElementById('PackageName').value.trim().toLowerCase();
                var table = document.getElementById('packagesTable');
                var packageNames = [];
                // Collect column names from the table header
                var rows = table.tBodies[0].rows;
                for (var i = 0; i < rows.length; i++) {
                    packageNames.push(rows[i].cells[1].textContent.trim().toLowerCase());
                }

              
                // Check if the input value matches any column name
                if (packageNames.includes(input)) {
                    console.log("pn",jm);
                    console.log("dup",dupName); 
                    if(jm===dupName){
                        isValid=true;
                        console.log("duwsdhwjp");
                        return isValid;
                    }else{
                        alert('Name is Invalid');
                        isValid=false;
                        return isValid;
                    }
                } 
                return isValid;
        }
        
        // function addPackage() {
        //     const packageForm = `
        //     <hr>
        //         <div class="row package-form w-50 mx-auto">
        //             <div class="form-group">
        //                 <label for="PackageName">Package Name:</label>
        //                 <input type="text" class="form-control" id="PackageName" name="PackageName" required>
        //             </div>            
        //             <div class="row form-group justify-content-evenly">
        //                 <div class="col-auto">
        //                     <label for="PackageType">Package Type:</label>
        //                     <select class="form-control" id="PackageType" name="PackageType" required>
        //                         <option value="TimeBased">TimeBased</option>
        //                         <option value="TicketBased">TicketBased</option>
        //                     </select>
        //                     </div>
        //                 <div class="col-auto">
        //                     <label for="Amount">Amount:</label>
        //                     <input type="number" class="form-control" id="Amount" name="Amount">
        //                 </div>
        //             </div>
        //             <div class="form-group">
        //                 <input type="hidden" name="packageIDInput">
        //             </div>
        //         </div>
        //     `;
        //     document.getElementById('packageContainer').insertAdjacentHTML('beforeend', packageForm);
        // }

        // function removePackage() {
        //     const packageForms = document.getElementsByClassName('package-form');
        //     if (packageForms.length > 1) {
        //         packageForms[packageForms.length - 1].remove();
        //     } else {
        //         alert('At least one package is required.');
        //     }
        // }


        //submit the Form data using json format using fetch api and async and await function
        document.getElementById('packageForm').addEventListener('submit', async function (e) {
            e.preventDefault();
            if (!validateForm()) return;

            const data = {
                PackageName: document.getElementById('PackageName').value,
                PackageType: document.getElementById('PackageType').value,
                noofdays: document.getElementById('noofdays').value,
                Amount: document.getElementById('Amount').value,
               // Exp_date: document.getElementById('Exp_date').value
               
                
            };

            

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
                        <td>${package.No_of_Days_Or_Tickets}</td>
                        <!-- <td>${addDays(new Date(),row.Exp_date)}</td> -->

                        <td>${package.Amount}</td>
                        
                        <td>
                        <button class="btn btn-primary" onclick="editPackage(${package.PackageID})">Edit</button>
                        <button class="btn btn-danger" onclick="deletePackage(${package.PackageID})">Delete</button>
                        </td>
                    `;  
                });
                $('#packagesTable')
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
                    spawn("#pkT");
                })
                .DataTable(); 
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
                $('#packagesTable').DataTable().destroy();
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
                No_of_Days_Or_Tickets: packageRow.children[3].textContent,
                Amount: packageRow.children[4].textContent,
        
            };
            document.getElementById('submitbtn').setAttribute("disabled",true);
            //populate the form with the package data
            document.getElementById('PackageName').value = packageData.PackageName;
            jm=packageData.PackageName;
            document.getElementById('PackageType').value = packageData.PackageType;
            document.getElementById('noofdays').value = packageData.No_of_Days_Or_Tickets;
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
            if (!validateForm1()) return;

            const data = {
                action: 'update',
                id: document.querySelector('input[name="packageIDInput"]').value,
                PackageName: document.getElementById('PackageName').value,
                PackageType: document.getElementById('PackageType').value,
                Amount: document.getElementById('Amount').value,
                No_of_Days_Or_Tickets: document.getElementById('noofdays').value
                // Days: document.getElementById('Days').value
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
                //destory datatable
                $('#packagesTable').DataTable().destroy();
                fetchPackages();
            } else {
                console.log(responseData);
                alert('Data update failed');
            }
            document.getElementById('updatebtn').style.display = 'none';
            document.getElementById('submitbtn').style.display = 'inline';
            document.getElementById('abortUdpatebtn').style.display = 'none';
            document.getElementById('packageForm').reset();
            document.getElementById('submitbtn').removeAttribute("disabled",true);

        }
        </script>
</body>
</html>

<?php 
    include 'admin_footer.php';
?>