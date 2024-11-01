<?php 
  
  function sim_getBtnShow() {

    $data = "<div id=\"hotspots_show\"><ul><li id=\"show\" class=\"show\">show hotspots</li></ul></div>";
    
    return $data;
       
  }
  
  function sim_getThumbTray() {

    $data = "
      <div id=\"thumb-tray-wrapper\">
      	<div id=\"thumb-back\"></div>
        <div id=\"thumb-tray\" class=\"load-item\"></div>
      	<div id=\"thumb-forward\"></div>
      </div>
    ";
    
    return $data;
       
  }
  
  function sim_getHotspots() {

    $query = sim_getQuery();
    
    
    $data = (!empty($custom['spots'])) ? $custom['spots'] : array();
    if(!empty($data)) $data = unserialize($data[0]); 

    $i = 0;
    $data  = "";
    if($query->have_posts()) {
      while($query->have_posts()): $query->the_post(); $id = get_the_ID(); 

        $meta = get_post_meta($id, 'spots');       
        $spots = (!empty($meta)) ? $meta : array();        
        if(!empty($spots)) $spots = $spots[0];  
            
        if(has_post_thumbnail() AND (!empty($spots))) {  
        
          $j = 0;
          $data .= "<div id=\"hotspots_{$id}\" class=\"image_map\">";
          foreach($spots as $value) {
            $url = (!empty($value['value'])) ? $value['value'] : "#";
            //$data .= "<a href=\"popup.html\" class=\"link1\" top=\"1%\" left=\"28%\" title=\"Product\" alt=\"Product\"></a>";
            $data .= "<a href=\"{$url}\" class=\"link{$j}\" left=\"{$value['x']}%\"top=\"{$value['y']}%\" title=\"Product\" alt=\"Product\"></a>";
          }
          $data .= "</div>";
          
          $i++;                           
          
        } 
        
      endwhile; 

    }
    
    return $data;
       
  }

  function sim_shortcode($atts) {
    
    extract(shortcode_atts(array(
      'show_btnshow' => true,
      'show_thumbtray' => true,
    ), $atts));
    
    $data = "";
    if($show_btnshow == true) $data .= sim_getBtnShow();   
    if($show_thumbtray == true) $data .= sim_getThumbTray();
    $data .= sim_getHotspots();
    
    return $data;
       
  }
  
  add_shortcode('sim', 'sim_shortcode');
  
  /*
    class MyPlugin {
      function baztag_func() {
        return "content = $content";
      }
    }
    add_shortcode( 'baztag', array('MyPlugin', 'baztag_func') );
  */
  
?>