<?php
require_once 'admin_headnav.php';
?>

<script>
    async function getUserData(){
        fetch('fetch_user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                UserID: <?php echo $_POST['UserID'];?>
            }),
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if(data.error){
                alert(data.error);
            } else {
                console.log(data.data); 
            }
        })
    }  
    getUserData();

</script>