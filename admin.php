<?php 
$login = false;
$showerror = false;

if (isset($_POST['login'])) {
    // Check if the username and password fields are set
    if (isset($_POST['AdminUsername']) && isset($_POST['password'])) {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=ticketing_system", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $username = $_POST['AdminUsername'];
            echo $username;
            $password = $_POST['password'];
            echo $password;

            $sql = "SELECT * FROM admins WHERE AdminUsername = :username";

            $stmt = $pdo->prepare($sql);
            $stmt->execute(['username' => $username]);

            // Fetch all results to get the number of rows
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $num = count($result);

            if ($num == 1) {
                foreach ($result as $row) {
                    if (password_verify($password, $row['AdminPassword'])) { // Assuming passwords are hashed
                        $login = true;
                        session_start();
                        $_SESSION['loggedin'] = true;
                        $_SESSION['AdminUsername'] = $username;
                        $_SESSION['role'] = 'Admin';
                        header("Location: admin_homepage.php");
                        exit();
                    } else {
                        $showerror = "Invalid credentials";
                    }
                }
            } else {
                $showerror = "Invalid credentials";
            }
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    } else {
        $showerror = "Please fill in both fields.";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="css/signup.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php //require 'partials/nav.php'; ?>
    <?php
    if ($login) {
        echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success</strong> You are logged in
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    if ($showerror) {
        echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error</strong> ' . $showerror . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    ?>

    <div class="container" id="bar">
        <div class="container" id="both">
            <div class="container" id="in2"></div>
            <div class="container" id="in1">
                <form method="POST" id="form" action="admin_login.php" class="form-container">
                    <h2 class="text-center">Admin Login</h2>
                    <br>
                    <div class="mb-3">
                        <label for="AdminUsername" class="form-label">Admin Username</label>
                        <input type="text" autocomplete="off" class="form-control" id="AdminUsername" name="AdminUsername" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <br>
                    <div class="mb-3 btn-center">
                        <button type="submit" name="login" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>