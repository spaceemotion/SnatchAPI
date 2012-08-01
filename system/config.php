<?php
  /*
  *  Site Global Configuration File
  *  Copyright (c) 2012 - Verexa
  */

  global $config;
  global $lang;
  
  /* Site Configuration */
  $config["site"]["production"] = false;
  $config["site"]["time_zone"] = "UTC";
  $config["site"]["title"] = "";
  $config["site"]["url"] = "";

  /* Plugins Configuration */
  $config["plugin"]["database"] = array(
    "active" => false,
    "dir" => SYSTEM_PLUGIN."database/",
    "file" => "plugin.php",
    "class" => "Database",
    "method" => "load"
  );
  
  /* Language Configuaration */
  $config["lang"]["en_US"] = array(
    "name" => "en_US",
    "active" => true,
    "file" => SYSTEM_LANG."en_US.php"
  );
  
  /* 
  *  Site Enabled Features
  *  DO NOT MODIFY
  */
  $config["site"]["enabled_lang"] = array();
  $config["site"]["enabled_plugin"] = array();
  
?>