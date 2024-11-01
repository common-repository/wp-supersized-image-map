<?php

  // ADMIN FUNCTIONS
  function sim_admin_settings() {
  	 
  	if($_POST['sim_hidden'] == 'Y') {	
  	
  		//Form data sent  		
  		update_option('sim_colorbox_load', $_POST['sim_colorbox_load']);
      update_option('sim_colorbox_iframe', $_POST['sim_colorbox_iframe']);
  		update_option('sim_colorbox_innerWidth', $_POST['sim_colorbox_innerWidth']);
  		update_option('sim_colorbox_innerHeight', $_POST['sim_colorbox_innerHeight']);
  		
  		update_option('sim_tooltip_load', $_POST['sim_tooltip_load']);

?>
		  <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
<?php

    }
?>
  
    <div class="wrap">
      <h2><?php _e('Supersized Image Map Settings', 'wp_sim'); ?></h2>
      
      <form name="sim_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <input type="hidden" name="sim_hidden" value="Y">
        
        <h4><?php _e('Colorbox', 'wp_sim'); ?></h4>
        <p>
          <?php _e("Load JS: "); ?>
          <select name="sim_colorbox_load">
            <option value="1" <?php if(get_option('sim_colorbox_load') == 1) echo "selected=\"selected\""; ?>>Yes</option>
            <option value="0" <?php if(get_option('sim_colorbox_load') == 0) echo "selected=\"selected\""; ?>>False</option>
          </select>
          <?php _e("Default: Yes" ); ?>
        </p>
        <p>
          <?php _e("iframe: "); ?>
          <input type="text" name="sim_colorbox_iframe" value="<?php echo get_option('sim_colorbox_iframe'); ?>" size="20"> 
          <?php _e("Default: true" ); ?>
        </p>
        <p>
          <?php _e("innerWidth: "); ?>
          <input type="text" name="sim_colorbox_innerWidth" value="<?php echo get_option('sim_colorbox_innerWidth'); ?>" size="20"> 
          <?php _e("Default: 750px" ); ?>
        </p>
        <p>
          <?php _e("innerHeight: "); ?>
          <input type="text" name="sim_colorbox_innerHeight" value="<?php echo get_option('sim_colorbox_innerHeight'); ?>" size="20"> 
          <?php _e("Default: 450px" ); ?>
        </p>
        
        <h4><?php _e('Tootip', 'wp_sim'); ?></h4>
        <p>
          <?php _e("Load JS: "); ?>
          <select name="sim_tooltip_load">
            <option value="1" <?php if(get_option('sim_tooltip_load') == 1) echo "selected=\"selected\""; ?>>Yes</option>
            <option value="0" <?php if(get_option('sim_tooltip_load') == 0) echo "selected=\"selected\""; ?>>False</option>
          </select>
          <?php _e("Default: Yes" ); ?>
        </p>
      
      	<p class="submit">
          <input type="submit" name="Submit" value="<?php _e('Update Options', 'oscimp_trdom' ) ?>" />
      	</p>
      </form>
    </div>

<?php
  	
  }
  
  function sim_admin_help() {
?>
    <div class="wrap">
    
      <h2><?php _e('How to Use', 'wp_sim'); ?></h2>
      <h4>To use the Plugin, you just need to add a shortcode.</h4>
      <p>[sim show_btnshow="true" show_thumbtray="true"]</p>
      <hr />
      
      <h4>show_btnshow</h4>
      <p>(true/false) (optional) Show the show/hide buttom.</p>
      <p>Default: true</p>
      
      <h4>show_thumbtray</h4>
      <p>(true/false) (optional) Shows the Thumb Tray.</p>
      <p>Default: true</p>
      
    </div>
<?php
  }   
  
  function sim_admin_head(){
  	echo '<link rel="stylesheet" media="screen" type="text/css" href="'.PLUGIN_DIR.'css/admin/stylesheet.css" />';
  	echo '<script type="text/javascript" src="'.PLUGIN_DIR.'js/admin/querys.js" /></script>';
  }
  
  // Add to admin options
  function sim_admin_actions() {
    add_menu_page('Supersized Image Map', 'Supersized Image Map', 10, 'wp-supersized-image-map', 'sim_admin', '');   
    add_submenu_page('wp-supersized-image-map', 'Settings', 'Settings', 10, 'wp-supersized-image-map-settings', "sim_admin_settings", ''); 
    add_submenu_page('wp-supersized-image-map', 'Help', 'Help', 10, 'wp-supersized-image-map-help', "sim_admin_help", ''); 
  }
  
?>