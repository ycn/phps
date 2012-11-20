<?php
include_once	APP_PATH . '/lib/App.class.php';

class Model
{
	protected $logger;
	protected $dbh;

	protected $tableName;

	public function __construct() {
		$this->logger = App::getLogger();
		$this->dbh = App::getDB();
	}
}
?>