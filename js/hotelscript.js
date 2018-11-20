$(document).ready(function(){ 
var slider = document.getElementById("priceRange");
var output = document.getElementById("priceVal");
output.innerHTML = slider.value;

slider.oninput = function() {
  output.innerHTML = this.value;
}
});