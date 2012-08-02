<?php

    /*
     * Maps.php
     * -------------------------------------------------
     * SnatchAPI Framework
	 * Copyright (c) 2012 - Verexa & SpaceEmotion
	 *
     */

	class Maps_Controller extends Controller {
		public function get_index($id = null) {
			if(PluginHelper::loadPlugin("database")) {
				$db_plugin = new Database_Plugin();

				if($id != null) {
					$sth = $db_plugin->prepare("SELECT name,description FROM map_maps WHERE id=:id");
					$sth->bindValue(":id", $id, PDO::PARAM_INT);
				} else {
					$sth = $db_plugin->prepare("SELECT name,description FROM map_maps");
				}

				$sth->execute();
				$sth->setFetchMode(PDO::FETCH_ASSOC);

				SiteHelper::writeDefault(200, $sth->fetchAll());
			}
		}
	}


?>
