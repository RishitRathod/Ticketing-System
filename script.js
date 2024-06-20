
async function setCookie(data) {
    for (var key in data) {
        document.cookie = key + "=" + data[key] + ";path=/";
    }
    console.log("Cookies set successfully");
    console.log(document.cookie);
}

async function getUserRole() {
    const cookies = document.cookie.split(';').map(cookie => cookie.trim());
    for (const cookie of cookies) {
        if (cookie.startsWith('role=')) {
            return cookie.split('=')[1];
        }
    }
    return null;

}



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

async function getUser() {
    try {
        const response = await fetch('../fatchUserData.php', {
            method: 'POST'
        });
        const data = await response.json();
        console.log(data);
        return data;
    } catch (error) {
        console.error('Error fetching user data:', error);
        return null;
    }
}

function formatDateTime(dateTime) {
    if (!dateTime) {
        return 'N/A';
    }
    const date = new Date(dateTime);
    if (isNaN(date)) {
        return 'N/A';
    }
    return date.toLocaleDateString('en-GB') + ' ' + date.toLocaleTimeString('en-GB');
}

function formatDate(date2) {
    if (!date2) {
        return 'N/A';
    }
    const date = new Date(date2);
    if (isNaN(date)) {
        return 'N/A';
    }
    return date.toLocaleDateString('en-GB');        
}

function formatTime(dateTime) {
if (!dateTime) {
return 'N/A';
}
// Extract time part if dateTime contains date
const time = dateTime.includes(' ') ? dateTime.split(' ')[1] : dateTime;
const [hours, minutes, seconds] = time.split(':');
if (hours === undefined || minutes === undefined || seconds === undefined) {
return 'N/A';
}
return `${hours.padStart(2, '0')}:${minutes.padStart(2, '0')}:${seconds.padStart(2, '0')}`;
}


function logout() {
    // Delete all cookies
    const cookies = document.cookie.split(";");
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.slice(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
    }
    console.log("User logged out successfully");
    
    // Redirect to the PHP logout script
    window.location.href = "userlogout.php";
}
