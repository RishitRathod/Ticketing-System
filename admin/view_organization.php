<?php
session_abort();
require_once 'admin_headnav.php';
///require_once 'fetch_organization.php';
?>

<script>
    var OrgID= <?php echo ($_POST['OrgID']);?>;
    //typecast to integer
    OrgID= parseInt(OrgID);
    console.log(OrgID);

    //fetching data from the server
    async function getorgData (OrgID){
        const abcd = OrgID;
        fetch('fetch_organization.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                OrgID: abcd
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
    getorgData(OrgID);
    

</script>