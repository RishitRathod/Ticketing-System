function showLoader() {
    document.querySelector('.loader').style.display = 'block';
}

function hideLoader() {
    document.querySelector('.loader').style.display = 'none';
}

function spawn(id){
    document.querySelector(id).style.opacity = "1";
}