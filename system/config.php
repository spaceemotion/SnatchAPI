<?php

    /*
     * config.php
     * -------------------------------------------------
     * SnatchAPI Framework
	 * Copyright (c) 2012 - Verexa & SpaceEmotion
	 *
     */


	global $config;

	/* Site Configuration */
	$config["site"]["production"] = false;
	$config["site"]["time_zone"] = "UTC";
	$config["site"]["title"] = "";
	$config["site"]["url"] = "";

	$config["site"]["enabled_plugins"] = array(
		"database"
	);

	/* Database connection */
	$config["db"] = array(
		"host"		=> "localhost",
		"user"		=> "root",
		"password"	=> "",
		"name"		=> "catacombsnatch"
	);


	/*
	 * Plugins Configuration
	 * FILLED BY SYSTEM - DO NOT MODIFY
	 */
	$config["site"]["plugins"] = array();

?>
