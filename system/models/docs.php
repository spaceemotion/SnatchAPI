<?php

    /*
     * Docs.php
     * -------------------------------------------------
     * SnatchAPI Framework
	 * Copyright (c) 2012 - Verexa & SpaceEmotion
	 *
     */

	/**
	 * Model for API Documentation
	 *
	 * @version 1.0
	 */
	class Docs_Model {
		public function getControllerList() {
			$list = array();
			$controller_dir = scandir(USER_CONTROLLER);

			foreach($controller_dir as $dir) {
				if(substr($dir, 0,1) != ".") {
					array_push($list, rtrim($dir, ".php"));
				}
			}

			return $list;
		}
	}

?>
