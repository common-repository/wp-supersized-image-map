<?php
  
  //add_action('init', 'simimages_post_register');
  function simimages_post_register() {
    $singular = SIMIMAGES_SINGULAR;
    $plural = SIMIMAGES_PLURAL;
    $tax = SIMIMAGES_TAX;
    $slug = SIMIMAGES_SLUG;
   
    $labels = array(
      'name' => _x($plural, 'post type general name'),
      'singular_name' => _x($singular, 'post type singular name'),
      'add_new' => _x('Adicionar '.$singular, 'product item'),
      'add_new_item' => __('Adicionar '.$singular),
      'edit_item' => __('Editar '.$singular),
      'new_item' => __('Nova '.$singular),
      'view_item' => __('Ver '.$singular),
      'search_items' => __('Procurar '.$singular),
      'not_found' =>  __('Nada encontrado'),
      'not_found_in_trash' => __('Nada encontrado na Lixeira'),
      'parent_item_colon' => ''
    );
    
    $args = array(
      'labels' => $labels,
      'public' => true,
      'publicly_queryable' => true,
      'show_ui' => true,
      'query_var' => true,
      //'menu_icon' => get_template_directory_uri().'/images/admin/portfolio.png',
      'rewrite' => false, // Permalinks format
      'capability_type' => 'post',
      'hierarchical' => false,
      'show_in_menu' => 'wp-supersized-image-map',
      'menu_position' => 1,
      'has_archive' => true,
      'supports' => array(
        'title', 
        //'editor', // (content)
        //'author',
        'thumbnail', // (featured image, current theme must also support post-thumbnails)
        //'excerpt',
        //'trackbacks',
        //'custom-fields',
        //'comments', // (also will see comment count balloon on edit screen)
        //'revisions', // (will store revisions)
        //'page-attributes', // (menu order, hierarchical must be true to show Parent option)
        //'post-formats', // add post formats, see Post Formats
      )
    );
    
    register_post_type($tax, $args);
    
  }
  //add_action('init', 'simimages_post_register');   
  
  /* TAXONOMIES */
  //add_action('init', 'simimages_tax_register');
  function simimages_tax_register() {
  
    $singular = "Categorie";
    $plural = "Categories";
    $tax = SIMIMAGES_TAX;
    $taxonomy = SIMIMAGES_TAX."-categories";
    $slug = "evento-categoria";
  
    $labels = array(
      'name' => _x($plural, 'taxonomy general name'),
      'singular_name' => _x($singular, 'taxonomy singular name'),
      'search_items' =>  __('Procurar '.$singular),
      'popular_items' => __($plural.' Populares'),
      'all_items' => __('Todas as '.$plural),
      'parent_item' => null,
      'parent_item_colon' => null,
      'edit_item' => __( 'Editar '.$singular), 
      'update_item' => __( 'Actualizar '.$singular),
      'add_new_item' => __( 'Adicionar Nova '.$singular),
      'new_item_name' => __( 'Nome Nova '.$singular),
      'separate_items_with_commas' => __( 'Separar por virgulas'),
      'add_or_remove_items' => __( 'Adicionar ou Remover '.$singular),
      'choose_from_most_used' => __( 'Escolha das Mais Utilizadas'),
      'menu_name' => __($plural),
    ); 
    
    register_taxonomy($taxonomy, array($tax), 
      array(
        "hierarchical" => true, 
        "labels" => $labels, 
        "singular_label" => $singular, 
        'rewrite' => array('slug' => $slug)
        //"rewrite" => true
      )
    );
    
  }
  
  /* CAMPOS PERSONALIZADOS */
  //add_action("admin_init", "admin_properties_simimages");
  function admin_properties_simimages() {
    //add_meta_box( $id, $title, $callback, $page, $context, $priority, $callback_args );
    add_meta_box("simimages_thumbnail", "Thumbnail", "simimages_thumbnail", SIMIMAGES_TAX, "normal", "low");
    add_meta_box("simimages_spots", "Spots", "simimages_spots", SIMIMAGES_TAX, "normal", "low");
  }
   
  function simimages_thumbnail() {
  
    global $post;
    
    $custom = get_post_custom($post->ID);
    $data = (!empty($custom['spots'])) ? $custom['spots'] : array();
    if(!empty($data)) $data = unserialize($data[0]); 
    
    if(has_post_thumbnail($post->ID)) {
?>
      <div id="div_sim_thumbnail">
        <div id="div_sim_thumbnail_wrapper">
          <div id="div_sim_image"><?php echo get_the_post_thumbnail($post->ID, 'sim_thumb_admin'); ?></div>
          <div id="div_sim_spots">
            <ul>
              <?php 
                if(!empty($data)) {
                  
                  $imgdata = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'sim_thumb_admin' );
                  //$imgurl = $imgdata[0]; // the url of the thumbnail picture
                  $width = $imgdata[1]; // thumbnail's width
                  $height = $imgdata[2]; // thumbnail's height 
                  
                  $part_width = $width / 2; 
                  $part_height = $height / 2;
                  
                  $i = 0;
                  foreach($data as $value) {    
                    $marginleft = ($value['x'] * $width) / 100;
                    $margintop = ($value['y'] * $height) / 100; 
              ?>
                    <li id="li_spot_<?php echo $i; ?>" class="li_spot" 
                      style="
                        left:<?php echo $part_width; ?>px; 
                        top:<?php echo $part_height; ?>px;
                        margin-left:<?php echo $marginleft; ?>px;
                        margin-top:<?php echo $margintop; ?>px;
                      ">Spot</li>
              <?php 
                    $i++;
                  }
                } 
              ?>
            </ul>
          </div>
        </div>
      </div>
<?php
    } else { echo "NO"; }
    
  }
    
  function simimages_spots() {
  
    global $post;
    
    $custom = get_post_custom($post->ID);
    $data = (!empty($custom['spots'])) ? $custom['spots'] : array();
    if(!empty($data)) {
      $data = unserialize($data[0]);   
  
      $i = 0;
      foreach($data as $value) {
        $parts = explode('http://', $value['value']);
        if(count($parts)>1) $value['value'] = $value['value'];
    		else $value['value'] = 'http://'.$value['value'];
?>
        <p id="p_<?php echo $i; ?>">
          Spot:
           X <input type="text" name="input_spots[<?php echo $i; ?>][0]" id="input_spot_<?php echo $i; ?>_x" value="<?php echo $value['x']; ?>" readonly="readonly" />
           Y <input type="text" name="input_spots[<?php echo $i; ?>][1]" id="input_spot_<?php echo $i; ?>_y" value="<?php echo $value['y']; ?>" readonly="readonly" />
           Href <input type="text" name="input_spots[<?php echo $i; ?>][2]" id="input_spot_<?php echo $i; ?>_href" value="<?php echo $value['value']; ?>" />
           <input type="button" class="input_delete" rel="<?php echo $i; ?>" value="Delete" />
        </p>
<?php
        $i++;
      } 
    }
  
  }
  
  //add_action('save_post', 'save_details_simimages');
  function simimages_save_details() {
  
    global $post;  
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post->ID;
		
		if(!empty($_POST['input_spots'])) {
  		
      $i = 0;
      $spots = array();
      $fields = $_POST['input_spots'];
  		foreach($fields as $value) {
    		
    		$spots[] = array(
          'id' => $i,
          'x' => $value['0'],
          'y' => $value['1'],
          'value' => $value['2']
        );
        
        $i++;
        
      }
      
      update_post_meta($post->ID, 'spots', $spots);
    
    }
    
  }
  
?>