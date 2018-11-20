$(document).ready(function(){ 
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
    var slider = document.getElementById("priceRange");
    var output = document.getElementById("priceVal");
    output.innerHTML = slider.value;

    slider.oninput = function() {
      output.innerHTML = this.value;
    }

});

function changeDate() {
    var mine = $('#datepicker').datepicker("getDate");
    mine.setDate(mine.getDate()+1);
    $( "#datepicker1" ).datepicker("option", "minDate", mine);
}