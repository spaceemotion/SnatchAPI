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
			echo "<h1>Docs</h1><p>Available controllers:</p>";

			$controllers = $this->model->getControllerList();

			foreach($controllers as $controller) {
				echo "$controller<br />";
			}
		}
	}


?>