<?php

	/*
	 * SnatchAPI Framework - Model class
	 * Copyright (c) 2012 - Verexa & SpaceEmotion
	 */


	class Model{
		private $header;
		private $footer;


		public function __construct(){

		}

		public function setHeader($file){
			$this->header = $file;
		}

		public function setFooter($file){
			$this->footer = $file;
		}

		public function &getHeader(){
			return $this->header;
		}

		public function &getFooter(){
			return $this->footer;
		}
	}

	
?>