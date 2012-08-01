<?php

    /*
     * Controller.php
     * -------------------------------------------------
     * SnatchAPI Framework
	 * Copyright (c) 2012 - Verexa & SpaceEmotion
	 *
     */

	class Controller {
		private $model;


		public function __construct(){ }

		public function loadModel($name){
			if(file_exists(USER_MODEL . $name . ".php")){
				require_once USER_MODEL . $name . ".php";
				$model_class = $name."_Model";

				if(class_exists($model_class))
					$this->model = new $model_class;
			}
		}

		public function &getModel(){
			return $this->model;
		}
	}


?>