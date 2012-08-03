<?php

    /*
     * Controller.php
     * -------------------------------------------------
     * SnatchAPI Framework
	 * Copyright (c) 2012 - Verexa & SpaceEmotion
	 *
     */

	class Controller {
		protected $model;
		protected $view;


		public function __construct(){ }

		public function loadModel($name){
			$file = USER_MODEL . $name . ".php";

			if(!file_exists($file))
				$file = SYSTEM_MODEL . $name . ".php";

			if(file_exists($file)){
				require_once $file;
				$model_class = ucfirst($name)."_Model";

				if(class_exists($model_class))
					$this->model = new $model_class;
			}
		}

		public function &getModel(){
			return $this->model;
		}

		public function &getView() {
			return $this->view;
		}
	}


?>