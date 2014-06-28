<?php
include 'safemysql.class.php';
include '../config/settings.php';

/**
* DB Connection Wrapper
*/
class Db {
	public function __construct() {
		// Powerup Database connection
		// Read Config $db_config VAR in settings.php file
		global $db_config;

		if (isset($db_config)) {
			$this->db = new SafeMysql($db_config);
		} else {
			throw new Exception("Database config read Error!", 1);
		}
	}
}
