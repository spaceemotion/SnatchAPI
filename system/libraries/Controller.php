<?php

	/*
	 * SnatchAPI Framework - Controller class
	 * Copyright (c) 2012 - Verexa & SpaceEmotion
	 */

	class Controller{
		private $model;


		public function __construct(){

		}

		public function loadModel($name){
			if(file_exists(BASE_DIR . "models/" . $name . ".php")){
				require_once BASE_DIR . "models/" . $name . ".php";
				$model_class = $name."_Model";

				if(class_exists($model_class))
					$this->model = new $model_class;
			}
		}

		public function &getModel(){
			return $this->model;
		}

		public function getSiteURL(){
			global $config;
			return $config["site"]["url"];
		}

		public function getSiteTitle(){
			global $config;
			return $config["site"]["title"];
		}
	}

	
?>