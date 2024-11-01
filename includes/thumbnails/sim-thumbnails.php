<?php
  
  add_theme_support('post-thumbnails');
  
  add_action('init', 'sim_thumbnails_register');  
  function sim_thumbnails_register() {    
    add_image_size('sim_thumb_admin', 300, 300);    
  }
  
  function sim_getThumb($post_id, $w, $h, $default = "") {
  
    $template_url = get_bloginfo('template_directory');
    
    if(has_post_thumbnail()) {                             
      $thumb_id = get_post_thumbnail_id($post_id);
      $url = wp_get_attachment_url($thumb_id);
      $thumb_url = "$template_url/timthumb.php?src={$url}&a=t";                           
    } else { 
      if(empty($default)) return;
      $default_url = "$template_url/images/default/{$default}"; 
      $thumb_url = "$template_url/timthumb.php?src={$default_url}&a=t";    
    }
    
    if($w > 0) $thumb_url .= "&w={$w}";
    if($h > 0) $thumb_url .= "&h={$h}";
    
    return "<img src=\"{$thumb_url}\" />";
  
  }
  
  function sim_getThumbUrl($post_id, $w, $h, $default = "") {
  
    $template_url = get_bloginfo('template_directory');
    
    if(has_post_thumbnail()) {                             
      $thumb_id = get_post_thumbnail_id($post_id);
      $url = wp_get_attachment_url($thumb_id);
      $thumb_url = "$template_url/timthumb.php?src={$url}&a=t";                           
    } else { 
      if(empty($default)) return;
      $default_url = "$template_url/images/default/{$default}"; 
      $thumb_url = "$template_url/timthumb.php?src={$default_url}&a=t";    
    }
    
    if($w > 0) $thumb_url .= "&w={$w}";
    if($h > 0) $thumb_url .= "&h={$h}";
    
    return $thumb_url;
  
  }
  
  function sim_getThumbByUrl($url, $w, $h) {
  
    $template_url = get_bloginfo('template_directory');   
    $thumb_url = "$template_url/timthumb.php?src={$url}&a=t&w={$w}&h={$h}";                         
    
    return "<img src=\"{$thumb_url}\" />";
  
  }
  
  function sim_getThumbByUrlRel($url, $w, $h, $w_thumb, $h_thumb) {
  
    $template_url = get_bloginfo('template_directory');   
    $big_url = "$template_url/timthumb.php?src={$url}&a=t&w={$w}&h={$h}";                         
    $thumb_url = "$template_url/timthumb.php?src={$url}&a=t&w={$w_thumb}&h={$h_thumb}";
    
    return "<img src=\"{$big_url}\" rel=\"{$thumb_url}\" />";
  
  }
  
  function sim_getThumbDefault($default) {
  
    $template_url = get_bloginfo('template_directory');
    $thumb_url = "$template_url/images/default/{$default}";
    
    return "<img src=\"{$thumb_url}\" />";
  
  }
  
?>