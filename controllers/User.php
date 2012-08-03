<?php

    /*
     * User.php
     * -------------------------------------------------
     * SnatchAPI Framework
	 * Copyright (c) 2012 - Verexa & SpaceEmotion
	 *
     */

	class User_Controller extends Controller {
		private $db;
		
		
		public function __construct() {
			if(PluginHelper::loadPlugin("database")) {
				$this->db = new Database_Plugin();
			} else {
				echo SiteHelper::write(500);
			}
		}
		
		public function get_index($id = null) {
			if($id != null) {
				$sth = $this->db->prepare("SELECT user_id,username FROM users WHERE user_id=:id");
				$sth->bindValue(":id", $id);
			} else {
				$sth = $this->db->prepare("SELECT user_id,username FROM users");
			}

			$sth->execute();
			$sth->setFetchMode(PDO::FETCH_ASSOC);

			SiteHelper::writeDefault(200, $sth->fetchAll());
		}

		public function get_maps($user_id) {
			$sth = $this->db->prepare("SELECT name,description,views,downloads FROM map_maps WHERE user_id=:id");
			$sth->bindValue(":id", $id);
			
			$sth->execute();
			$sth->setFetchMode(PDO::FETCH_ASSOC);

			SiteHelper::writeDefault(200, $sth->fetchAll());
		}
	}


?>