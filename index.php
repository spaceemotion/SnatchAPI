<?php

	/*
	 * SnatchAPI Framework - Index Page
	 * Copyright (c) 2012 - Verexa & SpaceEmotion
	 */

	/* Define Directory Constants */
	define("BASE_DIR", dirname(__FILE__)."/");
	define("SYSTEM", BASE_DIR."system/");
	define("SYSTEM_LIB", SYSTEM."libraries/");
	define("SYSTEM_PLUGIN", SYSTEM."plugins/");
	define("SYSTEM_HELPER", SYSTEM."helpers/");

	/*
	 *  Require Standard Functions
	 *  LEAVE IN THIS ORDER FOR FRAMEWORK TO WORK
	 */
	require_once SYSTEM."config.php";
	require_once SYSTEM."main.php";
	require_once SYSTEM."dispatch.php";

	run();


?>