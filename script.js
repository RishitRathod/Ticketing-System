function setCokkie(data){
    //set the cookie for all the data in the data object
    for(var key in data){
        document.cookie = key + "=" + data[key];
    }
    console.log("Cookies set successfully");
    console.log(document.cookie);
}

//async function to select a perticuler user from the database
async function getUser(){
    //fetch the user data from the server/
    const response = await fetch('../fatchUserData.php' , {
        method: 'POST' 
    });
    //get the response in json format
    const data = await response.json();
    console.log(data);
    //set the cookie for the user data
}
