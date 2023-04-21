$(document).ready(function() { 
  $.validator.addMethod("pwcheck", function(value) {
    return /[A-Z]/.test(value) // has uppercasse letter
        && /[a-z]/.test(value) // has a lowercase letter
        && /\d/.test(value) // has a digit
        && /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(value)// has one special char
  });

  $('#reg-form').validate({ // initialize the plugin
    errorClass: "invalid-input",
    rules: {
      userPassWord: {
        required: true,
        pwcheck: true,
        minlength: 8
      },
      conFirmUserPassWord: {
        required: true,
        equalTo: "#userPassWord"
      },
    },
    messages: {
      userPassWord: {
          required: "password is required",
          pwcheck: "1 lower case letter, 1 upper case letter, 1 number and 1 special character",
          minlength: "Must be at least 8 characters in length"
      },
      conFirmUserPassWord: {
          required: "Cofirm password is required",
          equalTo: "Cofirm password must match Password"
      }
    }
  });
});