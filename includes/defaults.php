<?php

  if($option = get_option('sim_colorbox_load')) update_option('sim_colorbox_load', 1);
  if($option = get_option('sim_colorbox_iframe')) update_option('sim_colorbox_iframe', true);
	if($option = get_option('sim_colorbox_innerWidth')) update_option('sim_colorbox_innerWidth', "750px");
	if($option = get_option('sim_colorbox_innerHeight')) update_option('sim_colorbox_innerHeight', "450px");
	
	if($option = get_option('sim_tooltip_load')) 	update_option('sim_tooltip_load', 1);
  
?>