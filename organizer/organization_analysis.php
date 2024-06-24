<head>
    <title> Analysis </title>
</head>
<?php
    include 'navhead.php';
?>



<?php
    include 'footer.php';
?>
 
 <script>
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