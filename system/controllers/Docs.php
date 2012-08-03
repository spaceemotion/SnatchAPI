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

		public function get_index() {?>
			<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
			<html>
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
					<title>SnatchAPI DynDoc</title>
				</head>
				<body>
					<h1>DynDoc - Dynamic Documentation for the SnatchAPI</h1>
					<p>This page is only an overview of the functions created by the API itself. For more information please <a href="https://github.com/spaceemotion/SnatchAPI/wiki">check the wiki</a>.</p>
					<?php

						$controllers = $this->model->getControllerList();
						$exclude_methods = get_class_methods("Controller");


						foreach($controllers as $controller) {
							include_once USER_CONTROLLER.$controller.'.php';

							$class_name = $controller."_Controller";

							?><table border="2" cellpadding="3">
								<thead>
									<tr>
										<th colspan="2" style="border-style: none;"><?= $controller ?></th>
									</tr>
								</thead>

								<tbody><?php
									foreach(get_class_methods($class_name) as $method) {
										if(!in_array($method, $exclude_methods)) {
											$expl = explode("_", $method, 2);

											$r = new ReflectionMethod($class_name, $method);
											$params = $r->getParameters();
											
											$request_method = strtoupper($expl[0]);

											?>
											<tr>
												<td width="70" valign="top" align="center" style="color: #fff; background-color: #<?= StringHelper::stringToColorCode($request_method) ?>">
													<code><?= $request_method ?></code>
												</td>
												<td width="90%"><code> <?
													echo strtolower($controller)."/";

													if($expl[1] != "index") echo "{$expl[1]}/";

													if(!empty($params)) {
														$param_count = count($params);

														for($p = 0; $p < $param_count; $p++) {
															$param = $params[$p];
															$out = $param->getName();

															if($param->isOptional()) {
																$default = $param->getDefaultValue();

																if($default === null)
																	$default = "null";

																$out = "[$out = $default]";
															} else {
																$out = "&lt;$out&gt;";
															}

															if($p != $param_count-1)
																$out .= "/";

															echo "<em>$out</em>";
														}

													}
												?></code></td>
											</tr>
											<?php
										}
									} ?>

								</tbody>
							</table><br /><?php
						}

					?>
					<hr />
					<?= SiteHelper::getSignature(true, "", " - Page created in ".substr((TimeHelper::utime() - $GLOBALS["config"]["site"]["start_time"])*1000, 0, 7)." milliseconds") ?>
			<?php
		}
		
	}


?>