$(document).ready(function(){ 
  var slider = document.getElementById("priceRange");
  var output = document.getElementById("priceVal");
  output.innerHTML = slider.value;

  slider.oninput = function() {
    output.innerHTML = this.value;
  };

  $(".radiocity").change(function(){  
        getData();
  });
  $(".roomselect").change(function(){  
    getData();
});
  $("#datepicker").change(function(){  
    getData();
});
$("#datepicker1").change(function(){  
  getData();
});
  


  });
  function getData() { 
    var radiocity = $("input[type=radio][name='optradiocity']:checked").val();
    var checkedboxes=[];
    $("input[type=checkbox][name=roomselect]:checked").each(function(){
        checkedboxes.push($(this).val());
    });
    var checkin = $("#datepicker").val();
    var checkout = $("#datepicker1").val();
    $.post("filters.php", {
      radiocity: radiocity, checkedboxes: checkedboxes, checkin: checkin , checkout:checkout
       }, function(messages,status) {
           if(messages==false) { 
               $('#resultsPrinted').html('No results Found');
           } else {
               $("#resultsPrinted").empty();
               $("#resultsPrinted").html(messages);
           }
       });
    //var maxprice = $("#priceVal").html();
  };