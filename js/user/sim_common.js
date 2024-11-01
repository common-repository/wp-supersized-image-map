//On resize hide hotspots 
$(window).resize(function() {
  $('#show').html("show hotspots");
  $('#show').addClass("show");
  $('#show').removeClass("hide");
  $(".image_map").css("display", "none");
  $(".image_map").css("visibility", "visible");     
});

$(document).ready(function(){  
  
  //Show tooltip
  $('.image_map a').tooltip({ 
      track: true, 
      delay: 0, 
      showURL: false, 
      showBody: " - ", 
      fade: 250 
  });
  
  //On click open colorbox popup
  $(".image_map a").colorbox({iframe:true, scrolling:false, innerWidth:"750px", innerHeight:"450px"});
  
  
  //Show/hide hotspots on click
  $('#show').click(function() {
    var state = $(this).attr('class');
    if(state=="show") {
      repositionHotspots();
      $(this).html("hide hotspots");
      $(this).addClass("hide");
      $(this).removeClass("show"); 
      var next_map = "#" + api.getField('title');                                          
      $(next_map).css("display", "inline");
      $(next_map).css("visibility", "visible");   
    } else {     
      $(this).html("show hotspots");
      $(this).addClass("show");
      $(this).removeClass("hide");
      $(".image_map").css("display", "none");
      $(".image_map").css("visibility", "hidden");
    }
  });
  
});