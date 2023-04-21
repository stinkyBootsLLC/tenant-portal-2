$(document).ready(function() { 
    // 8/1/2020 new entrance implementation
    $("#role-select").on('change', function() {
        if (this.value === "Tenant"){
            document.location.href = 'tenants/';
        } else {
            document.location.href = 'maintainers/';
        }
    });
});