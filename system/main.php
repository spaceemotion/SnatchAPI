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

			if($config["site"]["production"] == true)
				ini_set('display_errors','stderr');

			if($config["site"]["time_zone"] != null)
				date_default_timezone_set($config["site"]["time_zone"]);

			$this->loadPlugins();

			$url = $_GET['url'];
			$split_url = explode("/", trim($url, "/"));
			$count_url = count($split_url);

			$request_method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD']: "";

			if(count($split_url) > 0) {
				$file = USER_CONTROLLER.$split_url[0].".php";

				if(file_exists($file)) {
					include_once $file;

					$class_name = $split_url[0]."_Controller";
					if(class_exists($class_name)) {
						$controller = new $class_name();

						if(!isset($split_url[1]) && !empty($split_url)) {
							$func = $split_url[1];
							$args = null;

							if(count($split_url) > 2) {
								$args = array_splice($input, 2);
							}

							$controller->$func($args);
						} else {
							$controller->index();
						}

						exit;
					}
				}
			}

			SiteHelper::write(404);
		}

		private function loadPlugins() {
			global $config;

			$plugin_dir = scandir(SYSTEM_PLUGIN);

			foreach($plugin_dir as $dir) {
				if(substr($dir, 0,1) != ".") {
					array_push($config["site"]["plugins"], $dir);
				}
			}
		}
	}


?>