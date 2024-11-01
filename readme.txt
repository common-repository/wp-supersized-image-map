=== WP Supersized Image Map ===
Contributors: Joel Rocha
Donate link: http://joelrocha.com
Tags: imamap, image map, supersized
Requires at least: 3.0
Tested up to: 3.3.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This Plugin adds an image map to Supersized.
It ables you to resize the browser and keep the spots in place.

== Description ==

It's easy to create an image map, right?
But, what you do when you want your background to be full screen?
And you need to set some images above.

<b>Step 1:</b>
Get jQuery (can be done here: <a href="http://docs.jquery.com/Downloading_jQuery" target="_blank">http://jquery.com</a>).
Now a days you use it to everything, we can't live without it.  


<b>Step 2:</b>
If you Google it, you will find some scripts that will help you define a full screen background.
I used supersized, that can be download here:
<a href="http://www.buildinternet.com/project/supersized/" target="_blank">http://www.buildinternet.com/project/supersized/</a>

Why supersized?
In my case, I need my background to be full screen and to act like a slideshow.


<b>Step 2.2:</b>
Important options.
Set "autoplay: 0", the image only changes on button click.
Set "horizontal_center: 1", to set the image at the center of the browser.
Set a title in a descending order.

I set a title to know what hotspots I need to show.  		

[js]
  jQuery(function($){
    		
  	$.supersized({
  	
  		autoplay: 0, //Only plays on button click
  		horizontal_center: 1, //Defines the image at the center
  		
      // Functionality
  		slide_interval: 3000,		// Length between transitions
  		transition: 1, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
  		transition_speed: 3000,		// Speed of transition
  												   
  		// Components							
  		slide_links: 'blank',	// Individual links for each slide (Options: false, 'number', 'name', 'blank')
  		slides: [			// Slideshow Images
        {image: 'images/backgrounds/Frato-795531.jpg', title: 'hotspots_14', thumb: 'images/thumb/ambi_795531.jpg'},
        {image: 'images/backgrounds/Frato-794891.jpg', title: 'hotspots_13', thumb: 'images/thumb/ambi_794891.jpg'}	
      ],
      
      // Theme Options			   
  		progress_bar:	0,			// Timer for each slide							
  		mouse_scrub: 0
  		
  	});	
  	
  });
[/js]

You can see more options on the plugin page.


<b>Optinal Step 2.3:</b>
As you can see, I set some thumbnails with mouse event.
To do this, you need to set the "thumb:" options of the supersized configurations.

Then you set the HTML.
[html]
<div id="thumb-tray-wrapper">
	<div id="thumb-back"></div>
  <div id="thumb-tray" class="load-item"></div>
	<div id="thumb-forward"></div>
</div>
[/html]

And the css. I set it on the supersized.shutter.css

[css]
#thumb-tray-wrapper{width:452px; height:60px; position:absolute; text-align:center; bottom:58px!important;
left:50%; z-index:3000; padding:0 0 0 32px; margin:0 0 0 -250px;}

#thumb-tray{overflow:hidden; width:427px; height:59px; padding:0;}

ul#thumb-list{width:1500px !important; display:inline-block; list-style:none;
position:relative; left:0px; padding:0 0px;}

ul#thumb-list li{list-style:none; background:none; display:inline; width:91px;
height:46px; overflow:hidden; float:left; margin:7px 7px; padding:0; display:block !important;}

#thumb-back{left:0; background: url('../img/btn_play.png') no-repeat 0 0;}
#thumb-forward{right:0; background:url('../img/btn_play.png') no-repeat 100% 0;}
[/css]


<b>Step 3:</b>
You need to do some changes in supersized.shutter.js.

Befone any image transition, we hide the hotspots, so the user don't see it moving.

