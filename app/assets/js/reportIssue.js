$(document).ready(function() { 
    setTimeout(function(){
        window.location.reload(1);
    }, 1800000);

    $('#report-form').validate({ // initialize the plugin
        errorClass: "invalid-input",
        rules: {
            IssueReportDate: {
              required: true
               
            },
            IssueDescription: {
              required: true
               
            }
        }
    });
});