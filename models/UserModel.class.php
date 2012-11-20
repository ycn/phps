<?php
include_once	APP_PATH . '/lib/Model.class.php';

class UserModel extends Model
{
	protected $tableName = 'user';

	public function __construct() {
		parent::__construct();
	}
}
?>