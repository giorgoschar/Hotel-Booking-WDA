$(document).ready(function(){ 
});

function deleteRecord(id) { 
    var idnum = id.replace("btn-submit", "");
    var form= { 
        bookingid: $("#bookingid" + idnum),
        submit: $("#" + id)
    };
    $.post("cancel.php", {
        bookingid: form.bookingid.val()}, function(messages,status) {
            if(messages==false) { 
                alert("Not erased");
            } else {
                $("#bookings").empty();
                $("#bookings").html(messages);
                $("#modalCanceled").modal('show');
                }
            });
};