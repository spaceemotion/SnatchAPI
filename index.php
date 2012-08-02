<?php

    /*
     * index.php
     * -------------------------------------------------
     * SnatchAPI Framework
	 * Copyright (c) 2012 - Verexa & SpaceEmotion
	 *
     */


	/*
	 * Define Directory Constants
	 */

	define("BASE_DIR", dirname(__FILE__)."/");
	define("SYSTEM", BASE_DIR."system/");
	define("SYSTEM_LIB", SYSTEM."libraries/");
	define("SYSTEM_HELPER", SYSTEM_LIB."helpers/");
	define("SYSTEM_PLUGIN", SYSTEM_LIB."plugins/");

	define("SYSTEM_CONTROLLER", SYSTEM."controllers/");
	define("SYSTEM_MODEL", SYSTEM."models/");

	define("USER_CONTROLLER", BASE_DIR."controllers/");
	define("USER_MODEL", BASE_DIR."models/");


	/*
	 * Require Standard Functions
	 * LEAVE IN THIS ORDER FOR FRAMEWORK TO WORK
	 */

	require_once SYSTEM."config.php";
	require_once SYSTEM."main.php";


	/*
	 * Start the whole thing
	 */

	$app = new SnatchAPI();
	$app->run();


?>