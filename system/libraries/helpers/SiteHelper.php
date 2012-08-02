<?php

    /*
     * index.php
     * -------------------------------------------------
     * SnatchAPI Framework
	 * Copyright (c) 2012 - Verexa & SpaceEmotion
	 *
     */

	/**
	 * Helps displaying simple output
	 *
	 * @version 1.0
	 */
	class SiteHelper {
		private static $default = "xml";


		public static function writeDefault($status = 200, $data = array()) {
			if(self::$default == "xml")
				self::writeXml ($data);
			else
				self::writeJson ($status, $data);
		}

		public static function writeXml($data = array()) {
			header("Content-type: application/xml");

			$xml = new SimpleXMLElement("<api />");
			XmlHelper::array2xml($data, $xml);
			
			echo $xml->asXML();
		}

		public static function writeJson($status = 200, $data = array()) {
			self::write($status, json_encode($data), "application/json");
		}

		public static function write($status = 200, $body = '', $content_type = "text/html") {
			$status_msg = ErrorcodeHelper::getStatusCodeMessage($status);
			$status_header = "HTTP/1.1 $status $status_msg";

			header($status_header);
			header("Content-type: $content_type");

			if($body != '') {
				exit($body);
			} else {
				$body = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
							<html>
								<head>
									<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
									<title>'.$status.' '.$status_msg.'</title>
								</head>
								<body>
									<h1>'.$status_msg.'</h1>
									<p>'.$message.'</p>
									<hr />'.(self::getSignature()).'
								</body>
							</html>';

				exit($body);
			}
		}

		public static function getSiteURL(){
			global $config;

			return $config["site"]["url"];
		}

		public static function getSiteTitle(){
			global $config;

			return $config["site"]["title"];
		}

		public static function setDefaultOutput($default = "xml") {
			if($default != "xml" && $default != "json" && $default != "custom")
				self::$default = $default;
		}

		public static function getSignature($html = true, $prefix = '', $suffix = '') {
			if($_SERVER['SERVER_SIGNATURE'] == '')
				$signature = $_SERVER['SERVER_SOFTWARE'].' Server at '.$_SERVER['SERVER_NAME'].' Port '.$_SERVER['SERVER_PORT'];
			else
				$signature = $_SERVER['SERVER_SIGNATURE'];

			return ($html) ? '<address>'.$prefix.$signature.$suffix.'</address>' : $prefix.$signature.$suffix;
		}

		public static function getDefault() {
			return self::$default;
		}
	}

?>
