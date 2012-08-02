<?php

	/**
	 * XML functions
	 *
	 * @version 1.0
	 */
	class XMLHelper {
		/**
		 * Converts an array into a SimpleXmlElement
		 *
		 * @return SimpleXmlElement
		 */
		public static function array2xml($arr, &$xml) {
			foreach ($arr as $key => $value) {
				if (is_array($value)) {
					if (!is_numeric($key)) {
						$sub = $xml->addChild("$key");
						self::array2xml($value, $sub);
					} else {
						self::array2xml($value, $xml);
					}
				} else {
					$xml->addChild("$key", "$value");
				}
			}
		}
	}


?>