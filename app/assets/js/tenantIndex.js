/**
 * Returns true is valid email address.
 * @param {String} email 
 * @returns 
 */
function isEmail(email) {
    const regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!regex.test(email)) {
      return false;
    }else{
      return true;
    }
}// end isEmail(email)

$(document).ready(function() { 

    $('#email').on('keyup', function () {
        let email = $('#email').val();
        if(email === ''){
           // $('#message').html('Matching Passwords').css('color', 'white');
            $('#message1').html('Email is required').css('color', 'red');
        }
        if(isEmail(email) === false){
            $('#message1').html('Not an email').css('color', 'red');
        } else {
            $('#message1').hide();
        }

    });
    $('#password').on('keyup', function () {
        let password = $('#password').val();
        if(password === ''){
             $('#message2').html('Password is required').css('color', '#B30000');
        }
    });
    $('#formButton').click(function(e){
        let password = $('#password').val();
        if(password === ''){
             $('#message2').html('Password is required').css('color', '#B30000');
             e.preventDefault();
        }
        let email = $('#email').val();
        if(email === ''){
           // $('#message').html('Matching Passwords').css('color', 'white');
            $('#message1').html('Email is required').css('color', '#B30000');
        } else if(isEmail(email) === false){
            $('#message1').html('Not an email').css('color', '#B30000');
            e.preventDefault();
        } else {
            $('#message1').hide();
        }
    });
});// end $(document).ready(function()