$(document).ready(function(){ 
    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    });

    
        $('#datepicker').datepicker({ 
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        minDate: 0
        });
    $('#datepicker1').datepicker({ 
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        minDate: 0
    });


var form= { 
    rating: $("#starrating"),
    textarea: $("#ta"),
    roomid : $("#room_id"),
    submit: $("#btn1-submit")
};
form.submit.click(function() {
   $.post("addReview.php", {
       rating: form.rating.val(), textarea: form.textarea.val(), roomid:form.roomid.val(), userid:userid
        }, function(messages,status) {
            if(messages==false) { 
                $('#form-message').text('You need to choose a Rating');
                $('#error').show();
            }else if (messages=="exit") {
                $("#modalNeedToLogin").modal("show");
            } else {
                $("#reviewcontainer").empty();
                $("#reviewcontainer").html(messages);
            }
        });
   });
var form2= { 
    checkin: $("#datepicker"),
    checkout: $("#datepicker1"),
    room : $("#room_id"),
    submit: $("#btn-submit")
};
form2.submit.click(function() {
   $.post("booknow.php", {
       checkin: form2.checkin.val(), checkout: form2.checkout.val(), roomid:form2.room.val(), userid:userid
        }, function(messages,status) {
            if(messages=="error2") { 
                $("#myModal").modal("hide");
                $("#error-container-old").empty();
                $("#error-container").empty();
                $("#error-container").html('<div class="alert alert-danger"><strong>Not Available</strong> The hotel you are currently watching is not free for booking in the dates you are looking for.</div>')
            } else if (messages=="error") {
                
                $("#error-container").empty();
                $("#error-container").html(messages)
            } else if (messages =="exit") { 
                $("#modalNeedToLogin").modal("show");
            } else {
                $("#error-container-old").empty();
                $("#error-container").empty();
                $("#myModal").modal("hide");
                $("#myModalBtn").text("Booked")
                $("#myModalBtn").attr("disabled","disabled");
                $("#modalbooked").modal("show");            
            }
        });
   });
});
function getRate(id) {
    var val = document.getElementById(id).value;
    document.getElementById("starrating").value = val;
}
function changeDate() {
    var mine = $('#datepicker').datepicker("getDate");
    mine.setDate(mine.getDate()+1);
    $( "#datepicker1" ).datepicker("option", "minDate", mine);
}
function addToFavorites() { 
    //change icon to heart filled and post to javascript the hname and userid and change the status accordingly. if not logged in prompt for login.
    $.post("favorites.php", {
        hotel: hotelID, userid:userid
         }, function(messages,status) {
            if (messages=="exit") {
                $("#modalNeedToLogin").modal("show");
            } else { 
                $("#favorites").empty();
                $("#favorites").html(messages);
            }
            
        }); 
        
    };