<?php
    require_once 'userdashnav.php';

?>


<script>

//function to fetch data from the server
    async function getEventData(){
        fetch('fetch_event.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                EventID: <?php echo $_POST['EventID'];?>,
                action : "getEventDetails"
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

</script>

<?php
    include './user_footer.html';
?>