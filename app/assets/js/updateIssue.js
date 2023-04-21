$(document).ready(function() { 

    setTimeout(function(){
        window.location.reload(1);
    }, 1800000);

    $('#RepairPrice, #Scheduled, #Solution, #Repaired, select#Priority, select#Status ').click(function(event) {
        let aFields = [
            '#RepairPrice', '#Scheduled', '#Solution', '#Repaired', 'select#Priority', 'select#Status'
        ];
        aFields.forEach(element =>  $(element).removeClass( "invalid-update" ));
    });

    $('#update-btn').click(function(event) {
        let issueStatus = $( "select#Status" ).val();
        let priority = $( "select#Priority" ).val();
        let scheduledDate = $( "#Scheduled" ).val();
        let issueSolution = $( "#Solution" ).val();
        let repairedDate = $( "#Repaired" ).val();
        let repairPrice = $( "#RepairPrice" ).val();
        if(issueStatus === 'open'){
            alert("When updating an issue from OPEN, issue status must be changed to PENDING or CLOSED");
            event.preventDefault();
        }
        if(issueStatus === 'pending'){
            if(!priority){
                $('select#Priority').addClass('invalid-update');
                alert(" Priority cannot be blank" );
                event.preventDefault();
            }
            if(!scheduledDate){
                $('#Scheduled').addClass('invalid-update');
                alert("scheduled Date cannot be blank" );
                event.preventDefault();
            }
        }
        if(issueStatus === 'closed'){
            if(!priority){
                $('select#Priority').addClass('invalid-update');
                alert(" Priority cannot be blank" );
                event.preventDefault();
            }
            if(!scheduledDate){
                $('#Scheduled').addClass('invalid-update');
                alert("scheduled Date cannot be blank" );
                event.preventDefault();
            }          
            if( !issueSolution){
                $('#Solution').addClass('invalid-update');
                alert(" issue Solution cannot be blank" );
                event.preventDefault();
            }
            if( !repairedDate){
                $('#Repaired').addClass('invalid-update');
                alert(" repaired Date cannot be blank" );
                event.preventDefault();
            }
            if( !repairPrice){
                $('#RepairPrice').addClass('invalid-update');
                alert(" repair Price cannot be blank" );

                event.preventDefault();
            }
        }
    }); // end submitBtn

});