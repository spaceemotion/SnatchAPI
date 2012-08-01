<?php
	/*
	 * SnatchAPI Framework - Main system
	 * Copyright (c) 2012 - Verexa & SpaceEmotion
	 */


	/* Requiring Libraries */
	require_once SYSTEM_LIB."Controller.php";
	require_once SYSTEM_LIB."Plugin.php";

	/* Requiring Functions */
	require_once SYSTEM_LIB."Dispatch.php";

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

		$request_method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD']: "";

		foreach($dispatch as $page){
			$regex_count = count($page["regex"]);

			if($regex_count == $count_url){
				$match_count = 0;
				$params = array();
				$param_count = 0;

				for($i = 0; $i < $regex_count; $i++){
					if($page["regex"][$i] != $split_url[$i] && $page["regex"][$i] != '*') {
						break;
					} elseif($page["regex"][$i] == '*'){
						$params[$page["params"][$param_count]] = $split_url[$i];
						$match_count++;
						$param_count++;
					} else {
						$match_count++;
					}
				}

				if($match_count == $count_url){
					if(file_exists(BASE_DIR . "controllers/" . $page["controller"] . ".php")){
						require_once BASE_DIR . "controllers/" . $page["controller"] . ".php";

						$controller_class = $page["controller"] . "_Controller";

						if(method_exists($controller_class, $page["function"])){
							$controller = new $controller_class;
							
							if (strtolower($request_method) == strtolower($page["method"])){ 
								$content = call_user_func(array($controller, $page["function"]), $params);

								if($content != false) echo $content;
								else echo error(500, "Could Not Render Content!");
							} else {
								echo error(400, "Request via ". $request_method. "is not possible on this URL");
							}
						} else {
							echo error(500, "Method " . $page["controller"] . "_Controller::" . $page["function"] . "() Does Not Exist!");
						}
					} else {
						echo error(500, "Controller " . $page["controller"] . ".php Does Not Exist!");
					}

					return;
				}
			}
		}

		echo error(404, "Page Does Not Exist!");
	}

	/* Plugin Getting Stuff*/
	function &plugin($class){
		global $config;

		foreach($config["site"]["enabled_plugin"] as $plugin){
			if($class == $plugin["class"]) return $plugin["instance"];
		}

		return false;
	}

	/* JSON Return Encoding */
	function json($array){
		header('Content-Type: application/json;');
		return json_encode($array);
	}

	/* Error Function */
	function error($num = 0, $info = ""){
		require_once SYSTEM_HELPER.'ErrorcodeHelper.php';
		global $config;

		$string = "<div class=\"error_num\">Error " . $num . "</div><div class=\"error_info\">";
		$string .= ErrorcodeHelper::getStatusCodeMessage($num). "</div>";

		if(!$config["site"]["production"])
			$string .= "<div class=\"error_additional_info\">Additional Info: <code>" . $info . "</code></div>";

		header("Status: " . $num . " " . $error_info);
		
		return $string;
	}


?>