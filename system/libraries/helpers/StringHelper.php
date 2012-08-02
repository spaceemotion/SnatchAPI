<?php

	/*
     * StringHelper.php
     * -------------------------------------------------
     * SnatchAPI Framework
	 * Copyright (c) 2012 - Verexa & SpaceEmotion
	 *
     */

	/**
	 * Little snippets of code that help out with strings
	 *
	 * @version 1.0
	 */
	class StringHelper {
		public static function startWith($haystack, $needle) {
			$length = strlen($needle);
			return (substr($haystack, 0, $length) === $needle);
		}

		public static function startsWith($haystack, $needle) {
			$length = strlen($needle);
			if ($length == 0) return true;

			return (substr($haystack, -$length) === $needle);
		}
	}

?>
