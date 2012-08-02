<?php

	/*
     * plugin.php
     * -------------------------------------------------
     * SnatchAPI Framework
	 * Copyright (c) 2012 - Verexa & SpaceEmotion
	 *
     */

	/**
	 * Basic database plugin using the PDO class
	 *
	 * @version 1.0
	 */
	class Database_Plugin extends PDO {

		public function __construct() {
			global $config;

			try {
				parent::__construct("mysql:dbname=".$config["db"]["name"].";host=".$config["db"]["host"], $config["db"]["user"], $config["db"]["password"]);
			} catch (Exception $e) {
				$info  = "Host: {$config["db"]["host"]}<br />";
				$info .= "User: {$config["db"]["user"]}<br />";
				$info .= "Password: ".(empty($config["db"]["pass"]) ? "no password" : "yes")."<br />";
				$info .= "Name: {$config["db"]["name"]}";

				SiteHelper::write(500, "<code><b>Database connection error</b><br />$info</code>");
			}

		}

	}


?>