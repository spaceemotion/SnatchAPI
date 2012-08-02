<?php

    /*
     * PluginHelper.php
     * -------------------------------------------------
     * SnatchAPI Framework
	 * Copyright (c) 2012 - Verexa & SpaceEmotion
	 *
     */

	/**
	 * Helps loading plugins
	 *
	 * @version 1.0
	 */
	class PluginHelper {
		public static function getPlugins() {
			global $config;

			$plugin_dir = scandir(SYSTEM_PLUGIN);

			foreach($plugin_dir as $dir) {
				if(substr($dir, 0,1) != "." && in_array($dir, $config["site"]["enabled_plugins"])) {
					array_push($config["site"]["plugins"], $dir);
				}
			}
		}
	}

?>
