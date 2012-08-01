<?php
	/*
	 * SnatchAPI Framework - Site configuration file
	 * Copyright (c) 2012 - Verexa & SpaceEmotion
	 */

	global $config;

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

	/*
	 *  Site Enabled Features
	 *  DO NOT MODIFY
	 */
	$config["site"]["enabled_plugin"] = array();

?>