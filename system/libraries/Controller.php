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
		private $view;

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