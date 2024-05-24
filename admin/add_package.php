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
        


</script>
</body>
</html>
