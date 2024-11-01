<?php

  function include_files_in_dir($dir, $no_more=FALSE) {     
    $dir_init = $dir;
    $dir = dirname(__FILE__).$dir;
    
    if(!file_exists($dir)) throw new Exception("Folder $dir does not exist");
       
    $files = array();           
    if ($handle = opendir( $dir )) {       
      while(false !== ($file = @readdir($handle))) {
        if (is_dir( $dir.$file ) && !preg_match('/^\./', $file) && !$no_more) {
           include_files_in_dir($dir_init.$file."/", TRUE);
        } else {
           if(preg_match('/^[^~]{1}.*\.php$/', $file)) $files[] = $dir.$file;
        }
      }         
      @closedir($handle);        
    }              
    sort($files);       
    foreach($files as $file) include_once $file;       
  }
  
?>