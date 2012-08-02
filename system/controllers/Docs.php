<?php

    /*
     * Docs.php
     * -------------------------------------------------
     * SnatchAPI Framework
	 * Copyright (c) 2012 - Verexa & SpaceEmotion
	 *
     */

	class Docs_Controller extends Controller {
		private $time;


		public function __construct() {
			parent::__construct();
			$this->loadModel("Docs");

			$this->time = TimeHelper::utime();
		}

		public function get_index() {?>
			<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
			<html>
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
					<title>SnatchAPI DynDoc</title>
				</head>
				<body>
					<h1>DynDoc - Dynamic Documentation for the SnatchAPI</h1>
					<p>This page is only an overview of the functions created by the API itself. For more information please <a href="https://github.com/spaceemotion/SnatchAPI">check the wiki</a>.</p>
					<table border="1" width="50%"><?php

						$controllers = $this->model->getControllerList();

						foreach($controllers as $controller) {
							include_once USER_CONTROLLER.$controller.'.php';
							$class_name = $controller."_Controller";

							$class = new $class_name();

							$class_functions = $class->getApiList();


							if(!empty($class_functions)) {
								// Sort functions
								$functions = array();

								foreach($class_functions as $class_function) {
									if(StringHelper::startWith($class_function, "get_"))
										$functions["get"][] = ltrim($class_function, "get_");
									else if(StringHelper::startWith($class_function, "post_"))
										$functions["post"][] = ltrim($class_function, "post_");
									else if(StringHelper::startWith($class_function, "put_"))
										$functions["put"][] = ltrim($class_function, "put_");
									else if(StringHelper::startWith($class_function, "delete_"))
										$functions["delete"][] = ltrim($class_function, "delete_");
								}


								echo "<tr><th colspan=\"2\">$controller</th></tr>";


								foreach(array_keys($functions) as $request_method ) {
									echo "<tr>";

									echo "<td width=\"75\"><code><b>".strtoupper($request_method)."</b></code></td><td><code>";
									echo implode("<br />", $functions[$request_method]);

									echo "</code></td></tr>";
								}
							}
						}

						?>
					</table>
					<hr />
					<?= SiteHelper::getSignature(true, "", " - Page created in ".substr((TimeHelper::utime() - $this->time)*1000, 0, 7)." milliseconds") ?>
			<?php
		}
	}


?>