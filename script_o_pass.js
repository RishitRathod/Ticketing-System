$(document).ready(function() {
    $('#eye').click(function() {
        let passwordFieldType = $('#PassWord, #PassWord1').attr('type');
        $('#eye').empty();
        if (passwordFieldType === 'password') {
            $('#PassWord, #PassWord1').attr('type', 'text');
            let eyeOpen = `<i class="fa fa-eye"></i>`;
            $('#eye').append(eyeOpen);
        } else {
            $('#PassWord, #PassWord1').attr('type', 'password');
            let eyeClose= `<i class="fa fa-eye-slash"></i>`;
            $('#eye').append(eyeClose);
        }
    });
});
