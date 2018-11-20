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
    roomid : $("#roomid"),
    submit: $("#btn-submit"),
    result: $("#ajaxRes"),
};
form.submit.click(function() {
   $.post("addReview.php", {
       rating: form.rating.val(), textarea: form.textarea.val(), roomid:form.roomid.val(), userid:userid
        }, function(messages,status) {
            if(messages==false) { 
                $('#form-message').text('You need to choose a Rating');
                $('#error').show();
            } else {
                $("#reviewcontainer").empty();
                $("#reviewcontainer").html(messages);
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