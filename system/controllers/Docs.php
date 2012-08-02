<?php

    /*
     * Docs.php
     * -------------------------------------------------
     * SnatchAPI Framework
	 * Copyright (c) 2012 - Verexa & SpaceEmotion
	 *
     */

	class Docs_Controller extends Controller {
		public function __construct() {
			parent::__construct();

			$this->loadModel("Docs");
		}

		public function get_index() {
			echo "<h1>Docs</h1><ul>";

			$controllers = $this->model->getControllerList();

			foreach($controllers as $controller) {
				include_once USER_CONTROLLER.$controller.'.php';
				$class_name = $controller."_Controller";

				$class = new $class_name();

				$functions = $class->getApiList();

				echo "<li><strong>$controller</strong>";

				if(!empty($functions))
					echo "<br />Available functions: ".implode(",", $functions)."";

				echo "</li>";
			}

			echo "</ul>";
		}
	}


?>