<?php

    /*
     * TimeHelper.php
     * -------------------------------------------------
     * SnatchAPI Framework
	 * Copyright (c) 2012 - Verexa & SpaceEmotion
	 *
     */

	/**
	 * Adds some basic time functions
	 *
	 * @version 1.0
	 */
	class TimeHelper {
		public static function utime() {
			$time = explode(" ", microtime());

			return (double)$time[1] + (double)$time[0];
		}
	}

?>
