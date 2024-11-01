/*
$(document).ready(function(){
  
  $("#div_sim_image img").click(function(e){
    //$(this).html(e.pageX +', '+ e.pageY);
    alert(e.pageX);
  });  
  
});   
*/
 

jQuery(function($) { 
  
  $(".input_delete").click(function() {
    var rel_id = $(this).attr('rel');
    $("#p_" + rel_id + ", #li_spot_" + rel_id).remove();
  });
  
  $("#div_sim_image img").click(function(e) {
    
    var id = ($('#div_sim_spots .li_spot').length);
    var x = e.pageX - $(this).offset().left;
	  var y = e.pageY - $(this).offset().top - 12;
    
    var img_width = $(this).width(); 
    var img_height = $(this).height();
     
    var part_x = img_width / 2; 
    var part_y = img_height / 2; 
    
    //var part2_x = x / 2
    
    if(x < part_x) {
      var dif_x = part_x - x;   
      var margin_x = "-" + dif_x;
      
      var calc_perc_x = (100 * dif_x) / img_width;
      var perc_x = "-" + calc_perc_x;   
    } else {
      var dif_x = x - part_x;
      var margin_x = "" + dif_x;
      
      var calc_perc_x = (100 * dif_x) / img_width;
      var perc_x = "" + calc_perc_x;  
    }
    
    if(y < part_y) {
      var dif_y = part_y - y; 
      var margin_y = "-" + dif_y; 
      
      var calc_perc_y = (100 * dif_y) / img_height;
      var perc_y = "-" + calc_perc_y;     
    } else {
      var dif_y = y - part_y;
      var margin_y = "" + dif_y; 
      
      var calc_perc_y = (100 * dif_y) / img_height;
      var perc_y = "" + calc_perc_y;    
    }
    
    /*alert(
      "W:" + $(this).width() + 
      ", H:" + $(this).height() + 
      ", X: " + x + 
      ", Y: " + y
    );*/
    
    $("#simimages_spots .inside").append(
      "<p id=\"p_" + id + "\">" +
        "Spot:" +
        " X <input type=\"text\" name=\"input_spots[" + id + "][0]\" id=\"input_spot_" + id + "_x\" value=" + perc_x + " readonly=\"readonly\" />" +
        " Y <input type=\"text\" name=\"input_spots[" + id + "][1]\" id=\"input_spot_" + id + "_y\" value=" + perc_y + " readonly=\"readonly\" />" +
        " Href <input type=\"text\" name=\"input_spots[" + id + "][2]\" id=\"input_spot_" + id + "_href\" value=\"\" />" +
        " <input type=\"button\" class=\"input_delete\" rel=\"" + id + "\" value=\"Delete\" />" +
      "</p>"
    );
    
    var style = "left:" + part_x + "px;" + "top:" + part_y + "px;";
    style += "margin-left:" + margin_x + "px;" + "margin-top:" + margin_y + "px;";
    
    $("#div_sim_spots ul").append(
      "<li id=\"li_spot_" + id + "\" class=\"li_spot\" style=\"" + style + "\">Spot</li>"
    );    
    
  }); 

});

