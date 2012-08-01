<?php
  /*
  *  OpenInspire Framework - Main System  
  *  Copyright (c) 2012 - Verexa
  */
  
  /* Requiring Libraries */
  require_once SYSTEM_LIB."Controller.php";
  require_once SYSTEM_LIB."Plugin.php";
  require_once SYSTEM_LIB."Model.php";
  
  /* Requiring Functions */
  require_once SYSTEM_LIB."Dispatch.php";
  
  /* Load Languages */
  foreach($config["lang"] as $lang){
    if($lang["active"]){
      if(file_exists($lang["file"])){
        require_once $lang["file"];
        array_push($config["site"]["enabled_lang"], $lang["name"]);
      }
    }
  }
  
  /* Load Plugins */
  foreach($config["plugin"] as $plugin){
    if($plugin["active"]){
      if(file_exists($plugin["dir"] . $plugin["file"])){
        require_once $plugin["dir"] . $plugin["file"];
        
        $plugin_class = $plugin["class"]."_Plugin";
        
        if(method_exists($plugin_class, $plugin["method"])){
          $plugin_enabled = array(
            "class" => $plugin["class"],
            "instance" => new $plugin_class
          );
          
          call_user_func(array($plugin_enabled["instance"], $plugin["method"]), $plugin["dir"]);
          array_push($config["site"]["enabled_plugin"], $plugin_enabled);
        }
      }
    }
  }
  
  /* Run The Site */
  function run(){
    global $dispatch;
    global $config;
    
    if($config["site"]["production"] == true) ini_set('display_errors','stderr');
    if($config["site"]["time_zone"] != null) date_default_timezone_set($config["site"]["time_zone"]);
    
    $url = $_GET['url'];
    $split_url = explode("/", trim($url, "/"));
    $count_url = count($split_url);
    
    $page_set = false;
    
    foreach($dispatch as $page){
      $regex_count = count($page["regex"]);
      
      if($regex_count == $count_url){
        $match_count = 0;
        $params = array();
        $param_count = 0;
      
        for($i = 0; $i < $regex_count; $i++){
          if($page["regex"][$i] != $split_url[$i] && $page["regex"][$i] != '*') break;
          elseif($page["regex"][$i] == '*'){
            $params[$page["params"][$param_count]] = $split_url[$i];
            $match_count++;
            $param_count++;
          }
          else $match_count++;
        }
        
        if($match_count == $count_url){
          if(file_exists(BASE_DIR . "controllers/" . $page["controller"] . ".php")){
            require_once BASE_DIR . "controllers/" . $page["controller"] . ".php";
            
            $controller_class = $page["controller"] . "_Controller";
            
            if(method_exists($controller_class, $page["function"])){
              $controller = new $controller_class;
            
              $content = call_user_func(array($controller, $page["function"]), $params);
              if($content != false)
                echo $content;
              else
                echo error(500, "Could Not Render Content!");
              
              $page_set = true;
            }
            else{
              echo error(500, "Method " . $page["controller"] . "_Controller::" . $page["function"] . "() Does Not Exist!");
              $page_set = true;
            }
          }
          else{
            echo error(500, "Controller " . $page["controller"] . ".php Does Not Exist!");
            $page_set = true;
          }
          
          break;
        }
      }
    }
    
    if(!$page_set) echo error(404, "Page Does Not Exist!");
  }
  
  /* Plugin Getting Stuff*/
  function &plugin($class){
    global $config;
    
    foreach($config["site"]["enabled_plugin"] as $plugin){
      if($class == $plugin["class"]){
        return $plugin["instance"];
      }
    }
    
    return false;
  }
  
  /* Rendering Views */
  function render($view, $vars = null){
    if(file_exists(BASE_DIR . "views/" . $view . ".php")){
      ob_start();
      
      if($vars != null) extract($vars);
      require_once BASE_DIR . "views/" . $view . ".php";
      
      return ob_get_clean();
    }
    
    return false;
  }
  
  /* Render With Layout */
  function render_layout($view, $vars = null, $header = null, $footer = null){
    if(file_exists(BASE_DIR . "views/" . $view . ".php")){
      ob_start();
      
      if($vars != null) extract($vars);
      
      if($header != null) require_once BASE_DIR . "views/" . $header . ".php";
      require_once BASE_DIR . "views/" . $view . ".php";
      if($footer != null) require_once BASE_DIR . "views/" . $footer . ".php"; 
      
      return ob_get_clean();
    }

    return false;
  }
  
  /* Render With Model */
  function render_model($view, $vars = null, $model = null){
    if(file_exists(BASE_DIR . "views/" . $view . ".php")){
      ob_start();
      
      if($vars != null) extract($vars);
      
      if($model != null && $model->getHeader() != null) require_once BASE_DIR . "views/" . $model->getHeader() . ".php";
      require_once BASE_DIR . "views/" . $view . ".php";
      if($model != null && $model->getFooter() != null) require_once BASE_DIR . "views/" . $model->getFooter() . ".php"; 
      
      return ob_get_clean();
    }

    return false;
  }
  
  /* JSON Return Encoding */
  function json($array){
    header('Content-Type: application/json;');
    return json_encode($array);
  }
  
  /* HTML Return Encoding */
  function html($view = null, $vars = null){
    header('Content-Type: text/html;');
    return render($view, $vars);
  }
  
  /* Error Function */
  function error($num = 0, $info = ""){
    global $config;
    $string = "<div class=\"error_num\">Error " . $num . "</div><div class=\"error_info\">";
    $error_info = "";
    
    switch($num){
      /* 4xx Errors */
      case 400:
        $error_info = "Bad Request!";
        break;
      case 401:
        $error_info = "Unauthorised!";
        break;
      case 403:
        $error_info = "Forbidden!";
        break;
      case 404:
        $error_info = "Page Not Found!";
        break;

      /* 5xx Errors */
      case 500:
        $error_info = "Internal Server Error!";
        break;
      case 503:
        $error_info = "Service Unavialble!";
        break;
    }
    
    $string .= $error_info . "</div>";
    
    if(!$config["site"]["production"]) $string .= "<div class=\"error_additional_info\">Additional Info: <code>" . $info . "</code></div>";
    
    header("Status: " . $num . " " . $error_info);
    return $string;
  }
?>