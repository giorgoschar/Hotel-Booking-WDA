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
});
function changeDate() {
    var mine = $('#datepicker').datepicker("getDate");
    mine.setDate(mine.getDate()+1);
    $( "#datepicker1" ).datepicker("option", "minDate", mine);
}