<script>
//destory cookies via loops

function logout() {
    // Delete all cookies
    const cookies = document.cookie.split(";");
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
    }
    console.log("User logged out successfully");
    
    // Redirect to the PHP logout script
    window.location.href = "userlogout.php";
}
logout();

//delete all the cookies form application cookies


</script>

<?php
function deleteAllCookies() {
    // Check if there are any cookies set
    if (isset($_SERVER['HTTP_COOKIE'])) {
        // Split the cookies into an array
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach ($cookies as $cookie) {
            // Split each cookie into its name and value
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            // Set the cookie's expiration date to a past date
            setcookie($name, '', time() - 3600, '/');
            // Also unset the cookie in the $_COOKIE superglobal
            unset($_COOKIE[$name]);
        }
    }
}

// Call the function to delete all cookies
deleteAllCookies();

    require_once '../db_connection.php';
    
    db::logout('organizations'); //logout($tablename)
    $url = './organization_login.html';
   
    #destory the $_SESSION['user']
    unset($_SESSION['user']);
    session_unset();
    session_destroy();


    header('Location: ' . $url);
    exit();
?>
