<?php 
  
  // FRONT
  /*function sharebar_init(){
	if(!is_admin()) wp_enqueue_script('sharebar', get_bloginfo('wpurl').'/wp-content/plugins/sharebar/js/sharebar.js',array('jquery'));
  }*/
  
  function sim_getQuery() {
    
    $args= array(
      'post_type' => SIMIMAGES_TAX,
      'orderby' => 'order', 
      'order' => 'ASC',
      'posts_per_page' => -1
    );
    
    return new WP_Query($args);
    
  }
  
  function sim_header() {
    
    echo "<!-- SIM SCRIPTS -->";
    
    wp_enqueue_style('sim', PLUGIN_DIR.'css/user/stylesheet.css');
    
    wp_enqueue_style('supersized', PLUGIN_DIR.'js/user/supersized/css/supersized.css');
    wp_enqueue_style('supersized_shutter', PLUGIN_DIR.'js/user/supersized/theme/supersized.shutter.css', array('supersized'));
    wp_enqueue_script('supersized', PLUGIN_DIR.'js/user/supersized/js/supersized.3.2.4.js');
    wp_enqueue_script('supersized_shutter', PLUGIN_DIR.'js/user/supersized/theme/supersized.shutter.js', array('supersized'));

    if(get_option('sim_tooltip_load') == 1) {
      // Tooltip 
      wp_enqueue_style('tooltip', PLUGIN_DIR.'js/user/jquery.tooltip/jquery.tooltip.css');
      wp_enqueue_script('tooltip', PLUGIN_DIR.'js/user/jquery.tooltip/jquery.tooltip.js', array('jquery'));
    }
    
    if(get_option('sim_colorbox_load') == 1) {
      // Colorbox
      wp_enqueue_style('colorbox', PLUGIN_DIR.'js/user/jquery.colorbox/colorbox.css');
      wp_enqueue_script('colorbox', PLUGIN_DIR.'js/user/jquery.colorbox/jquery.colorbox-min.js', array('jquery'));
    }
    
    // Reposition Hotspots
    wp_enqueue_script('sim_reposition_hotspots', PLUGIN_DIR.'js/user/sim_reposition_hotspots.js', array('jquery', 'colorbox'));
     
    // Common 
    wp_enqueue_script('sim_common', PLUGIN_DIR.'js/user/sim_common.js', array('jquery', 'colorbox', 'sim_reposition_hotspots'));      
  	
  }
  
  function sim_header_script() {

    $query = sim_getQuery();
  
    $i = 0;
    if($query->have_posts()) {
?>
      <!-- SIM SCRIPTS INIT -->
      <script type="text/javascript">        
        jQuery(function($){
        	$.supersized({
        	
        		autoplay: 0,
        		horizontal_center: 1,
        		
            // Functionality
        		slide_interval: 3000,		// Length between transitions
        		transition: 1, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
        		transition_speed: 3000,		// Speed of transition
        												   
        		// Components							
        		slide_links: 'blank',	// Individual links for each slide (Options: false, 'number', 'name', 'blank')
        		slides: [			// Slideshow Images
              <?php 
                while($query->have_posts()): $query->the_post(); $id = get_the_ID();                
                  if(has_post_thumbnail()) {                             
                    $thumb_id = get_post_thumbnail_id($id);
                    $url = wp_get_attachment_url($thumb_id);
                    //$thumb_url = "$template_url/timthumb.php?src={$url}&a=t";                           
                    $thumb_url = $url;  
                     
                    if($i>0) echo ",";
              ?>
                    {image : '<?php echo $thumb_url; ?>', title : 'hotspots_<?php echo $id; ?>', thumb : '<?php echo $thumb_url; ?>'}	
              <?php 
                    $i++; 
                  }
                endwhile; 
              ?>
            ],
            
            // Theme Options			   
        		progress_bar:	0,			// Timer for each slide							
        		mouse_scrub: 0
        		
        	});	        	
        });
      </script>
      <!-- END SIM SCRIPTS INIT -->
<?php
  	}
  	
  	wp_reset_query();
  
  }

?>