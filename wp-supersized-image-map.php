<?php 
  /*
    Plugin Name: WP Supersized Image Map
    Plugin URI: http://joelrocha.com
    Description: Plugin for displaying a image map with supersized
    Author: Joel Rocha
    Version: 1.0
    Author URI: http://joelrocha.com
    
    Copyright 2012 Joel Rocha  (email : joelrocha@escolhadigital.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
  */ 
  
  define("PLUGIN_DIR", plugin_dir_url(__FILE__));
  define("SIMIMAGES_TAX", "sim_images");
  define("SIMIMAGES_SINGULAR", "Image");
  define("SIMIMAGES_PLURAL", "Images");
  define("SIMIMAGES_SLUG", "simimages");
  
  function sim_init() {	
  
    require_once dirname( __FILE__ ) . '/functions.php';
    
    // Include functions/*.php
    include_files_in_dir("/functions/");
    
    // Include includes/*.php
    include_files_in_dir("/includes/"); 
    
  }
  
  // INIT
  //sim_init();  
  add_action('init', 'sim_init');
  add_action('init', 'simimages_post_register');
  //add_action('init', 'simimages_tax_register');
  
  add_action("admin_init", "admin_properties_simimages");
  add_action('admin_menu', 'sim_admin_actions');
  add_action('admin_head', 'sim_admin_head');
  add_action('save_post', 'simimages_save_details');  
  
  add_action('wp_enqueue_scripts', 'sim_header');
  add_action('wp_head', 'sim_header_script');  
  
  //add_filter('the_content', 'sharebar_auto');
  //add_action('init', 'sharebar_init');
  //add_action('admin_head', 'sharebar_admin_head');
  //add_action('activate_sharebar/sharebar.php', 'sharebar_install');
  //add_action('admin_menu', 'sharebar_admin_actions');
  //add_action('add_meta_boxes', 'sharebar_custom_boxes');
  //add_action('draft_post', 'sharebar_save_post_options');
  //add_action('publish_post', 'sharebar_save_post_options');
  //add_action('save_post', 'sharebar_save_post_options');

?>     

<!--------------------------------->

<?php 
/*******************
This function handles the mood and listening_to meta tags.
It can be called with an action of update, delete, and get (default)
When called with an action of update, either $mood or $listening_to must be provided.
i.e. mood_music( $post->ID, 'update', 'Happy', 'Bon Jovi - It's My Life' );
*******************/
function mood_music( $post_id, $action = 'get', $mood = 0, $listening_to = 0 ) {
  
  //Let's make a switch to handle the three cases of 'Action'
  switch ($action) {
    case 'update' :
      if( ! $mood && ! $listening_to )
        //If nothing is given to update, end here
        return false;
      
      //add_post_meta usage:
      //add_post_meta( $post_id, $meta_key, $meta_value, $unique = false )
      
      //If the $mood variable is supplied,
      //add a new key named 'mood', containing that value.
      //If the 'mood' key already exists on this post,
      //this command will simply add another one.
      if( $mood ) {
        add_post_meta( $post_id, 'mood', $mood );
        return true;
        }
      //update_post_meta usage:
      //update_post_meta( $post_id, $meta_key, $meta_value )
      
      //If the $listening_to variable is supplied,
      //add a new key named 'listening_to', containing that value.
      //If the 'listening_to' key already exists on this post,
      //this command will update it to the new value
      if( $listening_to ) {
        add_post_meta( $post_id, 'listening_to', $listening_to, true ) or
          update_post_meta( $post_id, 'listening_to', $listening_to );
        return true;
      }
    case 'delete' :
      //delete_post_meta usage:
      //delete_post_meta( $post_id, $meta_key, $prev_value = ' ' )
    
      //This will delete all instances of the following keys from the given post
      delete_post_meta( $post_id, 'mood' );
      delete_post_meta( $post_id, 'listening_to' );
      
      //To only delete 'mood' if it's value is 'sad':
      //delete_post_meta( $post_id, 'mood', 'sad' );
    break;
    case 'get' :
      //get_post_custom usage:
      //get_post_meta( $post_id, $meta_key, $single value = false )
  
      //$stored_moods will be an array containing all values of the meta key 'mood'
      $stored_moods = get_post_meta( $post_id, 'mood' );
      //$stored_listening_to will be the first value of the key 'listening_to'
      $stored_listening_to = get_post_meta( $post_id, 'listening_to', 'true' );

      //Now we need a nice ouput format, so that
      //the user can implement it how he/she wants:
      //ie. echo mood_music( $post->ID, 'get' );
      
      $return = "<div class='mood-music'>";
      if ( ! empty( $stored_moods ) )
        $return .= '<strong>Current Mood</strong>: ';
      foreach( $stored_moods as $mood )
        $return .= $mood . ', ';
      $return .= '<br/>';

      if ( ! empty( $stored_listening_to ) ) {
        $return .= '<strong>Currently Listening To</strong>: ';
        $return .= $stored_listening_to;
        }
      $return .= '</div>';
      
      return $return;
    default :
      return false;
    break;
  } //end switch
} //end function
?>