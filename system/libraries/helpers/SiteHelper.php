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
		public static function write($status = 200, $body = '', $content_type = "text/html") {
			$status_msg = ErrorcodeHelper::getStatusCodeMessage($status);
			$status_header = "HTTP/1.1 $status $status_msg";

			header($status_header);
			header("Content-type: $content_type");

			if($body != '') {
				exit($body);
			} else {
				if($_SERVER['SERVER_SIGNATURE'] == '')
					$signature = $_SERVER['SERVER_SOFTWARE'].' Server at '.$_SERVER['SERVER_NAME'].' Port '.$_SERVER['SERVER_PORT'];
				else
					$signature = $_SERVER['SERVER_SIGNATURE'];

				$body = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
							<html>
								<head>
									<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
									<title>'.$status.' '.$status_msg.'</title>
								</head>
								<body>
									<h1>'.$status_msg.'</h1>
									<p>'.$message.'</p>
									<hr />
									<address>'.$signature.'</address>
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
	}

?>
