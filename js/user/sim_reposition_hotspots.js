jQuery.event.add(window, "load", repositionHotspots);
//jQuery.event.add(window, "resize", repositionHotspots);

function repositionHotspots() {

    /* HOTSPOTS */ 
    
    var imageId = "#supersized .activeslide img";     
    
    ///Image style
    var style = $(imageId).attr("style");
    var partsArray = style.split(':');
    
    var w = 0; //width
    var h = 0; //height
    var t = 0; //top
    var l = 0; //left
    
    var temp = 0;
    var partsStyle = style.split(' ');
    
    for(var i=0; i<partsStyle.length; i++) {
    
      //partsStyle[i]
      //var partsDots = style.split(' ');
      temp = parseInt(partsStyle[i+1]);
      
      if(partsStyle[i]=="width:") w = temp; 
      else if(partsStyle[i]=="height:") h = temp; 
      else if(partsStyle[i]=="top:") t = temp;
      else if(partsStyle[i]=="left:") l = temp; 
      
    }
    
    //Calculate center
    var dif_w = Math.round(w / 2);
    var dif_h = Math.round(h / 2);
    
    //Negative to positive
    var newL = Math.abs(l);
    var newDifW = dif_w - newL;
    
    var newT = Math.abs(t);
    var newDifH = dif_h - newT;
    
    //Move to center
    $('.image_map a').css('left', function(i, v) { return newDifW+"px"; });        
    $('.image_map a').css('top', function(i, v) { return newDifH+"px"; });     
    
    //Get top and left
    $('.image_map a').css('margin-top', function(i, v) {
    
      var marginTop = $(this).attr('top');
      
      var newMTP = Math.abs(parseInt(marginTop));
      
      var newMT = h * (newMTP / 100);
      
      if(parseInt(marginTop) > 0) return newMT+"px";
      else return "-"+newMT+"px";   
      
    });
    
    $('.image_map a').css('margin-left', function(i, v) {
    
      var marginLeft = $(this).attr('left');
      
      var newMLP = Math.abs(parseInt(marginLeft));
      
      var newML = w * (newMLP / 100);
      
      if(parseInt(marginLeft) > 0) return newML+"px";
      else return "-"+newML+"px";
      
    }); 
    
    /* END HOTSPOTS */ 

}