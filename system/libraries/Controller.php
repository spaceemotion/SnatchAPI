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

		public function getApiList() {
			$methods = get_class_methods(__CLASS__);
			$exclude = array('__construct', 'getModel', 'loadModel', 'getView', 'getApiList');

			$list = array();

			foreach($methods as $method){
				if(!in_array($method, $exclude))
					array_push($list, $method);
			}

			return $list;
		}
	}


?>