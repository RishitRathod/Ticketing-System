function setCokkie(data){
    //set the cookie for all the data in the data object
    for(var key in data){
        document.cookie = key + "=" + data[key];
    }
    console.log("Cookies set successfully");
    console.log(document.cookie);
}

//async function to select a perticuler user from the database
<<<<<<< HEAD
async function getUser() {
    try {
        // Fetch the user data from the server
        const response = await fetch('../fatchUserData.php', {
            method: 'POST'
        });
        
        // Get the response in JSON format
        const data = await response.json();
        console.log(data);
        return data;
    } catch (error) {
        return error('Error fetching user data:', error);
    }
=======
async function getUser(){
    //fetch the user data from the server/
    const response = await fetch('../fatchUserData.php' , {
        method: 'POST' 
    });
    //get the response in json format
    const data = await response.json();
    return data;
    //set the cookie for the user data
>>>>>>> aad02c832dabffd58c350ccb9afdf15008f12579
}

