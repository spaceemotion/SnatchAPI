<?php

    /*
     * main.php
     * -------------------------------------------------
     * SnatchAPI Framework
	 * Copyright (c) 2012 - Verexa & SpaceEmotion
	 *
     */

	/*
	 * Autoload library and helper classes
	 */
	function __autoload($class) {
		$file = SYSTEM_LIB;
		$helper_str = "Helper";
		$plugin_str = "Plugin";

		if(substr($class, -strlen($helper_str)) === $helper_str)
			$file = SYSTEM_HELPER;
		else if(substr($class, -strlen($plugin_str)) === $plugin_str)
			$file = SYSTEM_PLUGIN;

		$file .= "$class.php";

		if(file_exists($file)) {
			include_once $file;

			if(class_exists($class)) return;
		}

		die("<h1>Class not found: $class</h1>");
	}

	class SnatchAPI {
		public function run() {
			global $config;

			// Set start time
			$config["site"]["start_time"] = TimeHelper::utime();


			// Set environment
			if($config["site"]["production"] == true)
				ini_set('display_errors','stderr');

			if($config["site"]["time_zone"] != null)
				date_default_timezone_set($config["site"]["time_zone"]);


			// Load all plugins into config;
			PluginHelper::getPlugins();


			// Get urls and request method
			$url = $_GET['url'];
			$split_url = explode("/", trim($url, "/"));
			$count_url = count($split_url);

			$request_method = isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : "";

			if(isset($_GET["xml"])) {
				SiteHelper::setDefaultOutput ("xml");
			}

			// Render site
			if($count_url > 0) {
				$file = USER_CONTROLLER.$split_url[0].".php";

				if(!file_exists($file))
					$file = SYSTEM_CONTROLLER.$split_url[0].".php";

				if(file_exists($file)) {
					include_once $file;

					$class_name = ucfirst($split_url[0]."_Controller");
					if(class_exists($class_name)) {
						$controller = new $class_name();

						$func = "index";
						$args = array();

						if($count_url > 1) {
							$func = $split_url[1];

							if($count_url > 2) {
								$args = array_splice($split_url, 1);
							}
						}

						$function = $request_method."_".$func;

						if(method_exists($class_name, $function)) {
							if($count_url > 1) {
								$r = new ReflectionMethod($controller, $function);

								if(count($args) < count($r->getParameters()))
									exit(SiteHelper::write(400));
							}

							call_user_func_array(array($controller, $function), $args);

							exit;
						}
					}
				}
			}


			// If nothing happened, display an error
			SiteHelper::write(404);
		}
	}


?>