[js]
supersized.shutter.js
beforeAnimation : function(direction){        
        
  if (api.options.progress_bar && !vars.is_paused) $(vars.progress_bar).stop().animate({left : -$(window).width()}, 0 );
  
  /* Update Fields
  ----------------------------*/
  // Update slide caption
  if ($(vars.slide_caption).length){
  	(api.getField('title')) ? $(vars.slide_caption).html(api.getField('title')) : $(vars.slide_caption).html('');
  }
  
  // Update slide number
  if (vars.slide_current.length){
  
      $(vars.slide_current).html(vars.current_slide + 1);
   
      /* ADD THIS CODE */
      $(".image_map").css("display", "none");
      $(".image_map").css("visibility", "hidden");
      /* END ADD THIS CODE */ 
      
  }
[/js]


<b>Step 4</b>
This step is where the magic happens.

What I do is to get the width, height, top and left of the image.
Then, I calculate the center of the image.
Transform the negative numbers to positive.
Move all the hotspots to the center of the image.
Then get the distance from the center defined in percentage in the html link, like «top="1%"» and «left="28%"».

To calculate the distance, I set the percentage from the center and calculate that percentage in pixels.
Example:
  Image width = 400px
  Image height = 400px
  Image center vertical = 200px
  Image center horizontal = 200px

  Horizontal Percentage Distance from center = 20%
  Horizontal Distance from center in pixels = Image width - Percentage Distance = 400px-20% = 80px

So, the hotspots is positioned 80px from the center. 

After that, you need to see if the hotspot is position to the left or to the right.
To the left you set a negative percentage, to the right, you set it positive.

At this point all the hotspots are at the center of the image.
Then you position all the hotpots assigning the calculated value to the margin.

Example:
  Horizontal Distance from center in pixels = 80px
  Margin-left: -80px

You get the current image title to know what hotspots to show and it is good to go.

<b>Step 4.1:</b>
Set up the hotspots.
As I said above, I define the top and the left.

[html]
<div id="hotspots_13" class="image_map">
  <a href="popup.html" class="link1" top="1%" left="28%" title="Product" alt="Product"></a>
  <a href="popup.html" class="link2" top="-8%" left="13%" title="Product" alt="Product"></a>
  <a href="popup.html" class="link3" top="-10%" left="-11%" title="Product" alt="Product"></a>
  <a href="popup.html" class="link4" top="-24%" left="-7%" title="Product" alt="Product"></a>
  <a href="popup.html" class="link5" top="1%" left="1%" title="Product" alt="Product"></a>
  <a href="popup.html" class="link6" top="17%" left="8%" title="Product" alt="Product"></a>
  <a href="popup.html" class="link7" top="-33%" left="24%" title="Product" alt="Product"></a>
  <a href="popup.html" class="link8" top="8%" left="-25%" title="Product" alt="Product"></a>
</div>
[/html]

[css]
body, html{margin:0; padding:0; overflow:hidden;}
.image_map{width:100%; height:100%; z-index:2000; position:absolute; display:none;}
.image_map a{position:absolute; z-index:9000; width:20px; height:20px;
background:url('../images/icons/icon_yellow.png') center center no-repeat;}
[/css]

<b>Step 4.2</b>
Still in the supersized.shutter.js file.
After the image transition you calculate the sizes, positions, move and show the right hotspots.

[js]
supersized.shutter.js
/* After Slide Transition
----------------------------*/
afterAnimation : function(){
	if (api.options.progress_bar && !vars.is_paused) theme.progressBar();	//  Start progress bar
	
	/* ADD THIS CODE */
    /* HOTSPOTS */
    var imageId = "#supersized .activeslide img";     
    
    //Image style
    var style = $(imageId).attr("style");
    var partsArray = style.split(':');
    
    var w = 0; //width
    var h = 0; //height
    var t = 0; //top
    var l = 0; //left
    
    var temp = 0;
    var partsStyle = style.split(' ');
    
    for(var i=0; i<partsStyle.length; i++) {
    
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
    
    var next_map = "#" + api.getField('title');
    $(next_map).css("display", "inline");
    $(next_map).css("visibility", "visible");
  /* END ADD THIS CODE */
	
},
[/js]


<b>Step 5:</b>
When the browser is resized the hotspots are hidden and the "show hotspots" button changes.
So, when the user clicks to show the hotspots, they are positioned to the right place.

[js]
$(window).resize(function() {
  $('#show').html("show hotspots");
  $('#show').addClass("show");
  $('#show').removeClass("hide");
  $(".image_map").css("display", "none");
  $(".image_map").css("visibility", "visible");     
});
[/js]


<b>Step 5.2:</b>
Set a button to show or hide the hotspots.
[js]
$('#show').click(function() {
  var state = $(this).attr('class');
  if(state=="show") {
    repositionHotspots(); //function that position the hotspots
    $(this).html("hide hotspots");
    $(this).addClass("hide");
    $(this).removeClass("show"); 
    var next_map = "#" + api.getField('title'); //What hotpots will be show next - This fucntion comes with supersized                                          
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
[/js]



<b>Opticional Steps:</b>

This steps were made so the user have a better experience when surfing the website. 

Show a tooltip with the name of the product.
From here: <a href="http://docs.jquery.com/Plugins/Tooltip" target="_blank">http://docs.jquery.com/Plugins/Tooltip</a>
[js]
$('.image_map a').tooltip({ 
    track: true, 
    delay: 0, 
    showURL: false, 
    showBody: " - ", 
    fade: 250 
});
[/js]


Open a colorbox popup when click on the hotspot.
From here: <a href="http://colorpowered.com/colorbox" target="_blank">http://colorpowered.com/colorbox</a>
[js]
$(".image_map a").colorbox({
  iframe:true, 
  scrolling:false, 
  innerWidth:"750px", 
  innerHeight:"450px"
});
[/js]


== Installation ==

1. Download the plugin
1. Upload this plugin into your wp-content/plugins directory
1. Activate the plugin at the plugin administration page


== Frequently Asked Questions ==

= Shortcode? =
show_btnshow (true/false) and show_thumbtray(true/false).


== Screenshots ==

1. /tags/1.0/screenshot-1.jpg


== Changelog ==

= 1.0 =
* First version.

== Upgrade Notice == 

= 1.0 =
Test ou plugin.
