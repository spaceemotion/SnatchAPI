<?php
  /*
  *  OpenInspire Framework - Dispatch Library
  *  Copyright (c) 2012 - Verexa
  */
  
  $dispatch = array();
  
  function dispatch($url = null, $controller = null, $func = null){
    global $dispatch;
    if(!$url) return;
    if(!$controller) return;
    if(!$func) $func = "index";
    
    $regex = array();
    $params = array();
    
    $split_url = explode("/", trim($url, "/"));
    
    foreach($split_url as $part_url){
      if($part_url != null && $part_url["0"] == ':'){
        $var = substr($part_url, 1);
        array_push($params, $var);
        array_push($regex, "*");
      }
      else{
        array_push($regex, $part_url);
      }
    }
  
    $info = array(
      "controller" => $controller,
      "function" => $func,
      "regex" => $regex,
      "params" => $params
    );
    array_push($dispatch, $info);
  }
?>