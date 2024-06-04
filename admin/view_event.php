<?php
require_once 'admin_headnav.php';
?>

<script>
    //fetch data from server
    async function getEventsData(){
        fetch('fetch_event.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                EventID: <?php echo $_POST['EventID'];?>
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
    getEventsData();
</script>