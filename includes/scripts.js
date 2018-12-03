$(document).ready(function(){
$(function() {
    
    //autocomplete
    $("#searchbox").autocomplete({
        source: "autocomplete.php",
        minLength: 3,
      position: {
        my: "left+0 top+12",
    }
    });                

});
});


$(document).ready(function(){
    $(".hidethis").hide(0);
    $(".hidebutton").click(function(e){
      console.log(e.target.classList.item(3));
        var itemHeader = e.target.classList.item(0);
      if(e.target.classList.item(2) == "fa-arrow-alt-circle-down"){
         e.target.classList.remove("fa-arrow-alt-circle-down");
         e.target.classList.add("fa-arrow-alt-circle-up");  
         } else if(e.target.classList.item(2) == "fa-arrow-alt-circle-up"){
           e.target.classList.add("fa-arrow-alt-circle-down");
         e.target.classList.remove("fa-arrow-alt-circle-up");
         }
        itemHeader = "." + itemHeader + "button";
         $(itemHeader).toggle(0);
    });
});

