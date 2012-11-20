<?php
include_once	'../config.php';
include_once	APP_PATH . '/lib/API.class.php';

class LoginAPI extends API
{
	protected $needAuth = false;
	protected $User;

	public function __construct() {
		parent::__construct();

		$this->User = new UserModel();
	}
}

$api = new LoginAPI();
$api->call();
?>